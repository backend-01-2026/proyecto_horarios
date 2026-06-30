<?php

namespace Database\Factories;

use App\Models\AvailableClass;
use App\Models\Classroom;
use App\Models\Group;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimeSlot;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailableClassFactory extends Factory
{
    protected $model = AvailableClass::class;

    public function definition(): array
    {
        return [
            'subject_id' => Subject::factory(),
            'teacher_id' => Teacher::factory(),
            'classroom_id' => Classroom::factory(),
            'time_slot_id' => TimeSlot::factory(),
            'semester_id' => Semester::factory(),
            'group_id' => Group::factory(),
            'specialty_id' => null,
        ];
    }
}
