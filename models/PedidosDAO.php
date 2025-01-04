<?php

include_once("config/dataBase.php");
include_once("models/Producto.php");
include_once("models/Usuario.php");

class PedidosDAO {

    // Función para obtener los pedidos de un usuario por ID, ordenados por fecha ascendente
    public static function obtenerPedidosPorUsuario($idUsuario) {
        $conexion = DataBase::connect();

        $sql = "SELECT * FROM PEDIDO WHERE id_cliente = ? ORDER BY fecha_pedido ASC";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedido = $row;

            // Obtener los productos asociados a este pedido
            $productos_sql = "SELECT p.id, p.nombre, p.precio, p.url_imagen
                              FROM LINEA_PEDIDO lp
                              JOIN PRODUCTO p ON lp.id_producto = p.id
                              WHERE lp.numero_pedido = ?";
            $stmt_productos = $conexion->prepare($productos_sql);
            $stmt_productos->bind_param("i", $row['id']);
            $stmt_productos->execute();
            $productos_result = $stmt_productos->get_result();

            $productos = [];
            while ($producto = $productos_result->fetch_assoc()) {
                $productos[] = $producto;
            }

            $pedido['productos'] = $productos;
            $pedidos[] = $pedido;
        }

        $stmt->close();
        $conexion->close();
        return $pedidos;
    }

    // Obtener los detalles de un pedido, junto con los productos asociados
    public static function obtenerDetallesPedido($idPedido) {
        $conexion = DataBase::connect();

        $sqlPedido = "SELECT fecha_pedido, precio_total_pedidos FROM PEDIDO WHERE id = ?";
        $stmtPedido = $conexion->prepare($sqlPedido);
        $stmtPedido->bind_param("i", $idPedido);
        $stmtPedido->execute();
        $resultPedido = $stmtPedido->get_result();
        $pedido = $resultPedido->fetch_assoc();
        $stmtPedido->close();

        $sqlProductos = "
            SELECT p.nombre AS nombre_producto, 
                p.precio AS precio_producto, 
                lp.cantidad_productos, 
                p.url_imagen 
            FROM LINEA_PEDIDO lp
            INNER JOIN PRODUCTO p ON lp.id_producto = p.id
            WHERE lp.numero_pedido = ?
        ";
        $stmtProductos = $conexion->prepare($sqlProductos);
        $stmtProductos->bind_param("i", $idPedido);
        $stmtProductos->execute();
        $resultProductos = $stmtProductos->get_result();

        $productos = [];
        while ($row = $resultProductos->fetch_assoc()) {
            $productos[] = $row;
        }

        $stmtProductos->close();
        $conexion->close();

        return ['pedido' => $pedido, 'productos' => $productos];
    }

    // Nueva función: Obtener el ID del descuento
    public static function obtenerIdDescuento($codigo_descuento) {
        $conexion = DataBase::connect();
        $id_descuento = null;

        $codigo_descuento_param = "%$codigo_descuento%";
        $stmt = $conexion->prepare("SELECT id FROM DESCUENTOS WHERE tipo_descuento LIKE ?");
        $stmt->bind_param("s", $codigo_descuento_param);
        $stmt->execute();
        $stmt->bind_result($id_descuento);
        $stmt->fetch();
        $stmt->close();
        $conexion->close();

        return $id_descuento;
    }

    // Nueva función: Insertar un pedido
    public static function insertarPedido($fecha_pedido, $precio_total_pedidos, $cantidad_productos, $id_cliente) {
        $conexion = DataBase::connect();
        
        // Asegurarse de que la fecha esté en formato correcto
        $fecha_pedido = date('Y-m-d H:i:s', strtotime($fecha_pedido)); // Si la fecha viene en un formato distinto
        
        $stmt = $conexion->prepare("INSERT INTO PEDIDO (fecha_pedido, precio_total_pedidos, cantidad_productos, id_cliente) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdii", $fecha_pedido, $precio_total_pedidos, $cantidad_productos, $id_cliente);
        $stmt->execute();
        $id_pedido = $stmt->insert_id;
        $stmt->close();
        $conexion->close();
        return $id_pedido;
    }

    // Nueva función: Insertar una línea de pedido
    public static function insertarLineaPedido($cantidad_productos, $precio_productos, $id_producto, $id_descuento, $numero_pedido) {
        $conexion = DataBase::connect();
        $stmt = $conexion->prepare("INSERT INTO LINEA_PEDIDO (cantidad_productos, precio_productos, id_producto, id_descuento, numero_pedido) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("idiii", $cantidad_productos, $precio_productos, $id_producto, $id_descuento, $numero_pedido);
        $stmt->execute();
        $stmt->close();
        $conexion->close();
    }

    // Obtener todos los pedidos de la base de datos con filtros de orden
    public static function getAllPedidos($orden = null) {
        $conexion = DataBase::connect();
    
        // Lista blanca de valores permitidos para 'orden'
        $validOrders = ['usuario_desc', 'fecha', 'precio_asc', 'precio_desc'];
        if ($orden && !in_array($orden, $validOrders)) {
            // Si el valor de 'orden' no es válido, asignar un valor por defecto
            $orden = 'fecha'; // O cualquier valor por defecto que consideres apropiado
        }
    
        // Construir la consulta SQL base
        $sql = "SELECT * FROM PEDIDO";
    
        // Aplicar el orden si se especifica
        switch ($orden) {
            case 'usuario_desc':
                $sql .= " ORDER BY id_cliente DESC";
                break;
            case 'fecha':
                $sql .= " ORDER BY fecha_pedido ASC";
                break;
            case 'precio_asc':
                $sql .= " ORDER BY precio_total_pedidos ASC";
                break;
            case 'precio_desc':
                $sql .= " ORDER BY precio_total_pedidos DESC";
                break;
            default:
                $sql .= " ORDER BY fecha_pedido ASC"; // Valor por defecto
        }
    
        // Preparar y ejecutar la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Almacenar los pedidos en un arreglo
        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }
    
        // Cerrar la conexión
        $stmt->close();
        $conexion->close();
    
        return $pedidos;
    }       

    // Eliminar un pedido y sus líneas asociadas
    public static function eliminarPedido($id) {
        $db = DataBase::connect();
        
        // Eliminar las líneas del pedido primero
        $stmt = $db->prepare("DELETE FROM LINEA_PEDIDO WHERE numero_pedido = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Eliminar el pedido
        $stmt = $db->prepare("DELETE FROM PEDIDO WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        
        $stmt->close();
        $db->close();

        return $result;  // Devuelve true si se eliminó el pedido, false si no
    }

    // Función para obtener un pedido por ID
    public static function obtenerPedidoPorId($idPedido) {
        $conexion = DataBase::connect();

        // Consulta para obtener el pedido por su ID
        $sqlPedido = "SELECT * FROM PEDIDO WHERE id = ?";
        $stmtPedido = $conexion->prepare($sqlPedido);
        $stmtPedido->bind_param("i", $idPedido);
        $stmtPedido->execute();
        $resultPedido = $stmtPedido->get_result();
        
        // Si el pedido no existe, retornamos null
        if ($resultPedido->num_rows == 0) {
            return null;
        }
        
        // Obtener el pedido
        $pedido = $resultPedido->fetch_assoc();
        $stmtPedido->close();

        // Consulta para obtener los productos asociados al pedido
        $sqlProductos = "
        SELECT p.id, p.nombre, p.precio, p.url_imagen, lp.cantidad_productos 
        FROM LINEA_PEDIDO lp
        INNER JOIN PRODUCTO p ON lp.id_producto = p.id
        WHERE lp.numero_pedido = ?
        ";

        $stmtProductos = $conexion->prepare($sqlProductos);
        $stmtProductos->bind_param("i", $idPedido);
        $stmtProductos->execute();
        $resultProductos = $stmtProductos->get_result();

        $productos = [];
        while ($row = $resultProductos->fetch_assoc()) {
            $row['cantidad'] = (int)$row['cantidad_productos']; // Convertir 'cantidad_productos' a entero y asignarlo a 'cantidad'
            unset($row['cantidad_productos']); // Eliminar la columna 'cantidad_productos' para evitar confusión
            $productos[] = $row;
        }

        $stmtProductos->close();
        $conexion->close();

        return ['pedido' => $pedido, 'productos' => $productos];
    }

    // Función para actualizar un pedido
    public static function actualizarPedido($idPedido, $precio_total_pedidos, $cantidad_productos) {
        $conexion = DataBase::connect();  // Conexión a la base de datos

        // Consulta para actualizar el pedido
        $sql = "UPDATE PEDIDO SET precio_total_pedidos = ?, cantidad_productos = ? WHERE id = ?";
        $stmt = $conexion->prepare($sql);
        
        // Ajustar el tipo de los parámetros: d para decimal, i para integer
        $stmt->bind_param("dii", $precio_total_pedidos, $cantidad_productos, $idPedido);
        
        // Ejecutar la consulta
        $stmt->execute();
        $affectedRows = $stmt->affected_rows;  // Capturar las filas afectadas

        // Cerrar la declaración y la conexión
        $stmt->close();
        $conexion->close();

        // Devuelve true si al menos una fila fue actualizada
        return $affectedRows > 0;
    }

    // Función para añadir las líneas del pedido
    public static function actualizarLineaPedido($idPedido, $idProducto, $cantidadProductos, $precioProductos) {
        $conexion = DataBase::connect();

        // Inserta una nueva línea de pedido
        $sql = "INSERT INTO LINEA_PEDIDO (numero_pedido, id_producto, cantidad_productos, precio_productos) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("iidi", $idPedido, $idProducto, $cantidadProductos, $precioProductos);
        $stmt->execute();
        $stmt->close();

        $conexion->close();
        return true;  // Siempre retorna true si el proceso fue exitoso (insertar)
    }

    //para la limpieza a la hora de modificar
    public static function eliminarLineasPedido($idPedido) {
        $conexion = DataBase::connect();
    
        // Eliminar todas las líneas de productos asociadas al pedido
        $sqlEliminar = "DELETE FROM LINEA_PEDIDO WHERE numero_pedido = ?";
        $stmtEliminar = $conexion->prepare($sqlEliminar);
        $stmtEliminar->bind_param("i", $idPedido);
        $stmtEliminar->execute();
        $stmtEliminar->close();
    
        $conexion->close();
        return true; // Retorna true si el proceso fue exitoso
    }
}
?>