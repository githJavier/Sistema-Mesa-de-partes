<?php
require_once __DIR__ . '/getResolverMensajeAdmin.php';
require_once __DIR__ . '/../../utils/log_config.php';

header('Content-Type: application/json');

$getResolverMensajeAdmin = new GetResolverMensajeAdmin();

$id_ayuda = $_POST['id_ayuda'] ?? '';

if ($getResolverMensajeAdmin->validarBoton("btnResolverMensaje")) {

    if ($getResolverMensajeAdmin->validarIdAyuda($id_ayuda)) {

        if ($getResolverMensajeAdmin->marcarMensajeAdminComoResuelto($id_ayuda)) {

            echo json_encode([
                'flag' => 1
            ]);
            exit;

        } else {
            echo json_encode([
                'flag' => 0,
                'message' => $getResolverMensajeAdmin->message
            ]);
            exit;
        }

    } else {
        echo json_encode([
            'flag' => 0,
            'message' => $getResolverMensajeAdmin->message
        ]);
        exit;
    }

} else {
    echo json_encode([
        'flag' => 0,
        'message' => 'Solicitud no válida'
    ]);
    exit;
}
