@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 sm:px-6">
    
    <div class="relative bg-white rounded-4xl shadow-2xl shadow-indigo-100 border border-gray-100 overflow-hidden">
        
        <div class="h-32 bg-linear-to-r from-olive-950 to-red-600"></div>

        <div class="px-8 pb-8">
            <div class="relative -mt-16 mb-6">
                <div class="w-32 h-32 bg-white rounded-full p-2 shadow-xl shadow-red-200">
                    <div class="w-full h-full bg-red-50 rounded-full flex items-center justify-center text-2xl font-bold text-olivw-950 uppercase">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ auth()->user()->name }}</h2>
                <p class="text-red-500 font-medium">Perfil de Usuario</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Correo Electrónico</label>
                    <p class="text-gray-700 font-medium mt-1">{{ auth()->user()->email }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Rol del Sistema</label>
                    @if(auth()->user()->role)
                        <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-bold rounded-lg mt-1">
                            {{ auth()->user()->role }}
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 bg-gray-200 text-gray-600 text-sm font-bold rounded-lg mt-1 italic">
                            Sin asignar
                        </span>
                    @endif
                </div>

                <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 col-span-1 md:col-span-2">
                    <label class="block text-[10px] uppercase font-bold text-gray-400 tracking-widest">Registrado el</label>
                    <p class="text-gray-700 font-medium mt-1">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap gap-4">
                <a href="#" class="flex-1 text-center bg-gray-900 hover:bg-gray-800 text-white py-4 rounded-2xl font-bold transition-all transform hover:scale-[1.02] shadow-lg shadow-gray-300">
                    Editar Perfil
                </a>
                <a href="#" class="flex-1 text-center bg-white border-2 border-gray-100 hover:border-indigo-200 hover:bg-indigo-100 text-gray-700 py-4 rounded-2xl font-bold transition-all transform hover:scale-[1.02]">
                    Cambiar Contraseña
                </a>
            </div>
        </div>
    </div>
</div>
@endsection