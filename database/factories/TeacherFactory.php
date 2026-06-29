<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    public function definition(): array
    {
        return [
            'prefijo_academico' => fake()->randomElement(['Lic.', 'Ing.', 'M.Sc.', 'Ph.D.']),
            'nombre_completo' => fake()->name(),
        ];
    }
}
