<?php
require_once('getIngresarTramiteUsuario.php');
require_once('../Administracion/getAdministracion.php');
require_once('../../views/dashboard/formIngresarTramiteUsuario.php');

// Instanciar lógica para obtener datos del trámite
$getIngresarTramite = new GetIngresarTramiteUsuario;
$ultimoTramite      = $getIngresarTramite->asignarNumeroTramite();
$tipoDocumento      = $getIngresarTramite->obtenerTipoDocumento();

// Instanciar lógica para obtener datos administrativos
$getAdministracion  = new GetAdministracion();
$remitentes         = $getAdministracion->listarRemitentes();
$areas              = $getAdministracion->listarAreas();

// Instanciar y construir el formulario
$formIngresarTramite = new GetFormIngresarTramiteUsuario;
$formulario          = $formIngresarTramite->formIngresarTramiteUsuarioShow(
    $ultimoTramite,
    $tipoDocumento,
    $remitentes,
    $areas
);

// Devolver el formulario como respuesta JSON
echo json_encode([
    'flag'           => 1,
    'formularioHTML' => $formulario
]);
