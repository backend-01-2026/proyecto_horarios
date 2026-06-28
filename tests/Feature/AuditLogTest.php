<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\AvailableClass;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\SavedSchedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Models\User;
use App\Services\ScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    protected ScheduleService $service;
    protected User $user;
    protected SavedSchedule $schedule;
    protected AvailableClass $availableClass;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ScheduleService();
        $this->user = User::create(['name' => 'Admin Auditoría', 'email' => 'audit@test.com', 'password' => bcrypt('password'), 'rol' => 'admin']);
        Auth::login($this->user);

        $semester  = Semester::create(['nombre'  => 'Auditoría 2026-I']);
        $group     = Group::create(['nombre'     => 'Grupo AUDIT']);
        $classroom = Classroom::create(['codigo' => 'AUDIT-01']);
        $teacher   = Teacher::create(['prefijo_academico' => 'MSc.', 'nombre_completo' => 'Luis Torres']);
        $subject   = Subject::create(['sigla' => 'AUD001', 'nombre' => 'Auditoría de Sistemas']);
        $slot      = TimeSlot::create(['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);

        $this->availableClass = AvailableClass::create([
            'subject_id' => $subject->id, 'teacher_id' => $teacher->id,
            'classroom_id' => $classroom->id, 'time_slot_id' => $slot->id,
            'semester_id' => $semester->id, 'group_id' => $group->id,
        ]);
        $this->schedule = SavedSchedule::create(['user_id' => $this->user->id, 'nombre_horario' => 'Horario Auditoría', 'gestion' => '2026']);
    }

    public function test_agrega_clase_genera_audit_log_created(): void
    {
        $this->service->addClassToSchedule($this->schedule, $this->availableClass);
        $this->assertDatabaseHas('audit_logs', ['accion' => 'created', 'modelo' => 'ClassSelection', 'saved_schedule_id' => $this->schedule->id, 'available_class_id' => $this->availableClass->id]);
    }

    public function test_eliminar_clase_genera_audit_log_deleted(): void
    {
        $this->service->addClassToSchedule($this->schedule, $this->availableClass);
        $this->service->removeClassFromSchedule($this->schedule, $this->availableClass);
        $this->assertDatabaseHas('audit_logs', ['accion' => 'deleted', 'saved_schedule_id' => $this->schedule->id, 'available_class_id' => $this->availableClass->id]);
    }

    public function test_ciclo_completo_genera_dos_audit_logs(): void
    {
        $this->service->addClassToSchedule($this->schedule, $this->availableClass);
        $this->service->removeClassFromSchedule($this->schedule, $this->availableClass);
        $count = AuditLog::where('saved_schedule_id', $this->schedule->id)->where('available_class_id', $this->availableClass->id)->count();
        $this->assertEquals(2, $count);
    }

    public function test_registrar_creacion_inserta_en_bd(): void
    {
        AuditLog::registrarCreacion($this->schedule->id, $this->availableClass->id, ['subject' => ['nombre' => 'Test']], ['id' => $this->user->id, 'nombre' => $this->user->name, 'email' => $this->user->email, 'rol' => 'admin'], ['ip' => '127.0.0.1', 'user_agent' => 'PHPUnit']);
        $this->assertDatabaseHas('audit_logs', ['accion' => 'created', 'saved_schedule_id' => $this->schedule->id, 'available_class_id' => $this->availableClass->id, 'user_id' => $this->user->id, 'user_email' => $this->user->email]);
    }

    public function test_scope_creaciones_filtra_correctamente(): void
    {
        AuditLog::registrarCreacion($this->schedule->id, $this->availableClass->id);
        AuditLog::registrarEliminacion($this->schedule->id, $this->availableClass->id);
        $creaciones = AuditLog::creaciones()->get();
        $this->assertCount(1, $creaciones);
        $this->assertEquals('created', $creaciones->first()->accion);
    }

    public function test_scope_eliminaciones_filtra_correctamente(): void
    {
        AuditLog::registrarCreacion($this->schedule->id, $this->availableClass->id);
        AuditLog::registrarEliminacion($this->schedule->id, $this->availableClass->id);
        $eliminaciones = AuditLog::eliminaciones()->get();
        $this->assertCount(1, $eliminaciones);
        $this->assertEquals('deleted', $eliminaciones->first()->accion);
    }

    public function test_accion_label_retorna_texto_correcto(): void
    {
        $logCreado    = AuditLog::registrarCreacion($this->schedule->id, $this->availableClass->id);
        $logEliminado = AuditLog::registrarEliminacion($this->schedule->id, $this->availableClass->id);
        $this->assertEquals('Clase Agregada',  $logCreado->accion_label);
        $this->assertEquals('Clase Eliminada', $logEliminado->accion_label);
    }

    public function test_datos_clase_se_guarda_y_recupera_como_array(): void
    {
        $datosClase = ['subject' => ['nombre' => 'Matemáticas', 'sigla' => 'MAT101'], 'teacher' => ['nombre_completo' => 'Dr. Smith']];
        $log = AuditLog::registrarCreacion($this->schedule->id, $this->availableClass->id, $datosClase);
        $logRecuperado = AuditLog::find($log->id);
        $this->assertIsArray($logRecuperado->datos_clase);
        $this->assertEquals('Matemáticas', $logRecuperado->datos_clase['subject']['nombre']);
    }

    public function test_audit_log_no_tiene_updated_at(): void
    {
        $log = AuditLog::registrarCreacion($this->schedule->id, $this->availableClass->id);
        $this->assertNull(AuditLog::UPDATED_AT);
        $this->assertNotNull($log->created_at);
    }
}