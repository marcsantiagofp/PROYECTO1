<?php foreach ($categorias as $item): ?>
    <div class="col-6 col-md-3 col-lg">
        <a href="?controller=producto&action=mostrarProductos&id=<?= $item->getId(); ?>" class="nombre-categorias text-decoration-none">
            <img src="<?= $item->getUrl_imagen(); ?>" class="img-fluid">
            <p><?= $item->getNombre(); ?></p>
        </a>
    </div>
<?php endforeach; ?>