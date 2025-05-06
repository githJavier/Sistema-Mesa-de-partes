<?php
include_once("getIngresarTramite.php");

$getTramite = new GetIngresarTramite;

// Captura de campos enviados por FormData
$asunto = $_POST['asunto'] ?? null;
$tipoDocumento = $_POST['tipo_documento'] ?? null;
$numeroTramite = $_POST['numero_tramite'] ?? null;
$folios = $_POST['folios'] ?? null;
$documento = $_FILES['DOCUMENTO_VIRTUAL'] ?? null;

if($getTramite->validarAsunto($asunto)){
    if($getTramite->validarTipoDocumento($tipoDocumento)){
        if($getTramite->validarNumeroTramite($numeroTramite)){
            if($getTramite->validarArchivo($documento)){
                if($getTramite->validarFolios($folios)){
                    //mover el archivo
                    $rutaDestino = "../../uploads/tramites/" . basename($numeroTramite."-".$documento['name']);
                    $getTramite->moverArchivo($documento, $rutaDestino);
                    echo json_encode([
                        'flag' => 1,
                        'message' => "Envio de formulario exitoso",
                        'redirect' => "../../views/redireccion/home.php"
                    ]);
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