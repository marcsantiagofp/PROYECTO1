<?php

// Incluir archivos necesarios


class ApiController {

    // Acción para mostrar el panel
    public function panel() {
        // $view = 'views/panelAdmin.php';
        // include_once 'views/main.php';
        include_once 'views/panelAdmin.php';
    }

    // Acción para obtener los pedidos usando la función getAllPedidos de PedidosDAO
    public function obtenerPedidos() {

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        include_once 'models/PedidosDAO.php';

        try {
            // Llamar a la función getAllPedidos para obtener todos los pedidos
            $pedidos = PedidosDAO::getAllPedidos();

            // Verificar si se obtuvieron resultados
            if (!empty($pedidos)) {
                // Asegurarse de que los datos se conviertan en JSON
                echo json_encode($pedidos, JSON_PRETTY_PRINT);  // Usamos JSON_PRETTY_PRINT para mejor legibilidad
            } else {
                // Responder con un mensaje si no hay pedidos
                echo json_encode(["mensaje" => "No hay pedidos disponibles"]);
            }
        } catch (Exception $e) {
            // Manejo de errores en caso de excepciones
            echo json_encode(["error" => "Ocurrió un error al obtener los pedidos: " . $e->getMessage()]);
        }
    }
}