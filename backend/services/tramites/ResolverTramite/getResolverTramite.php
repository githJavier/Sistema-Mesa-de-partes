<?php
include_once("../../../shared/models/tramite.php");
session_start();

class GetResolverTramite{
    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerTramitesPorResolver(){
        $getResolverTramites = $this->objTramite;
        $area_usuario = $_SESSION['datos']['area'];
        $tramitesPendientes = $getResolverTramites->obtenerTramitesPorResolver($area_usuario);
        return $tramitesPendientes;
    }
}
