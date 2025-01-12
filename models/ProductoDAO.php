<?php

include_once("config/dataBase.php");
include_once("models/Producto.php");


class ProductoDAO{
    public static function getRecomendados() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO LIMIT 4");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $recomendados = [];
        while ($row = $result->fetch_object('Producto')) {
            $recomendados[] = $row;
        }
        
        $con->close();
        return $recomendados;
    }    

    public static function getSeccionCategorias() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM CATEGORIA LIMIT 5;");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $categorias=[];
        while($producto = $result->fetch_object("Producto")){
            $categorias[] = $producto;
        }
        
        $con->close();
        return $categorias;
    }

    public static function getSeccionBebidas() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 4 LIMIT 4;");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $postres=[];
        while($producto = $result->fetch_object("Producto")){
            $postres[] = $producto;
        }
        
        $con->close();
        return $postres;
    }

    public static function getCategoria($id_categoria) {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT id, nombre, descripcion, url_imagen FROM CATEGORIA WHERE id = ?");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $categoria = $result->fetch_assoc();
        $con->close();
    
        return $categoria;
    }

    public static function getCategoriaByProductoId($id_producto) {
        // Conectar a la base de datos
        $con = DataBase::connect();
        
        // Consulta para obtener la categoría del producto mediante el id del producto
        $stmt = $con->prepare("
            SELECT c.id, c.nombre
            FROM CATEGORIA c
            INNER JOIN PRODUCTO p ON c.id = p.id_categoria
            WHERE p.id = ?
        ");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();
        $categoria = $result->fetch_assoc();
        
        // Cerrar la conexión
        $stmt->close();
        $con->close();
        
        // Retornar la categoría
        return $categoria;
    }
    

    public static function getTiposPorCategoria($id_categoria) {
        $con = DataBase::connect();
        $stmt = $con->prepare("
            SELECT id, nombre 
            FROM TIPO
            WHERE id_categoria = ?
        ");
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $tipos = [];
        while ($tipo = $result->fetch_assoc()) {
            $tipos[] = $tipo;
        }
    
        $stmt->close();
        $con->close();
        return $tipos;
    }

    public static function getProductos($id_categoria, $orden = null) {
        // Conectar a la base de datos
        $con = DataBase::connect();
    
        // Consulta base con INNER JOIN
        $query = "
            SELECT p.id, p.nombre, p.precio, p.descripcion, p.url_imagen, c.nombre AS nombre_categoria
            FROM PRODUCTO p
            INNER JOIN CATEGORIA c ON p.id_categoria = c.id
            WHERE c.id = ?
        ";
    
        // Agregar ordenación según el parámetro $orden
        if ($orden === 'asc') {
            $query .= " ORDER BY p.precio ASC";
        } elseif ($orden === 'desc') {
            $query .= " ORDER BY p.precio DESC";
        }
    
        // Preparar la consulta
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id_categoria);
        $stmt->execute();
    
        // Obtener los resultados
        $result = $stmt->get_result();
    
        // Crear un array para almacenar los productos
        $productos = [];
        while ($producto = $result->fetch_object("Producto")) {
            $productos[] = $producto;
        }
    
        // Cerrar la conexión
        $stmt->close();
        $con->close();
    
        // Retornar la lista de productos
        return $productos;
    }    

    public static function getDescuentos() {
        // Suponiendo que tienes una tabla 'descuentos' en la base de datos
        $con = DataBase::connect();
        $query = "SELECT * FROM DESCUENTOS";
        $result = $con->query($query);
        
        $descuentos = [];
        
        while ($row = $result->fetch_assoc()) {
            $descuentos[] = $row;
        }
        
        return $descuentos;
    }

    //funcion que busque losp productos por id ponerla aqui
    public static function getProductoById($id_producto) {
        // Conectar a la base de datos
        $con = DataBase::connect();
        
        // Preparar la consulta SQL
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        
        // Obtener el resultado
        $result = $stmt->get_result();
        $producto = $result->fetch_object("Producto");
        
        // Cerrar la conexión
        $stmt->close();
        $con->close();
        
        // Retornar el producto
        return $producto;
    }
    
    public static function getAllProductos() {
        // Conectar a la base de datos
        $con = DataBase::connect();
        
        // Consulta para obtener todos los productos
        $stmt = $con->prepare("SELECT * FROM PRODUCTO");
        $stmt->execute();
        
        // Obtener los resultados
        $result = $stmt->get_result();
        
        // Crear un array para almacenar los productos
        $productos = [];
        while ($producto = $result->fetch_assoc()) {  // Usamos fetch_assoc para devolver un array
            $productos[] = $producto;
        }
        
        // Cerrar la conexión
        $stmt->close();
        $con->close();
        
        // Retornar la lista de productos
        return $productos;
    }  
    
    // Eliminar un producto por ID
    public static function eliminarProducto($id) {
        $db = DataBase::connect();
        $stmt = $db->prepare("DELETE FROM PRODUCTO WHERE id = ?");
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta y devolver true si se eliminó al menos una fila
        $result = $stmt->execute();
        $stmt->close();
        $db->close();

        return $result;  // Devuelve true si se eliminó un producto, false si no
    }

    // Insertar un producto
    public static function insertarProducto($nombre, $precio, $descripcion, $url_imagen, $id_categoria) {
        $con = DataBase::connect();
        $stmt = $con->prepare("INSERT INTO PRODUCTO (nombre, descripcion, precio, url_imagen, id_categoria) VALUES (?, ?, ?, ?, ?)");
        
        // Vincular los parámetros directamente
        $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $url_imagen, $id_categoria);
        $result = $stmt->execute();
        
        // Cerrar conexión
        $stmt->close();
        $con->close();
        
        return $result;  // Devuelve true si la inserción fue exitosa
    }

    public static function actualizarProducto($id, $nombre, $descripcion, $precio, $id_categoria) {
        // Conectar a la base de datos
        $con = DataBase::connect();
    
        // Preparar la consulta SQL para actualizar el producto
        $stmt = $con->prepare("
            UPDATE PRODUCTO 
            SET nombre = ?, descripcion = ?, precio = ?, id_categoria = ?
            WHERE id = ?
        ");
        
        if (!$stmt) {
            error_log("Error al preparar la consulta: " . $con->error);
            return false;
        }
    
        // Vincular los parámetros con los tipos correctos
        $stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $id_categoria, $id);
        
        // Ejecutar la consulta
        $result = $stmt->execute();
        
        if (!$result) {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
        }
    
        // Cerrar la conexión
        $stmt->close();
        $con->close();
    
        // Retornar el resultado de la operación
        return $result; // true si la actualización fue exitosa, false si no
    }    
}

?>