<?php
// Iniciar sesión solo si no está ya activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluimos los archivos necesarios
include_once 'models/Usuario.php';
include_once 'models/UsuarioDAO.php';
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
        // Verificar si se enviaron los datos desde el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $contraseñaIngresada = $_POST['contraseña'];
    
            // Buscar al usuario en la base de datos por su email
            $usuario = UsuarioDAO::getUsuarioByEmail($email);
    
            // Validar si el usuario existe
            if (!$usuario) {
                header("Location: ?controller=usuario&action=login&error=usuario_no_encontrado");
                exit;
            }
    
            // Verificar la contraseña
            // Acceder a la contraseña usando el método getContraseña() si $usuario es un objeto
            $contraseñaHash = $usuario->getContraseña(); // Usamos el getter de la clase Usuario
    
            if (!password_verify($contraseñaIngresada, $contraseñaHash)) {
                header("Location: ?controller=usuario&action=login&error=credenciales_invalidas");
                exit;
            }
    
            // Iniciar sesión si las credenciales son correctas
            // Guardamos el ID del usuario en la sesión
            $_SESSION['usuario_id'] = $usuario->getId();
    
            header("Location: ?controller=producto&action=home");
            exit;
        }
    
        // Si no es un POST, redirigir al formulario de inicio de sesión
        header("Location: ?controller=usuario&action=login");
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
        session_unset(); // Limpiar todas las variables de sesión
        session_destroy(); // Destruir la sesión
        header("Location: ?controller=usuario&action=mostrarFormulario"); // Redirigir al formulario de login
        exit;
    }
}
?>