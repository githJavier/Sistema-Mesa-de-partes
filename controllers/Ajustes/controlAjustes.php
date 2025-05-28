<?php 
include_once("getAjustes.php");

$getAjustes = new GetAjustes;
session_start();
if($getAjustes->validarBoton("btnGuardarDatos")){
    $celular = $_POST['celular'] ?? "";
    $departamento = $_POST['departamento'] ?? "";
    $provincia = $_POST['provincia'] ?? "";
    $distrito = $_POST['distrito'] ?? "";
    $direccion = $_POST['direccion'] ?? "";
    if($getAjustes->validarCelular($celular)){
        if($getAjustes->validarDepartamento($departamento)){
            if($getAjustes->validarProvincia($provincia)){
                if($getAjustes->validarDistrito($distrito)){
                    if($getAjustes->validarDireccion($direccion)){
                        if($getAjustes->actualizarUbicacionRemitente($_SESSION['usuario'], $departamento, $provincia, $distrito, $direccion, $celular)){
                            echo json_encode([
                                'flag' => 1,
                                'message' => $getAjustes->message,
                                'redirect' => "../../views/redireccion/home.php"
                            ]); 
                        }
                    }else{
                        echo json_encode(['flag' => 0, 'message' => $getAjustes->message]);
                        exit;
                    }
                }else{
                    echo json_encode(['flag' => 0, 'message' => $getAjustes->message]);
                    exit;
                }
            }else{
                echo json_encode(['flag' => 0, 'message' => $getAjustes->message]);
                exit;
            }
        }else{
            echo json_encode(['flag' => 0, 'message' => $getAjustes->message]);
            exit;
        }
    }else{
        echo json_encode(['flag' => 0, 'message' => $getAjustes->message]);
        exit;
    }
}

?>