<?php 
header('Content-Type: application/json; charset=utf-8');

// Captura toda salida para evitar que se mezcle con JSON
ob_start();

include_once("getConsultarTramitesArchivados.php");
include_once("../IngresarTramite/getIngresarTramite.php");
include_once("../../views/dashboard/formConsultarTramitesArchivados.php");

$getConsultarTramitesArchivados = new GetConsultarTramitesArchivados;
$tramites = $getConsultarTramitesArchivados->obtenerTramitesArchivados();
$getIngresarTramite = new GetIngresarTramite;
$tiposDocumento = $getIngresarTramite->obtenerTipoDocumento();
$formConsultarTramitesArchivados = new formConsultarTramitesArchivados;

// Captura la salida HTML en una variable
$formulario = $formConsultarTramitesArchivados->formConsultarTramitesArchivadosShow($tramites, $tiposDocumento);

// Limpia cualquier salida que haya quedado
$output = ob_get_clean();

// Ahora envía solo JSON
echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    
?>