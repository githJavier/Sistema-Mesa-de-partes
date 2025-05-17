<?php 
include_once("getConsultarTramitesDerivados.php");
include_once("../../views/dashboard/formConsultarTramitesDerivados.php");

$getConsultarTramitesDerivados = new GetConsultarTramitesDerivados;
$tramites = $getConsultarTramitesDerivados->obtenerTramitesDerivados();
$formConsultarTramitesDerivados = new formConsultarTramitesDerivados;
$formulario = $formConsultarTramitesDerivados->formConsultarTramitesDerivadosShow($tramites);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>