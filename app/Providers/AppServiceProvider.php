<?php

namespace App\Providers;

use App\Models\SavedSchedule;
use App\Observers\ClassSelectionObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            \App\Services\ScheduleService::class,
            fn () => new \App\Services\ScheduleService()
        );
    }

    public function boot(): void
    {
        // Registro del observer para las selecciones de horario
        SavedSchedule::observe(ClassSelectionObserver::class);

        /**
         * Desactivamos la protección de asignación masiva SOLO durante los tests.
         */
        if ($this->app->runningUnitTests()) {
            Model::unguard();
        }
    }
}