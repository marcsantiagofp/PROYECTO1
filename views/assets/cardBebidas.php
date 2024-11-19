<div class="row mb-4">
    <?php foreach (array_slice($bebidas, 0, 2) as $item) { ?>
        <a href="URL_COCACOLA" class="col-6 position-relative quintaSeccion d-block">
            <img src="<?= $item->getUrl_imagen() ?>" alt="Coca Cola" class="img-fluid">
            <p class="etiquetaPrecioBebidas"><?= $item->getPrecio() ?></p>
            <p class="nombreBebidas"><?= $item->getNombre() ?></p>
        </a>
    <?php } ?>
</div>
<div class="row">
    <?php foreach (array_slice($bebidas, 2, 4) as $item) { ?>
        <a href="URL_COCACOLA" class="col-6 position-relative quintaSeccion d-block">
            <img src="<?= $item->getUrl_imagen() ?>" alt="Coca Cola" class="img-fluid">
            <p class="etiquetaPrecioBebidas"><?= $item->getPrecio() ?></p>
            <p class="nombreBebidas"><?= $item->getNombre() ?></p>
        </a>
    <?php } ?>
</div>