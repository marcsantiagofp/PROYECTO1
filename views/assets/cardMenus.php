<div class="container mt-3">
    <h2 class="mb-3">Menús</h2>
    <p class="mb-4">Explora nuestras opciones de menús completos, diseñados para ofrecerte el combo perfecto. Incluyen tu hamburguesa favorita, una guarnición deliciosa y una bebida refrescante. ¡Una experiencia completa en cada bocado!</p>
    
    <!-- Filtros y orden a la derecha -->
    <div class="d-flex justify-content-end align-items-center mb-4">
        <div>
            <span>18 productos</span>
            <select class="form-select d-inline-block w-auto ms-3">
                <option>Todos los productos</option>
                <option>Precio ></option>
                <option>Precio <</option>
            </select>
        </div>
    </div>

    <!-- Filtros de categorías a la izquierda y productos a la derecha -->
    <div class="row">
        <!-- Filtros de categorías a la izquierda -->
        <div class="col-md-3 mb-4">
            <div class="btn-group-vertical w-100">
                <button class="w-100 filtrosCategorias">Pollo ></button>
                <button class="w-100 filtrosCategorias">Ternera ></button>
                <button class="w-100 filtrosCategorias">Vegetariano ></button>
            </div>
        </div>

        <!-- Productos a la derecha -->
        <div class="col-md-9">
            <div class="row gx-3 gy-4">
                <!-- Tarjeta de producto -->
                <?php foreach ($hamburgesas as $item) { ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <a href="URL_DESTINO_3" class="text-decoration-none">
                            <div class="tarjeta-productos">
                                <div class="etiquetaPrecioProductos"><?= $item->getPrecio() ?></div>
                                <img src="<?= $item->getUrl_imagen() ?>" class="img-fluid imagen-productos" alt="40px">
                                <p class="nombre-productos"><?= $item->getNombre() ?></p>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>