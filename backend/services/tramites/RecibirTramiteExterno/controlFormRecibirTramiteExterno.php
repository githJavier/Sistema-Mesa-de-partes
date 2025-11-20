<?php 
require_once __DIR__ . '/getRecibirTramiteExterno.php';
require_once __DIR__ . '/../../../views/dashboard/formRecibirTramiteExterno.php';

$getRecibirTramiteExterno = new GetRecibirTramiteExterno;
$tramitesExternos = $getRecibirTramiteExterno->obtenerTramitesExternos();
$formRecibirTramitesExternos = new formRecibirTramitesExternos;
$formulario = $formRecibirTramitesExternos->formRecibirTramitesExternosShow($tramitesExternos);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>