<?php
include_once("../dashboard/homeAdmin.php");
$panelPrincipal = new panelPrincipal();
session_start();
/*
function validarSesion()
{
    if (!isset($_SESSION["usuario"])) {
        return false;
    } else {
        return true;
    }
}*/

//if (validarSesion()) {
    $panelPrincipal->panelPrincipalShow();
//} else {
    //header("Location: ../../index.php");
 //   exit();
//}

?>