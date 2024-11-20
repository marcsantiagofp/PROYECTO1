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
    public static function hamburguesas() {
        $hamburgesas = ProductoDAO::getHamburguesas();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function menus() {
        $hamburgesas = ProductoDAO::getMenus();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function combos() {
        $hamburgesas = ProductoDAO::getCombos();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function postres() {
        $hamburgesas = ProductoDAO::getPostres();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function patatas() {
        $hamburgesas = ProductoDAO::getPatatas();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function bebidas() {
        $hamburgesas = ProductoDAO::getBebidas();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function infantiles() {
        $hamburgesas = ProductoDAO::getInfantiles();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
    public static function ofertas() {
        $hamburgesas = ProductoDAO::getOfertas();
        $view = 'views/productos.php';
        $paginaMostrar='assets/cardProductos.php';
        include_once 'views/main.php';
    }
}
?>