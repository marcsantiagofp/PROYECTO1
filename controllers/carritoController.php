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

    public function aplicarDescuento() {
        if (isset($_POST['codigo_descuento'])) {
            $codigoDescuento = $_POST['codigo_descuento'];
            $descuentos = ProductoDAO::getDescuentos(); // Obtener todos los descuentos
            
            foreach ($descuentos as $descuento) {
                if ($descuento['codigo_descuento'] === $codigoDescuento) {
                    // Convertir el tipo de descuento a número
                    $tipoDescuento = $descuento['tipo_descuento'];
    
                    if (strpos($tipoDescuento, '%') !== false) {
                        // Si es un porcentaje, quitar el '%' y convertir a número
                        $_SESSION['descuento'] = (float) rtrim($tipoDescuento, '%') / 100; // Asegurarse que se guarda como porcentaje
                    } else {
                        // Si es un valor fijo
                        $_SESSION['descuento'] = (float) $tipoDescuento;
                    }
    
                    echo "<script>alert('Descuento aplicado correctamente.');</script>";
                    echo "<script>window.location.href = '?controller=carrito&action=verCarrito';</script>";
                    return;
                }
            }
            
            echo "<script>alert('Código de descuento inválido.');</script>";
            echo "<script>window.location.href = '?controller=carrito&action=verCarrito';</script>";
        }
    } 

    // Función para finalizar la compra
    public function finalizarCompra() {
        // Verificar si existe una sesión iniciada
        if (!isset($_SESSION['usuario_id'])) {
            echo "<script>alert('Debes iniciar sesión para finalizar tu pedido.');</script>";
            echo "<script>window.location.href = '?controller=usuario&action=mostrarFormulario';</script>";
            return;
        }

        // Inicializar variables
        $fecha_pedido = date('Y-m-d H:i:s'); // Fecha actual
        $precio_total_pedidos = 0;
        $cantidad_total_productos = 0;

        // Calcular subtotal y total de productos
        foreach ($_SESSION['carrito'] as $producto) {
            $precio_total_pedidos += $producto['precio'] * $producto['cantidad'];
            $cantidad_total_productos += $producto['cantidad'];
        }

        // Aplicar el descuento si existe
        if (isset($_SESSION['descuento'])) {
            $precio_total_pedidos *= (1 - $_SESSION['descuento']);
        }

        // Verificar si el precio total es menor a 20 y añadir el costo de envío
        if ($precio_total_pedidos < 20) {
            $precio_total_pedidos += 3.50;
        }

        // ID del cliente (asumiendo que está en la sesión)
        $id_cliente = $_SESSION['usuario_id'];

        // Insertar el pedido en la base de datos usando PedidosDAO
        $id_pedido = PedidosDAO::insertarPedido($fecha_pedido, $precio_total_pedidos, $cantidad_total_productos, $id_cliente);

        // Insertar productos del carrito en la tabla LINEA_PEDIDO
        foreach ($_SESSION['carrito'] as $producto) {
            $id_producto = $producto['id'];
            $cantidad_productos = $producto['cantidad'];
            $precio_productos = $producto['precio'] * $producto['cantidad'];

            // Obtener el ID del descuento si existe
            $id_descuento = null;
            if (isset($_SESSION['descuento'])) {
                $id_descuento = PedidosDAO::obtenerIdDescuento($_SESSION['descuento']);
            }

            // Insertar línea de pedido en la base de datos
            PedidosDAO::insertarLineaPedido($cantidad_productos, $precio_productos, $id_producto, $id_descuento, $id_pedido);
        }

        // Limpiar el carrito y el descuento de la sesión
        unset($_SESSION['carrito']);
        unset($_SESSION['descuento']);

        // Redirigir a la página de confirmación
        echo "<script>alert('Pedido enviado con éxito.');</script>";
        echo "<script>window.location.href = '?controller=pedido&action=confirmacion&id=$id_pedido';</script>";
    }
}