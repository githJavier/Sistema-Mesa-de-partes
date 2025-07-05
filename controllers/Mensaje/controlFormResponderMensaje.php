<?php
require_once __DIR__ . '/../../views/dashboard/formResponderMensaje.php';
require_once __DIR__ . '/getResponderMensaje.php';
require_once __DIR__ . '/../../utils/log_config.php';

header('Content-Type: application/json');

$getResponderMensaje = new GetResponderMensaje();
$formResponderMensaje = new GetFormResponderMensaje();

$id_ayuda = $_POST['id_ayuda'] ?? '';

if ($getResponderMensaje->validarBoton("btnAbrirChatResponderMensaje")) {

    if ($getResponderMensaje->validarIdAyuda($id_ayuda)) {

        if ($consultaAyuda = $getResponderMensaje->obtenerAyudaYRemitentePorIdAyuda($id_ayuda)) {
            
            $datosAyuda = $consultaAyuda['ayuda'];
            $datosRemitente = $consultaAyuda['remitente'];

            $mensajesChat = $getResponderMensaje->obtenerMensajesPorIdAyuda($id_ayuda);

            // Puedes pasar datos reales en lugar de arrays vacíos si los necesitas
            $formulario = $formResponderMensaje->formResponderMensajeShow(
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
                'message' => $getResponderMensaje->message
            ]);
            exit;
        }

    } else {
        echo json_encode([
            'flag' => 0,
            'message' => $getResponderMensaje->message
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
