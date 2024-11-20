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

    public static function getHamburguesas() {
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

    public static function getMenus() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 6");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }

    public static function getCombos() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 7");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }

    public static function getPostres() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 8");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }

    public static function getPatatas() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 9");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }

    public static function getBebidas() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 4");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }

    public static function getInfantiles() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 11");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }

    public static function getOfertas() {
        $con = DataBase::connect();
        $stmt = $con->prepare("SELECT * FROM PRODUCTO WHERE id_categoria = 12");
        
        $stmt->execute();
        $result = $stmt->get_result();
            
        $menus=[];
        while($producto = $result->fetch_object("Producto")){
            $menus[] = $producto;
        }
        
        $con->close();
        return $menus;
    }
}

?>