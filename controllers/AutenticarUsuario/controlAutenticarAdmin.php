<?php
session_start();
include_once("getAutenticarAdmin.php");

$getAutenticarAdministrador = new GetAutenticarAdministrador();

if ($getAutenticarAdministrador->validarBoton("btnLogin")) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $recaptcha = $_POST['recaptcha'];
        if($getAutenticarAdministrador->validarReCaptcha($recaptcha)){
            if($getAutenticarAdministrador->verificarUsuario($usuario)){
                if(!($getAutenticarAdministrador->AdministradorEliminado($usuario))){
                    if(!($getAutenticarAdministrador->AdministradorInactivado($usuario))){
                        if($getAutenticarAdministrador->verificarContrasena($contrasena)){
                            if($getAutenticarAdministrador->validarAdministrador($usuario)){
                                if($getAutenticarAdministrador->validarContrasena($usuario,$contrasena)){
                                    $mes = $getAutenticarAdministrador->obtenerMes();
                                    $datos = $getAutenticarAdministrador->obtenerDatosUsuario($usuario, $contrasena);
                                    $_SESSION['usuario'] = $usuario;
                                    $_SESSION['datos'] = $datos;
                                    $_SESSION['mes'] = $mes;
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
        }else{
            echo json_encode([
                'flag' => 0,
                'message' => $getAutenticarAdministrador->message
                ]);
            exit;
        }
}
?>