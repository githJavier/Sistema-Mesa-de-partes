<?php
include_once("getAjustes.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEditar'])) {
    $id = $_POST['id'] ?? '';
    $correo = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $clave = $_POST['password'] ?? '';
    $claveHash = password_hash($clave, PASSWORD_BCRYPT);

    $getAjustes = new GetAjustes;
    $getAjustes->actualizarRegistroRemitente($correo, $telefono, $claveHash, $id);

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
