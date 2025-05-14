<?php

include_once("../../models/tramite.php");
include_once("../../models/tipoDocumento.php");
include_once("../../models/usuario.php");


class GetSeguimientoTramite{
    public $message = "";

    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerTramites(){
        $getSeguimientoTramite = $this->objTramite;
        $tramites = $getSeguimientoTramite->obtenerTramites();
        return $tramites;
    }

}
