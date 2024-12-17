<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative; /* Añadido para permitir la posición absoluta del botón */
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            position: fixed;
            top: 0;
            right: 0;
            height: 100%;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .main-content {
            flex-grow: 1;
            margin-right: 250px;
            padding: 20px;
        }

        /* Estilo para el botón de volver a la página principal */
        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background-color: #343a40;
        }
    </style>
</head>
<body>
    <!-- Botón para volver a la página principal -->
    <a href="?controller=producto&action=home" class="btn btn-secondary back-button">Volver al Inicio</a>

    <!-- Main content -->
    <div class="main-content">
        <h1 class="text-center mb-4">Admin Panel - <span id="section-title">Productos</span></h1>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr id="table-headers"></tr>
            </thead>
            <tbody id="section-table-body"></tbody>
        </table>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Menú</h3>
        <a href="#" onclick="showSection('usuarios')">Usuarios</a>
        <a href="#" onclick="showSection('productos')">Productos</a>
        <a href="#" onclick="showSection('pedidos')">Pedidos</a>
    </div>

    <!-- Modal para edición -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit-nombre" required>
                        </div>
                        <div class="mb-3" id="extra-fields"></div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function fetchData(resource) {
            const response = await fetch(`/api/${resource}`);
            return response.json();
        }

        function handleEdit(id, data) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nombre').value = data.nombre || '';
            const extraFields = document.getElementById('extra-fields');
            extraFields.innerHTML = '';

            if (data.email) {
                extraFields.innerHTML += `
                    <div class="mb-3">
                        <label for="edit-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-email" value="${data.email}" required>
                    </div>`;
            }

            if (data.precio) {
                extraFields.innerHTML += `
                    <div class="mb-3">
                        <label for="edit-precio" class="form-label">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="edit-precio" value="${data.precio}" required>
                    </div>`;
            }

            const modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        function deleteRecord(resource, id) {
            if (confirm('¿Estás seguro de eliminar este registro?')) {
                fetch(`/api/${resource}/${id}`, { method: 'DELETE' })
                    .then(() => showSection(resource))
                    .catch(err => alert('Error al eliminar: ' + err));
            }
        }

        function populateTable(resource, data) {
            const tableBody = document.getElementById('section-table-body');
            tableBody.innerHTML = '';

            data.forEach(item => {
                let extraFields = '';
                if (resource === 'usuarios') {
                    extraFields = `<td>${item.email}</td><td>${item.telefono}</td><td>${item.rol}</td>`;
                } else if (resource === 'productos') {
                    extraFields = `<td>${item.descripcion}</td><td>${item.precio}</td>`;
                } else if (resource === 'pedidos') {
                    extraFields = `<td>${item.fecha_pedido}</td><td>${item.precio_total_pedidos}</td><td>${item.cantidad_productos}</td>`;
                }

                tableBody.innerHTML += `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.nombre || ''}</td>
                        ${extraFields}
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="handleEdit('${resource}', ${JSON.stringify(item)})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteRecord('${resource}', ${item.id})">Eliminar</button>
                        </td>
                    </tr>`;
            });
        }

        async function showSection(section) {
            document.getElementById('section-title').textContent = section.charAt(0).toUpperCase() + section.slice(1);

            let headers = '';
            if (section === 'usuarios') {
                headers = `<th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Rol</th><th>Acciones</th>`;
            } else if (section === 'productos') {
                headers = `<th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Acciones</th>`;
            } else if (section === 'pedidos') {
                headers = `<th>ID</th><th>Fecha</th><th>Total</th><th>Cantidad</th><th>Acciones</th>`;
            }

            document.getElementById('table-headers').innerHTML = headers;
            const data = await fetchData(section);
            populateTable(section, data);
        }

        document.getElementById('editForm').addEventListener('submit', async e => {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const resource = document.getElementById('section-title').textContent.toLowerCase();
            const data = {
                nombre: document.getElementById('edit-nombre').value,
                email: document.getElementById('edit-email')?.value || undefined,
                precio: parseFloat(document.getElementById('edit-precio')?.value) || undefined
            };

            await fetch(`/api/${resource}/${id}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            showSection(resource);
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
        });

        document.addEventListener('DOMContentLoaded', () => {
            showSection('productos');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>