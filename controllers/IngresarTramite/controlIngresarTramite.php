<?php
include_once("getIngresarTramite.php");

$getTramite = new GetIngresarTramite;
// captura de tipo de tramite (como viene de afuera se le coloca externo)
$tipoTramite = "EXTERNO";
// Captura de campos enviados por FormData
$asunto = $_POST['asunto'] ?? null;
$tipoDocumento = $_POST['tipo_documento'] ?? null;
$numeroTramite = $_POST['numero_tramite'] ?? null;
$folios = $_POST['folios'] ?? null;
$remitente = $_POST['remitente'] ?? null;
$documento = $_FILES['DOCUMENTO_VIRTUAL'] ?? null;

// Configurar y capturar la hora
date_default_timezone_set('America/Lima');
$fechaRegistro = date('Y-m-d'); // Formato: 2025-05-06
$anio = date('Y'); //Capturar el año
$horaRegistro = date('H:i');    // Formato: 14:35

// Convertir hora a formato AM/PM
$horaNumerica = date('H'); // Obtiene solo la hora (00 a 23)
if ($horaNumerica >= 12) {
    $horaRegistro .= '-pm';
} else {
    $horaRegistro .= '-am';
}


if($getTramite->validarAsunto($asunto)){
    if($getTramite->validarTipoDocumento($tipoDocumento)){
        if($getTramite->validarNumeroTramite($numeroTramite)){
            if($getTramite->validarArchivo($documento)){
                if($getTramite->validarFolios($folios)){
                    //Nombre base para guardar el archivo
                    $nombre_base = $numeroTramite."-".$documento['name'];
                    //Guardar el archivo en la base de datos
                    if($getTramite->insertarTramite($tipoTramite, $anio, $numeroTramite,$tipoDocumento, $horaRegistro, $fechaRegistro,$remitente,$asunto)){
                        //mover el archivo
                        $rutaDestino = "../../uploads/tramites/" . basename($nombre_base);
                        $getTramite->moverArchivo($documento, $rutaDestino);
                        echo json_encode([
                            'flag' => 1,
                            'message' => "Envio de formulario exitoso",
                            'redirect' => "../../views/redireccion/home.php"
                        ]);
                    }
                    
                    
                }else{
                    echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
                    exit;
                }
            }else{
                echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
                exit;
            }
        }else{
            echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
            exit;
        }
    }else{
        echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
        exit;
    }
}else{
    echo json_encode(['flag' => 0, 'message' => $getTramite->message]);
    exit;
}

?>