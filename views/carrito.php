<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DecathlonEats - Mi Cesta</title>
    <!-- ICONOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS PERSONALIZADO -->
    <link rel="stylesheet" href="/PROYECTO1/css/styles.css">
</head>
<body>
    <!-- Cabecera -->
    <header class="header py-3 px-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <a href="?controller=producto&action=home" class="text-dark fw-bold" style="font-size: 14px;">&lt; CONTINUAR COMPRANDO</a>
            <div class="header-logo d-flex align-items-center">
                <a href="?controller=producto&action=home"><img src="/PROYECTO1/images/logoPrincipal.png" width="170" class="me-2"></a>
            </div>
            <div class="header-links d-flex align-items-center">
                <div class="iconos d-flex align-items-center">
                    <a href="/tienda" style="text-decoration: none;">
                        <div class="iconoCarrito d-flex flex-column align-items-center">
                            <span class="icono-img"><i class="bi bi-question-circle"></i></span> <!-- Ayuda -->
                            <span class="text-nowrap">AYUDA</span>
                        </div>
                    </a>
                    <a href="/tienda" style="text-decoration: none;">
                        <div class="iconoCarrito d-flex flex-column align-items-center">
                            <span class="icono-img"><i class="bi bi-person-circle"></i></span> <!-- Mi cuenta -->
                            <span class="text-nowrap">MI CUENTA</span>
                        </div>
                    </a>
                    <div class="iconoCarrito d-flex flex-column align-items-center">
                        <i class="bi bi-shield-lock me-1"><span class="fw-bold text-primary">100%</span></i> 
                        <span class="text-nowrap">SEGURO</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Encabezado de Mi Cesta -->
    <section class="bg-light py-3">
        <div class="container d-flex">
            <h1 class="fw-bold miCesta col-md-8 me-3">Mi Cesta</h1>
            <h1 class="fw-bold miCesta col-md-3">Resumen del Pedido</h1>
        </div>
    </section>

    <!-- Contenido Principal -->
    <div class="container my-5">
        <div class="row">
            <!-- Sección izquierda: Lista de productos -->
            <div class="col-md-8">
                <div class="row caractCarrito">
                    <div class="col-md-4 text-center">PRODUCTO</div>
                    <div class="col-md-4 text-center">CANTIDAD</div>
                    <div class="col-md-4 text-center">PRECIO TOTAL</div>
                </div>

                <?php if (empty($_SESSION['carrito'])): ?>
                    <div class="mensaje-carrito-vacio">
                        Tu carrito está vacío.
                    </div>
                <?php else: ?>
                    <?php foreach ($_SESSION['carrito'] as $producto): ?>
                        <div class="d-flex align-items-center justify-content-between mb-4 separadorLineaCarrito">
                            <!-- Producto y nombre -->
                            <div class="d-flex align-items-center flex-grow-1">
                                <img src="<?= $producto['imagen'] ?>" class="img-fluid" width="100">
                                <div class="ms-3">
                                    <p class="mb-1 fw-bold"><?= $producto['nombre'] ?></p>
                                </div>
                            </div>

                            <!-- Cantidad -->
                            <div class="d-flex justify-content-center align-items-center col-md-4">
                                <form action="carrito.php" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="accion" value="restar">-</button>
                                    <input type="text" name="cantidad" value="<?= $producto['cantidad'] ?>" class="form-control text-center mx-2" style="width: 50px;" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="accion" value="sumar">+</button>
                                </form>
                            </div>

                            <!-- Precio total -->
                            <div class="d-flex justify-content-center align-items-center col-md-4">
                                <p class="mb-0 fw-bold"><?= $producto['precio'] * $producto['cantidad'] ?>€</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Sección derecha: Resumen del pedido -->
            <div class="col-md-4">
                <div class="card rounded-0">
                    <div class="card-body">
                        <div class="d-flex separadorLineaCarrito">
                            <p class="mb-0 col-md-10">Subtotal (<?= count($_SESSION['carrito']) ?> artículos)</p>
                            <p class="fw-bold col-md-2"><?= array_sum(array_column($_SESSION['carrito'], 'precio')) ?>€</p>
                        </div>
                        <div class="d-flex separadorLineaCarrito mb-3">
                            <p class="text-muted mt-3">Envío de 3,50 para pedidos de menos de 20€</p>
                        </div>
                        <div class="d-flex">
                            <p class="fw-bold col-md-10">TOTAL</p>
                            <p class="fw-bold col-md-2"><?= array_sum(array_column($_SESSION['carrito'], 'precio')) + 3.5 ?>€</p>
                        </div>
                        <button type="button" class="botonesCarrito">COMENZAR PEDIDO !!</button>
                        <input type="text" class="form-control mb-3" placeholder="Introduce código promocional">
                        <button type="button" class="botonesCarrito">AÑADIR CÓDIGO</button>
                        <hr>
                        <div class="d-flex">
                            <p class="text-center text-muted">Pago seguro con:</p>
                            <div class="d-flex justify-content-center">
                                <img src="visa.png" alt="Visa" width="40" class="mx-1">
                                <img src="paypal.png" alt="PayPal" width="40" class="mx-1">
                                <img src="applepay.png" alt="Apple Pay" width="40" class="mx-1">
                            </div>
                            <p class="text-center text-muted mt-3">Métodos de entrega:</p>
                            <div class="d-flex justify-content-center">
                                <img src="glovo.png" alt="Glovo" width="40" class="mx-1">
                                <img src="ubereats.png" alt="Uber Eats" width="40" class="mx-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT BOOTSTRAP -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>