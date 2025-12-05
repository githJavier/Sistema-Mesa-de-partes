<?php

namespace Patterns\Observer;

class CorreoObserver implements Observer {

    public function update(array $data) {

        // Aquí se podría integrar PHPMailer o tu sistema de correo.
        // Por ahora lo dejamos simple para no romper el proyecto.

        $msg = "Correo enviado: El trámite {$data['id_tramite']} fue procesado.";
        error_log($msg);

        return true;
    }
}
