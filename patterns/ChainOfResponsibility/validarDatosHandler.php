<?php

namespace Patterns\ChainOfResponsibility;

class ValidarDatosHandler extends BaseHandler {

    public function handle(array $request) {

        if (empty($request['asunto'])) {
            throw new \Exception("El campo 'asunto' es obligatorio.");
        }

        if (empty($request['descripcion'])) {
            throw new \Exception("El campo 'descripcion' es obligatorio.");
        }

        // Si todo ok, continúa la cadena
        return parent::handle($request);
    }
}
