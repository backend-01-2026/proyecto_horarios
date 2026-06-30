@extends('layouts.app')

@section('title', 'Nuevo: Bloque horario')

@section('content')
<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Registrar Bloque horario</h1>

    <form method="POST" action="{{ route('time-slots.store') }}" class="bg-white p-6 rounded-lg shadow">
        @csrf
            <div class="mb-4">
                <label for="dia_semana" class="block text-sm font-medium text-gray-700 mb-1">Dia de la semana (1=Lun .. 7=Dom)</label>
                <input type="number" name="dia_semana" id="dia_semana" value="{{ old('dia_semana', '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-700">
                @error('dia_semana')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="hora_inicio" class="block text-sm font-medium text-gray-700 mb-1">Hora inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-700">
                @error('hora_inicio')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="hora_fin" class="block text-sm font-medium text-gray-700 mb-1">Hora fin</label>
                <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', '') }}" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-700">
                @error('hora_fin')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="px-4 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
                Guardar
            </button>
            <a href="{{ route('time-slots.index') }}" class="px-4 py-2 text-gray-700 font-semibold bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
