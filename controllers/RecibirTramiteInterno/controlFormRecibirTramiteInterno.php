<?php 
include_once("../../views/dashboard/formRecibirTramiteInterno.php");
include_once("getRecibirTramiteInterno.php");

$getRecibirTramiteInterno = new GetRecibirTramiteInterno;
$tramitesInternos = $getRecibirTramiteInterno->obtenerTramitesInternos('OFICINA TRAMITE DOCUMENTARIO');
$formRecibirTramitesInternos = new formRecibirTramitesInternos;
$formulario = $formRecibirTramitesInternos->formRecibirTramitesInternosShow($tramitesInternos);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>