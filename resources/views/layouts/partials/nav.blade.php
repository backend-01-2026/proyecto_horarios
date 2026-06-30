<nav id="main-nav" class="hidden md:flex md:items-center w-full md:w-auto mt-3 md:mt-0">
    <ul class="flex flex-col md:flex-row md:space-x-2 text-sm font-medium space-y-1 md:space-y-0">
        <li>
            <a href="{{ url('/') }}"
               class="block px-3 py-1.5 rounded-lg transition {{ request()->is('/') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                Escritorio
            </a>
        </li>
        <li>
            <a href="{{ url('/horarios') }}"
               class="block px-3 py-1.5 rounded-lg transition {{ request()->is('horarios*') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                Mis Horarios
            </a>
        </li>
        <li>
            <a href="{{ url('/materias') }}"
               class="block px-3 py-1.5 rounded-lg transition {{ request()->is('materias*') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                Materias
            </a>
        </li>
        <li>
            <a href="{{ url('/perfil') }}"
               class="block px-3 py-1.5 rounded-lg transition {{ request()->is('perfil') ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                Perfil
            </a>
        </li>
    </ul>
</nav>