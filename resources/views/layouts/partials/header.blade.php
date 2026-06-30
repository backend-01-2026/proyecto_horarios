<header class="bg-slate-800 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between flex-wrap">

        <a href="{{ url('/') }}" class="font-display text-xl font-bold tracking-wide hover:text-slate-200 transition">
            Gestor de Horarios
        </a>

        <button
            id="menu-toggle"
            type="button"
            class="md:hidden text-white focus:outline-none"
            aria-label="Abrir menú"
            aria-expanded="false"
            aria-controls="main-nav"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        @include('layouts.partials.nav')
    </div>
</header>