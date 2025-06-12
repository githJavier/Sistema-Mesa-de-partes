<?php 
include_once("getConsultarTramitesDerivados.php");
include_once("../IngresarTramite/getIngresarTramite.php");
include_once("../../views/dashboard/formConsultarTramitesDerivados.php");

$getConsultarTramitesDerivados = new GetConsultarTramitesDerivados;
$tramites = $getConsultarTramitesDerivados->obtenerTramitesDerivados();
$getIngresarTramite = new GetIngresarTramite;
$tiposDocumento = $getIngresarTramite->obtenerTipoDocumento();
$formConsultarTramitesDerivados = new formConsultarTramitesDerivados;
$formulario = $formConsultarTramitesDerivados->formConsultarTramitesDerivadosShow($tramites, $tiposDocumento);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>