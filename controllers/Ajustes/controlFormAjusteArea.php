<?php
include_once("GetAjustes.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEditar'])) {
    $id = $_POST['id'] ?? '';
    $area = $_POST['area'] ?? '';

    $getAjustes = new GetAjustes;
    $getAjustes->actualizarRegistroArea($id, $area);

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
