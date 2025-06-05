<?php
include_once("../../models/usuario.php");
include_once("../../models/administrador.php");
include_once("../../models/tipoDocumento.php");
include_once("../../models/area.php");

class GetAdministracion {
    public $message = "";
    private $objUsuario;
    private $objTipoDocumento;
    private $objArea;
    private $remitentes = [];
    private $tiposDocumento = [];
    private $areas = [];

    public function __construct() {
        $this->objUsuario = new Usuario();
        $this->objTipoDocumento = new TipoDocumento();
        $this->objArea = new Area();
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

    public function listarTiposDocumento() {
        $getTiposDocumento = $this->objTipoDocumento->obtenerTipoDocumento();
        if ($getTiposDocumento !== false) {
            $this->tiposDocumento = $getTiposDocumento;
            return $this->tiposDocumento;
        } else {
            $this->tiposDocumento = [];
            $this->message = "No se pudieron obtener los tipos de documento.";
            return $this->tiposDocumento;
        }
    }

    public function listarAreas() {
        $getAreas = $this->objArea->obtenerAreas();
        if ($getAreas !== false) {
            $this->areas = $getAreas;
            return $this->areas;
        } else {
            $this->areas = [];
            $this->message = "No se pudieron obtener las áreas.";
            return $this->areas;
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
