<?php
include_once("getAjustes.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnRecibir00'])) {
    $codigo_tramite = $_POST['codigo_tramite'] ?? '';
    $area_origen = $_POST['area_origen'] ?? '';
    $area_destino = $_POST['area_destino'] ?? '';
    $num_documento = $_POST['num_documento'] ?? '';

    // Configurar la zona horaria
    date_default_timezone_set('America/Lima');

    // Capturar fecha
    $fechaRegistro = date('Y-m-d');

    // Variable de formato: puedes poner 1 o 2 según tu necesidad
    $formato = 2; // Cambia a 2 para ver el otro formato

    // Elegir formato de hora según valor de $formato
    if ($formato == 1) {
        // Formato 24 horas, ejemplo: 13:00
        $horaRegistro = date('H:i');
    } elseif ($formato == 2) {
        // Formato 12 horas con am/pm separado por guion, ejemplo: 01:00 - pm
        $horaRegistro = date('h:i') . '-' . date('a');
    } else {
        // Valor no válido: puedes lanzar error o asignar valor por defecto
        $horaRegistro = 'Formato no válido';
    }

    $getAjustes = new GetAjustes;
    $getAjustes->RecibirTramiteExterno($codigo_tramite, $area_origen, $area_destino, $num_documento, $horaRegistro, $fechaRegistro);

    echo json_encode([
        'flag' => $getAjustes->success,
        'message' => $getAjustes->message,
        'redirect' => $getAjustes->success ? 'homeAdmin.php' : null
    ]);
    exit;
}

// Si no es POST válido o botón no existe
echo json_encode([
    'flag' => false,
    'message' => 'Solicitud no válida'
]);
