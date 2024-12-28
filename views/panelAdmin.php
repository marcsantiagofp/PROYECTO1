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
        <h1 class="text-center mb-4">Admin Panel - <span id="section-title"></span></h1>
        <table class="table table-striped">
            <thead class="table-dark">
                <tr id="table-headers">
                    <!-- Aquí se llenarán los encabezados dependiendo de la sección seleccionada -->
                </tr>
            </thead>
            <tbody id="section-table-body">
                <!-- Aquí se llenará la tabla con los datos de cada sección -->
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

    <script src="api/api.js"></script>
</body>
</html>