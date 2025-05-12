<?php
include_once("../../models/usuario.php");
include_once("../../models/ayuda.php");
class GetAyuda{
    public $message = "";

     public function obtenerDatosRemitente($usuario){
        $getDatosRemitente = new Usuario();
        $datosRemitente = $getDatosRemitente->obtenerDatosRemitenteForm($usuario);
        return $datosRemitente;
    }

    public function guardarConsulta($nombres, $email, $telefono_celular, $asunto, $mensaje){
        $getGuardarConsulta = new Ayuda;
        $respuesta = $getGuardarConsulta->guardarConsulta($nombres, $email,$telefono_celular,$asunto, $mensaje);
        if($respuesta){
            $this->message = "Consulta ingresado correctamente";
        }else{
            $this->message = "Ocurrio un problema al ingresar el trámite";
        }
        return $respuesta;

    }

    public function validarNombres($nombres){
        if (!isset($nombres) || trim($nombres) === "") {
            $this->message = "Los nombres o razón social es obligatorio.";
            return false;
        }
        return true;
    }

    public function validarEmail($email) {
    if (!isset($email) || trim($email) === "") {
        $this->message = "El correo electrónico es obligatorio.";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $this->message = "El formato del correo electrónico no es válido.";
        return false;
    }

    return true;
}


    public function validarTelefono($telefono) {
        if (!isset($telefono) || trim($telefono) === "") {
            $this->message = "El teléfono de contacto es obligatorio.";
            return false;
        }

        if (!preg_match('/^9\d{8}$/', $telefono)) {
            $this->message = "El número de teléfono debe empezar con 9 y tener exactamente 9 dígitos.";
            return false;
        }

    return true;
    }


    public function validarAsunto($asunto){
        if (!isset($asunto) || trim($asunto) === "") {
            $this->message = "El asunto es obligatorio.";
            return false;
        }
        return true;
    }

    public function validarMensaje($mensaje){
        if (!isset($mensaje) || trim($mensaje) === "") {
            $this->message = "El mensaje es obligatorio.";
            return false;
        }
        return true;
    }
}