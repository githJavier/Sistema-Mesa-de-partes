<?php
require_once('getIngresarTramite.php');
require_once('../../views/dashboard/formIngresarTramite.php');
require_once('../../views/dashboard/formAjustesDatos.php');
session_start();

// Instanciar lógica del trámite
$getIngresarTramite = new GetIngresarTramite;

// Obtener datos del remitente desde sesión
$datosRemitente = $getIngresarTramite->obtenerDatosRemitente($_SESSION['usuario']);

// Validar si hay datos personales incompletos
if (
    empty($datosRemitente['direccion']) ||
    empty($datosRemitente['departamento']) ||
    empty($datosRemitente['provincia']) ||
    empty($datosRemitente['distrito'])
) {
    // Cargar formulario para completar datos personales
    $formAjusteDatos = new GetFormAjustesDatos;
    $formulario = $formAjusteDatos->formAjustesDatos($datosRemitente);

    echo json_encode([
        'flag'           => 1,
        'message'        => 'Para continuar con el trámite, por favor, asegúrate de completar toda tu información personal antes de proceder.',
        'formularioHTML' => $formulario
    ]);
} else {
    // Obtener número de trámite y tipo de documento
    $ultimoTramite     = $getIngresarTramite->asignarNumeroTramite();
    $tipoDocumento     = $getIngresarTramite->obtenerTipoDocumento();

    // Cargar formulario para ingreso del trámite
    $formIngresarTramite = new GetFormIngresarTramite;
    $formulario = $formIngresarTramite->formIngresarTramiteShow($ultimoTramite, $tipoDocumento, $datosRemitente);

    echo json_encode([
        'flag'           => 2,
        'formularioHTML' => $formulario
    ]);
}
