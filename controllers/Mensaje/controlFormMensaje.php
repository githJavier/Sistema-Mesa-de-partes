<?php 
include_once("../../views/dashboard/formMensaje.php");

$formMensaje = new formMensaje;
$formulario = $formMensaje->formMensajeShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>