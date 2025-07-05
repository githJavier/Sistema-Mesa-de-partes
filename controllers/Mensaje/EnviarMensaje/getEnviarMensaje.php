<?php
require_once __DIR__ . '/../../../models/mensajesAyuda.php';
session_start();

class GetEnviarMensaje {
    private $objMensajesAyuda;
    public $message = '';  // Variable para mensajes de error

    public function __construct() {
        $this->objMensajesAyuda = new MensajesAyuda();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "EnviarMensaje";
    }

    public function validarMensaje($mensaje) {
        if (!isset($mensaje)) {
            $this->message = "No se recibió ningún mensaje.";
            return false;
        }

        $mensaje = trim($mensaje);

        if ($mensaje === '') {
            $this->message = "El mensaje no puede estar vacío.";
            return false;
        }

        if (mb_strlen($mensaje, 'UTF-8') > 3000) {
            $this->message = "El mensaje es demasiado largo. Máximo 3,000 caracteres.";
            return false;
        }

        // Aquí ya no se fuerza a tener letras o números, se permiten emojis, símbolos, etc.
        return true;
    }

    public function validarRemitente($datos) {
        if (!is_array($datos)) {
            $this->message = "Error interno: los datos del usuario no son válidos.";
            return false;
        }

        if (!isset($datos['tipo_remitente'])) {
            $this->message = "No se ha especificado el tipo de remitente";
            return false;
        }

        if (!in_array(trim($datos['tipo_remitente']), ['PERSONA NATURAL', 'PERSONA JURIDICA'])) {
            $this->message = "No tienes permisos para realizar esta acción.";
            return false;
        }

        return 'remitente';
    }

    public function registrarMensajeAyuda($idAyuda, $idRemitente, $idUsuarioSistema, $tipo, $mensaje) {
        // Validación de existencia del modelo
        if (!isset($this->objMensajesAyuda)) {
            $this->message = "Error interno: no se pudo acceder al modelo de mensajes.";
            return false;
        }

        // Intentar registrar el mensaje
        $resultado = $this->objMensajesAyuda->registrarMensajeAyuda(
            $idAyuda,
            $idRemitente,
            $idUsuarioSistema,
            $tipo,
            $mensaje
        );

        if (!$resultado) {
            $this->message = "Algo salió mal. No se pudo registrar el mensaje.";
            return false;
        }

        return true;
    }
}
