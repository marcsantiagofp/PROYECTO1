<?php
include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';
include_once 'config/dataBase.php';

class productoController{
    public static function home() {
        $recomendados = ProductoDAO::getRecomendados();
        $categorias = ProductoDAO::getCategorias();
        $bebidas = ProductoDAO::getSeccionBebidas();
        $view = 'views/home.php';
        include_once 'views/main.php';
    }
    public static function hamburgesas() {
        $hamburgesas = ProductoDAO::getHamburgesas();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardHamburgesas.php';
        include_once 'views/main.php';
    }
}
?>