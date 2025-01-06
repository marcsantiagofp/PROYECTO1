<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DecathlonEats</title>
</head>
<body class="m-0 border-0 bd-example m-0 border-0 bd-example-cols">
<!-- Encabezado -->
<header class="">
    <!-- CARRUSEL OFERTAS -->
    <div id="carouselExampleAutoplaying" class="carousel slide promocion" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <p class="textoPromocion">Promoción Menu Burger Barbacoa 4'99€ 🔥🔥</p>
            </div>
            <div class="carousel-item">
                <p class="textoPromocion">Prueba nuestras hamburgesas 🍔🍔</p>
            </div>
            <div class="carousel-item">
                <p class="textoPromocion">Prueba tus bebidas favoritas 🥤🥤</p>
            </div>
        </div>
    </div>
    <!-- Menú de navegación -->
    <nav class="navbar-expand-lg menu">
        <div class="container-fluid">
            <!-- Parte Superior -->
            <div class="parte-superior">
                <!-- Icono de hamburguesa -->
                <button class="navbar-toggler d-flex flex-column align-items-center d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 30 30%22%3E%3Cpath stroke=%22black%22 stroke-width=%222%22 d=%22M4 7h22M4 15h22M4 23h22%22/%3E%3C/svg%3E');"></span>
                    <span class="text-nowrap" style="font-size: 11px;">MENU</span>
                </button>
                <a href="?controller=producto&action=home">
                    <img src="/PROYECTO1/images/logoPrincipal.svg" alt="DecathlonEats Logo" class="img-fluid logo">
                </a>
                <input type="text" placeholder="Busca productos, ...   (desactivado temporalmente)" class="buscador">
                <button class="buscar-btn"><img src="/PROYECTO1/images/lupa.svg" alt="DecathlonEats Logo" class="lupa"></button>
                <div class="iconos">
                    <a href="#" onclick="return false;">
                        <div class="icono d-none d-lg-flex flex-column text-center">
                            <span class="icono-img"><i class="bi bi-question-circle"></i></span> <!-- Ayuda -->
                            <span class="text-nowrap">AYUDA</span>
                        </div>
                    </a>
                    <a href="https://www.decathlon.es/es/store-locator" style="margin-right: -20px;">
                    <div class="icono d-flex flex-column align-items-center">
                        <span class="icono-img"><i class="bi bi-shop"></i></span> <!-- Tienda -->
                        <span class="text-nowrap">TIENDA</span>
                    </div>
                    </a>
                    <a href="?controller=usuario&action=mostrarFormulario">
                        <div class="usuario">
                            <div class="icono d-flex flex-column align-items-center">
                                <!-- Icono del usuario -->
                                <span class="icono-img"><i class="bi bi-person-circle" style="font-size: 20px;"></i></span>
                                <!-- Nombre o texto predeterminado -->
                                <span class="text-nowrap">
                                    <?php
                                    // Comprobar si el usuario ha iniciado sesión
                                    if (isset($_SESSION['usuario_id'])) {
                                        // Obtener el usuario desde la base de datos
                                        $usuario = UsuarioDAO::getUsuarioById($_SESSION['usuario_id']);
                                        echo htmlspecialchars($usuario->getNombre()); // Mostrar el nombre del usuario
                                    } else {
                                        echo "MI CUENTA"; // Texto predeterminado si no ha iniciado sesión
                                    }
                                    ?>
                                </span>
                            </div>
                            <!-- Menú desplegable -->
                            <div class="usuario-menu">
                                <ul>
                                    <?php if (isset($_SESSION['usuario_id'])): ?>
                                        <li><a href="?controller=usuario&action=mostrarFormulario">Ver mis datos</a></li>
                                        <li><a href="?controller=usuario&action=mostrarHistorialPedidos">Historial de pedidos</a></li> 
                                        
                                        <?php
                                            // Llamar directamente a la función obtenerRolPorId usando el ID del usuario en la sesión
                                            $rol = UsuarioDAO::obtenerRolPorId($_SESSION['usuario_id']);
                                            
                                            // Si el rol es 'admin', mostrar el enlace al Panel de Admin
                                            if ($rol === 'admin') {
                                                echo '<li><a href="?controller=api&action=panel">Panel de Admin</a></li>';
                                            }                                                
                                        ?>
                                        
                                        <li><a href="?controller=usuario&action=cerrarSesion">Cerrar sesión</a></li>
                                    <?php else: ?>
                                        <li><a href="?controller=usuario&action=mostrarFormulario">Iniciar sesión</a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </a>
                    <a href="?controller=carrito&action=verCarrito">
                        <div class="icono d-flex flex-column align-items-center 
                            <?php echo isset($_SESSION['carrito']) ? 'carrito-animado' : ''; ?>" 
                            style="color: #3643BA;">
                            <span class="icono-img"><i class="bi bi-cart-check"></i></span> <!-- Mi cesta -->
                            <span class="text-nowrap">MI CESTA</span>
                        </div>
                    </a>
                </div>                      
            </div>
            
            <!-- Menú de navegación desplegable -->
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=1">Hamburguesas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=2">Menús</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=3">Combos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=4">Postres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=5">Patatas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=6">Bebidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=7">Infantiles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?controller=producto&action=mostrarProductos&id=8" style="color: #E3262F;">Ofertas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Línea separadora -->
    <div class="linea-separadora"></div>        
</header>