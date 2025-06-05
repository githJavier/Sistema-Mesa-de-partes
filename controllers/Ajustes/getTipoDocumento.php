<?php 
include_once("../../models/tipoDocumento.php");

class GetTipoDocumento {
    public $message = "";
    private $objTipoDocumento;

    public function __construct() {
        $this->objTipoDocumento = new TipoDocumento();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Crear";
    }

    public function verificarSiExisteTipoDocumento($tipoDocumento) {
        if ($this->objTipoDocumento->existeTipoDocumento($tipoDocumento)) {
            $this->message = "El tipo de documento ya está registrado.";
            return false;
        } else {
            $this->message = "Tipo de documento disponible.";
            return true;
        }
    }

    public function verificarSiExisteAbreviatura($abreviatura) {
        if ($this->objTipoDocumento->existeAbreviatura($abreviatura)) {
            $this->message = "La abreviatura ya está registrada.";
            return false;
        } else {
            $this->message = "Abreviatura disponible.";
            return true;
        }
    }

    public function verificarNombreTipoDocumento($nombreTipoDocumento) {
        $nombreTipoDocumento = trim($nombreTipoDocumento);

        if (empty($nombreTipoDocumento) || strlen($nombreTipoDocumento) < 3) {
            $this->message = "El nombre del tipo de documento es muy corto.";
            return false;
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/', $nombreTipoDocumento)) {
            $this->message = "El nombre contiene caracteres inválidos.";
            return false;
        }

        if (is_numeric($nombreTipoDocumento)) {
            $this->message = "El nombre no puede ser solo números.";
            return false;
        }

        $this->message = "Nombre del tipo de documento válido.";
        return true;
    }

    public function CrearTipoDocumento($nombreTipoDocumento, $abreviatura) {
        $resultado = $this->objTipoDocumento->agregarTipoDocumento($nombreTipoDocumento, $abreviatura);
        
        if ($resultado) {
            $this->message = "El tipo de documento fue agregado correctamente.";
            return true;
        } else {
            $this->message = "Error al agregar el tipo de documento.";
            return false;
        }
    }

}