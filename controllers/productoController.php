<?php
include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';
include_once 'config/dataBase.php';

class productoController{
    public static function home() {
        $recomendados = ProductoDAO::getRecomendados();
        $categorias = ProductoDAO::getCategorias();
        $bebidas = ProductoDAO::getBebidas();
        $view = 'views/home.php';
        include_once 'views/main.php';
    }
}
?>