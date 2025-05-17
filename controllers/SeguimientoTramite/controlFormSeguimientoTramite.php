<?php
include_once("getSeguimientoTramite.php");
include_once("../../views/dashboard/formSeguimientoTramite.php");

$getSeguimientoTramite = new GetSeguimientoTramite;
$tramites = $getSeguimientoTramite->obtenerMisTramites();
$formSegumientoTramite = new formSeguimientoTramite;
$formulario = $formSegumientoTramite->formSeguimientoTramiteShow($tramites);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>