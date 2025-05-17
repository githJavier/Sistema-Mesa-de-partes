<?php
include_once("../../models/tramite.php");
include_once("../../models/usuario.php");
session_start();

class GetConsultarTramitesDerivados{
    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerTramitesDerivados(){
        $nombre_usuario = $_SESSION["usuario"];
        $getConsultarTramitesDerivados = $this->objTramite;
        $tramites = $getConsultarTramitesDerivados->obtenerTramitesDerivados($nombre_usuario);
        return $tramites;
    }

}
