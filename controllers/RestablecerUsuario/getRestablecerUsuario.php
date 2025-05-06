<?php

include_once("../../models/usuario.php");
class GetRestablecerUsuario{
    public $message = "";
    private $objUsuario;

    public function __construct() {
        $this->objUsuario = new Usuario();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Recuperar";
    }

    public function verificarDocumento($documento) {
        $documento = trim($documento);
    
        if (empty($documento)) {
            $this->message = "Debe ingresar el documento DNI/RUC";
            return false;
        }
        if (strlen($documento) == 8) {
            if (!preg_match('/^\d{8}$/', $documento)) {
                $this->message = "El DNI debe contener solo números";
                return false;
            }
            return true;
        } elseif (strlen($documento) == 11) {
            if (!preg_match('/^\d{11}$/', $documento)) {
                $this->message = "El RUC debe contener solo números";
                return false;
            }
            return true;
        }
    
        $this->message = "Ingrese un documento válido (DNI: 8 dígitos, RUC: 11 dígitos)";
        return false;
    }
    
    

    public function verificarCorreo($correo) {
        $correo = trim($correo);
        if (empty($correo)) {
            $this->message = "Debe ingresar un correo electrónico.";
            return false;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $this->message = "Ingrese un correo válido (ejemplo@gmail.com).";
            return false;
        }
        return true;
    }

    public function verificarDocumentoCorreo($correo, $documento) {
        $objUsuario = new Usuario();
        $correoBD = $objUsuario->consultarCorreo($documento);
        if (empty($correoBD)) {
            $this->message = "El documento ingresado tiene registrado un correo.";
            return false;
        }
        if ($correo !== $correoBD) {
            $this->message = "El correo ingresado no coincide con el documento.";
            return false;
        }
        return true;
    }
    

    public function mandarCorreo($correo) {
        $codigo = $this->generarCodigoAleatorio();
    
        $asunto = "Código de recuperación de contraseña";
        $mensaje = "Hola,\n\nTu código de recuperación es: " . $codigo . "\n\nSi no solicitaste este código, ignora este mensaje.";
        $headers = "From: soporte@tuempresa.com" . "\r\n" .
                   "Reply-To: soporte@tuempresa.com" . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8";
    
        // Enviar correo
        if (mail($correo, $asunto, $mensaje, $headers)) {
            $this->message = "Correo enviado exitosamente. Revisa tu bandeja de entrada.";
            return true; 
        } else {
            $this->message = "Error al enviar el correo. Inténtalo nuevamente más tarde.";
            return false;
        }
    }
    
    
    public function generarCodigoAleatorio() {
        return str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    }
    


}