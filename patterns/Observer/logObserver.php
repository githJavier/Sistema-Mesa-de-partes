<?php

namespace Patterns\Observer;

class LogObserver implements Observer {

    public function update(array $data) {

        $log = "[" . date('Y-m-d H:i:s') . "] Tramite procesado: ID " . $data['id_tramite'] . "\n";

        file_put_contents(__DIR__ . '/../../logs/observer.log', $log, FILE_APPEND);

        return true;
    }
}
