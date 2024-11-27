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

    // Acción para ver el carrito
    public function verCarrito() {
        self::iniciarCarrito();
        include_once 'views/carrito.php'; // Aquí se mostrará la vista del carrito
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

    // Acción para eliminar o reducir la cantidad de un producto
    public function eliminarDelCarrito() {
        if (isset($_POST['id'])) { // Cambiar de GET a POST
            $producto_id = $_POST['id']; // Obtener el ID del producto a modificar
            foreach ($_SESSION['carrito'] as $index => $producto) {
                if ($producto['id'] == $producto_id) {
                    // Reducir la cantidad
                    if ($_SESSION['carrito'][$index]['cantidad'] > 1) {
                        $_SESSION['carrito'][$index]['cantidad']--; // Disminuir la cantidad
                    } else {
                        // Eliminar el producto si la cantidad es 1 o 0
                        unset($_SESSION['carrito'][$index]);
                    }
                    break;
                }
            }
    
            // Reindexar el array para eliminar posibles huecos
            $_SESSION['carrito'] = array_values($_SESSION['carrito']);
    
            // Redirige al carrito después de la eliminación o ajuste
            header("Location: ?controller=carrito&action=verCarrito");
            exit();
        }
    }
    

    // Acción para aumentar la cantidad de un producto en el carrito
    public function agregarCantidadCarrito() {
        if (isset($_POST['id'])) {
            $producto_id = $_POST['id'];
            foreach ($_SESSION['carrito'] as $index => $producto) {
                if ($producto['id'] == $producto_id) {
                    // Incrementar la cantidad
                    $_SESSION['carrito'][$index]['cantidad']++;
                    break;
                }
            }
            // Redirige al carrito después de agregar la cantidad
            header("Location: ?controller=carrito&action=verCarrito");
            exit();
        }
    }
}
?>