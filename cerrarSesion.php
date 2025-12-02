<?php
require_once __DIR__ . '/utils/AuthSystem/AuthFacade.php';

// Deshabilitar el caché del navegador
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0"); 

$auth = new AuthFacade();
$auth->logout();

// Redirigir al usuario a la página de inicio
header("Location: index.php");
exit;
?>
