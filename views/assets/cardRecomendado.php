<?php foreach ($recomendados as $item) { ?>
    <div class="col-sm-6 col-md-3 col-lg-3 col-lx-3">
        <a href="URL_DESTINO_1" class="text-decoration-none">
            <div class="tarjeta-productos">
                <div class="etiquetaPrecioProductos"><?= $item->getPrecio() ?></div>
                <img src="<?= $item->getUrl_imagen() ?>" class="img-fluid imagen-producto" alt="40px">
                <p class="nombre-productos"><?= $item->getNombre() ?></p>
            </div>
        </a>
    </div>
<?php } ?>