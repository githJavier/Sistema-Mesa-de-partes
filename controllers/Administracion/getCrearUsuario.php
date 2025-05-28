<?php 
include_once("../../models/administrador.php");
include_once("../../models/usuario.php");
include_once("../../models/area.php");

class GetCrearUsuario {
    public $message = "";
    private $objAdministrador;
    private $objUsuario;
    private $objArea;

    public function __construct() {
        $this->objAdministrador = new Administrador();
        $this->objUsuario = new Usuario();
        $this->objArea = new Area();
    }

    public function validarBoton($nombreBoton) {
        return isset($_POST[$nombreBoton]) && $_POST[$nombreBoton] == "Registrar";
    }

    public function verificarTipoDocumento($tipoDocumento) {
        $documentosValidos = ['L.E / DNI', 'CARNET EXT.', 'PASAPORTE', 'OTRO'];;
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

        switch ($tipoDocumento) {
            case 'L.E / DNI':
                return preg_match('/^\d{8}$/', $documento); // Exactamente 8 dígitos numéricos

            case 'CARNET EXT.':
                return preg_match('/^[a-zA-Z0-9]{9,}$/', $documento); // Alfanumérico, mínimo 9 caracteres

            case 'PASAPORTE':
                return preg_match('/^[a-zA-Z0-9]{6,}$/', $documento); // Alfanumérico, mínimo 6 caracteres

            case 'OTRO':
                return strlen($documento) >= 4; // Mínimo 4 caracteres de cualquier tipo

            default:
                return false; // Tipo de documento no válido
        }
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

    public function verificarUsuario($usuario) {
        if ($this->objAdministrador->existeUsuario($usuario)) {
            $this->message = "El usuario ya esta registrado.";
            return false;
        } else {
            $this->message = "Usuario Disponible";
            return true;
        }
    }

    public function verificarNombreUsuario($nombre) {
        $nombre = trim($nombre);
        if (empty($nombre) || strlen($nombre) < 2) {
            return false;
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
            return false;
        }

        return true;
    }

    public function verificarApellidoPaterno($apellidoPaterno) {
        $apellidoPaterno = trim($apellidoPaterno);
        if (empty($apellidoPaterno) || strlen($apellidoPaterno) < 2) {
            return false;
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellidoPaterno)) {
            return false;
        }

        return true;
    }

    public function verificarApellidoMaterno($apellidoMaterno) {
        $apellidoMaterno = trim($apellidoMaterno);
        if (empty($apellidoMaterno) || strlen($apellidoMaterno) < 2) {
            return false;
        }

        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $apellidoMaterno)) {
            return false;
        }

        return true;
    }

    public function verificarTipoUsuario($tipoUsuario) {
        $listaTiposUsuario = $this->objUsuario->obtenerTiposUsuario();

        foreach ($listaTiposUsuario as $tipo) {
            if ($tipo['tipo_usuario'] == $tipoUsuario) {
                return true;
            }
        }

        return false;
    }

    public function verificarEstadoUsuario($estadoUsuario) {
        if ($estadoUsuario === '0' || $estadoUsuario === '1') {
            return true;
        }
        return false;
    }

    public function verificarArea($area) {
        $listaAreas = $this->objArea->obtenerAreas();

        foreach ($listaAreas as $item) {
            if ($item['cod_area'] == $area) {
                return true;
            }
        }

        return false;
    }

    public function crearUsuario($tipoDocumento, $numeroDocumento, $nombre, $apellidoPaterno, $apellidoMaterno, $tipoUsuario, $estadoUsuario, $areaUsuario, $usuario, $password) {
        $hashed_password = md5($password);
        return $this->objAdministrador->crearUsuario(
            $tipoDocumento, 
            $numeroDocumento, 
            $nombre, 
            $apellidoPaterno, 
            $apellidoMaterno, 
            $tipoUsuario, 
            $estadoUsuario, 
            $areaUsuario, 
            $usuario, 
            $hashed_password
        );
    }

}