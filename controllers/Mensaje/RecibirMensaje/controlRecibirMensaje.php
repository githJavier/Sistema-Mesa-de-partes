<?php
require_once __DIR__ . '/getRecibirMensaje.php';
require_once __DIR__ . '/../../../utils/log_config.php';
require_once __DIR__ . '/../../../views/dashboard/formResponderMensajeAdmin.php';

header('Content-Type: text/html'); // Esto es importante

$id_ayuda = $_POST['idAyuda'] ?? '';
$ultimoIdMensaje = $_POST['ultimoIdMensaje'] ?? 0;

$getRecibirMensaje = new GetRecibirMensaje();

if ($getRecibirMensaje->validarIdAyuda($id_ayuda)) {

    $mensajesChat = $getRecibirMensaje->obtenerMensajesRecientes($id_ayuda, $ultimoIdMensaje);

    if ($mensajesChat !== false) {
        // Solo renderizamos la parte del chat actualizada
        $html = '';
        foreach ($mensajesChat as $mensaje) {
            $html .= '<div class="rma-message-wrapper ' 
                . ($mensaje['remitente_tipo'] === 'admin' ? 'rma-message-admin' : 'rma-message-remitente') 
                . '" data-id-mensaje="' . htmlspecialchars($mensaje['id']) . '">';

            $html .=     '<div class="rma-message-bubble">';
            $html .=         '<p class="rma-message-text">' . nl2br(htmlspecialchars($mensaje['mensaje'])) . '</p>';
            $html .=         '<span class="rma-message-time">' . htmlspecialchars($mensaje['fecha']) . ' ' . substr($mensaje['hora'], 0, 5) . '</span>';
            $html .=     '</div>';

            $html .= '</div>';
        }
        echo $html;
        exit;
    } else {
        echo '<div class="rma-chat-empty"><i class="fas fa-comments rma-chat-empty-icon"></i><p>Error al obtener mensajes.</p></div>';
        exit;
    }

} else {
    echo '<div class="rma-chat-empty"><i class="fas fa-comments rma-chat-empty-icon"></i><p>Solicitud inválida.</p></div>';
    exit;
}
