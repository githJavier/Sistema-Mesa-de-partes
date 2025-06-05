<?php
include_once("../../models/tramite.php");

class GetAjustes {
    public $message = "";
    public $success = false;

    public function RecibirTramiteExterno($codigo_tramite, $area_origen, $area_destino, $num_documento, $hora, $fecha){
        $getTramite = new Tramite();

        $orden = $getTramite->obtenerNuevoOrden($num_documento);

        $respuesta = $getTramite->RecibirTramiteExterno($codigo_tramite, $fecha, $hora, $area_origen, $area_destino, $num_documento, $orden);

        if ($respuesta) {
            $this->message = "Trámite recibido correctamente";
            $this->success = true;
        } else {
            $this->message = "No se pudo recibir el trámite";
            $this->success = false;
        }
    }
}
?>
