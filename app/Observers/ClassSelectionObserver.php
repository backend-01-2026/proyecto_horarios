<?php

namespace App\Observers;

use App\Jobs\ProcessTeacherNotification;
use App\Models\AuditLog;
use App\Models\AvailableClass;
use App\Models\SavedSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ClassSelectionObserver
{
    public function pivotAttached(SavedSchedule $savedSchedule, string $relationName, array $pivotIds, array $pivotIdsAttributes): void
    {
        if ($relationName !== 'availableClasses') return;
        foreach ($pivotIds as $availableClassId) {
            $this->procesarCreacion($savedSchedule, (int) $availableClassId);
        }
    }

    public function pivotDetached(SavedSchedule $savedSchedule, string $relationName, array $pivotIds): void
    {
        if ($relationName !== 'availableClasses') return;
        foreach ($pivotIds as $availableClassId) {
            $this->procesarEliminacion($savedSchedule, (int) $availableClassId);
        }
    }

    private function procesarCreacion(SavedSchedule $savedSchedule, int $availableClassId): void
    {
        try {
            $availableClass = AvailableClass::with([
                'subject', 'teacher', 'classroom', 'timeSlot', 'semester', 'group'
            ])->find($availableClassId);

            if (! $availableClass) {
                Log::warning('ClassSelectionObserver: AvailableClass no encontrada', ['available_class_id' => $availableClassId]);
                return;
            }

            AuditLog::registrarCreacion(
                savedScheduleId:  $savedSchedule->id,
                availableClassId: $availableClassId,
                datosClase:       $this->buildClassSnapshot($availableClass),
                datosUsuario:     $this->buildUserSnapshot(),
                metadatos:        $this->buildRequestMetadata()
            );

            ProcessTeacherNotification::dispatch(
                $availableClass->teacher_id,
                'nueva_inscripcion',
                [
                    'saved_schedule_id'  => $savedSchedule->id,
                    'available_class_id' => $availableClassId,
                    'materia'            => $availableClass->subject->nombre,
                    'grupo'              => $availableClass->group->nombre,
                    'aula'               => $availableClass->classroom->codigo,
                    'horario'            => $this->formatTimeSlot($availableClass->timeSlot),
                    'estudiante_nombre'  => $savedSchedule->user->name ?? 'Estudiante',
                ]
            )->onQueue('notifications');

            Log::info('ClassSelectionObserver: Clase agregada al horario', [
                'saved_schedule_id'  => $savedSchedule->id,
                'available_class_id' => $availableClassId,
                'materia'            => $availableClass->subject->nombre,
            ]);

        } catch (\Throwable $e) {
            Log::error('ClassSelectionObserver::procesarCreacion falló', [
                'error'              => $e->getMessage(),
                'saved_schedule_id'  => $savedSchedule->id,
                'available_class_id' => $availableClassId,
            ]);
        }
    }

    private function procesarEliminacion(SavedSchedule $savedSchedule, int $availableClassId): void
    {
        try {
            $availableClass = AvailableClass::with([
                'subject', 'teacher', 'classroom', 'timeSlot', 'semester', 'group'
            ])->find($availableClassId);

            $datosClase = $availableClass
                ? $this->buildClassSnapshot($availableClass)
                : ['available_class_id' => $availableClassId];

            AuditLog::registrarEliminacion(
                savedScheduleId:  $savedSchedule->id,
                availableClassId: $availableClassId,
                datosClase:       $datosClase,
                datosUsuario:     $this->buildUserSnapshot(),
                metadatos:        $this->buildRequestMetadata()
            );

            Log::info('ClassSelectionObserver: Clase removida del horario', [
                'saved_schedule_id'  => $savedSchedule->id,
                'available_class_id' => $availableClassId,
            ]);

        } catch (\Throwable $e) {
            Log::error('ClassSelectionObserver::procesarEliminacion falló', [
                'error'              => $e->getMessage(),
                'saved_schedule_id'  => $savedSchedule->id,
                'available_class_id' => $availableClassId,
            ]);
        }
    }

    private function buildClassSnapshot(AvailableClass $class): array
    {
        return [
            'available_class_id' => $class->id,
            'subject'   => ['id' => $class->subject?->id,   'sigla'  => $class->subject?->sigla,   'nombre' => $class->subject?->nombre],
            'teacher'   => ['id' => $class->teacher?->id,   'prefijo' => $class->teacher?->prefijo_academico, 'nombre_completo' => $class->teacher?->nombre_completo],
            'classroom' => ['id' => $class->classroom?->id, 'codigo' => $class->classroom?->codigo],
            'time_slot' => ['id' => $class->timeSlot?->id,  'dia_semana' => $class->timeSlot?->dia_semana, 'hora_inicio' => $class->timeSlot?->hora_inicio, 'hora_fin' => $class->timeSlot?->hora_fin],
            'semester'  => ['id' => $class->semester?->id,  'nombre' => $class->semester?->nombre],
            'group'     => ['id' => $class->group?->id,     'nombre' => $class->group?->nombre],
            'specialty' => $class->specialty ? ['id' => $class->specialty->id, 'nombre' => $class->specialty->nombre] : null,
        ];
    }

    private function buildUserSnapshot(): array
    {
        $user = Auth::user();
        if (! $user) return [];
        return ['id' => $user->id, 'nombre' => $user->name, 'email' => $user->email, 'rol' => $user->rol ?? 'estudiante'];
    }

    private function buildRequestMetadata(): array
    {
        return ['ip' => Request::ip(), 'user_agent' => Request::userAgent()];
    }

    private function formatTimeSlot(mixed $timeSlot): string
    {
        if (! $timeSlot) return 'Sin horario';
        $dias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $dia  = $dias[$timeSlot->dia_semana] ?? "Día {$timeSlot->dia_semana}";
        return "{$dia} {$timeSlot->hora_inicio} - {$timeSlot->hora_fin}";
    }
}