<?php 
include_once("../../config/conexion.php");

class Usuario
{
    public function validarUsuario($usuario, $tipoPersona)
    {
        $conexion = Conexion::conectarBD();
        $sql = 'SELECT COUNT(*) 
                FROM remitente 
                WHERE docu_num = ? AND retipo_docu = ?;';
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ss", $usuario, $tipoPersona);
        $stmt->execute();
        $count = 0;
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        return $count > 0;
    }

    public function verificarContrasena($usuario, $clave) {
        $conexion = Conexion::conectarBD();
    
        if (!$conexion) {
            return false; // No hacer echo aquí para evitar salida doble
        }
    
        $sql = 'SELECT clave FROM remitente WHERE docu_num = ? LIMIT 1';
        $stmt = $conexion->prepare($sql);
    
        if (!$stmt) {
            return false;
        }
    
        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) {
            return false;
        }
    
        $hashedPassword = null;
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
    
        if ($hashedPassword === null) {
            return false;
        }
    
        return password_verify($clave, $hashedPassword); // Retorna true o false sin hacer echo
    }

    public function obtenerDatosRemitente($usuario, $clave) {
        $conexion = Conexion::conectarBD();
        $sql = 'SELECT tipo_remitente, retipo_docu, nombres, clave 
                FROM remitente 
                WHERE docu_num = ? LIMIT 1';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación: " . $conexion->error);
        }
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datoRemitente = null;
        if ($resultado && $resultado->num_rows > 0) {
            $dato = $resultado->fetch_assoc();
            if (password_verify($clave, $dato['clave'])) {
                $datoRemitente = [
                    'retipo_docu' => $dato['retipo_docu'],
                    'nombres' => $dato['nombres'],
                    'tipo_remitente' => $dato['tipo_remitente']
                ];
            }
        }
        $stmt->close();
        Conexion::desconectarBD();
        return $datoRemitente;
    }
    public function obtenerDatosRemitenteForm($usuario) {
        $conexion = Conexion::conectarBD();
        $sql = 'SELECT tipo_remitente, retipo_docu, docu_num, nombres, direccion, departamento, provincia, distrito, telefono_celular, correo
                FROM remitente 
                WHERE docu_num = ? LIMIT 1';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación: " . $conexion->error);
        }
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $datoRemitente = null;
        if ($resultado && $resultado->num_rows > 0) {
            $dato = $resultado->fetch_assoc();
            $datoRemitente = [
                'tipo_remitente' => $dato['tipo_remitente'],
                'retipo_docu' => $dato['retipo_docu'],
                'docu_num' => $dato['docu_num'],
                'nombres' => $dato['nombres'],
                'direccion' => $dato['direccion'],
                'departamento' => $dato['departamento'],
                'provincia' => $dato['provincia'],
                'distrito' => $dato['distrito'],
                'telefono_celular' => $dato['telefono_celular'],
                'correo' => $dato['correo']
            ];
        }
        $stmt->close();
        Conexion::desconectarBD();
        return $datoRemitente;
    }
    
    
    

    public function crearUsuario($tipoUsuario, $tipoDocumento, $numeroDocumento, $nombres, $telefono, $email, $clave) {
        $conexion = Conexion::conectarBD();
        $sql = 'INSERT INTO remitente (tipo_remitente, retipo_docu, docu_num, nombres, telefono_celular, correo, clave)
                VALUES (?, ?, ?, ?, ?, ?, ?);';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return false;
        }
        $stmt->bind_param("sssssss", $tipoUsuario, $tipoDocumento, $numeroDocumento, $nombres, $telefono, $email, $clave);
        if ($stmt->execute()) {
            $stmt->close();
            Conexion::desconectarBD();
            return true; 
        } else {
            $stmt->close();
            Conexion::desconectarBD();
            return false;
        }
    }

    public function consultarCorreo($documento) {
        $conexion = Conexion::conectarBD();
        $sql = 'SELECT correo 
                FROM remitente 
                WHERE docu_num = ?';
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param("s", $documento);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                $correo = $fila['correo'];
            } else {
                $correo = null;
            }
            $stmt->close();
        } else {
            $correo = null;
        }
        Conexion::desconectarBD();
        return $correo;
    }

    public function actualizarUbicacionUsuario($numeroDocumento, $departamento, $provincia, $distrito, $direccion, $telefono) {
        $conexion = Conexion::conectarBD();
        $sql = 'UPDATE remitente 
                SET departamento = ?, provincia = ?, distrito = ?, direccion = ?, telefono_celular = ?
                WHERE docu_num = ?';
    
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return false;
        }
    
        $stmt->bind_param("ssssss", $departamento, $provincia, $distrito, $direccion, $telefono, $numeroDocumento);
    
        if ($stmt->execute()) {
            $stmt->close();
            Conexion::desconectarBD();
            return true;
        } else {
            $stmt->close();
            Conexion::desconectarBD();
            return false;
        }
    }

    public function listarRemitentes() {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT idremite, tipo_remitente, retipo_docu, docu_num, nombres, direccion, departamento, provincia, distrito, telefono_fijo, telefono_celular, correo
                FROM remitente";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return false;
        }

        if ($stmt->execute()) {
            $resultado = $stmt->get_result(); // Obtener resultados
            $remitentes = [];

            while ($fila = $resultado->fetch_assoc()) {
                $remitentes[] = $fila;
            }
            $stmt->close();
            Conexion::desconectarBD();
            return $remitentes;
        } else {
            $stmt->close();
            Conexion::desconectarBD();
            return false;
        }
    }

    public function obtenerInformacionId($id) {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT retipo_docu, docu_num, nombres, correo, telefono_celular
                FROM remitente
                WHERE idremite = ?";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return false;
        }

        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            $remitente = $resultado->fetch_assoc();
            $stmt->close();
            Conexion::desconectarBD();
            return $remitente ? $remitente : false;
        } else {
            $stmt->close();
            Conexion::desconectarBD();
            return false;
        }
    }

    public function actualizarDatos($correo, $telefono_celular, $clave, $idremite) {
    $conexion = Conexion::conectarBD();

    $sql = "UPDATE remitente
            SET correo = ?, telefono_celular = ?, clave = ?
            WHERE idremite = ?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        Conexion::desconectarBD();
        return false;
    }
    $stmt->bind_param("sssi", $correo, $telefono_celular, $clave, $idremite);
    $resultado = $stmt->execute();
    $stmt->close();
    Conexion::desconectarBD();
    return $resultado;
}



    
    
    
}

