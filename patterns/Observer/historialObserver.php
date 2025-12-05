<?php

namespace Patterns\Observer;

class HistorialObserver implements Observer {

    public function update(array $data) {

        // Aquí podrías integrar tu modelo HistorialModel
        // Por ahora dejamos un mensaje de simulación

        $msg = "Historial actualizado para trámite: {$data['id_tramite']}";
        error_log($msg);

        return true;
    }
}
