@extends('layouts.app')

@section('title', 'Inicio')

@section('breadcrumbs')
    <a href="{{ url('/') }}" class="hover:underline">Escritorio</a>
@endsection

@section('content')

    {{-- Bienvenida --}}
    <div class="mb-6">
        <h2 class="font-display text-2xl font-bold text-slate-800">Hola, Estudiante 👋</h2>
        <p class="text-slate-500 mt-1">Este es el resumen de tu semana académica.</p>
    </div>

    {{-- Tarjetas de resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        {{-- Materias --}}
        <div class="rounded-2xl bg-blue-600 text-white p-5 shadow-lg shadow-blue-600/20 hover:-translate-y-1 transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-3xl font-bold font-display">5</span> #Ejemplo
                <span class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-sm font-medium text-white/90">Materias inscritas</p>
            <a href="#" class="mt-4 inline-flex items-center text-xs font-semibold text-white/80 hover:text-white">
                Ver detalles →
            </a>
        </div>

        {{-- Horarios creados --}}
        <div class="rounded-2xl bg-amber-500 text-white p-5 shadow-lg shadow-amber-500/20 hover:-translate-y-1 transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-3xl font-bold font-display">3</span> #Ejemplo 
                <span class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-sm font-medium text-white/90">Horarios creados</p>
            <a href="#" class="mt-4 inline-flex items-center text-xs font-semibold text-white/80 hover:text-white">
                Ver detalles →
            </a>
        </div>

        {{-- Clases hoy --}}
        <div class="rounded-2xl bg-emerald-600 text-white p-5 shadow-lg shadow-emerald-600/20 hover:-translate-y-1 transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-3xl font-bold font-display">2</span> #Ejemplo
                <span class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 1 1-20 0 10 10 0 0 1 20 0Z" />
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-sm font-medium text-white/90">Clases hoy</p>
            <a href="#" class="mt-4 inline-flex items-center text-xs font-semibold text-white/80 hover:text-white">
                Ver detalles →
            </a>
        </div>

        {{-- Próximo examen --}}
        <div class="rounded-2xl bg-rose-600 text-white p-5 shadow-lg shadow-rose-600/20 hover:-translate-y-1 transition duration-200">
            <div class="flex items-center justify-between">
                <span class="text-3xl font-bold font-display">1</span> #Ejemplo
                <span class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </span>
            </div>
            <p class="mt-3 text-sm font-medium text-white/90">Próximo examen</p>
            <a href="#" class="mt-4 inline-flex items-center text-xs font-semibold text-white/80 hover:text-white">
                Ver detalles →
            </a>
        </div>

    </div>

    {{-- Panel de accesos rápidos --}}
    <div class="rounded-2xl bg-white shadow-md p-6">
        <h3 class="font-display text-lg font-bold text-slate-800">Accesos rápidos</h3>
        <p class="text-slate-500 text-sm mt-1">Continúa organizando tu semana.</p>

        <div class="flex flex-wrap gap-3 mt-4">
            <a href="{{ url('/perfil') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-blue-600 text-white text-sm font-semibold px-4 py-2.5 hover:bg-blue-700 transition">
                Mi Perfil
            </a>
            <a href="{{ url('/horarios') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-slate-800 text-white text-sm font-semibold px-4 py-2.5 hover:bg-slate-900 transition">
                Crear Horario
            </a>
        </div>
    </div>

@endsection