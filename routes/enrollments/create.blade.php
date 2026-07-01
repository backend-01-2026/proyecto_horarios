@extends('layouts.app')

@section('content')

<h3>Nueva Matrícula</h3>

<form method="POST" action="{{ route('enrollments.store') }}">
    @csrf

    <div class="mb-3">
        <label>Estudiante</label>
        <select name="student_id" class="form-control">
            @foreach($students as $student)
                <option value="{{ $student->id }}">{{ $student->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Grupo</label>
        <select name="group_id" class="form-control">
            @foreach($groups as $group)
                <option value="{{ $group->id }}">{{ $group->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>Semestre</label>
        <select name="semester_id" class="form-control">
            @foreach($semesters as $semester)
                <option value="{{ $semester->id }}">{{ $semester->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Guardar</button>
</form>

@endsection