<?php
include_once("getCrearUsuario.php");
$getUsuario = new GetCrearUsuario();

// Recuperar datos del formulario
$tipoDocumento = $_POST['tipoDocumento'] ?? "";
$numeroDocumento = $_POST['numeroDocumento'] ?? "";
$password = $_POST['password'] ?? "";
$usuario = $_POST['usuario'] ?? "";
$nombre = $_POST['nombre'] ?? "";
$apellidoPaterno = $_POST['apellidoPaterno'] ?? "";
$apellidoMaterno = $_POST['apellidoMaterno'] ?? "";
$tipoUsuario = $_POST['tipoUsuario'] ?? "";
$estadoUsuario = $_POST['estadoUsuario'] ?? "";
$areaUsuario = $_POST['areaUsuario'] ?? "";

// Validación principal de acción
if ($getUsuario->validarBoton("btnRegistrar")) {

    if ($getUsuario->verificarTipoDocumento($tipoDocumento)) {

        if ($getUsuario->verificarDocumento($numeroDocumento, $tipoDocumento)) {

            if ($getUsuario->verificarUsuario($usuario)) {

                if ($getUsuario->verificarContrasena($password)) {

                    if ($getUsuario->verificarNombreUsuario($nombre)) {

                        if ($getUsuario->verificarApellidoPaterno($apellidoPaterno)) {

                            if ($getUsuario->verificarApellidoMaterno($apellidoMaterno)) {

                                if ($getUsuario->verificarTipoUsuario($tipoUsuario)) {

                                    if ($getUsuario->verificarEstadoUsuario($estadoUsuario)) {

                                        if ($getUsuario->verificarArea($areaUsuario)) {

                                            if ($getUsuario->crearUsuario(
                                                $tipoDocumento,
                                                $numeroDocumento,
                                                $nombre,
                                                $apellidoPaterno,
                                                $apellidoMaterno,
                                                $tipoUsuario,
                                                $estadoUsuario,
                                                $areaUsuario,
                                                $usuario,
                                                $password
                                            )) {

                                                echo json_encode([
                                                    'flag' => 1,
                                                    'message' => "Usuario del sistema creado correctamente",
                                                    'redirect' => "../../views/redireccion/homeAdmin.php"
                                                ]);
                                            } else {
                                                echo json_encode(['flag' => 0, 'message' => 'Error al crear usuario del sistema']);
                                                exit;
                                            }
                                        } else {
                                            echo json_encode(['flag' => 0, 'message' => 'Área no válida']);
                                            exit;
                                        }
                                    } else {
                                        echo json_encode(['flag' => 0, 'message' => 'Estado de usuario no válido']);
                                        exit;
                                    }
                                } else {
                                    echo json_encode(['flag' => 0, 'message' => 'Tipo de usuario no válido']);
                                    exit;
                                }
                            } else {
                                echo json_encode(['flag' => 0, 'message' => 'Apellido materno no válido']);
                                exit;
                            }
                        } else {
                            echo json_encode(['flag' => 0, 'message' => 'Apellido paterno no válido']);
                            exit;
                        }
                    } else {
                        echo json_encode(['flag' => 0, 'message' => 'Nombre no válido']);
                        exit;
                    }
                } else {
                    echo json_encode(['flag' => 0, 'message' => 'Contraseña no válida']);
                    exit;
                }
            } else {
                echo json_encode(['flag' => 0, 'message' => $getUsuario->message]);
                exit;
            }
        } else {
            echo json_encode(['flag' => 0, 'message' => 'Número de documento no válido']);
            exit;
        }
    } else {
        echo json_encode(['flag' => 0, 'message' => 'Tipo de documento no válido']);
        exit;
    }
} else {
    echo json_encode(['flag' => 0, 'message' => 'Solicitud no válida']);
    exit;
}
