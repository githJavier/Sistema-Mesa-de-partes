<?php
include_once("getAjustes.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEditar'])) {
    $id = $_POST['id'] ?? '';
    $tipoDocumento = $_POST['tipoDocumento'] ?? '';
    $abreviatura = $_POST['abreviatura'] ?? '';

    $getAjustes = new GetAjustes;
    $getAjustes->actualizarRegistroTipoDocumento($id, $tipoDocumento, $abreviatura);

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
