<?php
include_once("getCrearUsuario.php");

$getUsuario = new GetCrearUsuario();

if ($getUsuario->validarBoton("btnRegistrar")) {
    $tipoPersona = $_POST['tipoPersona'] ?? "";
    $tipoDocumento = $_POST['tipoDocumento'] ?? "";
    $documento = $_POST['documento'] ?? "";
    $nombre = $_POST['nombre'] ?? "";
    $email = $_POST['email'] ?? "";
    $telefono = $_POST['telefono'] ?? "";
    $contrasena = $_POST['contrasena'] ?? "";
    $rContrasena = $_POST['rContrasena'] ?? "";
    $termsCheck = $_POST['termsCheck'] ?? false;

    if($getUsuario->verificarTipoDocumento($tipoDocumento)){
        if($getUsuario->verificarDocumento($documento, $tipoDocumento)){
            if($getUsuario->verificarUsuario($documento,$tipoDocumento)){
                if($getUsuario->verificarNombre($nombre,$tipoDocumento)){
                    if($getUsuario->verificarCorreo($email)){
                        if($getUsuario->verificarTelefono($telefono)){  
                            if($getUsuario->verificarContrasena($contrasena)){
                                if($getUsuario->verificarIgualdadContrasena($contrasena,$rContrasena)){
                                    if($getUsuario->verificarTerminos($termsCheck)){
                                        $contrasena = $getUsuario->encriptarContrasena($contrasena);
                                        if($getUsuario->crearUsuario($tipoPersona,$tipoDocumento,$documento,$nombre,$telefono,$email,$contrasena)){
                                            echo json_encode([
                                                'flag' => 1,
                                                'message' => "Usuario creado correctamente",
                                                'redirect' => "login.php"
                                            ]); 
                                        }else{
                                            echo json_encode(['flag' => 0, 'message' => 'Error al crear su usuario']);
                                            exit;
                                        }
                                    }else{
                                        echo json_encode(['flag' => 0, 'message' => 'Debe aceptar los términos y condiciones']);
                                        exit;
                                    }
                                }else{
                                    echo json_encode(['flag' => 0, 'message' => 'Las contraseñas no coinciden']);
                                    exit;
                                }
                            }else{
                                echo json_encode(['flag' => 0, 'message' => 'Ingrese una contraseña válida']);
                                exit;
                            }
                        }else{
                            echo json_encode(['flag' => 0, 'message' => 'Ingrese un teléfono válido']);
                            exit;
                        }
                    }else{
                        echo json_encode(['flag' => 0, 'message' => 'Ingrese un correo válido']);
                        exit;
                    }
                }else{
                    echo json_encode(['flag' => 0, 'message' => 'Ingrese un nombre válido']);
                    exit;
                }
            }else{
                echo json_encode(['flag' => 0, 'message' => $getUsuario->message]);
                exit;
            }
        }else{
            echo json_encode(['flag' => 0, 'message' => 'Ingrese un documento válido']);
            exit;
        }
    }else{
        echo json_encode(['flag' => 0, 'message' => 'Seleccionar un documento válido']);
        exit;
    }
    
    
}else{
    // Si no se presionó el botón
    echo json_encode(['flag' => 0, 'message' => 'Solicitud no válida']);
    exit;
}


