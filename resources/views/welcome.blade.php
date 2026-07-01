<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Horarios - UATF</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 font-sans flex flex-col min-h-screen">

    <header class="bg-red-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white text-red-700 font-bold p-2 rounded-full w-10 h-10 flex items-center justify-center shadow">
                    U
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight leading-none">U.A.T.F.</h1>
                    <span class="text-xs text-red-200">Universidad Autónoma Tomás Frías</span>
                </div>
            </div>
            
            <div>
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white text-red-700 px-4 py-2 rounded-lg font-semibold shadow hover:bg-gray-100 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-white hover:text-red-200 font-semibold transition">Iniciar Sesión</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-white text-red-700 px-4 py-2 rounded-lg font-semibold shadow hover:bg-gray-100 transition">Registrarse</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </header>

    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="max-w-4xl w-full text-center space-y-8">
            <div class="space-y-4">
                <span class="bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full uppercase tracking-wider">
                    Facultad de Ciencias Puras / Ingeniería
                </span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">
                    Sistema de Gestión de <span class="text-red-700">Horarios Académicos</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Plataforma universitaria para la consulta, asignación y control de horarios de clases, materias y ambientes de la U.A.T.F.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 max-w-2xl mx-auto text-left">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-700 mb-4">
                        <i data-lucide="calendar"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Consulta de Horarios</h3>
                    <p class="text-gray-600 text-sm mb-4">Revisa las asignaturas disponibles, docentes y aulas asignadas para este periodo.</p>
                    <a href="{{ url('/subjects') }}" class="text-red-700 font-semibold text-sm inline-flex items-center hover:underline">
                        Ir a materias <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center text-red-700 mb-4">
                        <i data-lucide="clock"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Clases Disponibles</h3>
                    <p class="text-gray-600 text-sm mb-4">Gestiona o visualiza los cupos y la disponibilidad horaria de las aulas en tiempo real.</p>
                    <a href="{{ url('/available-classes') }}" class="text-red-700 font-semibold text-sm inline-flex items-center hover:underline">
                        Ver ambientes <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-gray-400 py-6 text-sm border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 text-center space-y-2">
            <p class="font-semibold text-gray-300">Universidad Autónoma Tomás Frías — Potosí, Bolivia</p>
            <p class="text-xs">&copy; {{ date('Y') }} - Proyecto Desarrollado para la Gestión Universitaria.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>