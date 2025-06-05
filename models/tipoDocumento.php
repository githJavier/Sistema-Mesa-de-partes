<?php 
include_once("../../config/conexion.php");

class TipoDocumento{

    public function obtenerTipoDocumento(){
        $conexion = Conexion::conectarBD();
        $sql = "SELECT cod_tipodocumento, tipodocumento, abreviatura FROM tipodocumento";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
    
        $tiposDocumento = array(); // Array para almacenar los resultados
        $cod_tipodocumento = null;
        $tipodocumento = null;
        $abreviatura = null;
        $stmt->bind_result($cod_tipodocumento, $tipodocumento, $abreviatura);
        while ($stmt->fetch()) {
            $tiposDocumento[] = array(
                'cod_tipodocumento' => $cod_tipodocumento,
                'tipodocumento' => $tipodocumento,
                'abreviatura' => $abreviatura
            );
        }
        $stmt->close();
        Conexion::desconectarBD();
        return $tiposDocumento; 
    }

    public function obtenerTipoDocumentoId($cod_tipodocumento) {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT cod_tipodocumento, tipodocumento, abreviatura FROM tipodocumento WHERE cod_tipodocumento = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $cod_tipodocumento);
        $stmt->execute();

        $codigo = null;
        $nombre = null;
        $abreviatura = null;
        $stmt->bind_result($codigo, $nombre, $abreviatura);
        
        $tipoDocumento = null;
        if ($stmt->fetch()) {
            $tipoDocumento = array(
                'cod_tipodocumento' => $codigo,
                'tipodocumento' => $nombre,
                'abreviatura' => $abreviatura
            );
        }

        $stmt->close();
        Conexion::desconectarBD();
        return $tipoDocumento;
    }

    public function actualizarDatosTipoDocumento($id, $tipoDocumento, $abreviatura) {
        $conexion = Conexion::conectarBD();
        $sql = "UPDATE tipodocumento SET tipodocumento = ?, abreviatura = ? WHERE cod_tipodocumento = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            // Si falla la preparación de la consulta
            Conexion::desconectarBD();
            return false;
        }

        $stmt->bind_param("ssi", $tipoDocumento, $abreviatura, $id);
        $resultado = $stmt->execute();

        $stmt->close();
        Conexion::desconectarBD();
        return $resultado; // true si se actualizó correctamente, false si no
    }

    public function eliminarTipoDocumento($id) {
        $conexion = Conexion::conectarBD();
        $sql = "DELETE FROM tipodocumento WHERE cod_tipodocumento = ?";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            // Si falla la preparación de la consulta
            Conexion::desconectarBD();
            return false;
        }

        $stmt->bind_param("i", $id);
        $resultado = $stmt->execute();

        $stmt->close();
        Conexion::desconectarBD();
        return $resultado; // true si se eliminó correctamente, false si no
    }

    public function agregarTipoDocumento($tipodocumento, $abreviatura) {
        $conexion = Conexion::conectarBD();

        $sql = "INSERT INTO tipodocumento (tipodocumento, abreviatura) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt === false) {
            Conexion::desconectarBD();
            return false;  // Error preparando la consulta
        }

        $stmt->bind_param("ss", $tipodocumento, $abreviatura);
        $resultado = $stmt->execute();

        $stmt->close();
        Conexion::desconectarBD();
        return $resultado; // true si insertó correctamente, false si no
    }

    public function existeTipoDocumento($tipodocumento) {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT COUNT(*) FROM tipodocumento WHERE tipodocumento = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $tipodocumento);
        $stmt->execute();
        $cantidad = null;
        $stmt->bind_result($cantidad);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        
        return $cantidad > 0; // Devuelve true si ya existe
    }

    public function existeAbreviatura($abreviatura) {
        $conexion = Conexion::conectarBD();
        $sql = "SELECT COUNT(*) FROM tipodocumento WHERE abreviatura = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $abreviatura);
        $stmt->execute();
        $cantidad = null;
        $stmt->bind_result($cantidad);
        $stmt->fetch();
        $stmt->close();
        Conexion::desconectarBD();
        
        return $cantidad > 0; // Devuelve true si ya existe
    }

}