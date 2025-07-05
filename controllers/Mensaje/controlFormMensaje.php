<?php 
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/getMensaje.php';
require_once __DIR__ . '/../../views/dashboard/formMensaje.php';

$formMensaje = new FormMensaje;
$getMensaje = new GetMensaje;
$datos = $_SESSION['datos'];
$idUsuarioSistema = $datos['idremite'] ?? '1';
$consultas = $getMensaje->obtenerMisConsultasOrdenadasPorUltimoMensajeAdmin($idUsuarioSistema);
$formulario = $formMensaje->formMensajeShow($consultas);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>