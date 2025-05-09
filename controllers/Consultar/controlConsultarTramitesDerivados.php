<?php 
include_once("../../views/dashboard/formConsultarTramitesDerivados.php");

$formConsultarTramitesDerivados = new formConsultarTramitesDerivados;
$formulario = $formConsultarTramitesDerivados->formConsultarTramitesDerivadosShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>