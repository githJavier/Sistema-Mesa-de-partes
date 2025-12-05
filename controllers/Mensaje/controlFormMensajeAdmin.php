<?php
// 1. HEADER JSON PRIMERO - ESTO ES ESENCIAL
header('Content-Type: application/json; charset=utf-8');

// 2. DESACTIVAR ERRORES PARA EVITAR WARNINGS EN LA RESPUESTA
error_reporting(0);
ini_set('display_errors', 0);

// 3. CAPTURAR CUALQUIER SALIDA NO DESEADA
ob_start();

// 4. INCLUIR ARCHIVOS (con manejo de errores)
try {
    require_once __DIR__ . '/../../utils/log_config.php';
    require_once __DIR__ . '/getMensajeAdmin.php';
    require_once __DIR__ . '/../../views/dashboard/formMensajeAdmin.php';
    
    // 5. INSTANCIAR OBJETOS
    $formMensajeAdmin = new FormMensajeAdmin;
    $getMensajeAdmin = new GetMensajeAdmin;
    
    // 6. OBTENER DATOS
    $consultas = $getMensajeAdmin->obtenerConsultasOrdenadasPorUltimoMensajeRemitente();
    
    // 7. GENERAR HTML
    $formulario = $formMensajeAdmin->formMensajeAdminShow($consultas);
    
    // 8. LIMPIAR BUFFER Y VERIFICAR SI HAY SALIDA NO DESEADA
    $buffer = ob_get_clean();
    
    // 9. VERIFICAR SI EL FORMULARIO SE GENERÓ CORRECTAMENTE
    if (empty($formulario)) {
        throw new Exception("No se pudo generar el formulario de mensajes");
    }
    
    // 10. DEVOLVER JSON
    echo json_encode([
        'flag' => 1,
        'formularioHTML' => $formulario
    ]);
    
} catch (Exception $e) {
    // Limpiar buffer en caso de error
    ob_end_clean();
    
    echo json_encode([
        'flag' => 0,
        'error' => $e->getMessage()
    ]);
}
?>