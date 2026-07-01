@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Estudiantes</h3>
    <a href="{{ route('students.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">Editar</a>
                <a href="/students/{{ $student->id }}/subjects" class="btn btn-info btn-sm">Materias</a>

                <form action="{{ route('students.destroy', $student) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection