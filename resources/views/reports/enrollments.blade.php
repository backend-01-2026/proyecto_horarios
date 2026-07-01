@extends('layouts.app')

@section('content')

<h2>Reporte de Matrículas</h2>

<table class="table">

<thead>

<tr>

<th>Estudiante</th>
<th>Grupo</th>
<th>Semestre</th>

</tr>

</thead>

<tbody>

@foreach($enrollments as $e)

<tr>

<td>{{ $e->student->name }}</td>

<td>{{ $e->group->name }}</td>

<td>{{ $e->semester->name }}</td>

</tr>

@endforeach

</tbody>

</table>

@endsection