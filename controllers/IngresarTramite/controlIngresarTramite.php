<?php
include_once("getIngresarTramite.php");

// Validar método y botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEnviarTramite'])) {

    $getTramite = new GetIngresarTramite;

    // Tipo de trámite fijo
    $tipoTramite = "EXTERNO";

    // Captura de datos del formulario
    $btnEnviarTramite = 'btnEnviarTramite';
    $asunto           = $_POST['asunto']           ?? null;
    $tipoDocumento    = $_POST['tipo_documento']   ?? null;
    $numeroTramite    = $_POST['numero_tramite']   ?? null;
    $folios           = $_POST['folios']           ?? null;
    $remitente        = $_POST['remitente']        ?? null;

    // Datos fijos de área
    $area_origen      = "REMITENTE EXTERNO";
    $area_destino     = "OFICINA TRAMITE DOCUMENTARIO";

    // Captura del archivo adjunto
    $documento    = $_FILES['DOCUMENTO_VIRTUAL'] ?? null;
    $file         = $documento['name'];
    $file_loc     = $documento['tmp_name'];
    $file_size    = $documento['size'];
    $file_type    = $documento['type'];

    $new_size     = (float)$file_size / 1024;
    $new_file     = strtolower($file);
    $final_file   = str_replace(' ', '-', $new_file);

    // Construcción del nombre final del archivo
    $tipo          = "00INI00"; // Código para remitente
    $nombre_base   = $numeroTramite . "_" . $tipo . "_" . $final_file;
    $nombre_final  = $getTramite->limpiarNombreArchivo($nombre_base);

    // Configurar zona horaria y obtener fecha/hora
    date_default_timezone_set('America/Lima');
    $anio           = date('Y');
    $fechaRegistro  = date('Y-m-d');

    // Formato de hora: 1 = 24h, 2 = 12h
    $formato = 2;
    if ($formato == 1) {
        $horaRegistro = date('H:i');
    } elseif ($formato == 2) {
        $horaRegistro = date('h:i') . '-' . date('a');
    } else {
        $horaRegistro = 'Formato no válido';
    }

    // Validaciones encadenadas (cascada)
    if ($getTramite->validarBoton($btnEnviarTramite)) {
        if ($getTramite->validarAsunto($asunto)) {
            if ($getTramite->validarTipoDocumento($tipoDocumento)) {
                if ($getTramite->validarNumeroTramite($numeroTramite)) {
                    if ($getTramite->validarArchivo($documento)) {
                        if ($getTramite->validarFolios($folios)) {
                            if ($getTramite->moverArchivo($documento, $nombre_final)) {
                                // Insertar trámite en base de datos
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
                                    $area_origen,
                                    $area_destino,
                                    $nombre_final,
                                    $file_type,
                                    $new_size
                                )) {
                                    echo json_encode([
                                        'flag'     => 1,
                                        'message'  => "Trámite registrado y archivo subido correctamente.",
                                        'redirect' => "../../views/redireccion/home.php"
                                    ]);
                                    exit;
                                } else {
                                    echo json_encode(['flag' => 0, 'message' => '8'.$getTramite->message]);
                                    exit;
                                }
                            } else {
                                echo json_encode(['flag' => 0, 'message' => '7'.$getTramite->message]);
                                exit;
                            }
                        } else {
                            echo json_encode(['flag' => 0, 'message' => '6'.$getTramite->message]);
                            exit;
                        }
                    } else {
                        echo json_encode(['flag' => 0, 'message' => '5'.$getTramite->message]);
                        exit;
                    }
                } else {
                    echo json_encode(['flag' => 0, 'message' => '4'.$getTramite->message]);
                    exit;
                }
            } else {
                echo json_encode(['flag' => 0, 'message' => '3'.$getTramite->message]);
                exit;
            }
        } else {
            echo json_encode(['flag' => 0, 'message' => '2'.$getTramite->message]);
            exit;
        }
    } else {
        echo json_encode(['flag' => 0, 'message' => '1'.$getTramite->message]);
        exit;
    }
}

// Si no es una solicitud POST válida o falta el botón
echo json_encode([
    'flag'    => 0,
    'message' => 'Solicitud no válida'
]);
