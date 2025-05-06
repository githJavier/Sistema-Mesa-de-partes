<?php 
include_once("../../models/usuario.php");

class GetAutenticarUsuario {
    public $message = "";
    private $objUsuario;

    public function __construct() {
        $this->objUsuario = new Usuario();
    }

    // Validar si el botón fue presionado
    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Ingresar";
    }

    // Verificar si el tipo de documento es válido (DNI o RUC)
    public function verificarTipoDocumento($tipoDocumento) {
        $documentosValidos = ["DNI", "RUC"];
        $tipoDocumento = trim($tipoDocumento);
        
        if (in_array($tipoDocumento, $documentosValidos, true)) {
            return true;
        } else {
            $this->message = "Tipo de documento no válido. Debe ser DNI o RUC.";
            return false;
        }
    }

    // Validar formato del número de documento
    public function verificarDocumento($documento, $tipoDocumento) {
        $documento = trim($documento);
        
        if (empty($documento)) {
            $this->message = "El campo de documento no puede estar vacío.";
            return false;
        }

        if ($tipoDocumento === "DNI") {
            if (!preg_match('/^\d{8}$/', $documento)) {
                $this->message = "El DNI debe contener exactamente 8 dígitos numéricos.";
                return false;
            }
        } elseif ($tipoDocumento === "RUC") {
            if (!preg_match('/^\d{11}$/', $documento)) {
                $this->message = "El RUC debe contener exactamente 11 dígitos numéricos.";
                return false;
            }
        } else {
            $this->message = "Tipo de documento no válido.";
            return false;
        }

        return true;
    }

    // Validar la seguridad de la contraseña (mínimo 8 caracteres)
    public function verificarContrasena($contrasena) {
        $contrasena = trim($contrasena);
        
        if (empty($contrasena)) {
            $this->message = "El campo de contraseña no puede estar vacío.";
            return false;
        }

        if (strlen($contrasena) < 8) {
            $this->message = "La contraseña debe tener al menos 8 caracteres.";
            return false;
        }

        return true;
    }

    // Verificar si el usuario existe en la base de datos
    public function validarUsuario($documento, $tipoPersona) {
        if ($this->objUsuario->validarUsuario($documento, $tipoPersona)) {
            $this->message = "Usuario verificado correctamente.";
            return true;
        } else {
            $this->message = "El usuario ingresado no existe. Verifique sus datos e intente nuevamente.";
            return false;
        }
    }

    // Validar la contraseña del usuario en la base de datos
    public function validarContrasena($documento, $contrasena) {
        if ($this->objUsuario->verificarContrasena($documento, $contrasena)) {
            $this->message = "Inicio de sesión exitoso. Redirigiendo...";
            return true;
        } else {
            $this->message = "La contraseña ingresada es incorrecta. Intente nuevamente.";
            return false;
        }
    }

    // Obtener datos del usuario desde la base de datos
    public function obtenerDatosRemitente($documento, $contrasena) {
        return $this->objUsuario->obtenerDatosRemitente($documento, $contrasena);
    }

    public function obtenerMes() {
        date_default_timezone_set('UTC');
        $meses = [
            "January" => "Enero", "February" => "Febrero", "March" => "Marzo", "April" => "Abril",
            "May" => "Mayo", "June" => "Junio", "July" => "Julio", "August" => "Agosto",
            "September" => "Septiembre", "October" => "Octubre", "November" => "Noviembre", "December" => "Diciembre"
        ];
        $mesIngles = (new DateTime())->format('F'); // Obtiene el mes en inglés
        return $meses[$mesIngles];
    }
    
    
}
?>
