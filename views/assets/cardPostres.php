<div class="row mb-4">
    <?php foreach (array_slice($postres, 0, 2) as $item): ?>
        <div class="col-6 position-relative quintaSeccion d-block">
            <div 
                class="tarjeta-productos" 
                style="cursor: pointer;" 
                onclick="window.location.href='?controller=producto&action=verDetalles&id=<?= $item->getId(); ?>'"
            >
                <img src="<?= $item->getUrl_imagen(); ?>" alt="<?= $item->getNombre(); ?>" class="img-fluid">
                <p class="etiquetaPrecioProductos"><?= number_format($item->getPrecio(), 2, ',', '.') ?> €</p>
                <p class="nombre-productos"><?= $item->getNombre(); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="row">
    <?php foreach (array_slice($postres, 2, 4) as $item): ?>
        <div class="col-6 position-relative quintaSeccion d-block">
            <div 
                class="tarjeta-productos" 
                style="cursor: pointer;" 
                onclick="window.location.href='?controller=producto&action=verDetalles&id=<?= $item->getId(); ?>'"
            >
                <img src="<?= $item->getUrl_imagen(); ?>" alt="<?= $item->getNombre(); ?>" class="img-fluid">
                <p class="etiquetaPrecioProductos"><?= number_format($item->getPrecio(), 2, ',', '.') ?> €</p>
                <p class="nombre-productos"><?= $item->getNombre(); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>