<?php
include_once("getIngresarTramite.php");

// Validar método y botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEnviarTramite'])) {

    $getTramite = new GetIngresarTramite;

    // Captura de tipo de trámite (externo por defecto)
    $tipoTramite = "EXTERNO";

    // Captura de campos enviados por FormData
    $btnEnviarTramite= 'btnEnviarTramite';
    $asunto          = $_POST['asunto'] ?? null;
    $tipoDocumento   = $_POST['tipo_documento'] ?? null;
    $numeroTramite   = $_POST['numero_tramite'] ?? null;
    $folios          = $_POST['folios'] ?? null;
    $comentario      = $_POST['comentario'] ?? ' ';
    $remitente       = $_POST['remitente'] ?? null;

    $area_origen     = "REMITENTE EXTERNO";
    $area_destino    = "OFICINA TRAMITE DOCUMENTARIO";

    // Captura del archivo subido
    $documento       = $_FILES['DOCUMENTO_VIRTUAL'] ?? null;
    $file            = $documento['name'];
    $file_loc        = $documento['tmp_name'];
    $file_size       = $documento['size'];
    $file_type       = $documento['type'];

    $folder          = "../../uploads/tramites";

    // Preparación de nombre final del archivo
    $new_size        = (float)$file_size / 1024;
    $new_file_name   = strtolower($file);
    $final_file      = str_replace(' ', '-', $new_file_name);

    // Nombre base del archivo en el servidor
    $tipo = "00R00"; // Es un código que hace referencia a archivo subido por remitente
    $nombre_base = $numeroTramite . "_" . $tipo . "_" . $final_file;

    // Zona horaria y fecha/hora actual
    date_default_timezone_set('America/Lima');
    $anio            = date('Y');
    $fechaRegistro   = date('Y-m-d');

    // Selección de formato de hora
    $formato = 2; // 1: 24h / 2: 12h con am-pm

    if ($formato == 1) {
        $horaRegistro = date('H:i');
    } elseif ($formato == 2) {
        $horaRegistro = date('h:i') . '-' . date('a');
    } else {
        $horaRegistro = 'Formato no válido';
    }

    // Validaciones encadenadas del formulario
    if ($getTramite->validarBoton($btnEnviarTramite)) {
        if ($getTramite->validarAsunto($asunto)) {
            if ($getTramite->validarTipoDocumento($tipoDocumento)) {
                if ($getTramite->validarNumeroTramite($numeroTramite)) {
                    if ($getTramite->validarArchivo($documento)) {
                        if ($getTramite->validarFolios($folios)) {
                            // Intentar insertar el trámite
                            if ($getTramite->insertarTramite(
                                $tipoTramite,
                                $anio,
                                $numeroTramite,
                                $tipoDocumento,
                                $horaRegistro,
                                $fechaRegistro,
                                $remitente,
                                $asunto,
                                $folios,
                                $comentario,
                                $area_origen,
                                $area_destino,
                                $nombre_base,
                                $file_type,
                                $new_size
                            )) {
                                // Mover archivo a carpeta de destino
                                $rutaDestino = "../../uploads/tramites/" . basename($nombre_base);
                                if ($getTramite->moverArchivo($documento, $rutaDestino)) {
                                    // Archivo movido correctamente
                                    echo json_encode([
                                        'flag'     => 1,
                                        'message'  => "Trámite registrado y archivo subido correctamente.",
                                        'redirect' => "../../views/redireccion/home.php"
                                    ]);
                                    exit;
                                } else {
                                    echo json_encode([
                                        'flag'     => 1,
                                        'message'  => "Trámite registrado, pero hubo un error subiendo el archivo.",
                                        'redirect' => "../../views/redireccion/home.php"
                                    ]);
                                    exit;
                                }
                                exit;
                            } else {
                                echo json_encode([
                                    'flag'    => 0,
                                    'message' => $getTramite->message
                                ]);
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