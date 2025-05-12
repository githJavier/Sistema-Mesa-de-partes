<?php
include_once("../../config/conexion.php");
class Ayuda{
    public function guardarConsulta($nombres, $email, $telefono_celular, $asunto, $mensaje){
    $conexion = Conexion::conectarBD();
    $sql = "INSERT INTO ayuda (nombres, correo, telefono_celular, asunto, mensaje)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }

    $stmt->bind_param("sssss", $nombres, $email, $telefono_celular, $asunto, $mensaje);

    // Ejecutar solo UNA VEZ
    $resultado = $stmt->execute();

    $stmt->close();
    Conexion::desconectarBD();
    return $resultado;
}

}