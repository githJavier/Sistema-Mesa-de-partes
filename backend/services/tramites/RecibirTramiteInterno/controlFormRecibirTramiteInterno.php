<?php 
require_once __DIR__ . '/getRecibirTramiteInterno.php';
require_once __DIR__ . '/../../../views/dashboard/formRecibirTramiteInterno.php';
session_start();

$area = $_SESSION['datos']['area'];
$getRecibirTramiteInterno = new GetRecibirTramiteInterno;
$tramitesInternos = $getRecibirTramiteInterno->obtenerTramitesInternos($area);
$formRecibirTramitesInternos = new formRecibirTramitesInternos;
$formulario = $formRecibirTramitesInternos->formRecibirTramitesInternosShow($tramitesInternos);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>