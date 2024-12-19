<?php

// Incluir archivos necesarios
include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';
include_once 'models/Usuario.php';
include_once 'models/UsuarioDAO.php';
include_once 'models/PedidosDAO.php';
include_once 'config/dataBase.php';

class ApiController {

    // Acción para mostrar el panel
    public function panel() {
        $view = 'views/panelAdmin.php';
        include_once 'views/main.php';
    }

    // Acción para obtener los pedidos usando la función getAllPedidos de PedidosDAO
    public function obtenerPedidos() {
        try {
            // Llamar a la función getAllPedidos para obtener todos los pedidos
            $pedidos = PedidosDAO::getAllPedidos();

            // Verificar si se obtuvieron resultados
            if (!empty($pedidos)) {
                // Devolver los pedidos en formato JSON
                echo json_encode($pedidos);
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