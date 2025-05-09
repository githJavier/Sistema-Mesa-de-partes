<?php 
$_SESSION['mes'] = "Mayo";
 echo json_encode([
    'flag' => 1,
    'message' => "Inicio de sesión exitoso",
    'redirect' => "views/redireccion/homeAdmin.php",
    'mes' => "Mayo"
]);
?>