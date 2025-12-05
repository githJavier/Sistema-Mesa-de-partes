<?php

namespace Patterns\ChainOfResponsibility;

class ValidarUsuarioHandler extends BaseHandler {

    public function handle(array $request) {

        if (!isset($_SESSION['usuario_id'])) {
            throw new \Exception("Usuario no autenticado.");
        }

        // Puedes agregar validaciones adicionales si deseas

        return parent::handle($request);
    }
}
