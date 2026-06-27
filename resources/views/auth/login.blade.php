<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-xl rounded-xl p-8">

        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-red-700">
                Sistema de Gestión de Horarios
            </h1>

            <p class="text-gray-600 mt-2">
                Ingeniería Informática
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">
                    Correo Electrónico
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                >
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 mb-2">
                    Contraseña
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-lg transition"
            >
                Iniciar Sesión
            </button>

            <div class="text-center mt-4">
                <a
                    href="{{ route('register') }}"
                    class="text-red-700 hover:underline"
                >
                    ¿No tienes cuenta? Regístrate
                </a>
            </div>

        </form>

    </div>

</body>
</html>

