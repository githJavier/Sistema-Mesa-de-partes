<?php

class SessionManager {
    public function iniciar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function guardarUsuario($documento, $datos, $mes) {
        $this->iniciar();
        $_SESSION['usuario'] = $documento;
        $_SESSION['datos'] = $datos;
        $_SESSION['mes'] = $mes;
    }

    public function obtener($clave) {
        $this->iniciar();
        return isset($_SESSION[$clave]) ? $_SESSION[$clave] : null;
    }

    public function destruir() {
        $this->iniciar();
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
?>