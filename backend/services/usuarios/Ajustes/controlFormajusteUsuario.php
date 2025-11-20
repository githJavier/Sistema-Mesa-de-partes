<?php
include_once("getAjustes.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnEditar'])) {
    $id = $_POST['id'] ?? '';
    $tipoDocumento = $_POST['tipoDocumento'] ?? '';
    $numeroDocumento = $_POST['numeroDocumento'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellidoPaterno = $_POST['apellidoPaterno'] ?? '';
    $apellidoMaterno = $_POST['apellidoMaterno'] ?? '';
    $tipoUsuario = $_POST['tipoUsuario'] ?? '';
    $estadoUsuario = $_POST['estadoUsuario'] ?? '';
    $areaUsuario = $_POST['areaUsuario'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';
    $password = $_POST['password'] ?? '';
    if (empty($password)) {
        $claveHash = '';
    } else {
        // $claveHash = password_hash($password, PASSWORD_BCRYPT);
        $claveHash = md5($password);
    }

    $getAjustes = new GetAjustes;
    $getAjustes->actualizarRegistroUsuario($id, $tipoDocumento, $numeroDocumento, $nombre, $apellidoPaterno, $apellidoMaterno, $tipoUsuario, $estadoUsuario, $areaUsuario, $usuario, $claveHash);

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
