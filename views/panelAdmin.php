<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Css -->
    <link rel="stylesheet" href="css/cssAdmin.css">
    <!-- icnoo -->
    <link rel="icon" type="image/x-icon" href="/PROYECTO1/images/d.svg">
</head>
<body>
    <!-- Botón para volver a la página principal -->
    <a href="?controller=producto&action=home" class="btn btn-secondary back-button">Volver al Inicio</a>

    <!-- Main content -->
    <div class="main-content">
        <h1 class="text-center mb-4">Admin Panel - <span id="section-title"></span></h1>

        <!-- Contenedor de los botones de filtro y selector de moneda (inicialmente oculto) -->
        <div id="filter-section" style="display: none;">
            <!-- Botón para desplegar el menú de filtros -->
            <button class="btn btn-secondary btn-sm" type="button" onclick="desplegableFiltro()" style="margin-bottom: 10px;">
                Filtrar
            </button>

            <!-- Menú de filtros -->
            <div id="filter-menu" style="display: none;">
                <button class="btn btn-secondary btn-sm" onclick="fetchPedidos('usuario_desc')" style="margin-bottom: 8px;">Usuario Descendente</button>
                <button class="btn btn-secondary btn-sm" onclick="fetchPedidos('fecha')" style="margin-bottom: 8px;">Fecha</button>
                <button class="btn btn-secondary btn-sm" onclick="fetchPedidos('precio_asc')" style="margin-bottom: 8px;">Precio Ascendente</button>
                <button class="btn btn-secondary btn-sm" onclick="fetchPedidos('precio_desc')" style="margin-bottom: 8px;">Precio Descendente</button>
            </div>

            <!-- Selector de moneda (solo visible en la sección de pedidos) -->
            <div id="containerDeSelectorDeMonedas" class="currency-selector-container" style="margin-bottom: 20px; display: none;">
                <label for="selectorDeMonedaPedidos" style="margin-right: 10px;">Selecciona moneda:</label>
                <select id="selectorDeMonedaPedidos" style="padding: 5px 10px; font-size: 14px;">
                    <option value="EUR" selected>EUR (€)</option>
                    <option value="USD">USD ($)</option>
                    <option value="GBP">GBP (£)</option>
                    <option value="JPY">JPY (¥)</option>
                    <option value="AUD">AUD (A$)</option>
                    <!-- Agrega más monedas si es necesario -->
                </select>
            </div>
        </div>

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
        <a href="#" onclick="showSection('logs')">Logs</a>
    </div>
    
    <script>
        // Función para mostrar/ocultar el menú desplegable de filtros
        function desplegableFiltro() {
            const filterMenu = document.getElementById('filter-menu');
            // Cambiar la visibilidad del menú
            if (filterMenu.style.display === "none") {
                filterMenu.style.display = "block";
            } else {
                filterMenu.style.display = "none";
            }
        }
    </script>

    <script src="api/api.js"></script>
    <script src="api/moneda.js"></script>
</body>
</html>