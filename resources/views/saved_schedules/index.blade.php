@extends('layouts.app')

@section('title', 'Mis Horarios')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mis Horarios Guardados</h1>
        <a href="{{ route('saved-schedules.create') }}" class="px-4 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
            + Nuevo Horario
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($savedSchedules as $schedule)
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="font-bold text-gray-800">{{ $schedule->nombre_horario }}</h2>
                <p class="text-sm text-gray-500 mb-3">Gestion: {{ $schedule->gestion }}</p>
                <div class="flex gap-2">
                    <a href="{{ route('saved-schedules.show', $schedule) }}" class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">Ver</a>
                    <form method="POST" action="{{ route('saved-schedules.destroy', $schedule) }}" onsubmit="return confirm('¿Eliminar este horario guardado?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-8 rounded-lg shadow text-center text-gray-500">
                Aun no has guardado ningun horario.
            </div>
        @endforelse
    </div>
</div>
@endsection
