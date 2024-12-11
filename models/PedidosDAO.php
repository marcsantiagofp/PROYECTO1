<?php

include_once("config/dataBase.php");
include_once("models/Producto.php");
include_once("models/Usuario.php");

class PedidosDAO {

    // Función para obtener los pedidos de un usuario por ID, ordenados por fecha ascendente
    public static function obtenerPedidosPorUsuario($idUsuario) {
        $conexion = DataBase::connect(); // Conexión a la base de datos

        // Consulta para obtener los pedidos del usuario
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
                $productos[] = $producto; // Guardar cada producto en el array
            }

            // Si no hay productos, puedes dejar un mensaje (esto es opcional)
            if (empty($productos)) {
                error_log("No se encontraron productos para el pedido ID: " . $row['id']);
            }

            $pedido['productos'] = $productos; // Añadir los productos al pedido
            $pedidos[] = $pedido; // Añadir el pedido con productos a la lista
        }

        $stmt->close(); // Cerrar la declaración
        $conexion->close(); // Cerrar la conexión
        return $pedidos; // Retornar los pedidos
    }
}
?>