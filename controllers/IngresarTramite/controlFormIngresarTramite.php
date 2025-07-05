<?php 
include_once("getIngresarTramite.php");
require_once '../../views/dashboard/formIngresarTramite.php';
require_once '../../views/dashboard/formAjustesDatos.php';
session_start();

$getIngresarTramite = new GetIngresarTramite;
$datosRemitente = $getIngresarTramite->obtenerDatosRemitente($_SESSION['usuario']);
// Verificar si los campos de $datosRemitente están vacíos
if (empty($datosRemitente['direccion']) || empty($datosRemitente['departamento']) || empty($datosRemitente['provincia'])|| empty($datosRemitente['distrito'])) {
    $formAjusteDatos = new GetFormAjustesDatos;
    $formulario  = $formAjusteDatos->formAjustesDatos($datosRemitente);
    echo json_encode([
        'flag' => 1,
        'message' => 'Para continuar con el trámite, por favor, asegúrate de completar toda tu información personal antes de proceder.',
        'formularioHTML' => $formulario
    ]);    
}else{
    $ultimoTramite = $getIngresarTramite->asignarNumeroTramite();
    $tipoDocumento = $getIngresarTramite->obtenerTipoDocumento();
    $formIngresarTramite = new GetFormIngresarTramite;
    $formulario = $formIngresarTramite->formIngresarTramiteShow($ultimoTramite,$tipoDocumento, $datosRemitente);
    echo json_encode([
        'flag' => 2,
        'formularioHTML' => $formulario
    ]);
}

?>