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
$comentario = $_POST['comentario'] ?? ' ';
$area_origen = "REMITENTE EXTERNO";
$area_destino = "OFICINA TRAMITE DOCUMENTARIO";
$remitente = $_POST['remitente'] ?? null;

$documento = $_FILES['DOCUMENTO_VIRTUAL'] ?? null;
$file = rand(1000,100000)."-".$documento['name'];
$file_loc = $documento['tmp_name'];
$file_size = $documento['size'];
$file_type = $documento['type'];
$folder="../../uploads/tramites";
// new file size in KB
$new_size = $file_size/1024;
// new file size in KB
// make file name in lower case
$new_file_name = strtolower($file);
// make file name in lower case
$final_file=str_replace(' ','-',$new_file_name);


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
                    if($getTramite->insertarTramite($tipoTramite, $anio, $numeroTramite,$tipoDocumento, $horaRegistro, $fechaRegistro, $remitente, $asunto, $folios, $comentario, $area_origen, $area_destino, $final_file, $file_type, $new_size)){
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