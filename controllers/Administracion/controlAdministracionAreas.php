<?php 
include_once("../../views/dashboard/formAdministrarAreas.php");

$formAdministrarAreas = new formAdministrarAreas;
$formulario = $formAdministrarAreas->formAdministrarAreasShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>