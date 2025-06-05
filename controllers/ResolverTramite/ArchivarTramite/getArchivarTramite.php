<?php
include_once("../../../models/tramite.php");
session_start();
class GetArchivarTramite{
    public $message = "";
    public $success = false;

    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "ArchivarTramite";
    }

    public function validarMotivoo($motivo){
        if (!isset($motivo) || trim($motivo) === "") {
            $this->message = "El motivo es obligatorio.";
            return false;
        }
        return true;
    }

    public function validarMotivo($motivo){
        if (!isset($motivo) || trim($motivo) === "") {
            $this->message = "El asunto es obligatorio.";
            return false;
        }

        // Validar longitud máxima 100 caracteres
        if (strlen($motivo) > 100) {
            $this->message = "El motivo no debe exceder los 100 caracteres. Actualmente tiene " . strlen($motivo) . " caracteres.";
            return false;
        }

        // Si pasa todas las validaciones
        return true;
    }
    
    public function archivarTramite(
        $codigo_generado,
        $fecha,
        $hora,
        $comentario,
        $num_documento
    ) {
        try {
            // Validar sesión
            if (!isset($_SESSION['datos']['area'])) {
                $this->message = "Sesión inválida.";
                $this->success = false;
                return false;
            }

            $area_usuario = $_SESSION['datos']['area'];

            // Obtener orden del trámite
            $getTramite = new Tramite();
            $orden = $getTramite->obtenerSiguienteOrdenPorDocumento($num_documento);
            if ($orden === null) {
                $this->message = "Error al obtener el orden del trámite.";
                $this->success = false;
                return false;
            }

            // Llamar al modelo para archivar
            $getIngresarTramite = $this->objTramite;
            $respuesta = $getIngresarTramite->ArchivarTramite(
                $codigo_generado,
                $fecha,
                $hora,
                $area_usuario,
                $comentario,
                $num_documento,
                $orden
            );

            if ($respuesta) {
                $this->message = "Trámite archivado correctamente.";
                $this->success = true;
            } else {
                $this->message = "Ocurrió un problema al archivar el trámite.";
                $this->success = false;
            }

            return $respuesta;

        } catch (Exception $e) {
            $this->message = "Error inesperado al archivar el trámite.";
            $this->success = false;
            return false;
        }
    }
}
