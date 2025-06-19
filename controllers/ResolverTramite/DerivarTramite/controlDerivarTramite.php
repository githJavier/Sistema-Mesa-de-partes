<?php
include_once("getDerivarTramite.php");

// Validar método y botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnDerivarTramite'])) {

    $getTramite = new GetDerivarTramite;

    // Captura de campos enviados por FormData
    $btnDerivarTramite    = 'btnDerivarTramite';
    $fechaArchivo         = $_POST['fecha_archivo'] ?? null;
    $horaArchivo          = $_POST['hora_archivo'] ?? null;
    $numeroExpediente     = $_POST['expediente'] ?? null;
    $areaDestino          = $_POST['area_destino'] ?? null;
    $folios               = $_POST['folios'] ?? '';
    $motivoArchivo        = $_POST['motivo_archivo'] ?? null;
    $numeroDocumento      = $_POST['numero_documento'] ?? null;
    $codigoDetalleTramite = $_POST['codigo_detalle_tramite'] ?? null;

    // Verificar si se cargó un archivo
    $documento = $_FILES['documento_virtual'] ?? null;

    if ($documento) {
        // Generar un nombre único para el archivo
        $nombreOriginal   = $documento['name'];

        // Ruta temporal del archivo subido
        $rutaTemporal     = $documento['tmp_name'];

        // Propiedades del archivo
        $tamanoBytes      = $documento['size'];
        $tipoArchivo      = $documento['type'];

        // Convertir tamaño a kilobytes (KB)
        $tamanoKB         = $tamanoBytes / 1024;

        // Normalizar el nombre del archivo: minúsculas y sin espacios
        $nombreNormalizado = strtolower($nombreOriginal);
        $nombreFinal       = str_replace(' ', '-', $nombreNormalizado);

        // Nombre base del archivo en el servidor
        $tipo = "00DRV00"; // Es un código que hace referencia a archivo subido por usuario del sistema
        $nombre_base = $numeroExpediente . "_" . $tipo . "_" . $nombreFinal;
        $nombre_final = $getTramite->limpiarNombreArchivo($nombre_base);
    } else {
        // En caso no se haya subido un archivo
        $nombreFinal = null;
    }

    // Establecer la zona horaria local (Lima, Perú)
    date_default_timezone_set('America/Lima');

    // Obtener el año actual (útil para carpetas, archivos o metadatos)
    $anioActual = date('Y');

    // Obtener la fecha actual en formato 'YYYY-MM-DD'
    $fechaRegistro = date('Y-m-d');

    // Definir el formato de hora: 1 = 24 horas, 2 = 12 horas con am/pm
    $formatoHora = 2;

    // Obtener la hora actual según el formato elegido
    switch ($formatoHora) {
        case 1:
            // Ejemplo: 13:45
            $horaRegistro = date('H:i');
            break;

        case 2:
            // Ejemplo: 01:45 - pm
            $horaRegistro = date('h:i') . '-' . date('a');
            break;

        default:
            // En caso de formato inválido
            $horaRegistro = 'Formato no válido';
            break;
    }

    if ($getTramite->validarBoton($btnDerivarTramite)) {
        if ($getTramite->validarMotivo($motivoArchivo)) {
            if ($getTramite->validarAreaDestino($areaDestino)) {
                if ($getTramite->validarNumeroExpediente($numeroExpediente)) {
                    if ($getTramite->validarArchivo($documento)) {
                        if ($getTramite->validarFolios($folios)) {
                            if ($getTramite->moverArchivo($documento, $nombre_final)) {
                                // Intentar derivar el trámite
                                if ($getTramite->DerivarTramite(
                                    $numeroExpediente,
                                    $fechaRegistro,
                                    $horaRegistro,
                                    $areaDestino,
                                    $motivoArchivo,
                                    $numeroDocumento,
                                    $codigoDetalleTramite,
                                    $folios,
                                    $nombre_final,
                                    $tipoArchivo,
                                    $tamanoKB
                                )) {
                                    echo json_encode([
                                        'flag'     => 1,
                                        'message'  => "Trámite derivado y archivo subido correctamente.",
                                        'redirect' => "../../views/redireccion/home.php"
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