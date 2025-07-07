<?php
require_once __DIR__ . '/../../models/tramite.php';

class GetRecibirTramiteInterno{
    private $objTramite;
    public $message = '';

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Recibir00";
    }

    public function obtenerTramitesInternos($area){
        $getRecibirTramitesInternos = $this->objTramite;
        $tramitesInternos = $getRecibirTramitesInternos->obtenerTramitesRegistradosRemitenteInterno($area);
        return $tramitesInternos;
    }

    public function RecibirTramiteInterno($codigo_tramite, $area_origen, $area_destino, $num_documento, $hora, $fecha){
        $orden = $this->objTramite->obtenerNuevoOrden($num_documento);
        $respuesta = $this->objTramite->RecibirTramiteInterno($codigo_tramite, $fecha, $hora, $area_origen, $area_destino, $num_documento, $orden);
        if (!$respuesta) {
            $this->message = "No se pudo recibir el trámite";
            return false;
        } else {
            return true;
        }
    }
}
