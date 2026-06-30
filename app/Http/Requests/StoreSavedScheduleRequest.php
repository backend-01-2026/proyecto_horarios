<?php

namespace App\Http\Requests;

use App\Models\AvailableClass;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreSavedScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_horario' => ['required', 'string', 'max:255'],
            'gestion' => ['required', 'string', 'max:50'],
            'available_class_ids' => ['required', 'array', 'min:1'],
            'available_class_ids.*' => ['integer', 'exists:available_classes,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $this->validateNoOverlapBetweenSelectedClasses($validator);
            },
        ];
    }

    /**
     * Verifica que, entre las clases elegidas por el usuario para este horario,
     * no haya dos que compartan el mismo bloque horario (time_slot) en el mismo semestre.
     */
    protected function validateNoOverlapBetweenSelectedClasses(Validator $validator): void
    {
        $ids = $this->input('available_class_ids', []);

        if (empty($ids)) {
            return;
        }

        $classes = AvailableClass::whereIn('id', $ids)->get(['id', 'time_slot_id', 'semester_id']);

        $seen = [];

        foreach ($classes as $class) {
            $key = $class->time_slot_id.'-'.$class->semester_id;

            if (isset($seen[$key])) {
                $validator->errors()->add(
                    'available_class_ids',
                    'Seleccionaste dos clases que se cruzan en el mismo horario y semestre.'
                );
                break;
            }

            $seen[$key] = true;
        }
    }
}
