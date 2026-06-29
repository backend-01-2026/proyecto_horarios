<?php

namespace App\Observers;

use App\Models\AvailableClass;
use App\Models\SavedSchedule;
use Illuminate\Support\Facades\Log;

/**
 * ClassSelectionObserver
 *
 * Monitorea los eventos pivot de la relación many-to-many entre
 * SavedSchedule y AvailableClass (tabla 'class_selections').
 *
 * IMPORTANTE: El AuditLog y el ProcessTeacherNotification son responsabilidad
 * del ScheduleService, que los registra directamente con datos completos.
 * Este Observer solo registra en el log del sistema como respaldo informativo.
 *
 * Registro: AppServiceProvider::boot()
 */
class ClassSelectionObserver
{
    public function pivotAttached(SavedSchedule $savedSchedule, string $relationName, array $pivotIds, array $pivotIdsAttributes): void
    {
        if ($relationName !== 'availableClasses') return;
        foreach ($pivotIds as $availableClassId) {
            Log::info('ClassSelectionObserver: pivotAttached', [
                'saved_schedule_id'  => $savedSchedule->id,
                'available_class_id' => $availableClassId,
            ]);
        }
    }

    public function pivotDetached(SavedSchedule $savedSchedule, string $relationName, array $pivotIds): void
    {
        if ($relationName !== 'availableClasses') return;
        foreach ($pivotIds as $availableClassId) {
            Log::info('ClassSelectionObserver: pivotDetached', [
                'saved_schedule_id'  => $savedSchedule->id,
                'available_class_id' => $availableClassId,
            ]);
        }
    }
}