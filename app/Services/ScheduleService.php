<?php

namespace App\Services;

use App\Exceptions\ConflictException;
use App\Models\AvailableClass;
use App\Models\SavedSchedule;
use App\Models\TimeSlot;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleService
{
    public function validateAddition(SavedSchedule $schedule, AvailableClass $newClass): void
    {
        $existingClasses = $this->getExistingClassesWithRelations($schedule);
        $this->checkStudentTimeConflict($existingClasses, $newClass);
        $this->checkTeacherConflict($existingClasses, $newClass);
        $this->checkClassroomConflict($existingClasses, $newClass);
        $this->checkDuplicateSubject($existingClasses, $newClass);
        $this->checkSemesterConsistency($existingClasses, $newClass);
    }

    public function addClassToSchedule(SavedSchedule $schedule, AvailableClass $newClass): void
    {
        $this->validateAddition($schedule, $newClass);

        DB::transaction(function () use ($schedule, $newClass) {
            $schedule->availableClasses()->attach($newClass->id);
            Log::info('Clase agregada al horario', [
                'saved_schedule_id'  => $schedule->id,
                'available_class_id' => $newClass->id,
                'user_id'            => $schedule->user_id,
            ]);
        });
    }

    public function removeClassFromSchedule(SavedSchedule $schedule, AvailableClass $classToRemove): void
    {
        DB::transaction(function () use ($schedule, $classToRemove) {
            $schedule->availableClasses()->detach($classToRemove->id);
            Log::info('Clase eliminada del horario', [
                'saved_schedule_id'  => $schedule->id,
                'available_class_id' => $classToRemove->id,
                'user_id'            => $schedule->user_id,
            ]);
        });
    }

    public function detectAllConflicts(SavedSchedule $schedule): array
    {
        $conflicts = [];
        $classes   = $this->getExistingClassesWithRelations($schedule);

        for ($i = 0; $i < $classes->count(); $i++) {
            for ($j = $i + 1; $j < $classes->count(); $j++) {
                $classA = $classes[$i];
                $classB = $classes[$j];
                if ($this->timeSlotOverlaps($classA->timeSlot, $classB->timeSlot)) {
                    $conflicts[] = sprintf(
                        'Conflicto de horario entre "%s" y "%s" el día %s de %s a %s.',
                        $classA->subject->nombre,
                        $classB->subject->nombre,
                        $this->getDayName($classA->timeSlot->dia_semana),
                        $classA->timeSlot->hora_inicio,
                        $classA->timeSlot->hora_fin
                    );
                }
            }
        }

        return $conflicts;
    }

    public function getScheduleSummary(SavedSchedule $schedule): array
    {
        $classes = $this->getExistingClassesWithRelations($schedule);
        return [
            'total_clases'    => $classes->count(),
            'total_docentes'  => $classes->pluck('teacher_id')->unique()->count(),
            'total_aulas'     => $classes->pluck('classroom_id')->unique()->count(),
            'dias_con_clases' => $classes->pluck('timeSlot.dia_semana')->unique()->sort()->values()->toArray(),
            'materias'        => $classes->pluck('subject.nombre')->toArray(),
            'conflictos'      => $this->detectAllConflicts($schedule),
        ];
    }

    private function checkStudentTimeConflict(Collection $existingClasses, AvailableClass $newClass): void
    {
        $newSlot = $newClass->timeSlot;
        foreach ($existingClasses as $existing) {
            if ($this->timeSlotOverlaps($existing->timeSlot, $newSlot)) {
                throw new ConflictException(
                    tipo: 'horario_estudiante',
                    mensaje: sprintf(
                        'Ya tienes una clase de "%s" el %s de %s a %s. No puedes agregar "%s" en el mismo horario.',
                        $existing->subject->nombre,
                        $this->getDayName($existing->timeSlot->dia_semana),
                        $existing->timeSlot->hora_inicio,
                        $existing->timeSlot->hora_fin,
                        $newClass->subject->nombre
                    ),
                    context: [
                        'existing_class_id' => $existing->id,
                        'new_class_id'      => $newClass->id,
                        'time_slot_id'      => $newSlot->id,
                    ]
                );
            }
        }
    }

    private function checkTeacherConflict(Collection $existingClasses, AvailableClass $newClass): void
    {
        $newSlot = $newClass->timeSlot;
        foreach ($existingClasses as $existing) {
            if ($existing->teacher_id === $newClass->teacher_id && $this->timeSlotOverlaps($existing->timeSlot, $newSlot)) {
                throw new ConflictException(
                    tipo: 'docente_ocupado',
                    mensaje: sprintf(
                        'El docente "%s %s" ya tiene clase de "%s" el %s de %s a %s.',
                        $newClass->teacher->prefijo_academico,
                        $newClass->teacher->nombre_completo,
                        $existing->subject->nombre,
                        $this->getDayName($existing->timeSlot->dia_semana),
                        $existing->timeSlot->hora_inicio,
                        $existing->timeSlot->hora_fin
                    ),
                    context: [
                        'teacher_id'        => $newClass->teacher_id,
                        'existing_class_id' => $existing->id,
                        'new_class_id'      => $newClass->id,
                    ]
                );
            }
        }
    }

    private function checkClassroomConflict(Collection $existingClasses, AvailableClass $newClass): void
    {
        $newSlot = $newClass->timeSlot;
        foreach ($existingClasses as $existing) {
            if ($existing->classroom_id === $newClass->classroom_id && $this->timeSlotOverlaps($existing->timeSlot, $newSlot)) {
                throw new ConflictException(
                    tipo: 'aula_ocupada',
                    mensaje: sprintf(
                        'El aula "%s" ya está ocupada el %s de %s a %s por la clase de "%s".',
                        $newClass->classroom->codigo,
                        $this->getDayName($newSlot->dia_semana),
                        $newSlot->hora_inicio,
                        $newSlot->hora_fin,
                        $existing->subject->nombre
                    ),
                    context: [
                        'classroom_id'      => $newClass->classroom_id,
                        'existing_class_id' => $existing->id,
                        'new_class_id'      => $newClass->id,
                    ]
                );
            }
        }
    }

    private function checkDuplicateSubject(Collection $existingClasses, AvailableClass $newClass): void
    {
        foreach ($existingClasses as $existing) {
            if ($existing->subject_id === $newClass->subject_id) {
                throw new ConflictException(
                    tipo: 'materia_duplicada',
                    mensaje: sprintf(
                        'La materia "%s" ya está en tu horario (Grupo: %s). No puedes agregarla dos veces.',
                        $newClass->subject->nombre,
                        $existing->group->nombre
                    ),
                    context: [
                        'subject_id'        => $newClass->subject_id,
                        'existing_class_id' => $existing->id,
                        'new_class_id'      => $newClass->id,
                    ]
                );
            }
        }
    }

    private function checkSemesterConsistency(Collection $existingClasses, AvailableClass $newClass): void
    {
        if ($existingClasses->isEmpty()) return;

        $existingSemesterId = $existingClasses->first()->semester_id;
        if ($existingSemesterId !== $newClass->semester_id) {
            throw new ConflictException(
                tipo: 'semestre_inconsistente',
                mensaje: sprintf(
                    'Tu horario pertenece al semestre "%s". No puedes agregar clases del semestre "%s".',
                    $existingClasses->first()->semester->nombre,
                    $newClass->semester->nombre
                ),
                context: [
                    'expected_semester_id' => $existingSemesterId,
                    'new_semester_id'      => $newClass->semester_id,
                ]
            );
        }
    }

    private function getExistingClassesWithRelations(SavedSchedule $schedule): Collection
    {
        return $schedule->availableClasses()
            ->with(['subject', 'teacher', 'classroom', 'timeSlot', 'semester', 'group'])
            ->get();
    }

    private function timeSlotOverlaps(TimeSlot $slotA, TimeSlot $slotB): bool
    {
        if ($slotA->dia_semana !== $slotB->dia_semana) return false;
        return $slotA->hora_inicio < $slotB->hora_fin && $slotB->hora_inicio < $slotA->hora_fin;
    }

    private function getDayName(int $dayNumber): string
    {
        return match ($dayNumber) {
            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles',
            4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo',
            default => "Día {$dayNumber}",
        };
    }
}