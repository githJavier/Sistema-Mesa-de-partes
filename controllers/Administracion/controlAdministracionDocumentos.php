<?php 
include_once("../../views/dashboard/formAdministrarDocumentos.php");

$formAdministrarDocumentos = new formAdministrarDocumentos;
$formulario = $formAdministrarDocumentos->formAdministrarDocumentosShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>