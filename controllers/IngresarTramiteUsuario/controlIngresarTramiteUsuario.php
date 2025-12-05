<?php
// Agrega esto JUSTO después de <?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../../utils/log_config.php';
include_once("getIngresarTramiteUsuario.php");
require_once('../../patterns/ChainOfResponsibility/validarDatosHandler.php');
require_once('../../patterns/ChainOfResponsibility/validarDatosHandler.php');
require_once('../../patterns/Observer/tramitesSubject.php');
session_start();

// Validar que sea una solicitud POST válida y que se haya presionado el botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEnviarTramiteUsuario'])) {

    $getTramite        = new GetIngresarTramiteUsuario;
    $btnEnviarTramite  = 'btnEnviarTramiteUsuario';

    // Captura de campos del formulario
    $asunto            = $_POST['asunto'] ?? null;
    $tipoTramite       = $_POST['tipo_tramite'] ?? null;
    $numeroTramite     = $_POST['numero_tramite'] ?? null;
    $tipoDocumento     = $_POST['tipo_documento'] ?? null;
    $folios            = $_POST['folios'] ?? null;
    $remitente         = $_POST['remitente'] ?? null;
    $urgente           = $_POST['urgente'] ?? null;
    $observacion       = $_POST['observacion'] ?? null;
    $descripcion       = $_POST['descripcion'] ?? null;

    $area_origen       = $_SESSION['datos']['area'];
    $area_destino      = $_POST['unidad_organica_destino'] ?? null;
    $cod_usuario       = $_SESSION['datos']['cod_usuario'];

    // Captura del archivo subido
    $documento         = $_FILES['DOCUMENTO_VIRTUAL'] ?? null;
    $file              = $documento['name'];
    $file_loc          = $documento['tmp_name'];
    $file_size         = $documento['size'];
    $file_type         = $documento['type'];

    $new_size          = (float)$file_size / 1024;
    $new_file_name     = strtolower($file);
    $final_file        = str_replace(' ', '-', $new_file_name);

    // Preparación de fecha y hora de registro
    date_default_timezone_set('America/Lima');
    $anio              = date('Y');
    $fechaRegistro     = date('Y-m-d');
    $formato           = 2; // 1: 24h | 2: 12h am/pm

    if ($formato == 1) {
        $horaRegistro = date('H:i');
    } elseif ($formato == 2) {
        $horaRegistro = date('h:i') . '-' . date('a');
    } else {
        $horaRegistro = 'Formato no válido';
    }

    //ChainOfResponsibility
    $validarUsuarioHandler = new ValidarUsuarioHandler();
    if($validarUsuarioHandler->handle($_SESSION['usuario_id'])){
        $validarDatosHandler = new ValidarDatosHandler();
        if($validarDatosHandler->handle([$asunto]) && $validarDatosHandler->handle([$descripcion])){
            // Validaciones encadenadas (tipo cascada)
            if ($getTramite->validarBoton($btnEnviarTramite)) {
                if ($getTramite->validarAsunto($asunto)) {
                    if ($getTramite->validarTipoTramite($tipoTramite)) {
                        if ($getTramite->validarNumeroTramite($numeroTramite)) {
                            if (!$getTramite->verificarDisponibilidadCodigoTramite($numeroTramite)) {
                                do {
                                    $ultimoTramite = $getTramite->asignarNumeroTramite();
                                    if($tipoTramite === 'INTERNO'){
                                        $numeroTramite = $ultimoTramite['codigo_interno'];
                                    } else {
                                        $numeroTramite = $ultimoTramite['codigo_externo'];
                                    }
                                    $disponible = $getTramite->verificarDisponibilidadCodigoTramite($numeroTramite);
                                } while (!$disponible);
                            }
                            // Construcción del nombre final del archivo
                            $tipo              = "00INI00"; // Código fijo que representa usuario
                            $nombre_base       = $numeroTramite . "_" . $tipo . "_" . $final_file;
                            $nombre_final      = $getTramite->limpiarNombreArchivo($nombre_base);
                            if ($getTramite->validarAreaDestino($area_destino)) {
                                if ($getTramite->validarTipoDocumento($tipoDocumento)) {
                                    if ($getTramite->validarArchivo($documento)) {
                                        if ($getTramite->validarFolios($folios)) {
                                            if ($getTramite->validarRemitente($remitente)) {
                                                if ($getTramite->validarUrgencia($urgente)) {
                                                    $TramiteEnvioObserver = new TramiteSubject();
                                                    if ($TramiteEnvioObserver->attach($observacion)) {
                                                        if ($getTramite->moverArchivo($documento, $nombre_final)) {
                                                            // Registro del trámite en base de datos
                                                            if (
                                                                $getTramite->insertarTramiteUsuario(
                                                                    $tipoTramite,
                                                                    $anio,
                                                                    $numeroTramite,
                                                                    $tipoDocumento,
                                                                    $horaRegistro,
                                                                    $fechaRegistro,
                                                                    $remitente,
                                                                    $asunto,
                                                                    $folios,
                                                                    "",
                                                                    $area_origen,
                                                                    $area_destino,
                                                                    $cod_usuario,
                                                                    $urgente,
                                                                    $nombre_final,
                                                                    $file_type,
                                                                    $new_size
                                                                )
                                                            ) {
                                                                echo json_encode([
                                                                    'flag'     => 1,
                                                                    'message'  => "Trámite registrado y archivo subido correctamente.",
                                                                    'redirect' => "../../views/redireccion/homeAdmin.php"
                                                                ]);
                                                                exit;
                                                            } else {
                                                                echo json_encode([
                                                                    'flag'    => 0,
                                                                    'message' => $getTramite->message
                                                                ]);
                                                                exit;
                                                            }
                                                        } else {
                                                            echo json_encode([
                                                                'flag'    => 0,
                                                                'message' => $getTramite->message
                                                            ]);
                                                            exit;
                                                        }
                                                    } else {
                                                        echo json_encode([
                                                            'flag'    => 0,
                                                            'message' => $getTramite->message
                                                        ]);
                                                        exit;
                                                    }
                                                } else {
                                                    echo json_encode([
                                                        'flag'    => 0,
                                                        'message' => $getTramite->message
                                                    ]);
                                                    exit;
                                                }
                                            } else {
                                                echo json_encode([
                                                    'flag'    => 0,
                                                    'message' => $getTramite->message
                                                ]);
                                                exit;
                                            }
                                        } else {
                                            echo json_encode([
                                                'flag'    => 0,
                                                'message' => $getTramite->message
                                            ]);
                                            exit;
                                        }
                                    } else {
                                        echo json_encode([
                                            'flag'    => 0,
                                            'message' => $getTramite->message
                                        ]);
                                        exit;
                                    }
                                } else {
                                    echo json_encode([
                                        'flag'    => 0,
                                        'message' => $getTramite->message
                                    ]);
                                    exit;
                                }
                            } else {
                                echo json_encode([
                                    'flag'    => 0,
                                    'message' => $getTramite->message
                                ]);
                                exit;
                            }
                        } else {
                            echo json_encode([
                                'flag'    => 0,
                                'message' => $getTramite->message
                            ]);
                            exit;
                        }
                    } else {
                        echo json_encode([
                            'flag'    => 0,
                            'message' => $getTramite->message
                        ]);
                        exit;
                    }
                } else {
                    echo json_encode([
                        'flag'    => 0,
                        'message' => $getTramite->message
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    'flag'    => 0,
                    'message' => $getTramite->message
                ]);
                exit;
            }
        }
    }
}

// Si no es una solicitud POST válida o falta el botón
echo json_encode([
    'flag'    => 0,
    'message' => 'Solicitud no válida'
]);
