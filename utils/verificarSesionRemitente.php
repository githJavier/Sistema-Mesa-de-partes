<?php
require_once __DIR__ . '/AuthSystem/AuthFacade.php';

header('Content-Type: application/json');

$auth = new AuthFacade();

$status = $auth->verificarAccesoRemitente();

switch ($status) {
    case 'invalid_role':
        error_log('Acceso denegado: un usuario del sistema intentó acceder como remitente.');
        $auth->logout();
        echo json_encode(['status' => 'invalid_role']);
        break;

    case 'no_session':
        error_log('Sesión no iniciada o inválida');
        $auth->logout();
        echo json_encode(['status' => 'no_session']);
        break;

    case 'not_found':
        error_log("Remitente no encontrado");
        $auth->logout();
        echo json_encode(['status' => 'not_found']);
        break;

    case 'found':
        // El usuario es válido
        echo json_encode(['status' => 'found']);
        break;
}
exit;
?>