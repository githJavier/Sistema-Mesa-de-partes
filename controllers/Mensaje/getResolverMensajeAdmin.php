<?php
require_once __DIR__ . '/../../models/ayuda.php';
require_once __DIR__ . '/../../utils/log_config.php';
session_start();

class GetResolverMensajeAdmin {
    private $objAyuda;
    public $message = '';  // Para mensajes de error

    public function __construct() {
        $this->objAyuda = new Ayuda();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "ResolverMensaje";
    }

    public function validarIdAyuda($idAyuda) {
        if (!is_numeric($idAyuda) || (int)$idAyuda <= 0) {
            $this->message = "El ID de ayuda no es válido.";
            return false;
        }
        return (int)$idAyuda;
    }

    public function marcarMensajeAdminComoResuelto($idAyuda) {
        $resultado = $this->objAyuda->marcarMensajeAdminComoResuelto($idAyuda);
        if ($resultado) {
            return true;
        } else {
            $this->message = "No se pudo marcar el mensaje como resuelto.";
            return false;
        }
    }

}
