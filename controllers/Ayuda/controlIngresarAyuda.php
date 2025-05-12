<?php
include_once("getAyuda.php");

$getAyuda = new GetAyuda;

$nombre = $_POST['nombre'] ?? null;
$email = $_POST['email'] ?? null;
$telefono_celular = $_POST['telefono'] ?? null;
$asunto = $_POST['asunto'] ?? null;
$mensaje = $_POST['mensaje'] ?? null; 

if($getAyuda->validarNombres($nombre)){
    if($getAyuda->validarEmail($email)){
        if($getAyuda->validarTelefono($telefono_celular)){
            if($getAyuda->validarAsunto($asunto)){
                if($getAyuda->validarMensaje($mensaje)){
                    if($getAyuda->guardarConsulta($nombre,$email,$telefono_celular,$asunto,$mensaje)){
                        echo json_encode([
                        'flag' => 1,
                        'message' => "Envio de consulta exitoso",
                        'redirect' => "../../views/redireccion/home.php"
                        ]);
                    }else{
                        echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
                        exit;
                    }
                }else{
                    echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
                    exit;
                }
            }else{
                echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
                exit;
            }
        }else{
            echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
            exit;
        }
    }else{
        echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
        exit;
    }
}else{
    echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
    exit;
}
