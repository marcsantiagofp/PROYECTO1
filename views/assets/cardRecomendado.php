<?php foreach ($recomendados as $item): ?>
    <div class="col-sm-6 col-md-4 col-lg-3">
        <div 
            class="tarjeta-productos" 
            style="cursor: pointer;" 
            onclick="window.location.href='?controller=producto&action=verDetalles&id=<?= $item->getId(); ?>'"
        >
            <div class="etiquetaPrecioProductos"><?= number_format($item->getPrecio(), 2, ',', '.') ?> €</div>
            <img src="<?= $item->getUrl_imagen(); ?>" class="img-fluid imagen-productos" alt="Recomendado" style="max-height: 150px; object-fit: cover;">
            <p class="nombre-productos"><?= $item->getNombre(); ?></p>
        </div>
    </div>
<?php endforeach; ?>
