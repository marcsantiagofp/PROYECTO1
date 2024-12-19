<?php

// Incluir archivos
include_once 'models/Producto.php';
include_once 'models/ProductoDAO.php';
include_once 'models/Usuario.php';
include_once 'models/UsuarioDAO.php';
include_once 'config/dataBase.php';

class ApiController {

    // Acción para mostrar el panel
    public function panel() {
        $view = 'views/panelAdmin.php';
        include_once 'views/main.php';
    }

    // Acción para obtener los pedidos
    public function obtenerPedidos() {
        // Conectar a la base de datos
        $con = DataBase::connect();

        // Consultar pedidos
        $query = "SELECT * FROM PEDIDO";
        $result = $con->query($query);
        
        if ($result) {
            $pedidos = [];
            while ($row = $result->fetch_assoc()) {
                $pedidos[] = $row;
            }

            // Devolver los pedidos en formato JSON
            echo json_encode($pedidos);
        } else {
            // Manejo de errores si no se pueden obtener los pedidos
            echo json_encode(["error" => "No se pudieron obtener los pedidos"]);
        }
    }
}