<?php
include_once("getArea.php");
$getArea = new GetArea();

// Recuperar datos del formulario
$area = $_POST['area'] ?? "";
$abreviatura = $_POST['abreviatura'] ?? "";

// Validar que se presionó el botón "Crear"
if ($getArea->validarBoton("btnCrear")) {

    // Validar el nombre del area
    if ($getArea->verificarNombreArea($area)) {

        // Verificar que el area no exista ya registrada
        if ($getArea->verificarSiExisteArea($area)) {

            // Intentar crear el area
            if ($getArea->CrearArea($area, $abreviatura)) {
                echo json_encode([
                    'flag' => 1,
                    'message' => $getArea->message,
                    'redirect' => "../../views/redireccion/homeAdmin.php"
                ]);
            } else {
                echo json_encode([
                    'flag' => 0,
                    'message' => $getArea->message
                ]);
                exit;
            }

        } else {
            echo json_encode([
                'flag' => 0,
                'message' => $getArea->message // "El area ya está registrada."
            ]);
            exit;
        }

    } else {
        echo json_encode([
            'flag' => 0,
            'message' => $getArea->message // Mensaje específico según error en nombre
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
