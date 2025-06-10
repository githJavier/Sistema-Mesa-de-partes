<?php
session_start();
require_once __DIR__ . '/../utils/log_config.php';
require_once __DIR__ . '/../config/conexion.php';

header('Content-Type: application/json');

$conn = Conexion::conectarBD();

if (isset($_SESSION['datos']['num_doc'])) {
    error_log('Acceso denegado: un usuario del sistema intentó acceder como remitente.');
    session_destroy();
    echo json_encode(['status' => 'invalid_role']);
    exit;
}

if (!isset($_SESSION['usuario']) || !isset($_SESSION['datos']['tipo_remitente'])) {
    error_log('Sesión no iniciada o inválida');
    session_destroy();
    echo json_encode(['status' => 'no_session']);
    exit;
}

$num_doc = $_SESSION['usuario'];

$sql = "SELECT tipo_remitente, retipo_docu FROM remitente WHERE docu_num = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $num_doc);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['status' => 'found']);
    exit;
} else {
    error_log("Remitente no encontrado");
    session_destroy();
    echo json_encode(['status' => 'not_found']);
    exit;
}
