<?php
include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';
include_once 'config/dataBase.php';

class productoController{
    public static function home() {
        $recomendados = ProductoDAO::getRecomendados();
        $categorias = ProductoDAO::getSeccionCategorias();
        $postres = ProductoDAO::getSeccionBebidas();
        $view = 'views/home.php';
        include_once 'views/main.php';
    }
    
    public static function mostrarProductos() {
        // Obtener el ID de la categoría desde la URL
        $id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
        // Obtener el orden desde la URL (ascendente o descendente)
        $orden = isset($_GET['orden']) ? $_GET['orden'] : null;
    
        // Llamar a la función getCategoria con el ID de la categoría
        $categoria = ProductoDAO::getCategoria($id_categoria);
    
        // Llamar a la función getTiposPorCategoria con el ID de la categoría
        $tipos = ProductoDAO::getTiposPorCategoria($id_categoria);
    
        // Llamar a la función getProductos con el ID de la categoría y el orden
        $productos = ProductoDAO::getProductos($id_categoria, $orden);
    
        // Establecer las vistas a mostrar
        $view = 'views/productos.php';
    
        // Incluir la vista principal
        include_once 'views/main.php';
    }

    // Ver detalles de un producto
    public static function verDetalles() {
        // Obtener el ID del producto desde la URL
        $id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

        // Usar el método getProductoById para obtener el producto
        $producto = ProductoDAO::getProductoById($id_producto);

        // Si el producto no existe, no hacer nada
        if (!$producto) {
            return;
        }

        // Cargar la vista para mostrar los detalles del producto
        $view = 'views/detalleProducto.php';
        
        // Pasar el producto a la vista
        include_once 'views/main.php';
    }
}
?>