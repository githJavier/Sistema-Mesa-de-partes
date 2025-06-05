<?php 
include_once("getResolverTramite.php");
include_once("../../views/dashboard/formResolverTramite.php");

$getResolverTramite = new GetResolverTramite;
$tramitesPorResolver = $getResolverTramite->obtenerTramitesPorResolver();
$formResolverTramites = new formResolverTramites;
$formulario = $formResolverTramites->formResolverTramitesShow($tramitesPorResolver);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    
?>