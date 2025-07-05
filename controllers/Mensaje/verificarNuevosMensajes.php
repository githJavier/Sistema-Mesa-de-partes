<?php
require_once __DIR__ . '/../../utils/log_config.php';
include_once("../../models/ayuda.php");
session_start();

$idRemitente = $_SESSION['datos']['idremite'];
header('Content-Type: application/json');

// Obtenemos la fecha-hora de la última actividad conocida (en formato YYYY-MM-DD HH:MM:SS)
$ultimaActividad = isset($_GET['ultima_actividad']) ? $_GET['ultima_actividad'] : null;

if (!$ultimaActividad) {
    echo json_encode(['error' => 'Falta el parámetro de última actividad']);
    exit;
}

$objAyuda = new Ayuda();
$conexion = Conexion::conectarBD();

// Consulta SQL limitada por el id del remitente de la sesión
$sql = "
    SELECT 
        a.id_ayuda, a.asunto, a.mensaje, a.fecha, a.hora,
        a.fecha_ultimo_mensaje_admin, a.hora_ultimo_mensaje_admin,
        a.estado,
        r.idremite, r.tipo_remitente, r.retipo_docu, r.docu_num, r.nombres,
        r.correo, r.telefono_celular, r.departamento, r.provincia, r.distrito
    FROM ayuda a
    LEFT JOIN remitente r ON a.id_remitente = r.idremite
    WHERE 
        a.id_remitente = ?
        AND COALESCE(
            CONCAT(a.fecha_ultimo_mensaje_admin, ' ', a.hora_ultimo_mensaje_admin),
            CONCAT(a.fecha, ' ', a.hora)
        ) > ?
    ORDER BY 
        COALESCE(a.fecha_ultimo_mensaje_admin, a.fecha) DESC,
        COALESCE(a.hora_ultimo_mensaje_admin, a.hora) DESC
";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("is", $idRemitente, $ultimaActividad);
$stmt->execute();
$resultado = $stmt->get_result();

$nuevos = [];
while ($fila = $resultado->fetch_assoc()) {
    $nuevos[] = $fila;
}

$stmt->close();
Conexion::desconectarBD();

echo json_encode(['nuevos' => $nuevos]);
