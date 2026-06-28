<?php

namespace Tests\Unit;

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

class ScheduleServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ScheduleService $service;
    protected User $user;
    protected SavedSchedule $schedule;
    protected Subject $subjectA;
    protected Subject $subjectB;
    protected Teacher $teacher;
    protected Classroom $classroom;
    protected Semester $semester;
    protected Group $group;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service   = new ScheduleService();
        $this->user      = User::create(['name' => 'Estudiante Test', 'email' => 'test@example.com', 'password' => bcrypt('password'), 'rol' => 'estudiante']);
        $this->semester  = Semester::create(['nombre' => 'Gestión 2026-I']);
        $this->group     = Group::create(['nombre' => 'Grupo A']);
        $this->classroom = Classroom::create(['codigo' => 'AULA-01']);
        $this->teacher   = Teacher::create(['prefijo_academico' => 'Lic.', 'nombre_completo' => 'Carlos Mamani']);
        $this->subjectA  = Subject::create(['sigla' => 'MAT101', 'nombre' => 'Matemáticas I']);
        $this->subjectB  = Subject::create(['sigla' => 'FIS101', 'nombre' => 'Física I']);
        $this->schedule  = SavedSchedule::create(['user_id' => $this->user->id, 'nombre_horario' => 'Mi Horario 2026', 'gestion' => '2026']);
    }

    public function test_puede_agregar_clase_a_horario_vacio(): void
    {
        $slot  = $this->createTimeSlot(1, '08:00', '10:00');
        $clase = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slot->id);
        $this->service->validateAddition($this->schedule, $clase);
        $this->assertTrue(true);
    }

    public function test_dos_clases_en_dias_distintos_no_conflictan(): void
    {
        $slotLunes   = $this->createTimeSlot(1, '08:00', '10:00');
        $slotMartes  = $this->createTimeSlot(2, '08:00', '10:00');
        $claseLunes  = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotLunes->id);
        $claseMartes = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slotMartes->id);
        $this->schedule->availableClasses()->attach($claseLunes->id);
        $this->service->validateAddition($this->schedule, $claseMartes);
        $this->assertTrue(true);
    }

    public function test_clases_consecutivas_mismo_dia_no_conflictan(): void
    {
        $slotManana = $this->createTimeSlot(1, '08:00', '10:00');
        $slotTarde  = $this->createTimeSlot(1, '10:00', '12:00');
        $claseManan = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotManana->id);
        $claseTarde = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slotTarde->id);
        $this->schedule->availableClasses()->attach($claseManan->id);
        $this->service->validateAddition($this->schedule, $claseTarde);
        $this->assertTrue(true);
    }

    public function test_lanza_excepcion_por_mismo_time_slot(): void
    {
        $slot   = $this->createTimeSlot(1, '08:00', '10:00');
        $claseA = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slot->id);
        $claseB = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slot->id);
        $this->schedule->availableClasses()->attach($claseA->id);
        $this->expectException(ConflictException::class);
        $this->service->validateAddition($this->schedule, $claseB);
    }

    public function test_conflicto_horario_tiene_tipo_correcto(): void
    {
        $slot   = $this->createTimeSlot(3, '14:00', '16:00');
        $claseA = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slot->id);
        $claseB = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slot->id);
        $this->schedule->availableClasses()->attach($claseA->id);
        try {
            $this->service->validateAddition($this->schedule, $claseB);
            $this->fail('Debió lanzar ConflictException');
        } catch (ConflictException $e) {
            $this->assertEquals('horario_estudiante', $e->getTipo());
        }
    }

    public function test_lanza_excepcion_por_solapamiento_parcial(): void
    {
        $slotA  = $this->createTimeSlot(2, '08:00', '10:30');
        $slotB  = $this->createTimeSlot(2, '09:00', '11:00');
        $claseA = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotA->id);
        $claseB = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slotB->id);
        $this->schedule->availableClasses()->attach($claseA->id);
        $this->expectException(ConflictException::class);
        $this->service->validateAddition($this->schedule, $claseB);
    }

    public function test_lanza_excepcion_por_docente_ocupado(): void
{
    $otroGrupo = Group::create(['nombre' => 'Grupo B']);
    $slot      = $this->createTimeSlot(1, '10:00', '12:00');

    $claseA = $this->createAvailableClass(
        subjectId: $this->subjectA->id,
        slotId:    $slot->id,
        teacherId: $this->teacher->id,
        groupId:   $this->group->id
    );
    $claseB = $this->createAvailableClass(
        subjectId: $this->subjectB->id,
        slotId:    $slot->id,
        teacherId: $this->teacher->id,
        groupId:   $otroGrupo->id
    );

    $this->schedule->availableClasses()->attach($claseA->id);

    $this->expectException(ConflictException::class);
    $this->service->validateAddition($this->schedule, $claseB);
}

    public function test_lanza_excepcion_por_aula_ocupada(): void
{
    $otroDocente = Teacher::create(['prefijo_academico' => 'Dr.', 'nombre_completo' => 'Juan Quispe']);
    $slot        = $this->createTimeSlot(4, '14:00', '16:00');

    $claseA = $this->createAvailableClass(
        subjectId:   $this->subjectA->id,
        slotId:      $slot->id,
        teacherId:   $this->teacher->id,
        classroomId: $this->classroom->id
    );
    $claseB = $this->createAvailableClass(
        subjectId:   $this->subjectB->id,
        slotId:      $slot->id,
        teacherId:   $otroDocente->id,
        classroomId: $this->classroom->id
    );

    $this->schedule->availableClasses()->attach($claseA->id);

    $this->expectException(ConflictException::class);
    $this->service->validateAddition($this->schedule, $claseB);
}

    public function test_lanza_excepcion_por_materia_duplicada(): void
    {
        $slotA  = $this->createTimeSlot(1, '08:00', '10:00');
        $slotB  = $this->createTimeSlot(3, '14:00', '16:00');
        $claseA = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotA->id);
        $claseB = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotB->id);
        $this->schedule->availableClasses()->attach($claseA->id);
        try {
            $this->service->validateAddition($this->schedule, $claseB);
            $this->fail('Debió lanzar ConflictException');
        } catch (ConflictException $e) {
            $this->assertEquals('materia_duplicada', $e->getTipo());
        }
    }

    public function test_lanza_excepcion_por_semestre_inconsistente(): void
    {
        $otroSemestre = Semester::create(['nombre' => 'Gestión 2026-II']);
        $slotA        = $this->createTimeSlot(1, '08:00', '10:00');
        $slotB        = $this->createTimeSlot(2, '08:00', '10:00');
        $claseA       = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotA->id, semesterId: $this->semester->id);
        $claseB       = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slotB->id, semesterId: $otroSemestre->id);
        $this->schedule->availableClasses()->attach($claseA->id);
        try {
            $this->service->validateAddition($this->schedule, $claseB);
            $this->fail('Debió lanzar ConflictException');
        } catch (ConflictException $e) {
            $this->assertEquals('semestre_inconsistente', $e->getTipo());
        }
    }

    public function test_detecta_cero_conflictos_en_horario_limpio(): void
    {
        $slotLunes  = $this->createTimeSlot(1, '08:00', '10:00');
        $slotMartes = $this->createTimeSlot(2, '08:00', '10:00');
        $claseA     = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slotLunes->id);
        $claseB     = $this->createAvailableClass(subjectId: $this->subjectB->id, slotId: $slotMartes->id);
        $this->schedule->availableClasses()->attach([$claseA->id, $claseB->id]);
        $this->assertEmpty($this->service->detectAllConflicts($this->schedule));
    }

    public function test_get_schedule_summary_retorna_estructura_correcta(): void
    {
        $slot  = $this->createTimeSlot(1, '08:00', '10:00');
        $clase = $this->createAvailableClass(subjectId: $this->subjectA->id, slotId: $slot->id);
        $this->schedule->availableClasses()->attach($clase->id);
        $summary = $this->service->getScheduleSummary($this->schedule);
        $this->assertArrayHasKey('total_clases', $summary);
        $this->assertArrayHasKey('total_docentes', $summary);
        $this->assertArrayHasKey('total_aulas', $summary);
        $this->assertArrayHasKey('dias_con_clases', $summary);
        $this->assertArrayHasKey('materias', $summary);
        $this->assertArrayHasKey('conflictos', $summary);
        $this->assertEquals(1, $summary['total_clases']);
    }

    private function createTimeSlot(int $dia, string $inicio, string $fin): TimeSlot
    {
        return TimeSlot::create(['dia_semana' => $dia, 'hora_inicio' => $inicio, 'hora_fin' => $fin]);
    }

    private function createAvailableClass(?int $subjectId = null, ?int $slotId = null, ?int $teacherId = null, ?int $classroomId = null, ?int $semesterId = null, ?int $groupId = null): AvailableClass
    {
        return AvailableClass::create([
            'subject_id'   => $subjectId   ?? $this->subjectA->id,
            'teacher_id'   => $teacherId   ?? $this->teacher->id,
            'classroom_id' => $classroomId ?? $this->classroom->id,
            'time_slot_id' => $slotId      ?? $this->createTimeSlot(1, '08:00', '10:00')->id,
            'semester_id'  => $semesterId  ?? $this->semester->id,
            'group_id'     => $groupId     ?? $this->group->id,
        ]);
    }
}