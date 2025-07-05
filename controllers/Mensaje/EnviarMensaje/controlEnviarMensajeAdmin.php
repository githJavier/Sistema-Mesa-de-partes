<?php
require_once __DIR__ . '/getEnviarMensajeAdmin.php';
require_once __DIR__ . '/../../../utils/log_config.php';
header('Content-Type: application/json');

$getEnviarMensaje = new GetEnviarMensajeAdmin();

$mensaje = $_POST['mensaje'] ?? '';
$idAyuda = $_POST['idAyuda'] ?? '';
$idRemitente = $_POST['idRemitente'] ?? '';
$datos = $_SESSION['datos'];
$idUsuarioSistema = $datos['cod_usuario'] ?? '1';

if ($getEnviarMensaje->validarBoton("btnEnviarMensaje")) {
    if ($getEnviarMensaje->validarMensaje($mensaje)) {
        if ($tipo = $getEnviarMensaje->validarAdmin($datos)) {
            if ($getEnviarMensaje->registrarMensajeAyuda($idAyuda, $idRemitente, $idUsuarioSistema, $tipo, $mensaje)) {
                echo json_encode([
                    'flag' => 1
                ]);
                exit;
            } else {
                echo json_encode([
                    'flag' => 0,
                    'message' => $getEnviarMensaje->message
                ]);
                exit;
            }
        } else {
            echo json_encode([
                'flag' => 0,
                'message' => $getEnviarMensaje->message
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'flag' => 0,
            'message' => $getEnviarMensaje->message
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