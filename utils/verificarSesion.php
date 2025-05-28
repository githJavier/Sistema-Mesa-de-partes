<?php
session_start();
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

$conn = Conexion::conectarBD();

if (!isset($_SESSION['datos']['estado'])) {
    error_log('Sesión no iniciada o inválida');
    session_destroy();
    echo json_encode(['status' => 'no_session']);
    exit;
}

$num_doc = $_SESSION['datos']['num_doc'];
$sql = "SELECT estado FROM usuario WHERE num_doc = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $num_doc);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($row['estado'] != 1) {
        error_log('Usuario inactivo o eliminado');
        session_destroy();
        echo json_encode(['status' => 'inactive']);
        exit;
    } else {
        echo json_encode(['status' => 'active']);
        exit;
    }
} else {
    error_log('Usuario no encontrado');
    session_destroy();
    echo json_encode(['status' => 'not_found']);
    exit;
}
