<?php 
include_once("../../views/dashboard/formAdministrarRemitentes.php");
include("getAdministracion.php");

$formAdministrarRemitentes = new formAdministrarRemitentes;
$getAdministracion = new GetAdministracion();

$remitentes = $getAdministracion->listarRemitentes();

if (!empty($remitentes)) {
    $formulario = $formAdministrarRemitentes->formAdministrarRemitentesShow($remitentes);
    echo json_encode([
        'flag' => 1,
        'formularioHTML' => $formulario
    ]);
} else {
    echo json_encode([
        'flag' => 0,
        'message' => $getAdministracion->message
    ]);
}
