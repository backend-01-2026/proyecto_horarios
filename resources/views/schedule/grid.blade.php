@extends('layouts.app')

@section('title', 'Horario')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Horario General</h1>
        <a href="{{ route('schedule.print') }}" target="_blank" class="px-4 py-2 text-white font-semibold bg-gray-700 rounded-lg shadow hover:bg-gray-800 transition">
            Imprimir
        </a>
    </div>

    <form method="GET" action="{{ route('schedule.grid') }}" class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Especialidad</label>
            <select name="specialty_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todas</option>
                @foreach ($specialties as $specialty)
                    <option value="{{ $specialty->id }}" @selected(request('specialty_id') == $specialty->id)>{{ $specialty->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Semestre</label>
            <select name="semester_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todos</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" @selected(request('semester_id') == $semester->id)>{{ $semester->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Docente</label>
            <select name="teacher_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todos</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @selected(request('teacher_id') == $teacher->id)>{{ $teacher->nombre_completo }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Grupo</label>
            <select name="group_id" class="w-full border rounded-lg px-3 py-2">
                <option value="">Todos</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}" @selected(request('group_id') == $group->id)>{{ $group->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:col-span-4 flex justify-end">
            <button type="submit" class="px-4 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
                Filtrar
            </button>
        </div>
    </form>

    @php
        $dias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miercoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sabado', 7 => 'Domingo'];
        $horas = collect($grid)->flatMap(fn ($porHora) => array_keys($porHora))->unique()->sort()->values();
    @endphp

    @if ($horas->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
            No hay clases que coincidan con los filtros seleccionados.
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="text-white bg-red-800">
                    <tr>
                        <th class="px-3 py-3 border border-red-900">Hora</th>
                        @foreach ($dias as $diaNum => $diaNombre)
                            <th class="px-3 py-3 border border-red-900">{{ $diaNombre }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($horas as $hora)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border font-semibold text-gray-600">{{ $hora }}</td>
                            @foreach ($dias as $diaNum => $diaNombre)
                                <td class="px-3 py-2 border align-top">
                                    @if (isset($grid[$diaNum][$hora]))
                                        @foreach ($grid[$diaNum][$hora] as $class)
                                            <div class="mb-1 p-2 rounded bg-blue-50 border border-blue-200">
                                                <p class="font-semibold text-blue-900">{{ $class->subject->sigla }}</p>
                                                <p class="text-xs text-gray-600">{{ $class->teacher->nombre_completo }}</p>
                                                <p class="text-xs text-gray-500">{{ $class->classroom->codigo }} · {{ $class->group->nombre }}</p>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
