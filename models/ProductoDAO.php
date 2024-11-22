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
            
        $bebidas=[];
        while($producto = $result->fetch_object("Producto")){
            $bebidas[] = $producto;
        }
        
        $con->close();
        return $bebidas;
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
}

?>