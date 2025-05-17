<?php 
include_once("getConsultarTramitesArchivados.php");
include_once("../../views/dashboard/formConsultarTramitesArchivados.php");

$getConsultarTramitesArchivados = new GetConsultarTramitesArchivados;
$tramites = $getConsultarTramitesArchivados->obtenerTramitesArchivados();
$formConsultarTramitesArchivados = new formConsultarTramitesArchivados;
$formulario = $formConsultarTramitesArchivados->formConsultarTramitesArchivadosShow($tramites);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>