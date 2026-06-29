@extends('layouts.app')

@section('title', 'Clases Disponibles')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Clases Disponibles</h1>
        <a href="{{ route('available-classes.create') }}" class="px-4 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
            + Nueva Clase
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm text-left">
            <thead class="text-white bg-red-800">
                <tr>
                    <th class="px-4 py-3">Materia</th>
                    <th class="px-4 py-3">Profesor</th>
                    <th class="px-4 py-3">Aula</th>
                    <th class="px-4 py-3">Horario</th>
                    <th class="px-4 py-3">Semestre</th>
                    <th class="px-4 py-3">Grupo</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($availableClasses as $class)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $class->subject->sigla }} - {{ $class->subject->nombre }}</td>
                        <td class="px-4 py-3">{{ $class->teacher->nombre_completo }}</td>
                        <td class="px-4 py-3">{{ $class->classroom->codigo }}</td>
                        <td class="px-4 py-3">{{ $class->timeSlot->dia_semana }} {{ $class->timeSlot->hora_inicio }}-{{ $class->timeSlot->hora_fin }}</td>
                        <td class="px-4 py-3">{{ $class->semester->nombre }}</td>
                        <td class="px-4 py-3">{{ $class->group->nombre }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('available-classes.show', $class) }}" class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">Ver</a>
                            <a href="{{ route('available-classes.edit', $class) }}" class="px-3 py-1 text-xs text-white bg-yellow-600 rounded hover:bg-yellow-700">Editar</a>
                            <form method="POST" action="{{ route('available-classes.destroy', $class) }}" onsubmit="return confirm('¿Eliminar esta clase disponible?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No hay clases disponibles registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $availableClasses->links() }}
    </div>
</div>
@endsection
