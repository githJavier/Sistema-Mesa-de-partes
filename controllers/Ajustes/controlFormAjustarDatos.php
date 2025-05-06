<?php
include_once("getAjustes.php");
require_once '../../views/dashboard/formAjustesDatos.php';
session_start();

$getAjustes = new GetAjustes;
$datosRemitente = $getAjustes->obtenerDatosRemitente($_SESSION['usuario']);
$formAjusteDatos = new GetFormAjustesDatos;
$formulario = $formAjusteDatos->formAjustesDatos($datosRemitente);

// Supongamos que tienes campos 'departamento', 'provincia' y 'distrito' en $datosRemitente
$departamento = isset($datosRemitente['departamento']) ? $datosRemitente['departamento'] : null;
$provincia = isset($datosRemitente['provincia']) ? $datosRemitente['provincia'] : null;
$distrito = isset($datosRemitente['distrito']) ? $datosRemitente['distrito'] : null;

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario,
    'departamento' => $departamento,  // Agregamos el departamento a la respuesta
    'provincia' => $provincia,  // Agregamos la provincia a la respuesta
    'distrito' => $distrito   // Agregamos el distrito a la respuesta
]);    
?>
