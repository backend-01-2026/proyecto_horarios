<?php

namespace App\Http\Requests;

use App\Models\AvailableClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreAvailableClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'classroom_id' => ['required', 'exists:classrooms,id'],
            'time_slot_id' => ['required', 'exists:time_slots,id'],
            'semester_id' => ['required', 'exists:semesters,id'],
            'group_id' => ['required', 'exists:groups,id'],
            'specialty_id' => ['nullable', 'exists:specialties,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $this->validateNoScheduleConflict($validator);
            },
        ];
    }

    protected function validateNoScheduleConflict(Validator $validator): void
    {
        $timeSlotId = $this->input('time_slot_id');
        $semesterId = $this->input('semester_id');
        $teacherId = $this->input('teacher_id');
        $classroomId = $this->input('classroom_id');
        $groupId = $this->input('group_id');

        $this->checkTeacherConflict($validator, $teacherId, $timeSlotId, $semesterId);
        $this->checkClassroomConflict($validator, $classroomId, $timeSlotId, $semesterId);
        $this->checkGroupConflict($validator, $groupId, $timeSlotId, $semesterId);
    }

    protected function checkTeacherConflict(Validator $validator, int $teacherId, int $timeSlotId, int $semesterId): void
    {
        $exists = AvailableClass::where('teacher_id', $teacherId)
            ->where('time_slot_id', $timeSlotId)
            ->where('semester_id', $semesterId)
            ->exists();

        if ($exists) {
            $validator->errors()->add(
                'teacher_id',
                'El profesor ya tiene una clase programada en este horario y semestre.'
            );
        }
    }

    protected function checkClassroomConflict(Validator $validator, int $classroomId, int $timeSlotId, int $semesterId): void
    {
        $exists = AvailableClass::where('classroom_id', $classroomId)
            ->where('time_slot_id', $timeSlotId)
            ->where('semester_id', $semesterId)
            ->exists();

        if ($exists) {
            $validator->errors()->add(
                'classroom_id',
                'El aula ya está ocupada en este horario y semestre.'
            );
        }
    }

    protected function checkGroupConflict(Validator $validator, int $groupId, int $timeSlotId, int $semesterId): void
    {
        $exists = AvailableClass::where('group_id', $groupId)
            ->where('time_slot_id', $timeSlotId)
            ->where('semester_id', $semesterId)
            ->exists();

        if ($exists) {
            $validator->errors()->add(
                'group_id',
                'El grupo ya tiene una clase programada en este horario y semestre.'
            );
        }
    }
}
