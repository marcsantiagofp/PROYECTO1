<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
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
        <h1 class="text-center mb-4">Admin Panel - Pedidos</h1>
        <table class="table table-striped" id="pedidosTable">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Cantidad de Productos</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los pedidos se cargarán aquí mediante JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Menú</h3>
        <a href="#">Usuarios</a>
        <a href="#">Productos</a>
        <a href="#">Pedidos</a>
    </div>

    <!-- Modal para edición (si fuera necesario para editar pedidos) -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="edit-cliente" class="form-label">Cliente ID</label>
                            <input type="text" class="form-control" id="edit-cliente" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-fecha" class="form-label">Fecha del Pedido</label>
                            <input type="text" class="form-control" id="edit-fecha" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-total" class="form-label">Total</label>
                            <input type="number" step="0.01" class="form-control" id="edit-total" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-cantidad" class="form-label">Cantidad de Productos</label>
                            <input type="number" class="form-control" id="edit-cantidad" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para obtener pedidos de la API y mostrarlos en la tabla
        function fetchPedidos() {
            fetch('controllers/apicontroller.php?action=obtenerPedidos')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#pedidosTable tbody');
                    tableBody.innerHTML = '';  // Limpiar la tabla antes de agregar los nuevos pedidos

                    // Verificar si hay pedidos y agregarlos a la tabla
                    if (data && Array.isArray(data) && data.length > 0) {
                        data.forEach(pedido => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${pedido.id}</td>
                                <td>${pedido.id_cliente}</td>
                                <td>${pedido.fecha_pedido}</td>
                                <td>$${pedido.precio_total_pedidos}</td>
                                <td>${pedido.cantidad_productos}</td>
                            `;
                            tableBody.appendChild(row);
                        });
                    } else {
                        // Si no hay pedidos, mostrar un mensaje
                        tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay pedidos disponibles.</td></tr>';
                    }
                })
                // .catch(error => {
                //     console.error('Error al obtener pedidos:', error);
                //     alert('Hubo un problema al cargar los pedidos.');
                // });
        }

        // Cargar los pedidos cuando se carga la página
        document.addEventListener('DOMContentLoaded', function() {
            fetchPedidos();
        });

        // Enviar el formulario de edición (esto será ampliado más tarde)
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const clienteId = document.getElementById('edit-cliente').value;
            const fecha = document.getElementById('edit-fecha').value;
            const total = document.getElementById('edit-total').value;
            const cantidad = document.getElementById('edit-cantidad').value;

            // Aquí podrías enviar los datos modificados al servidor para guardar los cambios
            console.log("Guardar cambios", { clienteId, fecha, total, cantidad });
            // Cerrar el modal después de guardar
            $('#editModal').modal('hide');
        }); 
    </script>
</body>
</html>