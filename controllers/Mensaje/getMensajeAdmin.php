<?php
include_once("../../models/ayuda.php");
session_start();

class GetMensajeAdmin {
    private $objAyuda;
    public $message = '';  // Variable para mensajes de error

    public function __construct() {
        $this->objAyuda = new Ayuda();
    }

    public function obtenerConsultasOrdenadasPorUltimoMensajeRemitente() {
        $consultas = $this->objAyuda->obtenerConsultasOrdenadasPorUltimoMensajeRemitente();

        if ($consultas === false || empty($consultas)) {
            $this->message = "No se pudieron obtener las consultas de los remitentes.";
            return false;
        }

        return $consultas;
    }
}
