<?php
require_once('getIngresarTramiteUsuario.php');
require_once('../Administracion/getAdministracion.php');
require_once('../../views/dashboard/formIngresarTramiteUsuario.php');
session_start();

$miArea = $_SESSION['datos']['area'];

// Instanciar lógica para obtener datos del trámite
$getIngresarTramite = new GetIngresarTramiteUsuario;
$ultimoTramite      = $getIngresarTramite->asignarNumeroTramite();
$tipoDocumento      = $getIngresarTramite->obtenerTipoDocumento();

// Instanciar lógica para obtener datos administrativos
$getAdministracion  = new GetAdministracion();
$remitentes         = $getAdministracion->listarRemitentes();
$areas              = $getAdministracion->listarAreas();
$areasFiltradas = array_filter($areas, function($area) use ($miArea) {
    return $area['area'] !== $miArea;
});
$areasFiltradas = array_values($areasFiltradas); // <- Reindexa para que sea un array puro

// Instanciar y construir el formulario
$formIngresarTramite = new GetFormIngresarTramiteUsuario;
$formulario          = $formIngresarTramite->formIngresarTramiteUsuarioShow(
    $ultimoTramite,
    $tipoDocumento,
    $remitentes,
    $areasFiltradas
);

// Devolver el formulario como respuesta JSON
echo json_encode([
    'flag'           => 1,
    'formularioHTML' => $formulario
]);
