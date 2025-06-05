<?php
include_once("GetAjustes.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEliminar'])) {
    $id = $_POST['id'] ?? '';

    $getAjustes = new GetAjustes;
    $getAjustes->eliminarTipoDocumento($id);

    echo json_encode([
        'flag' => true,
        'message' => $getAjustes->message,
        'redirect' => 'homeAdmin.php'
    ]);
    exit;
}

echo json_encode([
    'flag' => false,
    'message' => 'Solicitud no válida'
]);
