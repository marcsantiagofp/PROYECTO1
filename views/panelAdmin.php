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
        .no-data {
            text-align: center;
            color: red;
            font-size: 1.2rem;
            margin-top: 20px;
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
                <tr id="table-headers">
                    <!-- Aquí se llenarán los encabezados dependiendo de la sección seleccionada -->
                </tr>
            </thead>
            <tbody id="section-table-body">
                <!-- Aquí se llenará la tabla con JavaScript dependiendo de la sección seleccionada -->
            </tbody>
        </table>
        <div id="no-data-message" class="no-data" style="display: none;">
            No hay datos disponibles.
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3 class="text-center">Menú</h3>
        <a href="#" onclick="showSection('usuarios')">Usuarios</a>
        <a href="#" onclick="showSection('productos')">Productos</a>
        <a href="#" onclick="showSection('pedidos')">Pedidos</a>
    </div>

    <script>
        async function fetchUsuarios() {
            const response = await fetch('?controller=api&action=obtenerUsuarios');
            const usuarios = await response.json();
            const tableBody = document.getElementById('section-table-body');
            const noDataMessage = document.getElementById('no-data-message');
            tableBody.innerHTML = '';  // Limpiar la tabla
            if (usuarios.length === 0) {
                noDataMessage.style.display = 'block';
            } else {
                noDataMessage.style.display = 'none';
                usuarios.forEach(usuario => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${usuario.id}</td>
                            <td>${usuario.nombre}</td>
                            <td>${usuario.email}</td>
                            <td>${usuario.telefono}</td>
                            <td>${usuario.rol}</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Editar</button>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            }
        }

        async function fetchProductos() {
            const response = await fetch('?controller=api&action=obtenerProductos');
            const productos = await response.json();
            const tableBody = document.getElementById('section-table-body');
            const noDataMessage = document.getElementById('no-data-message');
            tableBody.innerHTML = '';  // Limpiar la tabla
            if (productos.length === 0) {
                noDataMessage.style.display = 'block';
            } else {
                noDataMessage.style.display = 'none';
                productos.forEach(producto => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.descripcion}</td>
                            <td>${producto.precio}</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Editar</button>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            }
        }

        async function fetchPedidos() {
            const response = await fetch('?controller=api&action=obtenerPedidos');
            const pedidos = await response.json();
            const tableBody = document.getElementById('section-table-body');
            const noDataMessage = document.getElementById('no-data-message');
            tableBody.innerHTML = '';  // Limpiar la tabla
            if (pedidos.length === 0) {
                noDataMessage.style.display = 'block';
            } else {
                noDataMessage.style.display = 'none';
                pedidos.forEach(pedido => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>${pedido.id}</td>
                            <td>${pedido.id_cliente}</td>
                            <td>${pedido.fecha_pedido}</td>
                            <td>${pedido.precio_total_pedidos}</td>
                            <td>${pedido.cantidad_productos}</td>
                            <td>
                                <button class="btn btn-primary btn-sm">Ver</button>
                                <button class="btn btn-danger btn-sm">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            }
        }

        function showSection(section) {
            // Limpiar la tabla y ocultar el mensaje de "No hay datos"
            const tableBody = document.getElementById('section-table-body');
            const noDataMessage = document.getElementById('no-data-message');
            tableBody.innerHTML = '';  // Limpiar la tabla
            noDataMessage.style.display = 'none';  // Ocultar el mensaje de "No hay datos"

            // Cambiar el título de la sección
            document.getElementById('section-title').textContent = section.charAt(0).toUpperCase() + section.slice(1);
            
            // Cambiar los encabezados de la tabla dependiendo de la sección seleccionada
            const tableHeaders = document.getElementById('table-headers');
            let headers = '';
            
            if (section === 'usuarios') {
                headers = `
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                `;
                fetchUsuarios();  // Cargar los datos de los usuarios
            } else if (section === 'productos') {
                headers = `
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                `;
                fetchProductos();  // Cargar los datos de los productos
            } else if (section === 'pedidos') {
                headers = `
                    <th>ID</th>
                    <th>Cliente ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Cantidad de Productos</th>
                    <th>Acciones</th>
                `;
                fetchPedidos();  // Cargar los datos de los pedidos
            }

            // Actualizar los encabezados de la tabla
            tableHeaders.innerHTML = headers;
        }

        document.addEventListener('DOMContentLoaded', () => {
            showSection('productos');  // Mostrar productos por defecto al cargar la página
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>