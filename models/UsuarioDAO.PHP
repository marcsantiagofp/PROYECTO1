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

    // Obtener todos los usuarios de la base de datos
    public static function getAllUsuarios() {
        $db = DataBase::connect();

        // Consulta para obtener todos los usuarios
        $sql = "SELECT * FROM USUARIO ORDER BY id ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        // Almacenar los usuarios en un arreglo
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }

        // Cerrar conexión
        $stmt->close();
        $db->close();

        return $usuarios;
    }

    // Eliminar un usuario por ID
    public static function eliminarUsuario($id) {
        $db = DataBase::connect();
        $stmt = $db->prepare("DELETE FROM USUARIO WHERE id = ?");
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta y devolver true si se eliminó al menos una fila
        $result = $stmt->execute();
        $stmt->close();
        $db->close();

        return $result;  // Devuelve true si se eliminó un usuario, false si no
    }
    
    // Insertar nuevo usuario
    public static function insertarUsuarioAdmin($nombre, $email, $contraseña, $direccion, $rol) {
        $db = DataBase::connect();
        $stmt = $db->prepare("INSERT INTO USUARIO (nombre, email, contraseña, direccion, rol) VALUES (?, ?, ?, ?, ?)");
        
        // Asignamos los parámetros directamente a la consulta preparada
        $stmt->bind_param("sssss", $nombre, $email, $contraseña, $direccion, $rol);
        
        // Ejecutar la consulta y devolver el resultado
        return $stmt->execute();
    }
}
?>