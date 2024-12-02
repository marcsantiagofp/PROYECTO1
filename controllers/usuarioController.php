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
    // Acción para mostrar el formulario combinado de login y registro
    public function mostrarFormulario() {
        include_once 'views/inicioSession.php'; // Vista única con login y registro
    }
    
    // Acción para iniciar sesión
    public function iniciarSesion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            $usuario = UsuarioDAO::getUsuarioByEmail($email);

            if ($usuario && password_verify($contraseña, $usuario->getContraseña())) {
                // Almacena información del usuario en la sesión
                $_SESSION['usuario'] = [
                    'id' => $usuario->getId(),
                    'nombre' => $usuario->getNombre(),
                    'rol' => $usuario->getRol(),
                ];
                header("Location: ?controller=producto&action=mostrarProductos"); // Redirige a la página principal
                exit();
            } else {
                // Credenciales incorrectas
                header("Location: ?controller=usuario&action=mostrarFormulario&error=credenciales_invalidas");
                exit();
            }
        }
    }

    // Acción para cerrar sesión
    public function cerrarSesion() {
        session_unset(); // Limpia las variables de sesión
        session_destroy(); // Destruye la sesión
        header("Location: ?controller=usuario&action=mostrarFormulario");
        exit();
    }

    // Acción para registrar un nuevo usuario
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
            $direccion = $_POST['direccion'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $metodo_pago = $_POST['metodo_pago'] ?? null;

            $usuario = new Usuario();
            $usuario->setNombre($nombre)
                    ->setEmail($email)
                    ->setContraseña($contraseña)
                    ->setDireccion($direccion)
                    ->setTelefono($telefono)
                    ->setMetodoPago($metodo_pago)
                    ->setRol('usuario'); // Rol predeterminado

            if (UsuarioDAO::insertUsuario($usuario)) {
                header("Location: ?controller=usuario&action=mostrarFormulario&success=usuario_creado");
                exit();
            } else {
                header("Location: ?controller=usuario&action=mostrarFormulario&error=usuario_no_creado");
                exit();
            }
        }
    }
}
?>