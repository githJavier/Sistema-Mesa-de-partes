<?php 
include_once("../../config/conexion.php");
class Administrador{
    public function listarUsuarios() {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT u.cod_usuario, u.usuario, u.tipo_doc, u.num_doc, u.ap_paterno, u.ap_materno, u.nombre, u.estado, u.tipo, a.area
                FROM usuario u
                INNER JOIN area a ON u.cod_area = a.cod_area;";
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

    public function crearUsuario($usuario, $clave, $tipo_doc, $num_doc, $ap_paterno, $ap_materno, $nombre, $estado, $tipo, $cod_area) {
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