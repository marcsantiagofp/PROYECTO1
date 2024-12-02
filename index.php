<?php
include_once("config/parameters.php");
include_once("controllers/productoController.php");
include_once("controllers/carritoController.php");
include_once("controllers/usuarioController.php");

if (!isset($_GET['controller'])) {
    header("Location:" . url_base . "?controller=producto");
    exit();
} else {
    $nombre_controller = $_GET['controller'] . "Controller";

    if (class_exists($nombre_controller)) {
        $controller = new $nombre_controller();

        // Asegúrate de que la acción esté definida y sea válida
        if (isset($_GET['action']) && method_exists($controller, $_GET['action'])) {
            $action = $_GET['action'];
        } else {
            // Si no se define la acción, usamos la acción por defecto
            $action = default_action;
        }

        // Llama a la acción en el controlador correspondiente
        $controller->$action();
    } else {
        // Si no existe el controlador, redirige al controlador por defecto
        header("Location:" . url_base . "?controller=producto");
        exit();
    }
}
?>