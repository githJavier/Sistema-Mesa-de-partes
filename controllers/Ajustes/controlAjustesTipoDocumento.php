<?php
include_once("GetAjustes.php");

header('Content-Type: application/json');

$getAjustes = new GetAjustes();

if (isset($_GET['id'])) {
    $codigoTipoDocumento = intval($_GET['id']);
    $datosTipoDocumento = $getAjustes->obtenerTipoDocumentoId($codigoTipoDocumento);
    if ($datosTipoDocumento) {
        echo json_encode([
            'success' => true,
            'data' => [
                'tipoDocumento' => $datosTipoDocumento
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró el tipo de documento'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se especificó el ID del tipo de documento'
    ]);
}

exit;
?>
