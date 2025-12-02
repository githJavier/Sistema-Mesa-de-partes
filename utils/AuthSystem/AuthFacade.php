<?php
require_once 'SessionManager.php';
require_once 'AuthRepository.php';
require_once __DIR__ . '/../log_config.php';

class AuthFacade {
    private $session;
    private $repository;

    public function __construct() {
        $this->session = new SessionManager();
        $this->repository = new AuthRepository();
    }

    // --- MÉTODOS PARA EL LOGIN ---
    public function loginExitoso($documento, $datos, $mes) {
        // La fachada coordina el guardado en sesión
        $this->session->guardarUsuario($documento, $datos, $mes);
    }

    // --- MÉTODOS PARA VERIFICACIÓN (Interno/Admin) ---
    public function verificarAccesoAdmin() {
        $datos = $this->session->obtener('datos');

        if (!$datos || !isset($datos['estado'])) {
            return 'no_session';
        }

        $estadoReal = $this->repository->verificarEstadoUsuario($datos['num_doc']);

        if ($estadoReal === null) return 'not_found';
        if ($estadoReal != 1) return 'inactive';

        return 'active';
    }

    // --- MÉTODOS PARA VERIFICACIÓN (Remitente) ---
    public function verificarAccesoRemitente() {
        // Un usuario interno no puede ser remitente
        if ($this->session->obtener('datos') && isset($_SESSION['datos']['num_doc'])) { 
            return 'invalid_role'; 
        }

        $usuario = $this->session->obtener('usuario');
        $datos = $this->session->obtener('datos');

        if (!$usuario || !isset($datos['tipo_remitente'])) {
            return 'no_session';
        }

        $existe = $this->repository->verificarRemitente($usuario);
        return $existe ? 'found' : 'not_found';
    }

    // --- MÉTODO PARA LOGOUT ---
    public function logout() {
        $this->session->destruir();
    }
}
?>