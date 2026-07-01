<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Académico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Sistema Académico</a>

        <div>
            <a href="{{ route('students.index') }}" class="btn btn-outline-light btn-sm">Estudiantes</a>
            <a href="{{ route('enrollments.index') }}" class="btn btn-outline-light btn-sm">Matrículas</a>
            <a href="/student-subjects" class="btn btn-outline-light btn-sm">Materias</a>
        </div>
    </div>
</nav>

<!-- 🔥 AQUÍ VAN LOS MENSAJES (FUERA DEL NAVBAR) -->
<div class="container mt-3">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

</div>

<!-- CONTENIDO PRINCIPAL -->
<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>