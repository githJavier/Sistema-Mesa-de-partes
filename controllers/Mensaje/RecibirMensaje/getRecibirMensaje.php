<?php
require_once __DIR__ . '/../../../models/mensajesAyuda.php';
require_once __DIR__ . '/../../../utils/log_config.php';
session_start();

class GetRecibirMensaje {
    private $objMensajesAyuda;
    public $message = '';  // Para mensajes de error

    public function __construct() {
        $this->objMensajesAyuda = new MensajesAyuda();
    }

    public function validarIdAyuda($idAyuda) {
        if (!is_numeric($idAyuda) || (int)$idAyuda <= 0) {
            $this->message = "El ID de ayuda no es válido.";
            return false;
        }
        return (int)$idAyuda;
    }

    public function obtenerMensajesPorIdAyuda($idAyuda) {
        $mensajesChat = $this->objMensajesAyuda->obtenerMensajesPorIdAyuda($idAyuda);
        return $mensajesChat;
    }

    public function obtenerMensajesRecientes($idAyuda, $ultimoIdMensaje) {
        $mensajesChat = $this->objMensajesAyuda->obtenerMensajesRecientes($idAyuda, $ultimoIdMensaje);
        return $mensajesChat;
    }
}
