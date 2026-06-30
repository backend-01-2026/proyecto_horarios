@extends('layouts.app')

@section('title', 'Detalle de Clase Disponible')

@section('content')
<div class="p-6 max-w-2xl mx-auto">
    <h1 class="mb-6 text-2xl font-bold text-gray-800">Detalle de Clase Disponible</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <tbody class="divide-y divide-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50 w-1/3">Materia</th>
                    <td class="px-6 py-3">{{ $availableClass->subject->sigla }} - {{ $availableClass->subject->nombre }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Profesor</th>
                    <td class="px-6 py-3">{{ $availableClass->teacher->prefijo_academico }} {{ $availableClass->teacher->nombre_completo }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Aula</th>
                    <td class="px-6 py-3">{{ $availableClass->classroom->codigo }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Horario</th>
                    <td class="px-6 py-3">Día {{ $availableClass->timeSlot->dia_semana }} · {{ $availableClass->timeSlot->hora_inicio }} - {{ $availableClass->timeSlot->hora_fin }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Semestre</th>
                    <td class="px-6 py-3">{{ $availableClass->semester->nombre }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Grupo</th>
                    <td class="px-6 py-3">{{ $availableClass->group->nombre }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Especialidad</th>
                    <td class="px-6 py-3">{{ $availableClass->specialty?->nombre ?? 'Sin especialidad' }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Creado</th>
                    <td class="px-6 py-3">{{ $availableClass->created_at }}</td>
                </tr>
                <tr>
                    <th class="px-6 py-3 text-left text-gray-600 bg-gray-50">Actualizado</th>
                    <td class="px-6 py-3">{{ $availableClass->updated_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex gap-3 mt-6">
        <a href="{{ route('available-classes.edit', $availableClass) }}" class="px-4 py-2 text-white font-semibold bg-yellow-600 rounded-lg hover:bg-yellow-700 transition">
            Editar
        </a>
        <a href="{{ route('available-classes.index') }}" class="px-4 py-2 text-gray-700 font-semibold bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            Volver
        </a>
    </div>
</div>
@endsection
