<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS -->
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto rounded-0" style="max-width: 1000px;">
            <div class="card-header text-center">
                <h2>Pedido #001</h2>
            </div>
            <div class="card-body">
                <!-- Pedido único -->
                <div class="list-group">
                    <!-- Pedido único -->
                    <div class="list-group-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p><strong>Fecha:</strong> 10/12/2024</p>
                            <p><strong>Total:</strong> $50.00</p>
                        </div>

                        <!-- Productos del pedido -->
                        <div class="row" style="margin-top: 10px;">
                            <!-- Producto 1 -->
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="Ternera.svg" class="card-img-top" alt="Producto A">
                                    <div class="card-body">
                                        <h5 class="card-title">NOMBRE</h5>
                                        <p class="card-text">Precio: $25.00</p>
                                        <p class="card-text">Cantidad: 1</p>
                                        <p class="card-text"><strong>Total: $25.00</strong></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Producto 2 -->
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="Ternera.svg" class="card-img-top" alt="Producto B">
                                    <div class="card-body">
                                        <h5 class="card-title">NOMBRE</h5>
                                        <p class="card-text">Precio: $25.00</p>
                                        <p class="card-text">Cantidad: 1</p>
                                        <p class="card-text"><strong>Total: $25.00</strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>