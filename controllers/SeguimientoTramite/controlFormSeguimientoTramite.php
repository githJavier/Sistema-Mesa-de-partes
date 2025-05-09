<?php 
include_once("../../views/dashboard/formSeguimientoTramite.php");

$formSegumientoTramite = new formSeguimientoTramite;
$formulario = $formSegumientoTramite->formSeguimientoTramiteShow();


echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>