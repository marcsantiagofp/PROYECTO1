<?php

// Iniciar sesión solo si no está ya activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    public function finalizarCompra() {
        // Inicia el carrito en la sesión si no existe
        self::iniciarCarrito();
        
        if (empty($_SESSION['carrito'])) {
            // Si el carrito está vacío, redirigir a una página de error o mostrar un mensaje
            echo "Tu carrito está vacío. No puedes realizar el pedido.";
            return;
        }

        // Obtener el ID del usuario (suponiendo que ya está autenticado)
        $usuario_id = $_SESSION['usuario_id']; // O la forma en que guardas el ID de usuario en la sesión

        // Conectar a la base de datos
        $con = DataBase::connect();

        // Iniciar una transacción para asegurar la integridad de los datos
        $con->begin_transaction();

        try {
            // 1. Crear un nuevo pedido en la tabla PEDIDO
            $fecha_pedido = date('Y-m-d');
            $precio_total = 0;
            $cantidad_total = 0;
            
            // Calcular el precio total y la cantidad de productos
            foreach ($_SESSION['carrito'] as $producto) {
                $precio_total += $producto['precio'] * $producto['cantidad'];
                $cantidad_total += $producto['cantidad'];
            }

            // Insertar en la tabla PEDIDO
            $stmt = $con->prepare("INSERT INTO PEDIDO (fecha_pedido, precio_total_pedidos, cantidad_pedidos, id_cliente) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sdii", $fecha_pedido, $precio_total, $cantidad_total, $usuario_id);
            $stmt->execute();
            $numero_pedido = $stmt->insert_id; // Obtener el ID del pedido recién insertado

            // 2. Insertar las líneas de pedido en la tabla LINEA_PEDIDO
            foreach ($_SESSION['carrito'] as $producto) {
                $precio_producto = $producto['precio'] * $producto['cantidad']; // Precio total por producto
                $stmt = $con->prepare("INSERT INTO LINEA_PEDIDO (cantidad_productos, precio_productos, id_producto, numero_pedido) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("idii", $producto['cantidad'], $precio_producto, $producto['id'], $numero_pedido);
                $stmt->execute();
            }

            // 3. Si se ha aplicado algún descuento, podrías añadirlo a la tabla LINEA_PEDIDO (opcional)
            // Este paso depende de si el carrito contiene descuentos, si no, lo puedes omitir

            // Si todo está bien, confirmar la transacción
            $con->commit();

            // Limpiar el carrito después de finalizar el pedido
            unset($_SESSION['carrito']);
            
            // Redirigir a la página de confirmación del pedido o mostrar un mensaje de éxito
            echo "Pedido realizado con éxito. El número de tu pedido es: $numero_pedido";

        } catch (Exception $e) {
            // Si ocurre un error, deshacer la transacción
            $con->rollback();
            echo "Error al realizar el pedido: " . $e->getMessage();
        } finally {
            // Cerrar la conexión
            $con->close();
        }
    }
}
?>