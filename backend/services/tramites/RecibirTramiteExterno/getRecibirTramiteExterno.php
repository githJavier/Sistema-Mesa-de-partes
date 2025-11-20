<?php
require_once __DIR__ . '/../../../shared/models/tramite.php';

class GetRecibirTramiteExterno{
    private $objTramite;
    public $message = '';

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Recibir00";
    }

    public function obtenerTramitesExternos(){
        $getRecibirTramitesExternos = $this->objTramite;
        $tramitesExternos = $getRecibirTramitesExternos->obtenerTramitesRegistradosRemitenteExterno();
        return $tramitesExternos;
    }

    public function RecibirTramiteExterno($codigo_tramite, $area_origen, $area_destino, $num_documento, $hora, $fecha){
        $orden = $this->objTramite->obtenerNuevoOrden($num_documento);
        $respuesta = $this->objTramite->RecibirTramiteExterno($codigo_tramite, $fecha, $hora, $area_origen, $area_destino, $num_documento, $orden);
        if (!$respuesta) {
            $this->message = "No se pudo recibir el trámite";
            return false;
        } else {
            return true;
        }
    }
}
