<?php foreach ($categorias as $item) { ?>
    <div class="col-6 col-md-3 col-lg">
        <a href="URL_POLLO" class="nombre-categorias">
            <img src="<?= $item->getUrl_imagen() ?>" class="img-fluid">
            <p><?= $item->getNombre() ?></p>
        </a>
    </div>
<?php } ?>