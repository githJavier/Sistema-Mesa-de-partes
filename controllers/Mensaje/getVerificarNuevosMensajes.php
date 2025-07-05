<?php
require_once __DIR__ . '/../../models/ayuda.php';
require_once __DIR__ . '/../../utils/log_config.php';
session_start();

class GetResponderMensaje {
    private $objAyuda;
    public $message = '';  // Para mensajes de error

    public function __construct() {
        $this->objAyuda = new Ayuda();
    }

    public function obtenerConsultasOrdenadasPorUltimoMensajeRemitente() {
        $nuevosMensajes = $this->objAyuda->obtenerConsultasOrdenadasPorUltimoMensajeRemitente();
        if (empty($nuevosMensajes)) {
            $this->message = "No se encontró información de la consulta de ayuda asociada.";
            return false;
        }
        return $datos;
    }
}
