<?php 
include_once("../../views/dashboard/formAdministrarDocumentos.php");
include_once("getAdministracion.php");

$formAdministrarDocumentos = new formAdministrarDocumentos;
$getAdministracion = new GetAdministracion();
$tiposDocumento = $getAdministracion->listarTiposDocumento();

$formulario = $formAdministrarDocumentos->formAdministrarDocumentosShow($tiposDocumento);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>