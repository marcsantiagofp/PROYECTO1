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
            // Obtener el orden de los parámetros GET
            $orden = $_GET['orden'] ?? null;
    
            // Llamar al DAO con el filtro de orden
            $pedidos = PedidosDAO::getAllPedidos($orden);
    
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
                        if (
                            !isset($data->id_cliente) || 
                            !isset($data->fecha_pedido) || 
                            !isset($data->precio_total_pedidos) || 
                            !isset($data->cantidad_productos) || 
                            !isset($data->productos)
                        ) {
                            echo json_encode(["error" => "Datos incompletos para el pedido"]);
                            exit; // Detener aquí si los datos son incompletos
                        }
                    
                        // Verificar si el cliente existe
                        $usuario = UsuarioDAO::getUsuarioById($data->id_cliente);  // Obtener el usuario por su ID
                        if (!$usuario) {
                            echo json_encode(["error" => "ID de cliente no válido, vuelva a confirmar pedido e introducir uno correcto"]);
                            exit;  // Detener si el cliente no existe
                        }else{
                            LogsController::crearLog('Pedido Añadido', 'Cliente ID: ' . $data->id_cliente . ' | Precio Total: ' . $data->precio_total_pedidos);
                        }
                    
                        // Iniciar una transacción
                        $conexion = DataBase::connect();
                        $conexion->begin_transaction();
                    
                        // Insertar el pedido en la base de datos
                        $idPedido = PedidosDAO::insertarPedido(
                            $data->fecha_pedido, 
                            $data->precio_total_pedidos,
                            $data->cantidad_productos,
                            $data->id_cliente
                        );
                    
                        if (!$idPedido) {
                            // Error al insertar el pedido
                            echo json_encode(["error" => "Error al insertar el pedido"]);
                            $conexion->rollback();
                            exit;
                        }
                    
                        // Insertar las líneas de pedido
                        foreach ($data->productos as $producto) {
                            if (!isset($producto->id) || !isset($producto->cantidad) || !isset($producto->precio)) {
                                echo json_encode(["error" => "Datos incompletos para el producto"]);
                                $conexion->rollback();
                                exit;
                            }
                    
                            PedidosDAO::insertarLineaPedido(
                                $producto->cantidad, 
                                $producto->precio * $producto->cantidad, 
                                $producto->id, 
                                null, // Descuento null
                                $idPedido
                            );
                        }
                    
                        // Confirmar la transacción
                        $conexion->commit();
                    
                        // Enviar la respuesta final de éxito
                        echo json_encode(["success" => true, "id_pedido" => $idPedido]);
                        exit; // Asegurarse de no continuar ejecutando código                    
                                                                                                                                                                       
                    
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
                        if ($resultado) {
                            // Crear log para el nuevo usuario
                            LogsController::crearLog('Usuario Añadido', 'Nombre: ' . $data->nombre . ' | Email: ' . $data->email);
                        }
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
                        if ($resultado) {
                            // Crear log para el nuevo producto
                            LogsController::crearLog('Producto Añadido', 'Nombre: ' . $data->nombre . ' | Precio: ' . $data->precio);
                        }
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
                        // Eliminar usuario
                        $resultado = UsuarioDAO::eliminarUsuario($id);
                        // Registrar el log de la eliminación del usuario
                        LogsController::crearLog('Usuario Eliminado', "Se ha eliminado el usuario con ID: " . $id);
                        break;

                    case 'producto':
                        // Eliminar producto
                        $resultado = ProductoDAO::eliminarProducto($id);
                        // Registrar el log de la eliminación del producto
                        LogsController::crearLog('Producto Eliminado', "Se ha eliminado el producto con ID: " . $id);
                        break;
                        
                    case 'pedido':
                        // Eliminar pedido
                        $resultado = PedidosDAO::eliminarPedido($id);
                        // Registrar el log de la eliminación del pedido
                        LogsController::crearLog('Pedido Eliminado', "Se ha eliminado el pedido con ID: " . $id);
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

    // Acción para actualizar un elemento (pedido, usuario o producto)
    public function actualizarElemento() {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // Obtener el tipo de elemento desde los parámetros GET
        $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
        $data = json_decode(file_get_contents("php://input"));

        if ($tipo && $data) {
            try {
                $resultado = false;

                // Comprobar el tipo de elemento y llamar al método de actualización correspondiente
                switch ($tipo) {
                    case 'pedido':
                        // Validar que los parámetros necesarios estén presentes
                        if (!isset($data->id_pedido) || !isset($data->precio_total_pedidos) || !isset($data->cantidad_productos) || !isset($data->productos)) {
                            echo json_encode(["error" => "Datos incompletos para el pedido."]);
                            return;
                        }
                    
                        // Verificar que la lista de productos no esté vacía
                        if (empty($data->productos)) {
                            echo json_encode(["error" => "El pedido no contiene productos."]);
                            return;
                        }
                    
                        // Validar que los datos numéricos son correctos
                        if (!is_numeric($data->precio_total_pedidos) || $data->precio_total_pedidos <= 0) {
                            echo json_encode(["error" => "El precio total del pedido es inválido."]);
                            return;
                        }
                        if (!is_numeric($data->cantidad_productos) || $data->cantidad_productos <= 0) {
                            echo json_encode(["error" => "La cantidad total de productos es inválida."]);
                            return;
                        }
                    
                        // Actualizar el pedido en la base de datos
                        $resultadoPedido = PedidosDAO::actualizarPedido(
                            $data->id_pedido,
                            $data->precio_total_pedidos,
                            $data->cantidad_productos,
                        );

                        // Eliminar todas las líneas de productos asociadas al pedido para limpiar
                        $eliminarLineas = PedidosDAO::eliminarLineasPedido($data->id_pedido);
                        if (!$eliminarLineas) {
                            echo json_encode(["error" => "Error al eliminar las líneas de productos del pedido."]);
                        }else{
                            LogsController::crearLog('Pedido Actualizado', 'ID Pedido: ' . $data->id_pedido . ' | Precio Total: ' . $data->precio_total_pedidos . ' | Cantidad Productos: ' . $data->cantidad_productos);
                        }
                    
                        // Procesar cada producto para actualizar o crear las líneas de pedido
                        foreach ($data->productos as $producto) {
                            // Validar que los datos del producto sean válidos
                            if (!isset($producto->id) || !isset($producto->cantidad) || !isset($producto->precio)) {
                                echo json_encode(["error" => "Datos incompletos para el producto en el pedido."]);
                                return;
                            }
                    
                            // Validar que los valores numéricos del producto sean correctos
                            if (!is_numeric($producto->cantidad) || $producto->cantidad <= 0) {
                                echo json_encode(["error" => "Cantidad inválida para el producto ID " . $producto->id]);
                                return;
                            }
                            if (!is_numeric($producto->precio) || $producto->precio <= 0) {
                                echo json_encode(["error" => "Precio inválido para el producto ID " . $producto->id]);
                                return;
                            }
                    
                            // Calcular el precio total de la línea de pedido
                            $precioTotalLinea = $producto->precio * $producto->cantidad;
                    
                            // Verificar que el precio total de la línea sea válido
                            if ($precioTotalLinea <= 0) {
                                echo json_encode(["error" => "Precio total inválido para el producto ID " . $producto->id]);
                                return;
                            }
                    
                            // Actualizar la línea de pedido en la base de datos
                            $resultadoLinea = PedidosDAO::actualizarLineaPedido(
                                $data->id_pedido,
                                $producto->id,
                                $producto->cantidad,
                                $precioTotalLinea
                            );
                    
                            if (!$resultadoLinea) {
                                echo json_encode(["error" => "Error al actualizar la línea de pedido para el producto ID " . $producto->id]);
                                return;
                            }       
                        }
                        break;                                                                                                           

                    case 'usuario':
                        if (!isset($data->id) || !isset($data->nombre) || !isset($data->email) || !isset($data->direccion) || !isset($data->contraseña) || !isset($data->rol)) {
                            echo json_encode(["error" => "Datos incompletos para el usuario"]);
                            return;
                        }

                        $contraseñaHash = password_hash($data->contraseña, PASSWORD_DEFAULT); // Encriptar la contraseña

                        $resultado = UsuarioDAO::actualizarUsuario(
                            $data->id,
                            $data->nombre,
                            $data->email,
                            $data->direccion,
                            $contraseñaHash,
                            $data->rol
                        );

                        if ($resultado) {
                            echo json_encode(["success" => true, "mensaje" => "Usuario actualizado exitosamente"]);
                            LogsController::crearLog('Usuario Actualizado', 'ID Usuario: ' . $data->id . ' | Nombre: ' . $data->nombre);
                        } else {
                            echo json_encode(["error" => "Error al actualizar el usuario"]);
                        }
                        break;

                        case 'producto':
                            // Validar que los parámetros necesarios estén presentes
                            if (!isset($data->id) || !isset($data->nombre) || !isset($data->precio) || !isset($data->descripcion) || !isset($data->id_categoria)) {
                                echo json_encode(["error" => "Datos incompletos para el producto"]);
                                return;
                            }
                        
                            // Validar que el precio sea un número positivo
                            if ($data->precio <= 0) {
                                echo json_encode(["error" => "El precio debe ser mayor que 0"]);
                                return;
                            }
                        
                            // Validar que el precio y la categoría sean del tipo correcto
                            if (!is_numeric($data->precio)) {
                                echo json_encode(["error" => "El precio debe ser un número válido"]);
                                return;
                            }
                        
                            if (!is_numeric($data->id_categoria)) {
                                echo json_encode(["error" => "La categoría debe ser un número válido"]);
                                return;
                            }
                        
                            // Llamada al método del DAO para actualizar el producto
                            $resultado = ProductoDAO::actualizarProducto(
                                $data->id,
                                $data->nombre,
                                $data->descripcion,
                                $data->precio,
                                $data->id_categoria
                            );
                        
                            // Verificar si la actualización fue exitosa
                            if ($resultado) {
                                echo json_encode(["success" => true, "mensaje" => "Producto actualizado exitosamente"]);
                                LogsController::crearLog('Producto Actualizado', 'ID Producto: ' . $data->id . ' | Nombre: ' . $data->nombre);
                            } else {
                                echo json_encode(["error" => "Error al actualizar el producto, intente nuevamente"]);
                            }
                            break;                                              

                    default:
                        echo json_encode(["error" => "Tipo no válido"]);
                        return;
                }

                // Si la actualización fue exitosa
                if ($resultado) {
                    echo json_encode(["success" => true]);
                } else {
                    echo json_encode(["error" => "Error al actualizar el " . $tipo]);
                }
            } catch (Exception $e) {
                echo json_encode(["error" => "Error al actualizar el " . $tipo . ": " . $e->getMessage()]);
            }
        } else {
            echo json_encode(["error" => "Faltan parámetros o datos"]);
        }
    }

    //Funcion para obterner el usuario por la id para actualizar con la informacion o ya actualizada
    public function obtenerUsuarioPorId() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Usamos el DAO para obtener el usuario
            $usuario = UsuarioDAO::getUsuarioById($id);
    
            if ($usuario) {
                // Retornar los datos del usuario en formato JSON
                echo json_encode([
                    'id' => $usuario->getId(),
                    'nombre' => $usuario->getNombre(),
                    'email' => $usuario->getEmail(),
                    'contraseña' => $usuario->getContraseña(),
                    'direccion' => $usuario->getDireccion(),
                    'rol' => $usuario->getRol(),
                ]);
            } else {
                // En caso de que no se encuentre el usuario
                echo json_encode(['error' => 'Usuario no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    // Función para obtener el producto por la ID
    public function obtenerProductoPorId() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Usamos el DAO para obtener el producto
            $producto = ProductoDAO::getProductoById($id);

            if ($producto) {
                // Retornar los datos del producto en formato JSON
                echo json_encode([
                    'id' => $producto->getId(),
                    'nombre' => $producto->getNombre(),
                    'precio' => $producto->getPrecio(),
                    'descripcion' => $producto->getDescripcion(),
                    'id_categoria' => $producto->getId_categoria(),
                ]);
            } else {
                // En caso de que no se encuentre el producto
                echo json_encode(['error' => 'Producto no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }

    // Función para obtener el pedido por la ID
    public function obtenerPedidoPorId() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Usamos el DAO para obtener el pedido
            $pedido = PedidosDAO::obtenerPedidoPorId($id);

            if ($pedido) {
                // Retornar los datos del pedido en formato JSON
                $respuesta = [
                    'id' => $pedido['pedido']['id'],
                    'id_cliente' => $pedido['pedido']['id_cliente'],
                    'fecha_pedido' => $pedido['pedido']['fecha_pedido'],
                    'precio_total_pedidos' => $pedido['pedido']['precio_total_pedidos'],
                    'cantidad_productos' => $pedido['pedido']['cantidad_productos'],
                    'productos' => $pedido['productos'] // Incluimos los productos
                ];

                echo json_encode($respuesta);
            } else {
                // En caso de que no se encuentre el pedido
                echo json_encode(['error' => 'Pedido no encontrado']);
            }
        } else {
            echo json_encode(['error' => 'ID no proporcionado']);
        }
    }
}
?>