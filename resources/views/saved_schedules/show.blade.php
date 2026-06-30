@extends('layouts.app')

@section('title', $savedSchedule->nombre_horario)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $savedSchedule->nombre_horario }}</h1>
            <p class="text-sm text-gray-500">Gestion: {{ $savedSchedule->gestion }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('saved-schedules.print', $savedSchedule) }}" target="_blank" class="px-4 py-2 text-white font-semibold bg-gray-700 rounded-lg shadow hover:bg-gray-800 transition">
                Imprimir
            </a>
            <a href="{{ route('saved-schedules.index') }}" class="px-4 py-2 text-gray-700 font-semibold bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Volver
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @php
        $dias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miercoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sabado', 7 => 'Domingo'];
        $horas = collect($grid)->flatMap(fn ($porHora) => array_keys($porHora))->unique()->sort()->values();
    @endphp

    @if ($horas->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow text-center text-gray-500">
            Este horario no tiene clases asignadas.
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
                                        @php $class = $grid[$diaNum][$hora]; @endphp
                                        <div class="p-2 rounded bg-blue-50 border border-blue-200">
                                            <p class="font-semibold text-blue-900">{{ $class->subject->sigla }}</p>
                                            <p class="text-xs text-gray-600">{{ $class->teacher->nombre_completo }}</p>
                                            <p class="text-xs text-gray-500">{{ $class->classroom->codigo }}</p>
                                        </div>
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
