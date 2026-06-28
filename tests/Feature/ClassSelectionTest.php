<?php

namespace Tests\Feature;

use App\Exceptions\ConflictException;
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
use Tests\TestCase;

class ClassSelectionTest extends TestCase
{
    use RefreshDatabase;

    protected ScheduleService $service;
    protected User $user;
    protected SavedSchedule $schedule;
    protected Semester $semester;
    protected Group $group;
    protected Classroom $classroom;
    protected Teacher $teacher;
    protected Subject $subjectA;
    protected Subject $subjectB;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service   = new ScheduleService();
        $this->user      = User::create(['name' => 'Estudiante Integración', 'email' => 'integracion@test.com', 'password' => bcrypt('password'), 'rol' => 'estudiante']);
        $this->semester  = Semester::create(['nombre' => 'Gestión 2026-I']);
        $this->group     = Group::create(['nombre' => 'Grupo INT']);
        $this->classroom = Classroom::create(['codigo' => 'INT-01']);
        $this->teacher   = Teacher::create(['prefijo_academico' => 'Ing.', 'nombre_completo' => 'Pedro Vargas']);
        $this->subjectA  = Subject::create(['sigla' => 'SIS201', 'nombre' => 'Sistemas Operativos']);
        $this->subjectB  = Subject::create(['sigla' => 'SIS202', 'nombre' => 'Redes I']);
        $this->schedule  = SavedSchedule::create(['user_id' => $this->user->id, 'nombre_horario' => 'Horario Integración', 'gestion' => '2026']);
    }

    public function test_puede_agregar_clase_valida_a_horario(): void
    {
        $slot  = TimeSlot::create(['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);
        $clase = $this->makeClass($this->subjectA->id, $slot->id);
        $this->service->addClassToSchedule($this->schedule, $clase);
        $this->assertDatabaseHas('class_selections', ['saved_schedule_id' => $this->schedule->id, 'available_class_id' => $clase->id]);
    }

    public function test_puede_agregar_multiples_clases_sin_conflicto(): void
    {
        $slotLunes  = TimeSlot::create(['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);
        $slotMartes = TimeSlot::create(['dia_semana' => 2, 'hora_inicio' => '10:00', 'hora_fin' => '12:00']);
        $claseA = $this->makeClass($this->subjectA->id, $slotLunes->id);
        $claseB = $this->makeClass($this->subjectB->id, $slotMartes->id);
        $this->service->addClassToSchedule($this->schedule, $claseA);
        $this->service->addClassToSchedule($this->schedule, $claseB);
        $this->assertDatabaseHas('class_selections', ['saved_schedule_id' => $this->schedule->id, 'available_class_id' => $claseA->id]);
        $this->assertDatabaseHas('class_selections', ['saved_schedule_id' => $this->schedule->id, 'available_class_id' => $claseB->id]);
        $this->assertCount(2, $this->schedule->availableClasses);
    }

    public function test_bloquea_clase_con_choque_de_horario(): void
    {
        $slot   = TimeSlot::create(['dia_semana' => 3, 'hora_inicio' => '14:00', 'hora_fin' => '16:00']);
        $claseA = $this->makeClass($this->subjectA->id, $slot->id);
        $claseB = $this->makeClass($this->subjectB->id, $slot->id);
        $this->service->addClassToSchedule($this->schedule, $claseA);
        $this->expectException(ConflictException::class);
        $this->service->addClassToSchedule($this->schedule, $claseB);
    }

    public function test_bd_no_se_modifica_cuando_hay_conflicto(): void
    {
        $slot   = TimeSlot::create(['dia_semana' => 5, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);
        $claseA = $this->makeClass($this->subjectA->id, $slot->id);
        $claseB = $this->makeClass($this->subjectB->id, $slot->id);
        $this->service->addClassToSchedule($this->schedule, $claseA);
        try { $this->service->addClassToSchedule($this->schedule, $claseB); } catch (ConflictException) {}
        $this->assertDatabaseMissing('class_selections', ['saved_schedule_id' => $this->schedule->id, 'available_class_id' => $claseB->id]);
        $this->assertCount(1, $this->schedule->fresh()->availableClasses);
    }

    public function test_puede_eliminar_clase_del_horario(): void
    {
        $slot  = TimeSlot::create(['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);
        $clase = $this->makeClass($this->subjectA->id, $slot->id);
        $this->service->addClassToSchedule($this->schedule, $clase);
        $this->service->removeClassFromSchedule($this->schedule, $clase);
        $this->assertDatabaseMissing('class_selections', ['saved_schedule_id' => $this->schedule->id, 'available_class_id' => $clase->id]);
    }

    public function test_puede_reagregar_clase_despues_de_eliminar(): void
    {
        $slot   = TimeSlot::create(['dia_semana' => 2, 'hora_inicio' => '10:00', 'hora_fin' => '12:00']);
        $claseA = $this->makeClass($this->subjectA->id, $slot->id);
        $claseB = $this->makeClass($this->subjectB->id, $slot->id);
        $this->service->addClassToSchedule($this->schedule, $claseA);
        $this->service->removeClassFromSchedule($this->schedule, $claseA);
        $this->service->addClassToSchedule($this->schedule, $claseB);
        $this->assertDatabaseHas('class_selections', ['saved_schedule_id' => $this->schedule->id, 'available_class_id' => $claseB->id]);
    }

    public function test_relacion_devuelve_clases_correctas(): void
    {
        $slotA = TimeSlot::create(['dia_semana' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);
        $slotB = TimeSlot::create(['dia_semana' => 2, 'hora_inicio' => '08:00', 'hora_fin' => '10:00']);
        $claseA = $this->makeClass($this->subjectA->id, $slotA->id);
        $claseB = $this->makeClass($this->subjectB->id, $slotB->id);
        $this->service->addClassToSchedule($this->schedule, $claseA);
        $this->service->addClassToSchedule($this->schedule, $claseB);
        $clases = $this->schedule->fresh()->availableClasses;
        $this->assertCount(2, $clases);
        $this->assertTrue($clases->contains('id', $claseA->id));
        $this->assertTrue($clases->contains('id', $claseB->id));
    }

    public function test_saved_schedule_pertenece_al_usuario_correcto(): void
    {
        $this->assertEquals($this->user->id, $this->schedule->user->id);
    }

    public function test_user_puede_tener_multiples_horarios(): void
    {
        SavedSchedule::create(['user_id' => $this->user->id, 'nombre_horario' => 'Horario B', 'gestion' => '2026']);
        $this->assertCount(2, $this->user->savedSchedules);
    }

    private function makeClass(int $subjectId, int $slotId): AvailableClass
    {
        return AvailableClass::create([
            'subject_id' => $subjectId, 'teacher_id' => $this->teacher->id,
            'classroom_id' => $this->classroom->id, 'time_slot_id' => $slotId,
            'semester_id' => $this->semester->id, 'group_id' => $this->group->id,
        ]);
    }
}