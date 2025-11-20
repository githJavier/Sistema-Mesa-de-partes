<?php
include_once("getRestablecerUsuario.php");

$getUsuario = new GetRestablecerUsuario;

if($getUsuario->validarBoton("btnRecuperar")){
        $documento = $_POST['documento'];
        $email = $_POST['email'];
    if($getUsuario->verificarDocumento($documento)){
        if($getUsuario->verificarCorreo($email)){
            if($getUsuario->verificarDocumentoCorreo($email,$documento)){
                /*
                if($getUsuario->mandarCorreo($email)){*/
                    echo json_encode([
                        'flag' => 1,
                        'message' => "Correo enviado correctamente",
                        'redirect' => "login.php"
                    ]); 
                /*}else{
                    echo json_encode([
                        'flag' => 0, 
                        'message' => $getUsuario->message
                    ]);
                    exit;
                }*/
            }else{
                echo json_encode([
                    'flag' => 0, 
                    'message' => $getUsuario->message
                ]);
                exit;
            }
        }else{
            echo json_encode([
                'flag' => 0, 
                'message' => $getUsuario->message
            ]);
            exit;
        }
    }else{
        echo json_encode([
            'flag' => 0, 
            'message' => $getUsuario->message
        ]);
    }
}