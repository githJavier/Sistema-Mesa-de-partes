<?php 
// Configuración para evitar warnings deprecated
error_reporting(0);  // Desactiva TODOS los errores/warnings
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

// Captura toda salida para evitar que se mezcle con JSON
ob_start();

// Incluir archivos (puedes usar @ para suprimir warnings)
@include_once("getConsultarTramitesDerivados.php");
@include_once("../IngresarTramite/getIngresarTramite.php");
@include_once("../../views/dashboard/formConsultarTramitesDerivados.php");

// Instanciar objetos
$getConsultarTramitesDerivados = new GetConsultarTramitesDerivados;
$tramites = $getConsultarTramitesDerivados->obtenerTramitesDerivados();
$getIngresarTramite = new GetIngresarTramite;
$tiposDocumento = $getIngresarTramite->obtenerTipoDocumento();
$formConsultarTramitesDerivados = new formConsultarTramitesDerivados;

// SOLO UNA VEZ - Corregido el nombre de la variable:
$formulario = $formConsultarTramitesDerivados->formConsultarTramitesDerivadosShow($tramites, $tiposDocumento);
// ↑↑↑ NOTA: Eliminé la línea duplicada con error tipográfico ↑↑↑

// Limpia cualquier salida que haya quedado
$output = ob_get_clean();

// Verifica si el formulario se generó correctamente
if (empty($formulario)) {
    // Hubo un error al generar el formulario
    echo json_encode([
        'flag' => 0,
        'error' => 'No se pudo generar el formulario',
        'output' => substr($output, 0, 300) // Para debug
    ]);
    exit;
}

// Éxito - devuelve el formulario HTML
echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    
?>