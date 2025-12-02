<?php
require_once __DIR__ . '/../utils/AuthSystem/AuthFacade.php';

header('Content-Type: application/json');

$auth = new AuthFacade();
$status = $auth->verificarAccesoAdmin();

switch ($status) {
    case 'no_session':
        error_log('Sesión no iniciada o inválida');
        $auth->logout(); // La fachada también maneja limpieza si falla
        echo json_encode(['status' => 'no_session']);
        break;
    case 'inactive':
        error_log('Usuario inactivo o eliminado');
        $auth->logout();
        echo json_encode(['status' => 'inactive']);
        break;
    case 'not_found':
        error_log('Usuario no encontrado');
        $auth->logout();
        echo json_encode(['status' => 'not_found']);
        break;
    case 'active':
        echo json_encode(['status' => 'active']);
        break;
}
exit;

?>