<?php 
include_once("../../config/conexion.php");

class Tramite{
    
    public function obtenerUltimoTramite() {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT MAX(codigo_generado) AS ultimo_tramite FROM tramite";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        $resultado = null;
        $stmt->bind_result($resultado);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }

    public function ingresarTramite($tipoTramite, $anio, $codigoGenerado, $codTipoDocumento, $horaReg, $fecReg, $remitente, $asunto) {
        $conexion = Conexion::conectarBD();
        $sql = "INSERT INTO tramite (tipo_tramite, anio, codigo_generado, cod_tipodocumento, hora_reg, fec_reg, remitente, asunto)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        $stmt->bind_param(
            "sissssss",  // Tipos: i=int, s=string (ajústalo según tus datos)
            $tipoTramite,
            $anio,
            $codigoGenerado,
            $codTipoDocumento,
            $horaReg,
            $fecReg,
            $remitente,
            $asunto
        );
        $stmt->execute();
        // Puedes retornar true/false o el ID insertado si lo deseas:
        $resultado = $stmt->affected_rows > 0;
        $stmt->close();
        Conexion::desconectarBD();
        return $resultado;
    }
    
    
    
}