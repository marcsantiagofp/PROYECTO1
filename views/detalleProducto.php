<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto</title>
</head>
<body>

<div class="container mt-5">
    <div class="row g-5">
        <!-- Columna izquierda para la imagen -->
        <div class="col-md-5 text-center">
            <!-- Mostrar la imagen del producto -->
            <img src="<?php echo $producto->getUrl_imagen(); ?>" class="img-fluid w-75" alt="Producto">
        </div>

        <!-- Columna derecha para la información del producto -->
        <div class="col-md-7">
            <!-- Título -->
            <div class="mb-3">
                <h2 class="fw-bold"><?php echo $producto->getNombre(); ?></h2>
            </div>
            
            <!-- Precio -->
            <div class="mb-2">
                <p class="precioDentroProductos"><?php echo number_format($producto->getPrecio(), 2, ',', '.') . ' €'; ?></p>
            </div>
            
            <!-- Descripción -->
            <div class="mb-5">
                <p class="descripcionDentroProductos"><?php echo $producto->getDescripcion(); ?></p>
            </div>
            
            <!-- Botón para agregar al carrito -->
            <div>
                <form action="?controller=carrito&action=agregarAlCarrito" method="POST">
                    <input type="hidden" name="id" value="<?php echo $producto->getId(); ?>">
                    <button type="submit" class="botonComprarProductos">Añadir al carrito</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>