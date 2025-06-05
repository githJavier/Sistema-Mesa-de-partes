<?php
include_once("../../config/conexion.php");

class Area
{
    public function obtenerAreas() {
        $conexion = Conexion::conectarBD();
        $sql = 'SELECT cod_area, area FROM area';
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación: " . $conexion->error);
        }
        $stmt->execute();
        $resultado = $stmt->get_result();
        $areas = [];

        if ($resultado && $resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                $areas[] = [
                    'cod_area' => $fila['cod_area'],
                    'area' => $fila['area']
                ];
            }
        }

        $stmt->close();
        Conexion::desconectarBD();
        return $areas;
    }

    public function obtenerAreaId($cod_area) {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT cod_area, area FROM area WHERE cod_area = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $cod_area);
        $stmt->execute();

        $codigo = null;
        $nombre = null;
        $stmt->bind_result($codigo, $nombre);

        $area = null;
        if ($stmt->fetch()) {
            $area = array(
                'cod_area' => $codigo,
                'area' => $nombre
            );
        }

        $stmt->close();
        Conexion::desconectarBD();
        return $area;
    }

    public function actualizarArea($id, $area) {
        $conexion = Conexion::conectarBD();
        $sql = "UPDATE area SET area = ? WHERE cod_area = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            Conexion::desconectarBD();
            return false;
        }

        $stmt->bind_param("si", $area, $id);
        $resultado = $stmt->execute();

        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function eliminarArea($id) {
        $conexion = Conexion::conectarBD();
        $sql = "DELETE FROM area WHERE cod_area = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            Conexion::desconectarBD();
            return false;
        }

        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function agregarArea($area) {
        $conexion = Conexion::conectarBD();

        $sql = "INSERT INTO area (area) VALUES (?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            Conexion::desconectarBD();
            return false;
        }

        $stmt->bind_param("s", $area);
        $resultado = $stmt->execute();

        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function existeArea($area) {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT COUNT(*) FROM area WHERE area = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $area);
        $stmt->execute();
        $cantidad = null;
        $stmt->bind_result($cantidad);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        
        return $cantidad > 0;
    }
}
