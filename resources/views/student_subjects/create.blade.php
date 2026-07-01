@extends('layouts.app')

@section('content')

<h3>Asignar Materias a Estudiantes</h3>

<form method="POST" action="{{ route('student.subjects.store') }}">
@csrf

<div class="mb-3">
    <label>Estudiante</label>
    <select name="student_id" class="form-control" required>
        @foreach($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Materia</label>
    <select name="subject_id" class="form-control" required>
        @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
        @endforeach
    </select>
</div>

<button class="btn btn-primary">Asignar Materia</button>

</form>

@endsection