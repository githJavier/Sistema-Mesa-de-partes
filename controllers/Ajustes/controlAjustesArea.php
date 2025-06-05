<?php
include_once("GetAjustes.php");

header('Content-Type: application/json');

$getAjustes = new GetAjustes();

if (isset($_GET['id'])) {
    $codigoArea = intval($_GET['id']);
    $datosArea = $getAjustes->obtenerAreaId($codigoArea);
    if ($datosArea) {
        echo json_encode([
            'success' => true,
            'data' => [
                'area' => $datosArea
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró el area'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se especificó el ID del area'
    ]);
}

exit;
?>
