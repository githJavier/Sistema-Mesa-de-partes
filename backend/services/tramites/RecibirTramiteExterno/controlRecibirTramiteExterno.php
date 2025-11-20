<?php
require_once __DIR__ . '/getRecibirTramiteExterno.php';

header('Content-Type: application/json');

$getRecibirTramiteExterno = new GetRecibirTramiteExterno();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRecibir00'])) {
    $codigo_tramite = $_POST['codigo_tramite'] ?? '';
    $area_origen    = $_POST['area_origen'] ?? '';
    $area_destino   = $_POST['area_destino'] ?? '';
    $num_documento  = $_POST['num_documento'] ?? '';

    // Zona horaria y fecha actual
    date_default_timezone_set('America/Lima');
    $fechaRegistro = date('Y-m-d');

    // Formato de hora (1 = 24h, 2 = 12h am/pm)
    $formato = 2;
    $horaRegistro = match ($formato) {
        1 => date('H:i'),
        2 => date('h:i') . '-' . date('a'),
        default => 'Formato no válido'
    };

    if ($getRecibirTramiteExterno->validarBoton("btnRecibir00")) {
        if ($getRecibirTramiteExterno->RecibirTramiteExterno(
            $codigo_tramite, $area_origen, $area_destino, $num_documento, $horaRegistro, $fechaRegistro
        )) {
            echo json_encode([
                'flag'     => 1,
                'message'  => $getRecibirTramiteExterno->message,
                'redirect' => 'homeAdmin.php'
            ]);
            exit;
        }

        echo json_encode([
            'flag'    => 0,
            'message' => $getRecibirTramiteExterno->message
        ]);
        exit;
    }

    echo json_encode([
        'flag'    => 0,
        'message' => 'Solicitud no válida'
    ]);
    exit;
}

// Si no se recibió un POST válido
echo json_encode([
    'flag'    => 0,
    'message' => 'Solicitud no válida'
]);
