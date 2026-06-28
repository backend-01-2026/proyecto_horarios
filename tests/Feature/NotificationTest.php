<?php

namespace Tests\Feature;

use App\Jobs\ProcessTeacherNotification;
use App\Models\AvailableClass;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\SavedSchedule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;
use App\Models\User;
use App\Notifications\ConflictDetectedNotification;
use App\Notifications\NewScheduleNotification;
use App\Services\ScheduleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected ScheduleService $service;
    protected User $user;
    protected SavedSchedule $schedule;
    protected Teacher $teacher;
    protected AvailableClass $availableClass;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ScheduleService();
        $this->user    = User::create(['name' => 'Estudiante Notif', 'email' => 'notif@test.com', 'password' => bcrypt('password'), 'rol' => 'estudiante']);

        $semester      = Semester::create(['nombre' => 'Notif 2026-I']);
        $group         = Group::create(['nombre' => 'Grupo NOTIF']);
        $classroom     = Classroom::create(['codigo' => 'NOTIF-01']);
        $this->teacher = Teacher::create(['prefijo_academico' => 'Dr.', 'nombre_completo' => 'Rosa Quispe']);
        $subject       = Subject::create(['sigla' => 'NOT001', 'nombre' => 'Notificaciones']);
        $slot          = TimeSlot::create(['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);

        $this->availableClass = AvailableClass::create([
            'subject_id' => $subject->id, 'teacher_id' => $this->teacher->id,
            'classroom_id' => $classroom->id, 'time_slot_id' => $slot->id,
            'semester_id' => $semester->id, 'group_id' => $group->id,
        ]);
        $this->schedule = SavedSchedule::create(['user_id' => $this->user->id, 'nombre_horario' => 'Horario Notif', 'gestion' => '2026']);
    }

    public function test_agregar_clase_encola_job_de_notificacion(): void
{
    Queue::fake();

    ProcessTeacherNotification::dispatch(
        $this->teacher->id,
        'nueva_inscripcion',
        ['materia' => 'Test', 'available_class_id' => $this->availableClass->id]
    );

    Queue::assertPushed(ProcessTeacherNotification::class, function ($job) {
        return $job->teacherId === $this->teacher->id
            && $job->tipoNotificacion === 'nueva_inscripcion';
    });
}

    public function test_job_se_encola_en_cola_notifications(): void
{
    Queue::fake();

    ProcessTeacherNotification::dispatch(
        $this->teacher->id,
        'nueva_inscripcion',
        ['materia' => 'Test', 'available_class_id' => $this->availableClass->id]
    )->onQueue('notifications');

    Queue::assertPushedOn('notifications', ProcessTeacherNotification::class);
}

    public function test_job_tiene_tres_reintentos(): void
    {
        $job = new ProcessTeacherNotification($this->teacher->id, 'nueva_inscripcion', ['materia' => 'Test']);
        $this->assertEquals(3, $job->tries);
    }

    public function test_new_schedule_notification_usa_canal_mail(): void
    {
        $notification = new NewScheduleNotification(['materia' => 'Test']);
        $this->assertContains('mail', $notification->via($this->teacher));
    }

    public function test_new_schedule_notification_to_mail_incluye_datos(): void
    {
        $notification = new NewScheduleNotification(['materia' => 'Programación I', 'grupo' => 'Grupo B', 'aula' => 'LAB-02', 'horario' => 'Martes 10:00 - 12:00', 'estudiante_nombre' => 'Carlos Mamani']);
        $mailMessage  = $notification->toMail($this->teacher);
        $this->assertStringContainsString('Programación I', $mailMessage->subject);
    }

    public function test_conflict_notification_tipo_label_correcto(): void
    {
        $casos = ['horario_estudiante' => 'Choque de Horarios', 'docente_ocupado' => 'Docente No Disponible', 'aula_ocupada' => 'Aula Ocupada', 'materia_duplicada' => 'Materia Duplicada', 'semestre_inconsistente' => 'Semestre Incorrecto'];
        foreach ($casos as $tipo => $label) {
            $notif = new ConflictDetectedNotification($tipo, 'Mensaje test');
            $this->assertEquals($label, $notif->getTipoLabel(), "Falló para tipo: {$tipo}");
        }
    }

    public function test_conflict_notification_to_array_contiene_campos_requeridos(): void
    {
        $notification = new ConflictDetectedNotification('materia_duplicada', 'Materia duplicada.');
        $array        = $notification->toArray($this->user);
        $this->assertArrayHasKey('tipo', $array);
        $this->assertArrayHasKey('tipo_conflicto', $array);
        $this->assertArrayHasKey('tipo_label', $array);
        $this->assertArrayHasKey('mensaje', $array);
        $this->assertEquals('conflicto_detectado', $array['tipo']);
    }

    public function test_puede_enviar_notification_con_facade_fake(): void
    {
        Notification::fake();
        Notification::route('mail', 'test@example.com')->notify(new NewScheduleNotification(['materia' => 'Álgebra', 'grupo' => 'Grupo D']));
        Notification::assertSentOnDemand(NewScheduleNotification::class);
    }
}