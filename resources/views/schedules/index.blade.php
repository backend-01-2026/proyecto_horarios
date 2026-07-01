@extends('layouts.app')

@section('content')

<h2>Horarios Académicos</h2>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>Materia</th>
<th>Profesor</th>
<th>Grupo</th>
<th>Aula</th>
<th>Horario</th>
<th>Semestre</th>

</tr>

</thead>

<tbody>

@foreach($classes as $class)

<tr>

<td>{{ $class->subject->name }}</td>

<td>{{ $class->teacher->name }}</td>

<td>{{ $class->group->name }}</td>

<td>{{ $class->classroom->name }}</td>

<td>{{ $class->timeSlot->day }}</td>

<td>{{ $class->semester->name }}</td>

</tr>

@endforeach

</tbody>

</table>

@endsection