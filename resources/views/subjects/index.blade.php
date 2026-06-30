<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Gestión de Materias</title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
  </head>
  <body class="bg-gray-100">
    <nav class="p-4 text-white bg-red-700">
      <h1 class="text-2xl font-bold text-center">Sistema de Horarios - Materias</h1>
    </nav>
    <div class="max-w-6xl mx-auto p-6">
      <div class="flex flex-col gap-3 mb-4 sm:flex-row sm:justify-between">
        <input id="searchInput" class="w-full p-2 border rounded sm:w-80" placeholder="Buscar materia" oninput="filtrarTabla()" />
        <button onclick="abrirModal('nueva')" class="px-4 py-2 text-white bg-red-700 rounded hover:bg-red-800">
          + Nueva Materia
        </button>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full bg-white shadow rounded" id="tablaMaterias">
          <thead class="text-white bg-red-700">
            <tr>
              <th class="p-3 text-center">Código</th>
              <th class="p-3 text-center">Nombre</th>
              <th class="p-3 text-center">Semestre</th>
              <th class="p-3 text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
    <div id="modalOverlay" class="fixed inset-0 z-50 hidden bg-black/50" onclick="cerrarModal()">
      <div class="flex items-center justify-center min-h-screen p-4" onclick="event.stopPropagation()">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl">

          <div id="modalHeader" class="flex items-center justify-between p-4 text-white bg-red-700 rounded-t-lg">
            <h2 id="modalTitle" class="text-lg font-bold"></h2>
            <button onclick="cerrarModal()" class="text-2xl leading-none hover:text-gray-300">&times;</button>
          </div>
          <div id="modalBody" class="p-6 space-y-4"></div>
        </div>
      </div>
    </div>
    <div id="toast" class="fixed top-4 right-4 z-50 hidden px-6 py-3 text-white bg-green-600 rounded shadow-lg transition-opacity duration-300"></div>
    <script>
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
                <label class="block mb-1 text-sm font-semibold">Código</label>
                <input name="codigo" required class="w-full p-2 border rounded" placeholder="Ej: INF101" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold">Nombre</label>
                <input name="nombre" required class="w-full p-2 border rounded" placeholder="Nombre de la materia" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold">Semestre</label>
                <select name="semestre" required class="w-full p-2 border rounded bg-white">
                  <option value="">Seleccione</option>
                  <option>1°</option><option>2°</option><option>3°</option>
                  <option>4°</option><option>5°</option><option>6°</option>
                  <option>7°</option><option>8°</option><option>9°</option>
                </select>
              </div>
              <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="cerrarModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="px-4 py-2 text-white bg-red-700 rounded hover:bg-red-800">Guardar</button>
              </div>
            </form>`;
        } else if (tipo === 'ver') {
          const celdas = fila.querySelectorAll('td');
          title.textContent = 'Ver Materia';
          body.innerHTML = `
            <div class="space-y-3">
              <div><span class="font-semibold">Código:</span> ${celdas[0].textContent}</div>
              <div><span class="font-semibold">Nombre:</span> ${celdas[1].textContent}</div>
              <div><span class="font-semibold">Semestre:</span> ${celdas[2].textContent}</div>
              <div class="flex justify-end pt-4">
                <button type="button" onclick="cerrarModal()" class="px-4 py-2 text-white bg-gray-600 rounded hover:bg-gray-700">Cerrar</button>
              </div>
            </div>`;
        } else if (tipo === 'editar') {
          const celdas = fila.querySelectorAll('td');
          title.textContent = 'Editar Materia';
          body.innerHTML = `
            <form id="formEditar" onsubmit="guardar(event, 'editar')">
              <div>
                <label class="block mb-1 text-sm font-semibold">Código</label>
                <input name="codigo" value="${celdas[0].textContent}" required class="w-full p-2 border rounded" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold">Nombre</label>
                <input name="nombre" value="${celdas[1].textContent}" required class="w-full p-2 border rounded" />
              </div>
              <div>
                <label class="block mb-1 text-sm font-semibold">Semestre</label>
                <select name="semestre" required class="w-full p-2 border rounded bg-white">
                  <option>1°</option><option>2°</option><option>3°</option>
                  <option>4°</option><option>5°</option><option>6°</option>
                  <option>7°</option><option>8°</option><option>9°</option>
                </select>
              </div>
              <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="cerrarModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
                <button type="submit" class="px-4 py-2 text-white bg-red-700 rounded hover:bg-red-800">Guardar</button>
              </div>
            </form>`;
          body.querySelector('select[name="semestre"]').value = celdas[2].textContent;
        } else if (tipo === 'eliminar') {
          const celdas = fila.querySelectorAll('td');
          title.textContent = 'Eliminar Materia';
          body.innerHTML = `
            <p class="text-gray-700">¿Está seguro de eliminar la materia <strong>${celdas[1].textContent}</strong>?</p>
            <div class="flex justify-end gap-2 pt-4">
              <button type="button" onclick="cerrarModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded hover:bg-gray-300">Cancelar</button>
              <button onclick="eliminar(this)" class="px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Eliminar</button>
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
        const nombre = datos.get('nombre');
        if (tipo === 'nueva') {
          const tbody = document.querySelector('#tablaMaterias tbody');
          const fila = document.createElement('tr');
          fila.className = 'border-b hover:bg-gray-50';
          fila.innerHTML = `
            <td class="p-3 text-center">${datos.get('codigo')}</td>
            <td class="p-3 text-center">${nombre}</td>
            <td class="p-3 text-center">${datos.get('semestre')}</td>
            <td class="p-3 text-center">
              <div class="flex flex-wrap justify-center gap-1">
                <button onclick="abrirModal('ver', this)" class="px-3 py-1 text-white bg-blue-600 rounded hover:bg-blue-700">Ver</button>
                <button onclick="abrirModal('editar', this)" class="px-3 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600">Editar</button>
                <button onclick="abrirModal('eliminar', this)" class="px-3 py-1 text-white bg-red-600 rounded hover:bg-red-700">Eliminar</button>
              </div>
            </td>
          `;
          tbody.appendChild(fila);
        }
        cerrarModal();
        mostrarToast(`Materia "${nombre}" ${tipo === 'nueva' ? 'creada' : 'editada'} correctamente`);
      }
      function eliminar(btn) {
        const fila = btn.closest('tr') || btn.closest('div').closest('div').closest('div').closest('div');
        const nombreEl = document.querySelector('#modalBody strong');
        const nombre = nombreEl ? nombreEl.textContent : '';
        const overlay = document.getElementById('modalOverlay');

        const filaEnTabla = document.querySelector(`#tablaMaterias tbody tr td:nth-child(2)`);
        if (filaEnTabla) {
          const todas = document.querySelectorAll('#tablaMaterias tbody tr');
          for (const tr of todas) {
            if (tr.querySelector('td:nth-child(2)')?.textContent === nombre) {
              tr.remove();
              break;
            }
          }
        }
        cerrarModal();
        mostrarToast(`Materia "${nombre}" eliminada correctamente`);
      }
      function mostrarToast(mensaje) {
        const toast = document.getElementById('toast');
        toast.textContent = mensaje;
        toast.classList.remove('hidden');
        toast.style.opacity = '1';
        setTimeout(() => {
          toast.style.opacity = '0';
          setTimeout(() => toast.classList.add('hidden'), 300);
        }, 3000);
      }
      function filtrarTabla() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const filas = document.querySelectorAll('#tablaMaterias tbody tr');
        filas.forEach(f => {
          const texto = f.textContent.toLowerCase();
          f.style.display = texto.includes(input) ? '' : 'none';
        });
      }
    </script>
  </body>
</html>