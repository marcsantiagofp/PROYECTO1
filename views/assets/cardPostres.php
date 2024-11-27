<div class="row mb-4">
    <?php foreach (array_slice($postres, 0, 2) as $item): ?>
        <div class="col-6 position-relative quintaSeccion d-block">
            <!-- Formulario para agregar al carrito -->
            <form action="?controller=carrito&action=agregarAlCarrito" method="POST" id="form-<?= $item->getId(); ?>">
                <!-- Campo oculto con el ID del producto -->
                <input type="hidden" name="id" value="<?= $item->getId(); ?>">
            </form>
            <div 
                class="tarjeta-productos" 
                style="cursor: pointer;" 
                onclick="document.getElementById('form-<?= $item->getId(); ?>').submit();"
            >
                <img src="<?= $item->getUrl_imagen(); ?>" alt="<?= $item->getNombre(); ?>" class="img-fluid">
                <p class="etiquetaPrecioProductos"><?= number_format($item->getPrecio(), 2); ?>€</p>
                <p class="nombre-productos"><?= $item->getNombre(); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <?php foreach (array_slice($postres, 2, 4) as $item): ?>
        <div class="col-6 position-relative quintaSeccion d-block">
            <!-- Formulario para agregar al carrito -->
            <form action="?controller=carrito&action=agregarAlCarrito" method="POST" id="form-<?= $item->getId(); ?>">
                <!-- Campo oculto con el ID del producto -->
                <input type="hidden" name="id" value="<?= $item->getId(); ?>">
            </form>
            <div 
                class="tarjeta-productos" 
                style="cursor: pointer;" 
                onclick="document.getElementById('form-<?= $item->getId(); ?>').submit();"
            >
                <img src="<?= $item->getUrl_imagen(); ?>" alt="<?= $item->getNombre(); ?>" class="img-fluid">
                <p class="etiquetaPrecioProductos"><?= number_format($item->getPrecio(), 2); ?>€</p>
                <p class="nombre-productos"><?= $item->getNombre(); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>