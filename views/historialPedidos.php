<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS externo -->
</head>
<body class="bg-light">
    <div class="container">
        <h2 style="margin-left: 150px; margin-bottom: 20px;">Mis Compras</h2>
        <div class="card mx-auto rounded-0" style="max-width: 1000px;">
            <div class="card-body">
                <div class="row">
                    <?php foreach ($pedidos as $pedido): ?>
                        <div class="col-md-4 mb-3">
                            <!-- Enlace envolviendo todo el div para redirigir a la acción correcta -->
                            <a href="?controller=usuario&action=mostrarDetallesPedido&id=<?= htmlspecialchars($pedido['id']) ?>" class="text-decoration-none">
                                <div class="card">
                                    <?php
                                    // Obtener la primera imagen del primer producto del pedido
                                    $firstProduct = $pedido['productos'][0]; 
                                    $productImage = $firstProduct['url_imagen']; // URL de la imagen del primer producto
                                    ?>
                                    <!-- Mostrar la imagen del primer producto en lugar de una imagen estática -->
                                    <img src="<?= htmlspecialchars($productImage) ?>" class="card-img-top" alt="Producto">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($pedido['cantidad_productos']) ?> artículos</h5>
                                        <p class="card-text"><strong>Fecha:</strong> <?= htmlspecialchars($pedido['fecha_pedido']) ?></p>
                                        <p class="card-text" style="margin-bottom: 10px;"><strong>Total:</strong> <?= htmlspecialchars($pedido['precio_total_pedidos']) ?> €</p>
                                        <button class="btn btn-custom">Ver detalles</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>