<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/getMensajeAdmin.php';
require_once __DIR__ . '/../../views/dashboard/formMensajeAdmin.php';

$formMensajeAdmin = new FormMensajeAdmin;
$getMensajeAdmin = new GetMensajeAdmin;
$consultas = $getMensajeAdmin->obtenerConsultasOrdenadasPorUltimoMensajeRemitente();
$formulario = $formMensajeAdmin->formMensajeAdminShow($consultas);

echo json_encode([
    'flag' => 1,
    'formularioHTML' => $formulario
]);    

?>