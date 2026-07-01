@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Resumen General</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <div class="rounded-2xl bg-blue-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['specialties'] ?? 0 }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Especialidades</p>
            <a href="{{ url('/specialties') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-amber-500 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['semesters'] ?? 0 }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Semestres</p>
            <a href="{{ url('/semesters') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-emerald-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['subjects'] ?? 0 }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Materias</p>
            <a href="{{ url('/subjects') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-purple-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['teachers'] ?? 0 }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Profesores Total</p>
            <a href="{{ url('/teachers') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <span class="w-3 h-3 bg-red-600 rounded-full mr-2"></span> Ocupación de Aulas
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total de Aulas:</span>
                    <span class="font-bold text-gray-800">{{ $classroomsTotal ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-emerald-600 font-medium">Aulas Libres (Disponibles):</span>
                    <span class="font-bold text-emerald-600">{{ $classroomsLibres ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-amber-600 font-medium">Aulas con Clases Asignadas:</span>
                    <span class="font-bold text-amber-600">{{ $classroomsConClases ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                <span class="w-3 h-3 bg-gray-800 rounded-full mr-2"></span> Estado de Docentes
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Docentes:</span>
                    <span class="font-bold text-gray-800">{{ $teachersTotal ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-indigo-600 font-medium">Docentes con Horario Activo:</span>
                    <span class="font-bold text-indigo-600">{{ $teachersConClases ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 font-medium">Docentes sin Clases Asignadas:</span>
                    <span class="font-bold text-gray-500">{{ $teachersSinClases ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
