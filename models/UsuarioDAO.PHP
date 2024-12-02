<?php
include_once 'config/dataBase.php';
include_once 'models/Usuario.php';

class UsuarioDAO {

    // Obtener usuario por email
    public static function getUsuarioByEmail($email) {
        $db = DataBase::connect();
        $stmt = $db->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $usuario = new Usuario();
            $usuario->setId($row['id'])
                    ->setNombre($row['nombre'])
                    ->setEmail($row['email'])
                    ->setContraseña($row['contraseña']);
            return $usuario;
        }
        return null;
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
    
}