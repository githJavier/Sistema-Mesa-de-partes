<?php
include_once("../../models/tramite.php");
include_once("../../models/usuario.php");
session_start();

class GetConsultarTramitesArchivados{
    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerTramitesArchivados(){
        $nombre_usuario = $_SESSION["usuario"];
        $getConsultarTramitesArchivados = $this->objTramite;
        $tramites = $getConsultarTramitesArchivados->obtenerTramitesArchivados($nombre_usuario);
        return $tramites;
    }

}
