<?php
include_once("GetAjustes.php");

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $getAjustes = new GetAjustes();
    $remitente = $getAjustes->obtenerRemitenteId($id);

    if ($remitente) {
        echo json_encode(['success' => true, 'data' => $remitente]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró remitente']);
    }
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'ID no especificado']);
    exit;
}
?>
