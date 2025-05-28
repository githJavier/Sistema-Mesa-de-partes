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
}
