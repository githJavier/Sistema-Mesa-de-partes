<?php
require_once __DIR__ . '/../../models/mensajesAyuda.php';
require_once __DIR__ . '/../../models/ayuda.php';
require_once __DIR__ . '/../../utils/log_config.php';
session_start();

class GetResponderMensaje {
    private $objAyuda;
    private $objMensajesAyuda;
    public $message = '';  // Para mensajes de error

    public function __construct() {
        $this->objMensajesAyuda = new MensajesAyuda();
        $this->objAyuda = new Ayuda();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "AbrirChatResponderMensaje";
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

    public function obtenerAyudaYRemitentePorIdAyuda($idAyuda) {
        $datos = $this->objAyuda->obtenerAyudaYRemitentePorIdAyuda($idAyuda);
        if (empty($datos)) {
            $this->message = "No se encontró información de la consulta de ayuda asociada.";
            return false;
        }
        return $datos;
    }
}
