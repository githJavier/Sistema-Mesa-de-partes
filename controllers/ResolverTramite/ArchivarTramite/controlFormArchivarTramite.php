<?php
include_once("../../../views/dashboard/formArchivarTramite.php");

header('Content-Type: application/json');

// Validar método POST y existencia del botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnArchivarTramite'])) {

    // Captura de datos del formulario
    $codigo_tramite = $_POST['codigo_tramite'] ?? '';
    $asunto         = $_POST['asunto']         ?? '';
    $num_documento  = $_POST['num_documento']  ?? '';

    // Configurar zona horaria
    date_default_timezone_set('America/Lima');

    // Fecha actual del sistema
    $fechaRegistro = date('Y-m-d');

    // Elegir formato de hora (1: 24h | 2: 12h con am/pm)
    $formato = 2;

    if ($formato == 1) {
        $horaRegistro = date('H:i');
    } elseif ($formato == 2) {
        $horaRegistro = date('h:i') . '-' . date('a');
    } else {
        $horaRegistro = 'Formato no válido';
    }

    // Generar formulario para archivar el trámite
    $formArchivarTramites = new GetFormArchivarTramite;
    $formulario = $formArchivarTramites->formArchivarTramiteShow(
        $codigo_tramite,
        $asunto,
        $fechaRegistro,
        $horaRegistro,
        $num_documento
    );

    echo json_encode([
        'flag'           => 1,
        'formularioHTML' => $formulario
    ]);
    exit;
}

// Si no es POST válido o falta el botón, devolver respuesta genérica
echo json_encode([
    'flag'    => 0,
    'message' => 'Solicitud no válida'
]);