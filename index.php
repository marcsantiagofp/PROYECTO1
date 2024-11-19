<?php
include_once("config/parameters.php");
include_once("controllers/productoController.php");



if (!isset($_GET['controller'])){
    header("Location:" . url_base . "?controller=producto");
}else{
    $nombre_controller = $_GET['controller']."Controller";

    if(class_exists($nombre_controller)){
        $controller = new $nombre_controller();

        if(isset($_GET['action']) && method_exists($controller, $_GET['action'])){
            $action = $_GET['action'];
        }else{
            $action = default_action;
        }

        $controller->$action();

    }else{
        header("Location:" . url_base . "?controller=producto");
    }
}
?>