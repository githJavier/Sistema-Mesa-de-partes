<?php
require_once __DIR__ . '/../../views/dashboard/formResponderMensajeAdmin.php';
require_once __DIR__ . '/getResponderMensajeAdmin.php';
require_once __DIR__ . '/../../utils/log_config.php';

header('Content-Type: application/json');

$getResponderMensajeAdmin = new GetResponderMensajeAdmin();
$formResponderMensajeAdmin = new GetFormResponderMensajeAdmin();

$id_ayuda = $_POST['id_ayuda'] ?? '';

if ($getResponderMensajeAdmin->validarBoton("btnAbrirChatResponderMensajeAdmin")) {

    if ($getResponderMensajeAdmin->validarIdAyuda($id_ayuda)) {

        if ($consultaAyuda = $getResponderMensajeAdmin->obtenerAyudaYRemitentePorIdAyuda($id_ayuda)) {
            
            $datosAyuda = $consultaAyuda['ayuda'];
            $datosRemitente = $consultaAyuda['remitente'];

            $mensajesChat = $getResponderMensajeAdmin->obtenerMensajesPorIdAyuda($id_ayuda);

            // Puedes pasar datos reales en lugar de arrays vacíos si los necesitas
            $formulario = $formResponderMensajeAdmin->formResponderMensajeAdminShow(
                $datosAyuda,
                $datosRemitente,
                $mensajesChat
            );

            echo json_encode([
                'flag' => 1,
                'formularioHTML' => $formulario
            ]);
            exit;

        } else {
            echo json_encode([
                'flag' => 0,
                'message' => $getResponderMensajeAdmin->message
            ]);
            exit;
        }

    } else {
        echo json_encode([
            'flag' => 0,
            'message' => $getResponderMensajeAdmin->message
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
