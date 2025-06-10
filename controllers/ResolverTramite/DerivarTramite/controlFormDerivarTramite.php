<?php
include_once("../../../views/dashboard/formDerivarTramite.php");

header('Content-Type: application/json');

// Validar método POST y existencia del botón
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnDerivarTramite'])) {
    
    // Captura de datos del formulario    
    $codigo_tramite        = $_POST['codigo_tramite']       ?? '';
    $asunto                = $_POST['asunto']               ?? '';
    $num_documento         = $_POST['num_documento']        ?? '';
    $cod_detalle_tramite   = $_POST['cod_detalle_tramite']  ?? '';

    // Configurar la zona horaria
    date_default_timezone_set('America/Lima');

    // Capturar fecha
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

    // Generar formulario para derivar el trámite
    $formDerivarTramites = new GetFormDerivarTramite;
    $formulario = $formDerivarTramites->formDerivarTramiteShow(
        $codigo_tramite,
        $asunto,
        $fechaRegistro,
        $horaRegistro,
        $num_documento,
        $cod_detalle_tramite
    );

    echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
    ]);  
    exit;
}

// Si no es POST válido o falta el botón, devolver respuesta genérica
echo json_encode([
    'flag'    => 0,
    'message' => 'Solicitud no válida'
]);