<?php 
include_once("../../views/dashboard/formAdministrarUsuarios.php");

$formAdministrarUsuarios = new formAdministrarUsuarios;
$formulario = $formAdministrarUsuarios->formAdministrarUsuariosShow();

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>