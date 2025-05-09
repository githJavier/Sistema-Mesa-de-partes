<?php 
include_once("../../views/dashboard/formAdministrarRemitentes.php");

$formAdministrarRemitentes = new formAdministrarRemitentes;
$formulario = $formAdministrarRemitentes->formAdministrarRemitentesShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>