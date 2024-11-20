<div class="container mt-3">

    <?php
        $accion = isset($_GET['action']) ? $_GET['action'] : default_action;

        // Comprobamos si la acción es "hamburguesas" o "menus"
        if ($accion == 'hamburguesas') {
            echo 
            '<h2 class="mb-3">Hamburguesas</h2>
            <p class="mb-4">Descubre nuestra deliciosas hamburguesas, preparadas con ingredientes frescos y con opciones para todos los gustos. Personaliza tu pedido a tu gusto y disfruta de una experiencia de comida rápida, cómoda y sabrosa. ¡Haz tu menú único con las mejores combinaciones de bebidas, patatas y más!</p>';
        } elseif ($accion == 'menus') {
            echo 
            '<h2 class="mb-3">Menús</h2>
            <p class="mb-4">Explora nuestras opciones de menús completos, diseñados para ofrecerte el combo perfecto. Incluyen tu hamburguesa favorita, una guarnición deliciosa y una bebida refrescante. ¡Una experiencia completa en cada bocado!</p>';
        } elseif ($accion == 'combos') {
            echo 
            '<h2 class="mb-3">Combos</h2>
            <p class="mb-4">¡Más opciones, más sabor! Nuestros combos te permiten disfrutar de tus productos favoritos en una combinación que se adapta a ti. Perfectos para compartir o para quienes buscan una comida variada y satisfactoria.</p>';
        } elseif ($accion == 'postres') {
            echo 
            '<h2 class="mb-3">Combos</h2>
            <p class="mb-4">¡Endulza tu día con nuestra irresistible selección de postres. Desde opciones clásicas hasta especialidades exclusivas, siempre encontrarás algo para satisfacer tus antojos. ¡Perfectos para acompañar cualquier comida o como capricho final!</p>';
        } elseif ($accion == 'patatas') {
            echo 
            '<h2 class="mb-3">Patatas</h2>
            <p class="mb-4">Nuestras patatas fritas son el acompañamiento ideal. Doradas y crujientes, con el toque perfecto de sal. También puedes probar nuestras opciones sazonadas o especiales. ¡Un clásico que nunca falla!</p>';
        } elseif ($accion == 'bebidas') {
            echo 
            '<h2 class="mb-3">Bebidas</h2>
            <p class="mb-4">Refresca tu experiencia con nuestra amplia selección de bebidas. Desde refrescos tradicionales hasta opciones más innovadoras, tenemos algo para todos los gustos. Completa tu comida con el toque perfecto.</p>';
        } elseif ($accion == 'infantiles') {
            echo 
            '<h2 class="mb-3">Infantiles</h2>
            <p class="mb-4">Diseñados especialmente para los pequeños, nuestros menús infantiles ofrecen opciones deliciosas y divertidas. Cada comida está preparada con porciones perfectas para que disfruten mientras comen.</p>';
        } elseif ($accion == 'ofertas') {
            echo 
            '<h2 class="mb-3">Ofertas</h2>
            <p class="mb-4">Descubre nuestras ofertas exclusivas pensadas para que disfrutes al máximo al mejor precio. Combina tus favoritos y ahorra mientras te das un capricho. ¡No te pierdas estas oportunidades únicas!</p>';
        }
    ?>

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
                <button class="w-100 filtrosCategorias">Vegetarianas ></button>
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