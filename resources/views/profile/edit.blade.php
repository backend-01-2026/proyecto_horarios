@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        
        <div class="bg-red-700 text-white p-6">
            <h2 class="text-xl font-bold">Modificar Información Personal</h2>
            <p class="text-xs text-red-200">Universidad Autónoma Tomás Frías — Panel de Perfil</p>
        </div>

        <form action="{{ url('/api/users/' . $user->id) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT') @if(session('success'))
                <div class="p-4 rounded-xl text-sm font-semibold bg-emerald-50 text-emerald-700 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-medium text-gray-700">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Apellido</label>
                    <input type="text" name="lastname" value="{{ old('lastname', $user->lastname) }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-medium text-gray-700">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-medium text-gray-700">
            </div>

            <div class="pt-4 border-t border-gray-100">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nueva Contraseña (Opcional)</label>
                <input type="password" name="password" placeholder="Dejar en blanco para no cambiar" minlength="8"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-red-500 font-medium text-gray-700">
                <p class="text-[10px] text-gray-400 mt-1">Si decides cambiarla, debe incluir mayúscula, minúscula y número.</p>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <a href="{{ url('/perfil') }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 py-3 rounded-xl font-bold transition">
                    Cancelar
                </a>
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-3 rounded-xl font-bold transition shadow-lg shadow-red-100">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection