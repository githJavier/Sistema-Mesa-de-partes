<?php
include_once("../../models/usuario.php");

class GetAdministracion {
    public $message = "";
    private $objUsuario;
    private $remitentes = [];

    public function __construct() {
        $this->objUsuario = new Usuario();
    }

    public function listarRemitentes() {
    $getRemitentes = $this->objUsuario->listarRemitentes();
    if ($getRemitentes !== false) {
        $this->remitentes = $getRemitentes;
        return $this->remitentes;
    } else {
        $this->remitentes = [];
        $this->message = "No se pudieron obtener los remitentes.";
        return $this->remitentes;
    }
}


}
