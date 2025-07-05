<?php
include_once("../../models/ayuda.php");
session_start();

class GetMensaje {
    private $objAyuda;
    public $message = '';  // Variable para mensajes de error

    public function __construct() {
        $this->objAyuda = new Ayuda();
    }

    public function obtenerMisConsultasOrdenadasPorUltimoMensajeAdmin($idRemitente) {
        $consultas = $this->objAyuda->obtenerMisConsultasOrdenadasPorUltimoMensajeAdmin($idRemitente);

        if ($consultas === false || empty($consultas)) {
            $this->message = "No se encontraron consultas registradas para este remitente.";
            return false;
        }

        return $consultas;
    }
}
