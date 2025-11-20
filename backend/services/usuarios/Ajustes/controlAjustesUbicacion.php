<?php 
include_once("getAjustes.php");

$getAjustes = new GetAjustes();

// Si se recibe un nombre de provincia por POST, devolver distritos
if (isset($_POST['action']) && $_POST['action'] === 'distritos' && isset($_POST['provincia'])) {
    $nombreProv = $_POST['provincia'];
    $distritos = $getAjustes->obtenerDistrito($nombreProv);

    if ($distritos != null) {
        echo json_encode([
            'flag' => 1,
            'distritos' => $distritos
        ]);
    } else {
        echo json_encode([
            'flag' => 0,
            'message' => 'No se encontraron distritos.'
        ]);
    }
    exit;
}

// Si se recibe un nombre de departamento por POST, devolver provincias
if (isset($_POST['Depa'])) {
    $nombreDepa = $_POST['Depa'];
    $provincias = $getAjustes->obtenerProvincia($nombreDepa);

    if ($provincias != null) {
        echo json_encode([
            'flag' => 1,
            'provincias' => $provincias
        ]);
    } else {
        echo json_encode([
            'flag' => 0,
            'message' => 'No se encontraron provincias.'
        ]);
    }
    exit;
}

// Caso por defecto: devolver departamentos
$departamentos = $getAjustes->obtenerDepartamento();
if ($departamentos != null) {
    echo json_encode([
        'flag' => 1,
        'departamentos' => $departamentos
    ]);
}
?>
