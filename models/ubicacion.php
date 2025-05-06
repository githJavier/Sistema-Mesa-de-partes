<?php
include_once("../../config/conexion.php");

class Ubicacion{

    public function obtenerDepartamento() {
        $conexion = Conexion::conectarBD();
        $sql = 'SELECT idDepa, departamento 
                FROM ubdepartamento';
        if ($stmt = $conexion->prepare($sql)) {
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                $departamentos = [];
                while ($fila = $resultado->fetch_assoc()) {
                    $departamentos[] = $fila;
                }
                $stmt->close();
                Conexion::desconectarBD();
                return $departamentos;
            } else {
                error_log("Error al ejecutar la consulta: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Error al preparar la consulta: " . $conexion->error);
        }
        Conexion::desconectarBD();
        return [];
    }
    public function obtenerProvincia($departamento) {
        $conexion = Conexion::conectarBD();
        $provincias = [];
    
        $sql = 'SELECT idProv, provincia 
                FROM ubprovincia 
                WHERE departamento = ?';
    
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param('s', $departamento);
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                while ($fila = $resultado->fetch_assoc()) {
                    $provincias[] = $fila;
                }
            } else {
                error_log("Error al ejecutar la consulta: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Error al preparar la consulta: " . $conexion->error);
        }
    
        Conexion::desconectarBD();
        return $provincias;
    }

    public function obtenerDistrito($provincia) {
        $conexion = Conexion::conectarBD();
        $distritos = [];
    
        $sql = 'SELECT idDist, distrito
                FROM ubdistrito 
                WHERE provincia = ?';
    
        if ($stmt = $conexion->prepare($sql)) {
            $stmt->bind_param('s', $provincia);
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                while ($fila = $resultado->fetch_assoc()) {
                    $distritos[] = $fila;
                }
            } else {
                error_log("Error al ejecutar la consulta: " . $stmt->error);
            }
            $stmt->close();
        } else {
            error_log("Error al preparar la consulta: " . $conexion->error);
        }
    
        Conexion::desconectarBD();
        return $distritos;
    }
    
    
}
?>