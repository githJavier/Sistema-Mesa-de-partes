<?php 
include_once("../../views/dashboard/formAyuda.php");
include_once("../../views/dashboard/formAjustesDatos.php");
include_once("getAyuda.php");
session_start();

$getAyuda = new GetAyuda;
$datosRemitente = $getAyuda->obtenerDatosRemitente($_SESSION['usuario']);
// Verificar si los campos de $datosRemitente están vacíos
if (empty($datosRemitente['direccion']) || empty($datosRemitente['departamento']) || empty($datosRemitente['provincia'])|| empty($datosRemitente['distrito'])) {
    $formAjusteDatos = new GetFormAjustesDatos;
    $formulario  = $formAjusteDatos->formAjustesDatos($datosRemitente);
    echo json_encode([
        'flag' => 1,
        'message' => 'Para continuar con la consulta, por favor, asegúrate de completar toda tu información personal antes de proceder.',
        'formularioHTML' => $formulario
    ]);    
}else{
    $formAyuda = new formAyuda;
    $formulario = $formAyuda->formAyudaShow($datosRemitente);

    echo json_encode([
        'flag' => 2,
        'formularioHTML' => $formulario
    ]);    

}


?>