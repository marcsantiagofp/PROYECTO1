<?php
include_once 'config/dataBase.php';
include_once 'models/Usuario.php';

class UsuarioDAO{

    // Obtener usuario por email
    public static function getUsuarioByEmail($email) {
        $db = DataBase::connect();
        $stmt = $db->prepare("SELECT * FROM USUARIO WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($row = $result->fetch_assoc()) {
            // Crear un objeto Usuario con los datos de la base de datos
            $usuario = new Usuario();
            $usuario->setId($row['id'])
                    ->setNombre($row['nombre'])
                    ->setEmail($row['email'])
                    ->setContraseña($row['contraseña'])
                    ->setTelefono($row['telefono'])
                    ->setDireccion($row['direccion'])
                    ->setMetodoPago($row['metodo_pago'])
                    ->setRol($row['rol']);
            return $usuario;  // Devuelve el objeto Usuario
        }
        return null;  // Si no se encuentra el usuario
    }

    // Obtener usuario por ID
    public static function getUsuarioById($id) {
        $db = DataBase::connect();
        $stmt = $db->prepare("SELECT * FROM USUARIO WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $usuario = new Usuario();
            $usuario->setId($row['id'])
                    ->setNombre($row['nombre'])
                    ->setEmail($row['email'])
                    ->setContraseña($row['contraseña'])
                    ->setTelefono($row['telefono'])
                    ->setDireccion($row['direccion'])
                    ->setMetodoPago($row['metodo_pago'])
                    ->setRol($row['rol']);
            return $usuario;
        }
        return null; // Si no se encuentra el usuario
    }

    // Insertar nuevo usuario
    public static function insertUsuario($usuario) {
        $db = DataBase::connect();
        $stmt = $db->prepare("INSERT INTO USUARIO (nombre, email, contraseña, direccion, telefono, metodo_pago, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $nombre = $usuario->getNombre();
        $email = $usuario->getEmail();
        $contraseña = $usuario->getContraseña();
        $direccion = $usuario->getDireccion();
        $telefono = $usuario->getTelefono();
        $metodo_pago = $usuario->getMetodoPago();
        $rol = $usuario->getRol();
    
        $stmt->bind_param("sssssss", $nombre, $email, $contraseña, $direccion, $telefono, $metodo_pago, $rol);
    
        return $stmt->execute();
    }

    public static function obtenerRolPorId($usuario_id) {
        $db = DataBase::connect();
        $stmt = $db->prepare("SELECT rol FROM USUARIO WHERE id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['rol'];  // Retorna el rol del usuario
        }
        return null;  // Si no se encuentra el usuario
    }
}
?>