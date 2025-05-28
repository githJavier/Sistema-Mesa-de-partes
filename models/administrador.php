<?php
require_once __DIR__ . '/../utils/log_config.php';
include_once("../../config/conexion.php");

class Administrador{

    public function existeUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT 1 FROM usuario WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        $existe = $stmt->num_rows > 0;

        $stmt->close();
        Conexion::desconectarBD();

        return $existe;
    }

    public function fueEliminadoUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT estado FROM usuario WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $estado = null;
        $stmt->bind_result($estado);

        $eliminado = false;
        if ($stmt->fetch()) {
            if ($estado == '2') {
                $eliminado = true;
            }
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $eliminado;
    }
    
    public function fueInactivadoUsuario($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT estado FROM usuario WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $estado = null;
        $stmt->bind_result($estado);

        $inactivado = false;
        if ($stmt->fetch()) {
            if ($estado == '0') {
                $inactivado = true;
            }
        }

        $stmt->close();
        Conexion::desconectarBD();

        return $inactivado;
    }

    public function estaActivo($usuario) {
        $conexion = Conexion::conectarBD();
        if (!$conexion) return false;

        $sql = 'SELECT 1 FROM usuario WHERE usuario = ? AND estado = 1 LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        $activo = $stmt->num_rows > 0;

        $stmt->close();
        Conexion::desconectarBD();

        return $activo;
    }

    
    public function verificarContrasena($usuario, $contrasenaIngresada) {        
        $resultado = false;

        $conexion = Conexion::conectarBD();
        if (!$conexion) {
            //error_log("[ERROR] Fallo al conectar a la BD.");
            return $resultado;
        }

        $sql = 'SELECT clave FROM usuario WHERE usuario = ? LIMIT 1;';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            //error_log("[ERROR] Fallo al preparar la consulta.");
            return $resultado;
        }

        $stmt->bind_param("s", $usuario);
        if (!$stmt->execute()) {
            //error_log("[ERROR] Fallo al ejecutar la consulta.");
            return $resultado;
        }

        $hashedPassword = null;
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        $stmt->close();
        Conexion::desconectarBD();

        if ($hashedPassword === null) {
            //error_log("[INFO] Usuario no encontrado o clave vacía.");
            return $resultado;
        }

        // Si estás usando md5, compara directamente
        $contrasenaIngresada = md5($contrasenaIngresada);

        if ($contrasenaIngresada === $hashedPassword) {
            $resultado = true;
        }

        return $resultado;
    }


    public function obtenerDatosUsuario($usuario, $clave) {
        $conexion = Conexion::conectarBD();

        $sql = 'SELECT u.usuario, u.clave, u.tipo_doc, u.num_doc, u.ap_paterno, u.ap_materno, u.nombre, u.tipo, a.area, u.estado
                FROM usuario u
                INNER JOIN area a ON u.cod_area = a.cod_area
                WHERE usuario = ?
                LIMIT 1';

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación: " . $conexion->error);
        }

        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $datosUsuario = null;

        if ($resultado && $resultado->num_rows > 0) {
            $dato = $resultado->fetch_assoc();

            $clave = md5($clave);
            if ($clave === $dato['clave']) {
                $datosUsuario = [
                    'usuario' => $dato['usuario'],
                    'tipo_doc' => $dato['tipo_doc'],
                    'num_doc' => $dato['num_doc'],
                    'nombre_completo' => $dato['nombre'].' '.$dato['ap_paterno'].' '.$dato['ap_materno'],
                    'tipo' => $dato['tipo'],
                    'area' => $dato['area'],
                    'estado' => $dato['estado']
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();
        return $datosUsuario;
    }


    public function listarUsuarios() {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT u.cod_usuario, u.usuario, u.tipo_doc, u.num_doc, u.ap_paterno, u.ap_materno, u.nombre, u.estado, u.tipo, a.area
                FROM usuario u
                INNER JOIN area a ON u.cod_area = a.cod_area
                WHERE u.estado IN (0, 1)";
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

    public function crearUsuario($tipo_doc, $num_doc, $nombre, $ap_paterno, $ap_materno, $tipo, $estado, $cod_area, $usuario, $clave) {
        $conexion = Conexion::conectarBD();
        $sql = 'INSERT INTO usuario (usuario, clave, tipo_doc, num_doc, ap_paterno, ap_materno, nombre, estado, tipo, cod_area)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            Conexion::desconectarBD();
            return false;
        }
        $stmt->bind_param("sssssssssi",$usuario, $clave, $tipo_doc, $num_doc, $ap_paterno, $ap_materno, $nombre, $estado, $tipo, $cod_area);
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
}