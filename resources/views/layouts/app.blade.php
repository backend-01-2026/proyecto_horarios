<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Sistema de Horarios') · UATF</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen bg-gray-100">
    <nav class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 py-3 text-white bg-red-900 shadow-lg">
        <div class="flex items-center gap-3">
            <span class="text-lg font-bold">Sistema de Horarios</span>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('available-classes.index') }}" class="hover:underline">Clases Disponibles</a>
        </div>
    </nav>

    <main class="flex-1 w-full pt-16">
        @if (session('success'))
            <div class="mx-4 mt-4 p-4 text-green-700 bg-green-100 rounded-lg border-l-4 border-green-600">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mx-4 mt-4 p-4 bg-red-50 rounded-lg border-l-4 border-red-600">
                <ul class="text-red-700 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
