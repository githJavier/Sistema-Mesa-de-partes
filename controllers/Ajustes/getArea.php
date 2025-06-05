<?php 
include_once("../../models/area.php");

class GetArea {
    public $message = "";
    private $objTipoArea;

    public function __construct() {
        $this->objTipoArea = new Area();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Crear";
    }

    public function verificarSiExisteArea($area) {
        if ($this->objTipoArea->existeArea($area)) {
            $this->message = "El área ya está registrada.";
            return false;
        } else {
            $this->message = "Área disponible.";
            return true;
        }
    }

    public function verificarNombreArea($nombreArea) {
        $nombreArea = trim($nombreArea);

        if (empty($nombreArea) || strlen($nombreArea) < 3) {
            $this->message = "El nombre del área es muy corto.";
            return false;
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/', $nombreArea)) {
            $this->message = "El nombre contiene caracteres inválidos.";
            return false;
        }

        if (is_numeric($nombreArea)) {
            $this->message = "El nombre no puede ser solo números.";
            return false;
        }

        $this->message = "Nombre del área válido.";
        return true;
    }

    public function CrearArea($nombreArea) {
        $resultado = $this->objTipoArea->agregarArea($nombreArea);
        
        if ($resultado) {
            $this->message = "El área fue agregada correctamente.";
            return true;
        } else {
            $this->message = "Error al agregar el área.";
            return false;
        }
    }

}