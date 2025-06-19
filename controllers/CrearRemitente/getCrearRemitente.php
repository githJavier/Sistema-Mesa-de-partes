<?php 
include_once("../../models/usuario.php");

class GetCrearRemitente {
 
    public $message = "";
    private $objUsuario;

    public function __construct() {
        $this->objUsuario = new Usuario();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Registrar";
    }

    public function verificarTipoDocumento($tipoDocumento) {
        $documentosValidos = ["DNI", "RUC"];
        $tipoDocumento = trim($tipoDocumento);
        if (in_array($tipoDocumento, $documentosValidos, true)) {
            return true;
        } else {
            return false;
        }
    }

    public function verificarDocumento($documento, $tipoDocumento) {
        $documento = trim($documento);
        if (empty($documento)) {
            return false;
        }
        if ($tipoDocumento === "DNI") {
            return preg_match('/^\d{8}$/', $documento);
        } elseif ($tipoDocumento === "RUC") {
            return preg_match('/^\d{11}$/', $documento);
        } else {
            return false;
        }
    }

    public function verificarNombre($nombre, $tipoDocumento) {
        $nombre = trim($nombre);
        if (empty($nombre)) {
            return false;
        }
        if ($tipoDocumento == "DNI") {
            // Solo se permiten letras (con tildes), espacios, comas y puntos, entre 2 y 250 caracteres
            if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s,\.]{2,250}$/', $nombre)) {
                return false;
            }
        } elseif ($tipoDocumento == "RUC") {
            if (!preg_match('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,&\-\(\)\/]{2,250}$/', $nombre)) {
                return false;
            }
        }
        return true;
    }
    

    public function verificarCorreo($correo) {
        $correo = trim($correo);
        return filter_var($correo, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function verificarTelefono($telefono) {
        $telefono = trim($telefono);
        if (empty($telefono)) {
            return false;
        }
        if (!ctype_digit($telefono)) {
            return false;
        }
        if (!preg_match('/^9\d{8}$/', $telefono)) {
            return false;
        }
        return true;
    }

    public function verificarContrasena($contrasena) {
        $contrasena = trim($contrasena);
        if (empty($contrasena)) {
            return false;
        }
        if (strlen($contrasena) > 7) {
            return true;
        } else {
            return false;
        }
    }
    
    public function verificarIgualdadContrasena(string $contrasena, string $rContrasena): bool {
        return trim($contrasena) === trim($rContrasena);
    }

    public function verificarTerminos($termsCheck): bool {
        return isset($termsCheck) && filter_var($termsCheck, FILTER_VALIDATE_BOOLEAN);
    }

    public function verificarUsuario($documento, $tipoPersona) {
        if ($this->objUsuario->validarRemitente($documento, $tipoPersona)) {
            $this->message = "El usuario ya esta registrado.";
            return false;
        } else {
            $this->message = "Usuario Disponible";
            return true;
        }
    }

    public function encriptarContrasena($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    

    public function crearRemitente($tipoUsuario, $tipoDocumento, $numeroDocumento, $nombres, $telefono, $email, $clave){
        return $this->objUsuario->crearRemitente($tipoUsuario, $tipoDocumento, $numeroDocumento, $nombres, $telefono, $email, $clave);
    }

}