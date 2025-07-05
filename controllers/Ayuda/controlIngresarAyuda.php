<?php
require_once __DIR__ . '/../../utils/log_config.php';
require_once __DIR__ . '/getAyuda.php';
session_start();

$getAyuda = new GetAyuda;

$nombre = $_POST['nombre'] ?? null;
$email = $_POST['email'] ?? null;
$telefono_celular = $_POST['telefono'] ?? null;
$asunto = $_POST['asunto'] ?? null;
$mensaje = $_POST['mensaje'] ?? null; 
$id_remitente = $_SESSION['datos']['idremite'] ?? null;

if($getAyuda->validarNombres($nombre)){
    if($getAyuda->validarEmail($email)){
        if($getAyuda->validarTelefono($telefono_celular)){
            if($getAyuda->validarAsunto($asunto)){
                if($getAyuda->validarMensaje($mensaje)){
                    if($getAyuda->validarIdRemitente($id_remitente)){
                        if($getAyuda->guardarConsulta($id_remitente, $asunto, $mensaje)){
                            echo json_encode([
                            'flag' => 1,
                            'message' => "Envio de consulta exitoso",
                            'redirect' => "../../views/redireccion/home.php"
                            ]);
                            exit;
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
}else{
    echo json_encode(['flag' => 0, 'message' => $getAyuda->message]);
    exit;
}
