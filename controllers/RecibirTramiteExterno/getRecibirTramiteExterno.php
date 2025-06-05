<?php
include_once("../../models/tramite.php");
session_start();

class GetRecibirTramiteExterno{
    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerTramitesExternos(){
        $getRecibirTramitesExternos = $this->objTramite;
        $tramitesExternos = $getRecibirTramitesExternos->obtenerTramitesRegistradosRemitenteExterno();
        return $tramitesExternos;
    }

}
