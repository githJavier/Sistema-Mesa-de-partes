<?php
include_once("../../models/tramite.php");
session_start();

class GetRecibirTramiteInterno{
    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerTramitesInternos($area){
        $getRecibirTramitesInternos = $this->objTramite;
        $tramitesInternos = $getRecibirTramitesInternos->obtenerTramitesRegistradosRemitenteInterno($area);
        return $tramitesInternos;
    }

}
