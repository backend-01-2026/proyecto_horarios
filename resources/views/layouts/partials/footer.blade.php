<footer class="bg-white border-t mt-auto">
    <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-3 gap-6 text-sm text-slate-600">
        <div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Gestor de Horarios</h3>
            <p>Plataforma para que los estudiantes creen y organicen sus horarios de clases de forma sencilla.</p>
        </div>
        <div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Enlaces</h3>
            <ul class="space-y-1">
                <li><a href="{{ url('/') }}" class="hover:text-blue-700">Escritorio</a></li>
                <li><a href="{{ url('/horarios') }}" class="hover:text-blue-700">Mis Horarios</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Contacto</h3>
            <p>soporte@gestorhorarios.com</p>
        </div>
    </div>
    <div class="text-center text-xs text-slate-400 py-3 border-t">
        &copy; {{ date('Y') }} Gestor de Horarios. Todos los derechos reservados.
    </div>
</footer>