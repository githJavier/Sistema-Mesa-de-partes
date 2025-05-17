<?php 
include_once("../../views/dashboard/formAdministrarUsuarios.php");
include_once("getAdministracion.php");


$formAdministrarUsuarios = new formAdministrarUsuarios;
$getAdministracion = new GetAdministracion;
$usuarios = $getAdministracion->listarUsuarios();

if (!empty($usuarios)) {
    $formulario = $formAdministrarUsuarios->formAdministrarUsuariosShow($usuarios);
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
 

?>