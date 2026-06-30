@extends('layouts.app')

@section('title', 'Nuevo Horario')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Armar mi Horario</h1>

    <form method="POST" action="{{ route('saved-schedules.store') }}">
        @csrf

        <div class="bg-white p-6 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="nombre_horario" class="block text-sm font-medium text-gray-700 mb-1">Nombre del horario</label>
                <input type="text" name="nombre_horario" id="nombre_horario" value="{{ old('nombre_horario') }}" class="w-full border rounded-lg px-3 py-2">
                @error('nombre_horario')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="gestion" class="block text-sm font-medium text-gray-700 mb-1">Gestion</label>
                <input type="text" name="gestion" id="gestion" placeholder="Ej. 2026-2" value="{{ old('gestion') }}" class="w-full border rounded-lg px-3 py-2">
                @error('gestion')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @error('available_class_ids')
            <p class="text-red-600 text-sm mb-3">{{ $message }}</p>
        @enderror

        <div class="overflow-x-auto bg-white rounded-lg shadow mb-6">
            <table class="w-full text-sm text-left">
                <thead class="text-white bg-red-800">
                    <tr>
                        <th class="px-4 py-3">Elegir</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Docente</th>
                        <th class="px-4 py-3">Aula</th>
                        <th class="px-4 py-3">Horario</th>
                        <th class="px-4 py-3">Grupo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($availableClasses as $class)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="available_class_ids[]" value="{{ $class->id }}"
                                    @checked(collect(old('available_class_ids', []))->contains($class->id))>
                            </td>
                            <td class="px-4 py-3">{{ $class->subject->sigla }} - {{ $class->subject->nombre }}</td>
                            <td class="px-4 py-3">{{ $class->teacher->nombre_completo }}</td>
                            <td class="px-4 py-3">{{ $class->classroom->codigo }}</td>
                            <td class="px-4 py-3">{{ $class->timeSlot->dia_semana }} {{ $class->timeSlot->hora_inicio }}-{{ $class->timeSlot->hora_fin }}</td>
                            <td class="px-4 py-3">{{ $class->group->nombre }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">No hay clases disponibles registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-4 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
                Guardar Horario
            </button>
            <a href="{{ route('saved-schedules.index') }}" class="px-4 py-2 text-gray-700 font-semibold bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
