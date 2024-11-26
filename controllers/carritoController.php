<?php

session_start();
include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';

class CarritoController {

    // Inicia el carrito en la sesión si no existe
    public static function iniciarCarrito() {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Acción para agregar un producto al carrito
    public function agregarAlCarrito() {
        self::iniciarCarrito();
    
        if (isset($_POST['id'])) {
            $producto_id = $_POST['id'];
            $producto = ProductoDAO::getProductoById($producto_id); // Obtener el producto por su ID
    
            if ($producto) {
                $encontrado = false;
                // Revisa si el producto ya está en el carrito
                foreach ($_SESSION['carrito'] as &$item) {
                    if ($item['id'] == $producto->getId()) {
                        $item['cantidad']++;  // Si está, se aumenta la cantidad
                        $encontrado = true;
                        break;
                    }
                }
                // Si no está en el carrito, lo agrega
                if (!$encontrado) {
                    $_SESSION['carrito'][] = [
                        'id' => $producto->getId(),
                        'nombre' => $producto->getNombre(),
                        'precio' => $producto->getPrecio(),
                        'imagen' => $producto->getUrl_imagen(),
                        'cantidad' => 1
                    ];
                }
            }
    
            // Obtener la categoría del producto
            $categoria = ProductoDAO::getCategoriaByProductoId($producto_id);
    
            // Redirige a la página de la categoría del producto
            header("Location: ?controller=producto&action=mostrarProductos&id=" . $categoria['id']);
            exit();
        }
    }

    // Acción para eliminar un producto del carrito
    public function eliminarDelCarrito() {
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
            foreach ($_SESSION['carrito'] as $index => $producto) {
                if ($producto['id'] == $producto_id) {
                    unset($_SESSION['carrito'][$index]); // Elimina el producto del carrito
                    break;
                }
            }
            // Redirige al carrito
            header("Location: ?controller=carrito&action=verCarrito");
            exit();
        }
    }

    // Acción para ver el carrito
    public function verCarrito() {
        include_once 'views/carrito.php'; // Aquí se mostrará la vista del carrito
    }

    // Acción para actualizar la cantidad de un producto en el carrito
    public function actualizarCantidad() {
        if (isset($_POST['id']) && isset($_POST['cantidad'])) {
            $producto_id = $_POST['id'];
            $cantidad = $_POST['cantidad'];

            foreach ($_SESSION['carrito'] as &$producto) {
                if ($producto['id'] == $producto_id) {
                    // Verifica que la cantidad no sea menor a 1
                    if ($cantidad >= 1) {
                        $producto['cantidad'] = $cantidad; // Actualiza la cantidad
                    }
                    break;
                }
            }
        }
        
        // Redirige nuevamente al carrito
        header("Location: ?controller=carrito&action=verCarrito");
        exit();
    }
}
?>