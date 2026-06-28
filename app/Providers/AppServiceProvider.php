<?php

namespace App\Providers;

use App\Models\SavedSchedule;
use App\Observers\ClassSelectionObserver;
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
        SavedSchedule::observe(ClassSelectionObserver::class);
    }
}