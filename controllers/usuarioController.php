<?php
// Iniciar sesión solo si no está ya activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluimos los archivos necesarios
include_once 'models/Usuario.php';
include_once 'models/UsuarioDAO.php';
include_once 'models/PedidosDAO.php';
include_once 'config/dataBase.php';

class UsuarioController {
    public function mostrarFormulario() {
        // Verificar si la sesión de usuario ya está iniciada
        if (isset($_SESSION['usuario_id'])) {
            // Si la sesión está iniciada, mostrar los datos del usuario
            $this->mostrarDatosUsuario();
        } else {
            // Si no está iniciada la sesión, mostrar el formulario de login y registro
            $this->mostrarFormularioLogin();
        }
    }
    
    private function mostrarDatosUsuario() {
        // Verificar si la sesión está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Verificar si el usuario está logueado
        if (isset($_SESSION['usuario_id'])) {
            // Obtener el ID del usuario desde la sesión
            $usuario = UsuarioDAO::getUsuarioById($_SESSION['usuario_id']);
        } else {
            // Si no está logueado, redirigir al formulario de login
            header("Location: ?controller=usuario&action=mostrarFormulario");
            exit;
        }
    
        // Aquí se carga la vista con los datos del usuario, pasando el objeto usuario
        $view = 'views/datosUsuario.php';
        include_once 'views/main.php'; // En la vista se usará la variable $usuario
    }    
    
    private function mostrarFormularioLogin() {
        // Aquí se carga el formulario de login y registro
        $view = 'views/inicioSession.php';
        include_once 'views/main.php';
    }

    // Acción para iniciar sesión
    public function iniciarSesion() {
        session_start(); // Asegúrate de que la sesión está iniciada
        $errores = [];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $contraseñaIngresada = $_POST['contraseña'];
    
            $usuario = UsuarioDAO::getUsuarioByEmail($email);
    
            if (!$usuario) {
                $_SESSION['error'] = 'usuario_no_encontrado'; // Almacena el error en la sesión
            } else {
                $contraseñaHash = $usuario->getContraseña();
    
                if (!password_verify($contraseñaIngresada, $contraseñaHash)) {
                    $_SESSION['error'] = 'credenciales_invalidas';
                }
            }
    
            if (!isset($_SESSION['error'])) {
                $_SESSION['usuario_id'] = $usuario->getId();
                header("Location: ?controller=producto&action=home");
                exit;
            }
        }
    
        header("Location: ?controller=usuario&action=mostrarFormulario");
        exit;
    }
    

    // Acción para registrar un nuevo usuario
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $contraseña = isset($_POST['contraseña']) ? password_hash($_POST['contraseña'], PASSWORD_DEFAULT) : '';
            $direccion = $_POST['direccion'] ?? '';
            $telefono = $_POST['telefono'] ?? '';

            // Crear y configurar un nuevo usuario
            $usuario = new Usuario();
            $usuario->setNombre($nombre)
                    ->setEmail($email)
                    ->setContraseña($contraseña)
                    ->setDireccion($direccion)
                    ->setTelefono($telefono)
                    ->setRol('usuario'); // Rol predeterminado

            // Intentar registrar el usuario
            if (UsuarioDAO::insertUsuario($usuario)) {
                header("Location: ?controller=usuario&action=mostrarFormulario&success=usuario_creado");
                exit();
            } else {
                header("Location: ?controller=usuario&action=mostrarFormulario&error=usuario_no_creado");
                exit();
            }
        } else {
            header("Location: ?controller=usuario&action=mostrarFormulario");
            exit();
        }
    }

    // Acción para cerrar sesión
    public function cerrarSesion() {
        session_start(); // Iniciar sesión si no está iniciada

        // Eliminar solo la sesión del usuario
        if (isset($_SESSION['usuario_id'])) {
            unset($_SESSION['usuario_id']); // Eliminar la variable de sesión específica
        }

        // Redirigir al formulario de login
        header("Location: ?controller=producto&action=home");
        exit;
    }

    public function mostrarHistorialPedidos() {
        // Obtener el ID del usuario desde la sesión
        $id_usuario = $_SESSION['usuario_id'];
        
        // Obtener los pedidos del usuario desde el PedidosDAO
        include_once 'models/PedidosDAO.php'; 
        $pedidos = PedidosDAO::obtenerPedidosPorUsuario($id_usuario);
        
        // Pasar los pedidos a la vista
        $view = 'views/historialPedidos.php';
        include_once 'views/main.php'; // En la vista se usará la variable $pedidos
    }   
    
    public function mostrarDetallesPedido() {
        if (isset($_GET['id'])) {
            $idPedido = $_GET['id'];
    
            // Llamar al método en el DAO para obtener los detalles del pedido y productos
            $detalles = PedidosDAO::obtenerDetallesPedido($idPedido);
    
            // Pasar los detalles del pedido y los productos a la vista
            $pedido = $detalles['pedido'];
            $productos = $detalles['productos'];
    
            $view = 'views/detallesPedido.php';
            include_once 'views/main.php';
        } else {
            // Redirigir o mostrar un error si no hay un id en la URL
            echo "Pedido no encontrado.";
        }
    }    
}
?>