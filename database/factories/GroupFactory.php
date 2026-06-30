<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->randomElement(['A', 'B', 'C', 'D', '1', '2', '3']),
        ];
    }
}
