<?php 
session_start();
include_once("getAutenticarUsuario.php");


$getAutenticarUsuario = new GetAutenticarUsuario();

if ($getAutenticarUsuario->validarBoton("btnLogin")) {
    $documento = $_POST['documento'];
    $contrasena = $_POST['contrasena'];
    $tipoPersona = $_POST['tipoPersona'];
    if($getAutenticarUsuario->verificarTipoDocumento($tipoPersona)){
        if($getAutenticarUsuario->verificarDocumento($documento,$tipoPersona)){
            if($getAutenticarUsuario->verificarContrasena($contrasena)){
                if($getAutenticarUsuario->validarRemitente($documento, $tipoPersona)){
                    if($getAutenticarUsuario->validarContrasena($documento,$contrasena)){
                        $mes = $getAutenticarUsuario->obtenerMes();
                        $datos = $getAutenticarUsuario->obtenerDatosRemitente($documento, $contrasena);
                        $_SESSION['usuario'] = $documento;
                        $_SESSION['datos'] = $datos;
                        $_SESSION['mes'] = $mes;
                        echo json_encode([
                            'flag' => 1,
                            'message' => "Inicio de sesión exitoso",
                            'redirect' => "views/redireccion/home.php",
                            'mes' => $mes
                        ]);
                        
                    }else{
                        echo json_encode([
                            'flag' => 0,
                            'message' => $getAutenticarUsuario->message
                        ]);  
                    }
                }else{
                    echo json_encode([
                        'flag' => 0,
                        'message' => $getAutenticarUsuario->message
                    ]);
                }
            }else{
                echo json_encode([
                    'flag' => 0,
                    'message' => $getAutenticarUsuario->message
                ]);  
            }
        }else{
            echo json_encode([
                'flag' => 0,
                'message' => $getAutenticarUsuario->message
            ]);  
        }
    }else{
        echo json_encode([
            'flag' => 0,
            'message' => $getAutenticarUsuario->message
        ]);
    }
}

?>