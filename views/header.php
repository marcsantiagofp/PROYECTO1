<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DecathlonEats</title>
</head>
<body class="m-0 border-0 bd-example m-0 border-0 bd-example-cols">

    <!-- Encabezado -->
    <header>
        <!-- CARRUSEL OFERTAS -->
        <div id="carouselExampleAutoplaying" class="carousel slide promocion" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <p class="textoPromocion">Promoción Menu Burger Barbacoa 4'99€ 🔥🔥</p>
                </div>
                <div class="carousel-item">
                    <p class="textoPromocion">Prueba nuestras novedades 🍔🍔</p>
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
                    <a href="home.php">
                        <img src="/PROYECTO1/images/logoPrincipal.png" alt="DecathlonEats Logo" class="img-fluid logo">
                    </a>
                    <input type="text" placeholder="Busca producto, ..." class="buscador">
                    <button class="buscar-btn"><img src="/PROYECTO1/images/lupa.png" alt="DecathlonEats Logo" class="lupa"></button>
                    <div class="iconos">
                        <a href="/tienda">
                            <div class="icono d-none d-lg-flex flex-column text-center">
                                <span class="icono-img"><i class="bi bi-question-circle"></i></span> <!-- Ayuda -->
                                <span class="text-nowrap">AYUDA</span>
                            </div>
                        </a>
                        <a href="/tienda">
                        <div class="icono d-flex flex-column align-items-center">
                            <span class="icono-img"><i class="bi bi-shop"></i></span> <!-- Tienda -->
                            <span class="text-nowrap">TIENDA</span>
                        </div>
                        </a>
                        <a href="/tienda">
                        <div class="icono d-flex flex-column align-items-center">
                            <span class="icono-img"><i class="bi bi-person-circle"></i></span> <!-- Mi cuenta -->
                            <span class="text-nowrap">MI CUENTA</span>
                        </div>
                        </a>
                        <a href="carrito.php">
                        <div class="icono d-flex flex-column align-items-center" style="color: #3643BA;">
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
                            <a class="nav-link" href="productos.php">Hamburguesas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Menús</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Combos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Postres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Patatas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Bebidas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Infantiles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" style="color: #E3262F;">Ofertas</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Línea separadora -->
        <div class="linea-separadora"></div>        
</header>