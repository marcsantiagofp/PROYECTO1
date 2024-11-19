<?php

include_once("config/dataBase.php");
include_once("models/Producto.php");


class ProductoDAO{

    public static function getAll(){
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO;");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $productos=[];
        while($producto = $result->fetch_object("Producto")){
            $productos[] = $producto;
        }

        $con->close();
        return $productos;
    }

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

    public static function getCategorias() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM CATEGORIA;");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $categorias=[];
        while($producto = $result->fetch_object("Producto")){
            $categorias[] = $producto;
        }
        
        $con->close();
        return $categorias;
    }
}

?>