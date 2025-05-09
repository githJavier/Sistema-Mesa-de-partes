<?php 
include_once("../../views/dashboard/formAyuda.php");

$formAyuda = new formAyuda;
$formulario = $formAyuda->formAyudaShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>