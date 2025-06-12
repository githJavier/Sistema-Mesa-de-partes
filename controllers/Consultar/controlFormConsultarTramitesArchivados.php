<?php 
include_once("getConsultarTramitesArchivados.php");
include_once("../IngresarTramite/getIngresarTramite.php");
include_once("../../views/dashboard/formConsultarTramitesArchivados.php");

$getConsultarTramitesArchivados = new GetConsultarTramitesArchivados;
$tramites = $getConsultarTramitesArchivados->obtenerTramitesArchivados();
$getIngresarTramite = new GetIngresarTramite;
$tiposDocumento = $getIngresarTramite->obtenerTipoDocumento();
$formConsultarTramitesArchivados = new formConsultarTramitesArchivados;
$formulario = $formConsultarTramitesArchivados->formConsultarTramitesArchivadosShow($tramites, $tiposDocumento);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>