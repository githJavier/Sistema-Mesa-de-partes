<?php

namespace Patterns\ChainOfResponsibility;

class EnviarNotificacionHandler extends BaseHandler {

    public function handle(array $request) {

        // Ejemplo de notificación simulada:
        // En un sistema real puedes llamar a tu clase NotificacionModel
        // NOTA: No afecta al sistema actual.

        // $notificacion = new NotificacionModel();
        // $notificacion->enviar($request['id_tramite'], "Trámite registrado");

        // Solo simula una notificación:
        $request['notificacion'] = "Notificación enviada correctamente";

        return parent::handle($request);
    }
}
