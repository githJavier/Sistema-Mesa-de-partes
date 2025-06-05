<?php 
include_once("../../views/dashboard/formAdministrarAreas.php");
include_once("getAdministracion.php");

$formAdministrarAreas = new formAdministrarAreas;
$getAdministracion = new GetAdministracion();
$areas = $getAdministracion->listarAreas();

$formulario = $formAdministrarAreas->formAdministrarAreasShow($areas);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>