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
    <script>
        function mostrarFormularioPago() {
            var formularioPago = document.getElementById('formulario-pago');
            
            // Verificar si el carrito está vacío usando PHP para establecer la condición
            var carritoVacio = <?php echo empty($_SESSION['carrito']) ? 'true' : 'false'; ?>;
            
            if (carritoVacio) {
                alert('Tu carrito está vacío. No puedes realizar la compra.');
            } else {
                formularioPago.style.display = formularioPago.style.display === 'block' ? 'none' : 'block';
            }
        }
    </script>
</head>
<body>
    <!-- Cabecera -->
    <header class="header py-3 px-4 bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <a href="?controller=producto&action=home" class="text-dark fw-bold" style="font-size: 14px;">&lt; CONTINUAR COMPRANDO</a>
            <div class="header-logo d-flex align-items-center">
                <a href="?controller=producto&action=home"><img src="/PROYECTO1/images/logoPrincipal.svg" width="170" class="me-2"></a>
            </div>
            <div class="header-links d-flex align-items-center">
                <div class="iconos d-flex align-items-center">
                    <a href="/tienda" style="text-decoration: none;">
                        <div class="iconoCarrito d-flex flex-column align-items-center">
                            <span class="icono-img"><i class="bi bi-question-circle"></i></span> <!-- Ayuda -->
                            <span class="text-nowrap">AYUDA</span>
                        </div>
                    </a>
                    <a href="?controller=usuario&action=mostrarFormulario" style="text-decoration: none;">
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

                                <!-- Formulario para eliminar o restar la cantidad -->
                                <form action="?controller=carrito&action=eliminarDelCarrito" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <input type="hidden" name="accion" value="restar"> <!-- Añadido para identificar que es restar -->
                                    <!-- Botón Restar (Llama a la acción de reducir la cantidad) -->
                                    <button class="btn btn-outline-secondary btn-sm" type="submit">-</button>
                                </form>

                                <!-- Campo de cantidad (solo lectura) -->
                                <input type="text" name="cantidad" value="<?= $producto['cantidad'] ?>" class="form-control text-center mx-2" style="width: 50px;" readonly>

                                <!-- Formulario para sumar la cantidad -->
                                <form action="?controller=carrito&action=agregarCantidadCarrito" method="POST" class="d-flex align-items-center">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <!-- Botón Sumar (Llama a la acción de agregar cantidad) -->
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
                    <!-- Subtotal -->
                        <div class="d-flex separadorLineaCarrito">
                            <?php
                            $subtotal = 0;
                            $totalArticulos = 0;

                            // Calcular subtotal y total de artículos
                            foreach ($_SESSION['carrito'] as $producto) {
                                $subtotal += $producto['precio'] * $producto['cantidad']; // Precio total por producto
                                $totalArticulos += $producto['cantidad']; // Cantidad total de artículos
                            }
                            ?>
                            <p class="mb-0 col-md-10">Subtotal (<?= $totalArticulos ?> artículos)</p>
                            <p class="fw-bold col-md-2"><?= number_format($subtotal, 2) ?>€</p>
                        </div>

                        <!-- Mensaje de envío -->
                        <div class="d-flex separadorLineaCarrito mb-3">
                            <p class="text-muted mt-3">
                                Envío de 3,50 para pedidos de menos de 20€
                            </p>
                        </div>

                        <!-- Total con envío -->
                        <div class="d-flex">
                            <?php
                            // Calcular el coste de envío
                                if ($subtotal < 20 and $subtotal > 0) {
                                    $envio = 3.50;
                                } else {
                                    $envio = 0;
                                }
                                //Total de los productos
                                $total = $subtotal + $envio; // Total con el envío
                            ?>
                            <p class="fw-bold col-md-10">TOTAL</p>
                            <p class="fw-bold col-md-2"><?= number_format($total, 2) ?>€</p>
                        </div>

                        <!-- Botones -->
                        <button type="button" class="botonesCarrito" onclick="mostrarFormularioPago()">COMENZAR PEDIDO !!</button>
                        <input type="text" class="form-control mb-3" placeholder="Introduce código promocional">
                        <button type="button" class="botonesCarrito">AÑADIR CÓDIGO</button>
                        <hr>

                        <!-- Formulario de pago (inicialmente oculto) -->
                        <div id="formulario-pago" style="display: none;">
                            <form action="?controller=producto&action=home" method="POST">
                                <div class="mt-3">
                                    <label for="titular" class="form-label">Titular de la tarjeta</label>
                                    <input type="text" id="titular" class="form-control" name="titular" placeholder="Nombre completo" required>
                                </div>
                                <div class="mt-3">
                                    <label for="numero-tarjeta" class="form-label">Número de tarjeta</label>
                                    <input type="text" id="numero-tarjeta" class="form-control" name="numero_tarjeta" placeholder="XXXX-XXXX-XXXX-XXXX" required>
                                </div>
                                <div class="mt-3">
                                    <label for="fecha-vencimiento" class="form-label">Fecha de vencimiento</label>
                                    <input type="month" id="fecha-vencimiento" class="form-control" name="fecha_vencimiento" required>
                                </div>
                                <div class="mt-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" id="cvv" class="form-control" name="cvv" placeholder="XXX" required>
                                </div>

                                <!-- Línea separadora -->
                                <hr>

                                <!-- Botón para finalizar el pedido -->
                                <form action="?controller=carrito&action=finalizarCompra" method="POST">
                                    <button type="submit" class="botonesCarrito">FINALIZAR PEDIDO</button>
                                </form>
                            </form>
                        </div>

                        <!-- Métodos de pago y entrega -->
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column align-items-end">
                                <p class="fw-bold">Pago seguro con:</p>
                                <div class="d-flex">
                                    <img src="/PROYECTO1/images/CARRITO/pago.svg" class="img-fluid">
                                </div>
                            </div>

                            <div class="d-flex flex-column align-items-start">
                                <p class="fw-bold">Métodos de entrega:</p>
                                <div class="d-flex">
                                    <img src="/PROYECTO1/images/CARRITO/entrega.svg" class="img-fluid">
                                </div>
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