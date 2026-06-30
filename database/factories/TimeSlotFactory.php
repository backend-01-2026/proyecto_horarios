<?php

namespace Database\Factories;

use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeSlotFactory extends Factory
{
    protected $model = TimeSlot::class;

    public function definition(): array
    {
        return [
            'dia_semana' => fake()->numberBetween(1, 5),
            'hora_inicio' => fake()->randomElement(['08:00', '09:30', '11:00', '14:00', '15:30']),
            'hora_fin' => fake()->randomElement(['09:30', '11:00', '12:30', '15:30', '17:00']),
        ];
    }
}
