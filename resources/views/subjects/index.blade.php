<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Gestión de Materias</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <style>
      body {
        background: linear-gradient(135deg, #fef2f2 0%, #fce7e7 25%, #fff 50%, #fce7e7 75%, #fef2f2 100%);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }
      .glass-card {
        background: rgba(255,255,255,0.8);
        backdrop-filter: blur(16px);
        border: 1px solid rgba(220,38,38,0.15);
        box-shadow: 0 8px 32px rgba(185,28,28,0.1);
      }
      .futuristic-nav {
        background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 30%, #dc2626 60%, #991b1b 100%);
        box-shadow: 0 4px 30px rgba(185,28,28,0.3);
      }
      .btn-primary {
        background: linear-gradient(135deg, #b91c1c, #dc2626);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(185,28,28,0.25);
      }
      .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(185,28,28,0.4);
      }
      .btn-ver {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
      }
      .btn-ver:hover {
        background: linear-gradient(135deg, #1d4ed8, #2563eb);
      }
      .btn-editar {
        background: linear-gradient(135deg, #d97706, #f59e0b);
      }
      .btn-editar:hover {
        background: linear-gradient(135deg, #b45309, #d97706);
      }
      .btn-eliminar {
        background: linear-gradient(135deg, #dc2626, #ef4444);
      }
      .btn-eliminar:hover {
        background: linear-gradient(135deg, #b91c1c, #dc2626);
      }
      .btn-action {
        transition: all 0.2s ease;
      }
      .btn-action:hover {
        transform: translateY(-2px);
        filter: brightness(1.1);
      }
      .input-futuristic {
        border: 2px solid #e5e7eb;
        transition: all 0.3s ease;
      }
      .input-futuristic:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 4px rgba(220,38,38,0.12);
        outline: none;
      }
      thead tr {
        background: linear-gradient(135deg, #7f1d1d, #b91c1c, #dc2626);
      }
      th {
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
      }
      tbody tr {
        transition: all 0.2s ease;
      }
      tbody tr:hover {
        background: linear-gradient(90deg, rgba(220,38,38,0.04), rgba(220,38,38,0.01));
        transform: scale(1.003);
      }
      .footer-grad {
        background: linear-gradient(135deg, #7f1d1d, #b91c1c, #dc2626);
      }
      .modal-grad {
        background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 30%, #dc2626 60%, #991b1b 100%);
      }
      .pill {
        transition: all 0.2s ease;
        cursor: pointer;
      }
      .pill.active {
        box-shadow: 0 0 0 2px white, 0 0 0 4px #dc2626;
      }
    </style>
  </head>
  <body>
    <nav class="futuristic-nav p-5">
      <div class="flex flex-col items-center">
        <h1 class="text-2xl font-bold tracking-wide text-white">Registro de Materias</h1>    
      </div>
    </nav>
    <div class="flex-1 max-w-6xl mx-auto w-full p-6">
      <div class="flex flex-col gap-3 mb-6 sm:flex-row sm:justify-between">
        <input id="searchInput" class="input-futuristic w-full p-3 rounded-xl sm:w-80" placeholder="Buscar materia..." oninput="filtrarTabla()" />
        <button onclick="abrirModal('nueva')" class="btn-primary px-5 py-3 text-white font-semibold rounded-xl">
          + Nueva Materia
        </button>
      </div>
      <div class="flex flex-wrap items-center gap-2 mb-4" id="filtrosSemestre">
        <span class="text-sm font-semibold text-gray-600">Semestre:</span>
        <button onclick="filtrarSemestre('todas')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary active" data-semestre="todas">Todas</button>
        <button onclick="filtrarSemestre('1°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="1°">1°</button>
        <button onclick="filtrarSemestre('2°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="2°">2°</button>
        <button onclick="filtrarSemestre('3°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="3°">3°</button>
        <button onclick="filtrarSemestre('4°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="4°">4°</button>
        <button onclick="filtrarSemestre('5°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="5°">5°</button>
        <button onclick="filtrarSemestre('6°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="6°">6°</button>
        <button onclick="filtrarSemestre('7°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="7°">7°</button>
        <button onclick="filtrarSemestre('8°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="8°">8°</button>
        <button onclick="filtrarSemestre('9°')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full btn-primary" data-semestre="9°">9°</button>
      </div>
      <div class="flex flex-wrap items-center gap-2 mb-4 hidden" id="filtrosMencion">
        <span class="text-sm font-semibold text-gray-600">Mención:</span>
        <button onclick="filtrarMencion('todas')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full bg-gradient-to-r from-purple-700 to-purple-500 active" data-mencion="todas">Todas</button>
        <button onclick="filtrarMencion('Ciberseguridad')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full bg-gradient-to-r from-purple-700 to-purple-500" data-mencion="Ciberseguridad">Ciberseguridad</button>
        <button onclick="filtrarMencion('Ing. Software')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full bg-gradient-to-r from-purple-700 to-purple-500" data-mencion="Ing. Software">Ing. Software</button>
        <button onclick="filtrarMencion('Inteligencia Artificial')" class="pill px-4 py-1.5 text-sm font-medium text-white rounded-full bg-gradient-to-r from-purple-700 to-purple-500" data-mencion="Inteligencia Artificial">Inteligencia Artificial</button>
      </div>
      <div class="overflow-x-auto glass-card rounded-2xl p-1">
        <table class="w-full" id="tablaMaterias">
          <thead>
            <tr>
              <th class="p-4 text-center text-white">Código</th>
              <th class="p-4 text-center text-white">Nombre</th>
              <th class="p-4 text-center text-white">Semestre</th>
              <th class="p-4 text-center text-white">Mención</th>
              <th class="p-4 text-center text-white">Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <footer class="footer-grad py-4 mt-auto">
      <p class="text-sm text-center text-white/90">&copy; {{ date("Y") }} Universidad Autónoma Tomás Frías</p>
    </footer>
    <div id="modalOverlay" class="fixed inset-0 z-50 hidden bg-black/50" onclick="cerrarModal()">
      <div class="flex items-center justify-center min-h-screen p-4" onclick="event.stopPropagation()">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl">
          <div class="flex items-center justify-between p-5 text-white rounded-t-2xl modal-grad">
            <h2 id="modalTitle" class="text-lg font-bold"></h2>
            <button onclick="cerrarModal()" class="text-2xl leading-none hover:text-gray-300">&times;</button>
          </div>
          <div id="modalBody" class="p-6 space-y-4"></div>
        </div>
      </div>
    </div>
    <div id="toast" class="fixed top-4 right-4 z-50 hidden px-6 py-3 text-white bg-green-600 rounded-xl shadow-lg transition-all duration-300"></div>
    <script>
      let filaEditando = null;
      let semestreActivo = 'todas';
      let mencionActiva = 'todas';
      function abrirModal(tipo, btn) {
        const overlay = document.getElementById('modalOverlay');
        const title = document.getElementById('modalTitle');
        const body = document.getElementById('modalBody');
        let fila = null;
        if (btn) {
          fila = btn.closest('tr');
        }
        if (tipo === 'nueva') {
          title.textContent = 'Registrar Materia';
          body.innerHTML = `
            <form id="formNueva" onsubmit="guardar(event, 'nueva')">
              <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Código</label>
                <input name="codigo" required class="input-futuristic w-full p-3 rounded-xl" placeholder="Ej: INF101" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Nombre</label>
                <input name="nombre" required class="input-futuristic w-full p-3 rounded-xl" placeholder="Nombre de la materia" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Semestre</label>
                <select name="semestre" required class="input-futuristic w-full p-3 rounded-xl bg-white" onchange="toggleMencion(this)">
                  <option value="">Seleccione</option>
                  <option>1°</option><option>2°</option><option>3°</option>
                  <option>4°</option><option>5°</option><option>6°</option>
                  <option>7°</option><option>8°</option><option>9°</option>
                </select>
              </div>
              <div id="campoMencion" class="hidden">
                <label class="block mb-1 text-sm font-semibold text-gray-700">Mención</label>
                <select name="mencion" class="input-futuristic w-full p-3 rounded-xl bg-white">
                  <option value="">Seleccione</option>
                  <option>Ciberseguridad</option>
                  <option>Ing. Software</option>
                  <option>Inteligencia Artificial</option>
                </select>
              </div>
              <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="cerrarModal()" class="px-5 py-2.5 text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-medium">Cancelar</button>
                <button type="submit" class="btn-primary px-5 py-2.5 text-white font-semibold rounded-xl">Guardar</button>
              </div>
            </form>`;
        } else if (tipo === 'ver') {
          const celdas = fila.querySelectorAll('td');
          const mencionTexto = fila.dataset.mencion || '-';
          title.textContent = 'Ver Materia';
          body.innerHTML = `
            <div class="space-y-4">
              <div class="p-4 rounded-xl bg-gray-50"><span class="font-semibold text-gray-700">Código:</span> <span class="text-gray-900">${celdas[0].textContent}</span></div>
              <div class="p-4 rounded-xl bg-gray-50"><span class="font-semibold text-gray-700">Nombre:</span> <span class="text-gray-900">${celdas[1].textContent}</span></div>
              <div class="p-4 rounded-xl bg-gray-50"><span class="font-semibold text-gray-700">Semestre:</span> <span class="text-gray-900">${celdas[2].textContent}</span></div>
              <div class="p-4 rounded-xl bg-gray-50"><span class="font-semibold text-gray-700">Mención:</span> <span class="text-gray-900">${mencionTexto}</span></div>
              <div class="flex justify-end pt-2">
                <button type="button" onclick="cerrarModal()" class="px-5 py-2.5 text-white bg-gray-500 rounded-xl hover:bg-gray-600 font-medium">Cerrar</button>
              </div>
            </div>`;
        } else if (tipo === 'editar') {
          filaEditando = fila;
          const celdas = fila.querySelectorAll('td');
          const mencionActual = fila.dataset.mencion || '';
          const semestreOriginal = celdas[2].textContent;
          title.textContent = 'Editar Materia';
          body.innerHTML = `
            <form id="formEditar" onsubmit="guardar(event, 'editar')">
              <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Código</label>
                <input name="codigo" value="${celdas[0].textContent}" required class="input-futuristic w-full p-3 rounded-xl" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Nombre</label>
                <input name="nombre" value="${celdas[1].textContent}" required class="input-futuristic w-full p-3 rounded-xl" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold text-gray-700">Semestre</label>
                <select name="semestre" required class="input-futuristic w-full p-3 rounded-xl bg-white" data-original="${semestreOriginal}" onchange="confirmarCambioSemestre(this)">
                  <option>1°</option><option>2°</option><option>3°</option>
                  <option>4°</option><option>5°</option><option>6°</option>
                  <option>7°</option><option>8°</option><option>9°</option>
                </select>
              </div>
              <div id="avisoSemestre" class="hidden p-3 text-sm text-yellow-800 bg-yellow-50 border border-yellow-300 rounded-xl">
                ⚠ Esta materia pertenece a <strong>${semestreOriginal}</strong>. ¿Cambiar a <strong id="nuevoSemestreTexto"></strong>?
                <div class="flex gap-2 mt-2">
                  <button type="button" onclick="aceptarCambioSemestre()" class="px-3 py-1 text-sm text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">Sí, cambiar</button>
                  <button type="button" onclick="cancelarCambioSemestre()" class="px-3 py-1 text-sm text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300">No, cancelar</button>
                </div>
              </div>
              <div id="campoMencionEdit">
                <label class="block mb-1 text-sm font-semibold text-gray-700">Mención</label>
                <select name="mencion" class="input-futuristic w-full p-3 rounded-xl bg-white">
                  <option value="">Sin mención</option>
                  <option>Ciberseguridad</option>
                  <option>Ing. Software</option>
                  <option>Inteligencia Artificial</option>
                </select>
              </div>
              <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="cerrarModal()" class="px-5 py-2.5 text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-medium">Cancelar</button>
                <button type="submit" class="btn-primary px-5 py-2.5 text-white font-semibold rounded-xl">Guardar</button>
              </div>
            </form>`;
          body.querySelector('select[name="semestre"]').value = semestreOriginal;
          toggleMencionEdit(body.querySelector('select[name="semestre"]'));
          if (mencionActual) body.querySelector('select[name="mencion"]').value = mencionActual;
        } else if (tipo === 'eliminar') {
          const celdas = fila.querySelectorAll('td');
          title.textContent = 'Eliminar Materia';
          body.innerHTML = `
            <p class="text-gray-700">¿Está seguro de eliminar la materia <strong>${celdas[1].textContent}</strong>?</p>
            <div class="flex justify-end gap-3 pt-4">
              <button type="button" onclick="cerrarModal()" class="px-5 py-2.5 text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 font-medium">Cancelar</button>
              <button onclick="eliminar(this)" class="px-5 py-2.5 text-white bg-red-600 rounded-xl hover:bg-red-700 font-semibold">Eliminar</button>
            </div>`;
        }
        overlay.classList.remove('hidden');
      }
      function cerrarModal() {
        document.getElementById('modalOverlay').classList.add('hidden');
      }
      function guardar(e, tipo) {
        e.preventDefault();
        const form = e.target;
        const datos = new FormData(form);
        const codigo = datos.get('codigo').toUpperCase().trim();
        const nombre = datos.get('nombre').toUpperCase().trim();
        const semestre = datos.get('semestre');
        if (tipo === 'nueva') {
          const hayFilas = document.querySelector('#tablaMaterias tbody tr');
          if (hayFilas) {
            const todos = document.querySelectorAll('#tablaMaterias tbody tr');
            for (const tr of todos) {
              if (tr.querySelector('td:first-child')?.textContent.trim() === codigo.trim()) {
                mostrarError(`Ya existe una materia con el código "${codigo}"`);
                return;
              }
              if (tr.querySelector('td:nth-child(2)')?.textContent.trim().toLowerCase() === nombre.trim().toLowerCase()) {
                mostrarError(`Ya existe una materia con el nombre "${nombre}"`);
                return;
              }
            }
          }
          const mencion = datos.get('mencion') || '';
          const tbody = document.querySelector('#tablaMaterias tbody');
          const fila = document.createElement('tr');
          fila.className = 'border-b border-gray-100 hover:bg-red-50/50';
          fila.dataset.mencion = mencion;
          fila.innerHTML = `
            <td class="p-4 text-center font-medium">${codigo}</td>
            <td class="p-4 text-center">${nombre}</td>
            <td class="p-4 text-center">${semestre}</td>
            <td class="p-4 text-center">${mencion || '-'}</td>
            <td class="p-4 text-center">
              <div class="flex flex-wrap justify-center gap-2">
                <button onclick="abrirModal('ver', this)" class="btn-action btn-ver px-3 py-1.5 text-sm text-white rounded-lg">Ver</button>
                <button onclick="abrirModal('editar', this)" class="btn-action btn-editar px-3 py-1.5 text-sm text-white rounded-lg">Editar</button>
                <button onclick="abrirModal('eliminar', this)" class="btn-action btn-eliminar px-3 py-1.5 text-sm text-white rounded-lg">Eliminar</button>
              </div>
            </td>`;
          tbody.appendChild(fila);
        } else if (tipo === 'editar' && filaEditando) {
          const mencion = datos.get('mencion') || '';
          const celdas = filaEditando.querySelectorAll('td');
          celdas[0].textContent = codigo;
          celdas[1].textContent = nombre;
          celdas[2].textContent = semestre;
          celdas[3].textContent = mencion || '-';
          filaEditando.dataset.mencion = mencion;
          filaEditando = null;
        }
        cerrarModal();
        mostrarToast(`Materia "${nombre}" ${tipo === 'nueva' ? 'creada' : 'editada'} correctamente`);
      }
      function eliminar(btn) {
        const nombreEl = document.querySelector('#modalBody strong');
        const nombre = nombreEl ? nombreEl.textContent : '';
        const todas = document.querySelectorAll('#tablaMaterias tbody tr');
        for (const tr of todas) {
          if (tr.querySelector('td:nth-child(2)')?.textContent === nombre) {
            tr.remove();
            break;
          }
        }
        cerrarModal();
        mostrarToast(`Materia "${nombre}" eliminada correctamente`);
      }
      function mostrarToast(mensaje) {
        const toast = document.getElementById('toast');
        toast.className = 'fixed top-4 right-4 z-50 hidden px-6 py-3 text-white bg-green-600 rounded-xl shadow-lg transition-all duration-300';
        toast.textContent = mensaje;
        toast.classList.remove('hidden');
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
        setTimeout(() => {
          toast.style.opacity = '0';
          toast.style.transform = 'translateY(-10px)';
          setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
      }
      function mostrarError(mensaje) {
        const toast = document.getElementById('toast');
        toast.className = 'fixed top-4 right-4 z-50 hidden px-6 py-3 text-white bg-red-600 rounded-xl shadow-lg transition-all duration-300';
        toast.textContent = mensaje;
        toast.classList.remove('hidden');
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
        setTimeout(() => {
          toast.style.opacity = '0';
          toast.style.transform = 'translateY(-10px)';
          setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
      }
      let semestrePendiente = null;
      let selectSemestre = null;

      function toggleMencion(select) {
        const campo = document.getElementById('campoMencion');
        const val = parseInt(select.value.replace('°', ''));
        if (val === 6 || val === 7) {
          campo.classList.remove('hidden');
        } else {
          campo.classList.add('hidden');
        }
      }
      function toggleMencionEdit(select) {
        const campo = document.getElementById('campoMencionEdit');
        const val = parseInt(select.value.replace('°', ''));
        if (val === 6 || val === 7) {
          campo.classList.remove('hidden');
        } else {
          campo.classList.add('hidden');
        }
      }
      function confirmarCambioSemestre(select) {
        const original = select.dataset.original;
        if (select.value === original) {
          document.getElementById('avisoSemestre').classList.add('hidden');
          return;
        }
        selectSemestre = select;
        semestrePendiente = select.value;
        document.getElementById('nuevoSemestreTexto').textContent = semestrePendiente;
        document.getElementById('avisoSemestre').classList.remove('hidden');
        select.value = original;
      }
      function aceptarCambioSemestre() {
        if (selectSemestre && semestrePendiente) {
          selectSemestre.value = semestrePendiente;
          selectSemestre.dataset.original = semestrePendiente;
          toggleMencionEdit(selectSemestre);
        }
        document.getElementById('avisoSemestre').classList.add('hidden');
        semestrePendiente = null;
        selectSemestre = null;
      }
      function cancelarCambioSemestre() {
        document.getElementById('avisoSemestre').classList.add('hidden');
        semestrePendiente = null;
        selectSemestre = null;
      }
      function filtrarSemestre(semestre) {
        semestreActivo = semestre;
        document.querySelectorAll('#filtrosSemestre .pill').forEach(p => p.classList.remove('active'));
        document.querySelector(`#filtrosSemestre .pill[data-semestre="${semestre}"]`)?.classList.add('active');

        const menciones = document.getElementById('filtrosMencion');
        const val = parseInt(semestre.replace('°', ''));
        if (semestre !== 'todas' && (val === 6 || val === 7)) {
          menciones.classList.remove('hidden');
        } else {
          menciones.classList.add('hidden');
          mencionActiva = 'todas';
          document.querySelectorAll('#filtrosMencion .pill').forEach(p => p.classList.remove('active'));
          document.querySelector('#filtrosMencion .pill[data-mencion="todas"]')?.classList.add('active');
        }
        aplicarFiltros();
      }
      function filtrarMencion(mencion) {
        mencionActiva = mencion;
        document.querySelectorAll('#filtrosMencion .pill').forEach(p => p.classList.remove('active'));
        document.querySelector(`#filtrosMencion .pill[data-mencion="${mencion}"]`)?.classList.add('active');
        aplicarFiltros();
      }
      function aplicarFiltros() {
        const input = document.getElementById('searchInput').value.toLowerCase().trim();
        const filas = document.querySelectorAll('#tablaMaterias tbody tr');
        const buscando = input !== '';
        filas.forEach(f => {
          const nombre = f.querySelector('td:nth-child(2)')?.textContent.toLowerCase().trim() || '';
          const sem = f.querySelector('td:nth-child(3)')?.textContent.trim();
          const menc = f.dataset.mencion || '';
          const pasaBusqueda = !buscando || nombre.startsWith(input);
          const pasaSemestre = buscando || semestreActivo === 'todas' || sem === semestreActivo;
          const pasaMencion = buscando || mencionActiva === 'todas' || menc === mencionActiva;
          f.style.display = (pasaSemestre && pasaMencion && pasaBusqueda) ? '' : 'none';
        });
      }
      function filtrarTabla() {
        aplicarFiltros();
      }
    </script>
  </body>
</html>

