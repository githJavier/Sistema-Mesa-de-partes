<?php
include_once("getArchivarTramite.php");

// Validar método y botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnArchivarTramite'])) {

    $getTramite = new GetArchivarTramite;

    // Captura de campos enviados por FormData
    $btnArchivarTramite = 'btnArchivarTramite';
    $fecha_archivo      = $_POST['fecha_archivo']     ?? null;
    $hora_archivo       = $_POST['hora_archivo']      ?? null;
    $expediente         = $_POST['expediente']        ?? null;
    $asunto_archivo     = $_POST['asunto_archivo']    ?? null;
    $motivo_archivo     = $_POST['motivo_archivo']    ?? null;
    $numero_documento   = $_POST['numero_documento']  ?? null;

    // Zona horaria y fecha/hora actual
    date_default_timezone_set('America/Lima');
    $fechaRegistro = date('Y-m-d');

    // Elegir formato de hora
    $formato = 2; // 1 = 24h | 2 = 12h con am/pm
    if ($formato == 1) {
        $horaRegistro = date('H:i');
    } elseif ($formato == 2) {
        $horaRegistro = date('h:i') . '-' . date('a');
    } else {
        $horaRegistro = 'Formato no válido';
    }

    if ($getTramite->validarBoton($btnArchivarTramite)) {
        if ($getTramite->validarMotivo($motivo_archivo)) {
            // Intentar archivar el trámite
            if ($getTramite->archivarTramite(
                $expediente,
                $fechaRegistro,
                $horaRegistro,
                $motivo_archivo,
                $numero_documento
            )) {
                echo json_encode([
                    'flag'     => 1,
                    'message'  => $getTramite->message,
                    'redirect' => 'homeAdmin.php'
                ]);
                exit;
            } else {
                echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
                exit;
            }
        } else {
            echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
            exit;
        }
    } else {
        echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
        exit;
    }
}

// Si no es POST válido o botón no existe
echo json_encode([
    'flag'    => 0,
    'message' => 'Solicitud no válida'
]);
