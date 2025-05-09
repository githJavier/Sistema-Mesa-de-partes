<?php 
include_once("../../views/dashboard/formConsultarTramitesArchivados.php");

$formConsultarTramitesArchivados = new formConsultarTramitesArchivados;
$formulario = $formConsultarTramitesArchivados->formConsultarTramitesArchivadosShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>