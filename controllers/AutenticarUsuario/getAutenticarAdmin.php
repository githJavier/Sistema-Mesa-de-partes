<?php
include_once("../../models/administrador.php");

class GetAutenticarAdministrador {
    public $message = "";
    private $objAdministrador;

    public function __construct() {
        $this->objAdministrador = new Administrador();
    }

    // Validar si el botón fue presionado
    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Acceder";
    }

    // Validar formato del número de documento
    public function verificarUsuario($usuario) {
        $usuario = trim($usuario);

        if (empty($usuario)) {
            $this->message = "El campo de usuario no puede estar vacío.";
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

        if (strlen($contrasena) < 4) {
            $this->message = "La contraseña debe tener al menos 4 caracteres.";
            return false;
        }

        return true;
    }

    // Verificar si el administrador existe en la base de datos
    public function validarAdministrador($usuario) {
        if ($this->objAdministrador->existeUsuario($usuario)) {
            $this->message = "Administrador verificado correctamente.";
            return true;
        } else {
            $this->message = "El administrador ingresado no existe. Verifique sus datos e intente nuevamente.";
            return false;
        }
    }

    // Verificar si el administrador fue eliminado de la base de datos
    public function AdministradorEliminado($usuario) {
        if ($this->objAdministrador->fueEliminadoUsuario($usuario)) {
            $this->message = "Acceso denegado. El administrador fue eliminado del sistema";
            return true;
        } else {
            $this->message = "El administrador no fue eliminado del sistema.";
            return false;
        }
    }

    // Verificar si el administrador fue inactivado de la base de datos
    public function AdministradorInactivado($usuario) {
        if ($this->objAdministrador->fueInactivadoUsuario($usuario)) {
            $this->message = "Acceso denegado. El administrador fue inactivado temporalmente del sistema";
            return true;
        } else {
            $this->message = "El administrador no fue inactivado del sistema.";
            return false;
        }
    }

    // Validar la contraseña del administrador en la base de datos
    public function validarContrasena($documento, $contrasena) {
        if ($this->objAdministrador->verificarContrasena($documento, $contrasena)) {
            $this->message = "Inicio de sesión exitoso. Redirigiendo...";
            return true;
        } else {
            $this->message = "La contraseña ingresada es incorrecta. Intente nuevamente.";
            return false;
        }
    }

    // Obtener datos del administrador desde la base de datos
    public function obtenerDatosUsuario($usuario, $contrasena) {
        return $this->objAdministrador->obtenerDatosUsuario($usuario, $contrasena);
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
