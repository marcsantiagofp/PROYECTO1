<?php

// Incluir los archivos necesarios para las clases que vamos a usar
include_once 'models/PedidosDAO.php';
include_once 'models/UsuarioDAO.php';
include_once 'models/ProductoDAO.php';
include_once 'config/dataBase.php';
include_once 'models/Usuario.php';

class ApiController {

    // Acción para mostrar el panel
    public function panel() {
        include_once 'views/panelAdmin.php';
    }

    // PEDIDOS 
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

    // USUARIOS
    // Acción para obtener los usuarios
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

    // PRODUCTOS
    // Acción para obtener los productos
    public function obtenerProductos() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        try {
            $productos = ProductoDAO::getAllProductos();

            if (!empty($productos)) {
                echo json_encode($productos, JSON_PRETTY_PRINT);
            } else {
                echo json_encode(["mensaje" => "No hay productos disponibles"]);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => "Error al obtener productos: " . $e->getMessage()]);
        }
    }

    // GENERAL
    // Acción para agregar un elemento (pedido, usuario o producto)
    public function agregarElemento() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Obtener el tipo de elemento desde los parámetros GET
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $data = json_decode(file_get_contents("php://input"));

        if ($tipo && $data) {
            try {
                $resultado = false;

                // Comprobar el tipo de elemento y llamar al método de inserción correspondiente
                switch ($tipo) {
                    case 'pedido':
                        // Validar que todos los parámetros del pedido estén presentes
                        if (!isset($data->id_cliente) || !isset($data->fecha_pedido) || !isset($data->precio_total_pedidos) || !isset($data->cantidad_productos)) {
                            echo json_encode(["error" => "Datos incompletos para el pedido"]);
                            return;
                        }
                        // Insertar el pedido en la base de datos
                        $resultado = PedidosDAO::insertarPedido($data->id_cliente, $data->fecha_pedido, $data->precio_total_pedidos, $data->cantidad_productos);
                        break;

                    case 'usuario':
                        // Validar que todos los parámetros del usuario estén presentes
                        if (!isset($data->nombre) || !isset($data->email) || !isset($data->direccion) || !isset($data->rol) || !isset($data->contraseña)) {
                            echo json_encode(["error" => "Datos incompletos para el usuario"]);
                            return;
                        }
                        // Encriptar la contraseña antes de insertarla
                        $contraseñaHash = password_hash($data->contraseña, PASSWORD_DEFAULT);
                        // Insertar el usuario en la base de datos pasando los datos directamente
                        $resultado = UsuarioDAO::insertarUsuarioAdmin($data->nombre, $data->email, $contraseñaHash, $data->direccion, $data->rol);
                        break;

                    case 'producto':
                        // Validar que todos los parámetros del producto estén presentes
                        if (!isset($data->nombre) || !isset($data->precio) || !isset($data->descripcion) || !isset($data->id_categoria)) {
                            echo json_encode(["error" => "Datos incompletos para el producto"]);
                            return;
                        }
                    
                        // Si la URL de la imagen no está presente, asignar un valor por defecto
                        $url_imagen = isset($data->url_imagen) ? $data->url_imagen : 'default.webp';
                    
                        // Insertar el producto pasando los parámetros directamente
                        $resultado = ProductoDAO::insertarProducto($data->nombre, $data->precio, $data->descripcion, $url_imagen, $data->id_categoria);
                        break;

                    default:
                        echo json_encode(["error" => "Tipo no válido"]);
                        return;
                }

                // Si la inserción fue exitosa
                if ($resultado) {
                    echo json_encode(["success" => true]);
                } else {
                    echo json_encode(["error" => "Error al agregar el " . $tipo]);
                }
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al agregar el " . $tipo . ": " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan parámetros o datos"]);
        }
    }

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

                // Si la eliminación fue exitosa
                if ($resultado) {
                    echo json_encode(["success" => true]);
                } else {
                    echo json_encode(["error" => "No se pudo eliminar el " . $tipo]);
                }
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al eliminar el " . $tipo . ": " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan parámetros"]);
        }
    }
}
?>