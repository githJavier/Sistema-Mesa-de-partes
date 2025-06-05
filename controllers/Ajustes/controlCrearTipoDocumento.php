<?php
include_once("getTipoDocumento.php");
$getTipoDocumento = new GetTipoDocumento();

// Recuperar datos del formulario
$tipoDocumento = $_POST['tipoDocumento'] ?? "";
$abreviatura = $_POST['abreviatura'] ?? "";

// Validar que se presionó el botón "Crear"
if ($getTipoDocumento->validarBoton("btnCrear")) {

    // Validar el nombre del tipo de documento
    if ($getTipoDocumento->verificarNombreTipoDocumento($tipoDocumento)) {

        // Verificar que el tipo de documento no exista ya registrado
        if ($getTipoDocumento->verificarSiExisteTipoDocumento($tipoDocumento)) {

            // Verificar que la abreviatura no exista ya registrada
            if ($getTipoDocumento->verificarSiExisteAbreviatura($abreviatura)) {

                // Intentar crear el tipo de documento
                if ($getTipoDocumento->CrearTipoDocumento($tipoDocumento, $abreviatura)) {
                    echo json_encode([
                        'flag' => 1,
                        'message' => $getTipoDocumento->message,
                        'redirect' => "../../views/redireccion/homeAdmin.php"
                    ]);
                } else {
                    echo json_encode([
                        'flag' => 0,
                        'message' => $getTipoDocumento->message
                    ]);
                    exit;
                }

            } else {
                echo json_encode([
                    'flag' => 0,
                    'message' => $getTipoDocumento->message // "La abreviatura ya está registrada."
                ]);
                exit;
            }

        } else {
            echo json_encode([
                'flag' => 0,
                'message' => $getTipoDocumento->message // "El tipo de documento ya está registrado."
            ]);
            exit;
        }

    } else {
        echo json_encode([
            'flag' => 0,
            'message' => $getTipoDocumento->message // Mensaje específico según error en nombre
        ]);
        exit;
    }

} else {
    echo json_encode([
        'flag' => 0,
        'message' => 'Solicitud no válida'
    ]);
    exit;
}
