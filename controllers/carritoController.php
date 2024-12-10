<?php

// Iniciar sesión solo si no está ya activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';
include_once 'models/Usuario.php';
include_once 'models/UsuarioDAO.php';
include_once 'config/dataBase.php';

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

    // Función para finalizar la compra
    public function finalizarCompra() {
        // Usar la clase DataBase para conectarse a la base de datos
        $conexion = DataBase::connect();

        // Insertar el pedido en la tabla PEDIDO
        $fecha_pedido = date('Y-m-d'); // Fecha actual
        $precio_total_pedidos = 0;
        $cantidad_productos = 0;

        // Verificar si existe una sesión iniciada
        if (!isset($_SESSION['usuario_id'])) {
            echo "<script>alert('Debes iniciar sesión para finalizar tu pedido.');</script>";
            echo "<script>window.location.href = '?controller=usuario&action=mostrarFormulario';</script>";
            return;
        }

        // Calcular subtotal y total de productos
        foreach ($_SESSION['carrito'] as $producto) {
            $precio_total_pedidos += $producto['precio'] * $producto['cantidad'];
            $cantidad_productos += $producto['cantidad'];
        }

        // ID del cliente (asumiendo que está en la sesión)
        $id_cliente = $_SESSION['usuario_id'];

        // Insertar en PEDIDO
        $stmt = $conexion->prepare("INSERT INTO PEDIDO (fecha_pedido, precio_total_pedidos, cantidad_productos, id_cliente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdii", $fecha_pedido, $precio_total_pedidos, $cantidad_productos, $id_cliente);
        $stmt->execute();
        $id_pedido = $stmt->insert_id; // Obtener el ID del pedido insertado

        // Insertar productos del carrito en la tabla LINEA_PEDIDO
        foreach ($_SESSION['carrito'] as $producto) {
            $id_producto = $producto['id'];
            $cantidad_productos = $producto['cantidad'];
            $precio_productos = $producto['precio'] * $producto['cantidad'];

            $stmt_linea = $conexion->prepare("INSERT INTO LINEA_PEDIDO (cantidad_productos, precio_productos, id_producto, numero_pedido) VALUES (?, ?, ?, ?)");
            $stmt_linea->bind_param("idii", $cantidad_productos, $precio_productos, $id_producto, $id_pedido);
            $stmt_linea->execute();
        }

        // Limpiar el carrito
        unset($_SESSION['carrito']);

        // Cerrar las declaraciones y la conexión
        $stmt->close();
        $conexion->close();

        // Redirigir a la página de confirmación o mostrar mensaje
        echo "<script>alert('Pedido enviado con éxito.');</script>";
        echo "<script>window.location.href = '?controller=pedido&action=confirmacion&id=$id_pedido';</script>";
    }
}