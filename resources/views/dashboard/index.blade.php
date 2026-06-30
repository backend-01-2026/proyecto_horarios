@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Resumen General</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="rounded-2xl bg-blue-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['specialties'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Especialidades</p>
            <a href="{{ route('specialties.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-amber-500 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['semesters'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Semestres</p>
            <a href="{{ route('semesters.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-emerald-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['teachers'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Docentes</p>
            <a href="{{ route('teachers.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-purple-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['subjects'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Materias</p>
            <a href="{{ route('subjects.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-rose-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['classrooms'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Aulas</p>
            <a href="{{ route('classrooms.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-cyan-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['time_slots'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Bloques horarios</p>
            <a href="{{ route('time-slots.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-orange-600 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['groups'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Grupos</p>
            <a href="{{ route('groups.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>

        <div class="rounded-2xl bg-red-700 text-white p-5 shadow-lg">
            <span class="text-3xl font-bold">{{ $counters['available_classes'] }}</span>
            <p class="mt-2 text-sm font-medium text-white/90">Clases programadas</p>
            <a href="{{ route('available-classes.index') }}" class="mt-3 inline-block text-xs font-semibold text-white/80 hover:text-white">Ver detalles →</a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="bg-white p-5 rounded-2xl shadow">
            <h2 class="font-bold text-gray-800 mb-3">Ocupacion de Aulas</h2>
            <p class="text-sm text-gray-600">Total de aulas: <strong>{{ $classroomsTotal }}</strong></p>
            <p class="text-sm text-gray-600">Con clases asignadas: <strong>{{ $classroomsConClases }}</strong></p>
            <p class="text-sm text-gray-600">Libres (sin clases): <strong>{{ $classroomsLibres }}</strong></p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow">
            <h2 class="font-bold text-gray-800 mb-3">Carga de Docentes</h2>
            <p class="text-sm text-gray-600">Total de docentes: <strong>{{ $teachersTotal }}</strong></p>
            <p class="text-sm text-gray-600">Con clases asignadas: <strong>{{ $teachersConClases }}</strong></p>
            <p class="text-sm text-gray-600">Sin clases asignadas: <strong>{{ $teachersSinClases }}</strong></p>
        </div>
    </div>
</div>
@endsection
