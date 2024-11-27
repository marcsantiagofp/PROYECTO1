<?php foreach ($recomendados as $item): ?>
    <div class="col-sm-6 col-md-3 col-lg-3 col-lx-3">
        <form action="?controller=carrito&action=agregarAlCarrito" method="POST" id="form-<?= $item->getId(); ?>">
            <!-- Datos del producto como campos ocultos -->
            <input type="hidden" name="id" value="<?= $item->getId(); ?>">
        </form>
        <div 
            class="tarjeta-productos" 
            style="cursor: pointer;" 
            onclick="document.getElementById('form-<?= $item->getId(); ?>').submit();"
        >
            <div class="etiquetaPrecioProductos"><?= number_format($item->getPrecio(), 2); ?> €</div>
            <img src="<?= $item->getUrl_imagen(); ?>" class="img-fluid imagen-producto" alt="40px">
            <p class="nombre-productos"><?= $item->getNombre(); ?></p>
        </div>
    </div>
<?php endforeach; ?>