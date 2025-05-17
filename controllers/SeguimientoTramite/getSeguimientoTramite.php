<?php
include_once("../../models/tramite.php");
session_start();

class GetSeguimientoTramite{
    private $objTramite;

    public function __construct() {
        $this->objTramite = new Tramite();
    }

    public function obtenerMisTramites(){
        $nombres_usuario = $_SESSION["datos"]["nombres"];
        $getSeguimientoTramite = $this->objTramite;
        $tramites = $getSeguimientoTramite->obtenerMisTramites($nombres_usuario);
        return $tramites;
    }

}
