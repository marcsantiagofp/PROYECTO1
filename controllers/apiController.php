<?php

include_once("config/dataBase.php");

class ApiController {

    public function panel() {
        // Aquí puedes cargar tu vista con datos
        $view = 'views/panelAdmin.php';
        include_once 'views/main.php';
    }

    // Obtener todos los usuarios
    public function getUsuarios() {
        $db = Database::connect();
        $query = "SELECT * FROM USUARIO";
        $result = $db->query($query);

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($usuarios);
        
        // Cerrar la conexión después de usarla
        $db->close();
    }

    // Crear un nuevo usuario
    public function createUsuario() {
        $db = Database::connect();
        $data = json_decode(file_get_contents('php://input'), true);

        $nombre = $data['nombre'];
        $email = $data['email'];
        $contraseña = password_hash($data['contraseña'], PASSWORD_BCRYPT);
        $direccion = $data['direccion'];
        $telefono = $data['telefono'];
        $metodo_pago = $data['metodo_pago'];
        $rol = $data['rol'];

        $query = $db->prepare("INSERT INTO USUARIO (nombre, email, contraseña, direccion, telefono, metodo_pago, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param('sssssss', $nombre, $email, $contraseña, $direccion, $telefono, $metodo_pago, $rol);

        if ($query->execute()) {
            echo json_encode(['id' => $db->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        // Cerrar la conexión
        $db->close();
    }

    // Editar un usuario existente
    public function updateUsuario($id) {
        $db = Database::connect();
        $data = json_decode(file_get_contents('php://input'), true);

        $query = $db->prepare("UPDATE USUARIO SET nombre = ?, email = ?, direccion = ?, telefono = ?, metodo_pago = ?, rol = ? WHERE id = ?");
        $query->bind_param('ssssssi', $data['nombre'], $data['email'], $data['direccion'], $data['telefono'], $data['metodo_pago'], $data['rol'], $id);

        if ($query->execute()) {
            echo json_encode(['mensaje' => 'Usuario actualizado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }

    // Eliminar un usuario
    public function deleteUsuario($id) {
        $db = Database::connect();
        $query = $db->prepare("DELETE FROM USUARIO WHERE id = ?");
        $query->bind_param('i', $id);

        if ($query->execute()) {
            echo json_encode(['mensaje' => 'Usuario eliminado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }

    // Obtener todos los productos
    public function getProductos() {
        $db = Database::connect();
        $query = "SELECT * FROM PRODUCTO";
        $result = $db->query($query);

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($productos);

        // Cerrar la conexión
        $db->close();
    }

    // Crear un nuevo producto
    public function createProducto() {
        $db = Database::connect();
        $data = json_decode(file_get_contents('php://input'), true);

        $nombre = $data['nombre'];
        $precio = $data['precio'];
        $descripcion = $data['descripcion'];
        $url_imagen = $data['url_imagen'];
        $id_oferta = $data['id_oferta'];
        $id_categoria = $data['id_categoria'];

        $query = $db->prepare("INSERT INTO PRODUCTO (nombre, precio, descripcion, url_imagen, id_oferta, id_categoria) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param('sdssii', $nombre, $precio, $descripcion, $url_imagen, $id_oferta, $id_categoria);

        if ($query->execute()) {
            echo json_encode(['id' => $db->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }

    // Editar un producto existente
    public function updateProducto($id) {
        $db = Database::connect();
        $data = json_decode(file_get_contents('php://input'), true);

        $query = $db->prepare("UPDATE PRODUCTO SET nombre = ?, precio = ?, descripcion = ?, url_imagen = ?, id_oferta = ?, id_categoria = ? WHERE id = ?");
        $query->bind_param('sdssiii', $data['nombre'], $data['precio'], $data['descripcion'], $data['url_imagen'], $data['id_oferta'], $data['id_categoria'], $id);

        if ($query->execute()) {
            echo json_encode(['mensaje' => 'Producto actualizado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }

    // Eliminar un producto
    public function deleteProducto($id) {
        $db = Database::connect();
        $query = $db->prepare("DELETE FROM PRODUCTO WHERE id = ?");
        $query->bind_param('i', $id);

        if ($query->execute()) {
            echo json_encode(['mensaje' => 'Producto eliminado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }

    // Obtener todos los pedidos
    public function getPedidos() {
        $db = Database::connect();
        $query = "SELECT * FROM PEDIDO";
        $result = $db->query($query);

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($pedidos);

        // Cerrar la conexión
        $db->close();
    }

    // Crear un nuevo pedido
    public function createPedido() {
        $db = Database::connect();
        $data = json_decode(file_get_contents('php://input'), true);

        $fecha_pedido = $data['fecha_pedido'];
        $precio_total_pedidos = $data['precio_total_pedidos'];
        $cantidad_productos = $data['cantidad_productos'];
        $id_cliente = $data['id_cliente'];

        $query = $db->prepare("INSERT INTO PEDIDO (fecha_pedido, precio_total_pedidos, cantidad_productos, id_cliente) VALUES (?, ?, ?, ?)");
        $query->bind_param('sdii', $fecha_pedido, $precio_total_pedidos, $cantidad_productos, $id_cliente);

        if ($query->execute()) {
            echo json_encode(['id' => $db->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }

    // Eliminar un pedido
    public function deletePedido($id) {
        $db = Database::connect();
        $query = $db->prepare("DELETE FROM PEDIDO WHERE id = ?");
        $query->bind_param('i', $id);

        if ($query->execute()) {
            echo json_encode(['mensaje' => 'Pedido eliminado correctamente']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => $db->error]);
        }

        $db->close();
    }
}

// Rutas API
$apiController = new ApiController();

$method = $_SERVER['REQUEST_METHOD'];
$resource = $_GET['resource'] ?? '';
$id = $_GET['id'] ?? null;

if ($resource === 'usuarios') {
    if ($method === 'GET') {
        $apiController->getUsuarios();
    } elseif ($method === 'POST') {
        $apiController->createUsuario();
    } elseif ($method === 'PUT' && $id) {
        $apiController->updateUsuario($id);
    } elseif ($method === 'DELETE' && $id) {
        $apiController->deleteUsuario($id);
    }
} elseif ($resource === 'productos') {
    if ($method === 'GET') {
        $apiController->getProductos();
    } elseif ($method === 'POST') {
        $apiController->createProducto();
    } elseif ($method === 'PUT' && $id) {
        $apiController->updateProducto($id);
    } elseif ($method === 'DELETE' && $id) {
        $apiController->deleteProducto($id);
    }
} elseif ($resource === 'pedidos') {
    if ($method === 'GET') {
        $apiController->getPedidos();
    } elseif ($method === 'POST') {
        $apiController->createPedido();
    } elseif ($method === 'DELETE' && $id) {
        $apiController->deletePedido($id);
    }
} else {
    //no hace nda
}
?>