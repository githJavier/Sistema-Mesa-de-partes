<?php

namespace Patterns\ChainOfResponsibility;

class FinalizarHandler extends BaseHandler {

    public function handle(array $request) {

        // Este handler solo devuelve el resultado final
        $request['estado_cadena'] = "Proceso completado";

        return parent::handle($request);
    }
}
