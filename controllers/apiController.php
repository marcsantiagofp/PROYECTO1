<?php

// Incluir los archivos necesarios para las clases que vamos a usar
include_once 'models/PedidosDAO.php';
include_once 'models/UsuarioDAO.php';
include_once 'models/ProductoDAO.php';

class ApiController {

    // Acción para mostrar el panel
    public function panel() {
        include_once 'views/panelAdmin.php';
    }

    //PEDIDOS 
        // Acción para obtener los pedidos
        public function obtenerPedidos() {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            try {
                $pedidos = PedidosDAO::getAllPedidos();

                if (!empty($pedidos)) {
                    echo json_encode($pedidos, JSON_PRETTY_PRINT);
                } else {
                    echo json_encode(["mensaje" => "No hay pedidos disponibles"]);
                }
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al obtener pedidos: " . $e->getMessage()]);
            }
        }

    //USUARIOS
        // Acción para obtener usuarios
        public function obtenerUsuarios() {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            try {
                $usuarios = UsuarioDAO::getAllUsuarios();

                if (!empty($usuarios)) {
                    echo json_encode($usuarios, JSON_PRETTY_PRINT);
                } else {
                    echo json_encode(["mensaje" => "No hay usuarios disponibles"]);
                }
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al obtener usuarios: " . $e->getMessage()]);
            }
        }

    //PRODUCTOS
        // Acción para obtener productos
        public function obtenerProductos() {
            header("Access-Control-Allow-Origin: *");
            header("Content-Type: application/json; charset=UTF-8");

            try {
                $productos = ProductoDAO::getAllProductos();  // Aquí debes revisar qué datos estás obteniendo

                if (!empty($productos)) {
                    echo json_encode($productos, JSON_PRETTY_PRINT);
                } else {
                    echo json_encode(["mensaje" => "No hay productos disponibles"]);
                }
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al obtener productos: " . $e->getMessage()]);
            }
        }    

    //GENERAL
    // Acción para eliminar un elemento (pedido, usuario o producto)
    public function eliminarElemento() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
    
        // Obtener el tipo de elemento y el ID desde los parámetros GET
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $id = isset($_GET['id']) ? $_GET['id'] : null;
    
        if ($tipo && $id) {
            try {
                $resultado = false;
    
                // Comprobar el tipo de elemento y llamar a la función correspondiente
                switch ($tipo) {
                    case 'usuario':
                        $resultado = UsuarioDAO::eliminarUsuario($id);
                        break;
                    case 'producto':
                        $resultado = ProductoDAO::eliminarProducto($id);
                        break;
                    case 'pedido':
                        $resultado = PedidosDAO::eliminarPedido($id);
                        break;
                    default:
                        echo json_encode(["error" => "Tipo no válido"]);
                        return;
                }
    
                // Si la eliminación fue exitosa, no retornamos mensaje alguno
                if ($resultado) {
                    echo json_encode(["success" => true]); // Respuesta exitosa
                } else {
                    echo json_encode(["error" => "No se pudo eliminar el " . $tipo]); // Error en la eliminación
                }
            } catch (Exception $e) {
                // En caso de error en el servidor, responder con un mensaje detallado
                echo json_encode(["error" => "Error al eliminar el " . $tipo . ": " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan parámetros"]); // Faltan parámetros en la solicitud
        }
    }    
}
?>