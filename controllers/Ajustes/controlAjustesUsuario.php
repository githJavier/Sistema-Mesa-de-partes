<?php
include_once("GetAjustes.php");
include_once("../../models/area.php");
include_once("../../models/usuario.php");

header('Content-Type: application/json');

$getAjustes = new GetAjustes();
$areaModel = new Area();
$usuarioModel = new Usuario();

$listaAreas = $areaModel->obtenerAreas();
$listaTiposUsuario = $usuarioModel->obtenerTiposUsuario();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $usuarioData = $getAjustes->obtenerUsuarioId($id);

    if ($usuarioData) {
        echo json_encode([
            'success' => true,
            'data' => [
                'usuario' => $usuarioData,
                'areas' => $listaAreas,
                'tipos_usuario' => $listaTiposUsuario
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró usuario',
            'data' => [
                'areas' => $listaAreas,
                'tipos_usuario' => $listaTiposUsuario
            ]
        ]);
    }
} else {
    // No se pidió usuario, solo áreas y tipos de usuario
    echo json_encode([
        'success' => true,
        'data' => [
            'areas' => $listaAreas,
            'tipos_usuario' => $listaTiposUsuario
        ]
    ]);
}

exit;
?>

