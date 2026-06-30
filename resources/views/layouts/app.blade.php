<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestor de Horarios')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

    @include('layouts.partials.header')

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 py-6">

        @hasSection('breadcrumbs')
            <nav class="text-sm text-slate-400 mb-4" aria-label="Breadcrumb">
                @yield('breadcrumbs')
            </nav>
        @endif

        @if (session('success'))
            <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>
