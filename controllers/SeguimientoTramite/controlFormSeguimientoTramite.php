<?php
include_once("getSeguimientoTramite.php");
include_once("../IngresarTramite/getIngresarTramite.php");
include_once("../../views/dashboard/formSeguimientoTramite.php");

$getSeguimientoTramite = new GetSeguimientoTramite;
$tramites = $getSeguimientoTramite->obtenerMisTramites();
$getIngresarTramite = new GetIngresarTramite;
$tiposDocumento = $getIngresarTramite->obtenerTipoDocumento();
$formSegumientoTramite = new formSeguimientoTramite;
$formulario = $formSegumientoTramite->formSeguimientoTramiteShow($tramites, $tiposDocumento);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>