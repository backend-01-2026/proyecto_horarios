@extends('layouts.app')

@section('title', 'Especialidades')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Especialidades</h1>
        <a href="{{ route('specialties.create') }}" class="px-4 py-2 text-white font-semibold bg-red-700 rounded-lg shadow hover:bg-red-800 transition">
            + Nuevo
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm text-left">
            <thead class="text-white bg-red-800">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($specialties as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $item->nombre }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('specialties.show', $item) }}" class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700">Ver</a>
                            <a href="{{ route('specialties.edit', $item) }}" class="px-3 py-1 text-xs text-white bg-yellow-600 rounded hover:bg-yellow-700">Editar</a>
                            <form method="POST" action="{{ route('specialties.destroy', $item) }}" onsubmit="return confirm('¿Eliminar este registro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-xs text-white bg-red-600 rounded hover:bg-red-700">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-8 text-center text-gray-500">No hay registros de especialidades.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $specialties->links() }}
    </div>
</div>
@endsection
