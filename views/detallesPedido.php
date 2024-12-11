<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS -->
    <style>
        .btn-light {
            border-radius: 0;
            padding: 10px 20px;
            font-weight: bold;
            margin-left: 150px;
            border: 1px solid #ddd;
            background-color: #f0f0f0;
        }

        .btn-light:hover {
            background-color: #e0e0e0; /* Color ligeramente más oscuro al pasar el ratón */
            border-color: #ccc; /* Cambiar el borde a un color más oscuro */
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <!-- Botón para volver a todos los pedidos con estilo cuadrado y gris claro -->
        <a href="?controller=usuario&action=mostrarHistorialPedidos" class="btn btn-light mb-4">Volver a todos los pedidos</a>

        <div class="card mx-auto rounded-0" style="max-width: 1000px;">
            <div class="card-header text-center">
                <h2>Pedido #<?= htmlspecialchars($idPedido) ?></h2>
            </div>
            <div class="card-body">
                <!-- Pedido único -->
                <div class="list-group">
                    <div class="list-group-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p><strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha_pedido']) ?></p>
                            <p><strong>Total:</strong> <?= htmlspecialchars($pedido['precio_total_pedidos']) ?> €</p>
                        </div>

                        <!-- Productos del pedido -->
                        <div class="row" style="margin-top: 10px;">
                            <?php foreach ($productos as $producto): ?>
                                <!-- Producto -->
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="<?= htmlspecialchars($producto['url_imagen']) ?>" class="card-img-top" alt="Producto">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($producto['nombre_producto']) ?></h5>
                                            <p class="card-text">Precio: <?= htmlspecialchars($producto['precio_producto']) ?> €</p>
                                            <p class="card-text">Cantidad: <?= htmlspecialchars($producto['cantidad_productos']) ?></p>
                                            <p class="card-text"><strong>Total: <?= htmlspecialchars($producto['precio_producto'] * $producto['cantidad_productos']) ?> €</strong></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>