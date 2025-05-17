<?php
include_once("../../models/usuario.php");
include_once("../../models/administrador.php");

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

    public function listarUsuarios() {
        $objAdministrador = new Administrador;
        $usuarios = $objAdministrador->listarUsuarios();

        if ($usuarios !== false) {
            return $usuarios;
        } else {
            $this->message = "No se pudieron obtener los usuarios.";
            return [];
        }
    }

    public function crearUsuario($usuario, $clave, $tipo_doc, $num_doc, $ap_paterno, $ap_materno, $nombre, $estado, $tipo, $cod_area) {
        $objAdministrador = new Administrador;
        $respuesta = $objAdministrador->crearUsuario($usuario,$clave,$tipo_doc, $num_doc, $ap_paterno, $ap_materno, $nombre, $estado, $tipo, $cod_area);
        if($respuesta){
            $this->message = "Usuario creado correctamente.";
        }else{
            $this->message = "Error al crear usuario";
        }
    }



}
