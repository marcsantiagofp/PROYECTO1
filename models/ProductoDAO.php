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

    public static function getHamburgesas() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria IN (1, 2, 3)");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $hamburgesas=[];
        while($producto = $result->fetch_object("Producto")){
            $hamburgesas[] = $producto;
        }
        
        $con->close();
        return $hamburgesas;
    }
}

?>