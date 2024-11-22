<div class="container mt-3">
    <h2 class="mb-3"><?= $categoria['nombre'] ?></h2>
    <p class="mb-4"><?= $categoria['descripcion'] ?></p>

   <!-- Filtros y orden a la derecha -->
    <div class="d-flex justify-content-end align-items-center mb-4">
        <div>
            <span><?= count($productos) ?> productos</span>
            <form method="GET" class="d-inline">
                <!-- Parámetros necesarios para mantener la ruta -->
                <input type="hidden" name="controller" value="producto">
                <input type="hidden" name="action" value="mostrarProductos">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <select name="orden" class="form-select d-inline-block w-auto ms-3" onchange="this.form.submit()">
                    <option value="" <?= !isset($_GET['orden']) ? 'selected' : '' ?>>Todos los productos</option>
                    <option value="asc" <?= (isset($_GET['orden']) && $_GET['orden'] === 'asc') ? 'selected' : '' ?>>Precio ascendente</option>
                    <option value="desc" <?= (isset($_GET['orden']) && $_GET['orden'] === 'desc') ? 'selected' : '' ?>>Precio descendente</option>
                </select>
            </form>
        </div>
    </div>



    <!-- Filtros de categorías a la izquierda y productos a la derecha -->
    <div class="row">
        <!-- Filtros de categorías a la izquierda -->
        <div class="col-md-3 mb-4">
            <div class="btn-group-vertical w-100">
                <?php foreach ($tipos as $tipo) { ?>
                    <button class="w-100 filtrosCategorias">
                        <?= htmlspecialchars($tipo['nombre']) ?> >
                    </button>
                <?php } ?>
            </div>
        </div>

        <!-- Productos a la derecha -->
        <div class="col-md-9">
            <div class="row gx-3 gy-4">
                <!-- Tarjeta de producto -->
                <?php foreach ($productos as $item) { ?>
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