<?php 
include_once("getRecibirTramiteExterno.php");
include_once("../../views/dashboard/formRecibirTramiteExterno.php");

$getRecibirTramiteExterno = new GetRecibirTramiteExterno;
$tramitesExternos = $getRecibirTramiteExterno->obtenerTramitesExternos();
$formRecibirTramitesExternos = new formRecibirTramitesExternos;
$formulario = $formRecibirTramitesExternos->formRecibirTramitesExternosShow($tramitesExternos);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>