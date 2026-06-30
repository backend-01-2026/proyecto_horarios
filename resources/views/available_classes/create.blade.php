@extends('layouts.app')

@section('title', 'Nueva Clase Disponible')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Registrar Nueva Clase Disponible</h1>

    <form method="POST" action="{{ route('available-classes.store') }}" class="p-6 bg-white rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Materia</label>
            <select name="subject_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Seleccionar materia</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->sigla }} - {{ $subject->nombre }}
                    </option>
                @endforeach
            </select>
            @error('subject_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Profesor</label>
            <select name="teacher_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Seleccionar profesor</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->prefijo_academico }} {{ $teacher->nombre_completo }}
                    </option>
                @endforeach
            </select>
            @error('teacher_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Aula</label>
            <select name="classroom_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Seleccionar aula</option>
                @foreach ($classrooms as $classroom)
                    <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>
                        {{ $classroom->codigo }}
                    </option>
                @endforeach
            </select>
            @error('classroom_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Horario</label>
            <select name="time_slot_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Seleccionar horario</option>
                @foreach ($timeSlots as $timeSlot)
                    <option value="{{ $timeSlot->id }}" {{ old('time_slot_id') == $timeSlot->id ? 'selected' : '' }}>
                        Día {{ $timeSlot->dia_semana }} · {{ $timeSlot->hora_inicio }} - {{ $timeSlot->hora_fin }}
                    </option>
                @endforeach
            </select>
            @error('time_slot_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Semestre</label>
            <select name="semester_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Seleccionar semestre</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" {{ old('semester_id') == $semester->id ? 'selected' : '' }}>
                        {{ $semester->nombre }}
                    </option>
                @endforeach
            </select>
            @error('semester_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Grupo</label>
            <select name="group_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Seleccionar grupo</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->nombre }}
                    </option>
                @endforeach
            </select>
            @error('group_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold text-gray-700">Especialidad (opcional)</label>
            <select name="specialty_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-red-600 focus:ring-2 focus:ring-red-300 outline-none">
                <option value="">Sin especialidad</option>
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected' : '' }}>
                        {{ $specialty->nombre }}
                    </option>
                @endforeach
            </select>
            @error('specialty_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
                Guardar
            </button>
            <a href="{{ route('available-classes.index') }}" class="px-6 py-2 text-gray-700 font-semibold bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
