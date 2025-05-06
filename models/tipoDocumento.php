<?php 
include_once("../../config/conexion.php");

class TipoDocumento{

    public function obtenerTipoDocumento(){
        $conexion = Conexion::conectarBD();
        $sql = "SELECT cod_tipodocumento, tipodocumento FROM tipodocumento";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
    
        $tiposDocumento = array(); // Array para almacenar los resultados
        $cod_tipodocumento = null;
        $tipodocumento = null;
        $stmt->bind_result($cod_tipodocumento, $tipodocumento);
        while ($stmt->fetch()) {
            $tiposDocumento[] = array(
                'cod_tipodocumento' => $cod_tipodocumento,
                'tipodocumento' => $tipodocumento
            );
        }
        $stmt->close();
        Conexion::desconectarBD();
        return $tiposDocumento; 
    }
    
}