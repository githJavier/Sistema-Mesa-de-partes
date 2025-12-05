<?php

namespace Patterns\ChainOfResponsibility;

class GuardarTramiteHandler extends BaseHandler {

    public function handle(array $request) {

        // Aquí NO rompemos nada del sistema. Solo demostramos la inserción.
        // Idealmente, llamas a tu modelo existente, por ejemplo:
        // $model = new TramiteModel();
        // $request['id_tramite'] = $model->guardar($request);

        // Simulación de guardado:
        $request['id_tramite'] = rand(1000, 9999);

        return parent::handle($request);
    }
}
