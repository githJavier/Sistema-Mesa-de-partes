<?php
session_start();
include_once("getAutenticarAdmin.php");
require_once("../../utils/AuthSystem/AuthFacade.php");

$getAutenticarAdministrador = new GetAutenticarAdministrador();
$auth = new AuthFacade();

if ($getAutenticarAdministrador->validarBoton("btnLogin")) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
        if($getAutenticarAdministrador->verificarUsuario($usuario)){
            if(!($getAutenticarAdministrador->AdministradorEliminado($usuario))){
                if(!($getAutenticarAdministrador->AdministradorInactivado($usuario))){
                    if($getAutenticarAdministrador->verificarContrasena($contrasena)){
                        if($getAutenticarAdministrador->validarAdministrador($usuario)){
                            if($getAutenticarAdministrador->validarContrasena($usuario,$contrasena)){
                                $mes = $getAutenticarAdministrador->obtenerMes();
                                $datos = $getAutenticarAdministrador->obtenerDatosUsuario($usuario, $contrasena);
                                $auth->loginExitoso($usuario, $datos, $mes);
                                echo json_encode([
                                    'flag' => 1,
                                    'message' => "Inicio de sesión exitoso",
                                    'redirect' => "views/redireccion/homeAdmin.php",
                                    'mes' => $mes
                                ]);
                                
                            }else{
                                echo json_encode([
                                    'flag' => 0,
                                    'message' => $getAutenticarAdministrador->message
                                ]);  
                            }
                        }else{
                            echo json_encode([
                                'flag' => 0,
                                'message' => $getAutenticarAdministrador->message
                            ]);
                        }
                    }else{
                        echo json_encode([
                            'flag' => 0,
                            'message' => $getAutenticarAdministrador->message
                        ]);  
                    }
                }else{
                    echo json_encode([
                        'flag' => 0,
                        'message' => $getAutenticarAdministrador->message
                    ]);  
                }
            }else{
                echo json_encode([
                    'flag' => 0,
                    'message' => $getAutenticarAdministrador->message
                ]);  
            }
        }else{
            echo json_encode([
                'flag' => 0,
                'message' => $getAutenticarAdministrador->message
            ]);  
        }
}
?>