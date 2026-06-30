@extends('layouts.app')

@section('title', 'Detalle: Semestre')

@section('content')
<div class="p-6 max-w-xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Detalle de Semestre</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <div class="mb-4">
            <span class="block text-xs uppercase text-gray-400 font-semibold">Nombre</span>
            <span class="text-gray-800 text-base">{{ $semester->nombre }}</span>
        </div>
    </div>

    <div class="flex gap-3 mt-6">
        <a href="{{ route('semesters.edit', $semester) }}" class="px-4 py-2 text-white font-semibold bg-yellow-600 rounded-lg shadow hover:bg-yellow-700 transition">
            Editar
        </a>
        <a href="{{ route('semesters.index') }}" class="px-4 py-2 text-gray-700 font-semibold bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            Volver
        </a>
    </div>
</div>
@endsection
