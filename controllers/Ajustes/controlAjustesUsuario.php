<?php
include_once("getAjustes.php");
include_once("../../models/area.php");
include_once("../../models/usuario.php");
include_once("../../models/tipoDocumento.php");

header('Content-Type: application/json');

$getAjustes = new GetAjustes();
$areaModel = new Area();
$usuarioModel = new Usuario();
$tipoDocumentoModel = new TipoDocumento();

$listaAreas = $areaModel->obtenerAreas();
$listaTiposUsuario = $usuarioModel->obtenerTiposUsuario();
$listaTiposDocumento = $tipoDocumentoModel->obtenerTipoDocumento();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $usuarioData = $getAjustes->obtenerUsuarioId($id);

    if ($usuarioData) {
        echo json_encode([
            'success' => true,
            'data' => [
                'usuario' => $usuarioData,
                'areas' => $listaAreas,
                'tipos_usuario' => $listaTiposUsuario,
                'tipos_documento' => $listaTiposDocumento
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró usuario',
            'data' => [
                'areas' => $listaAreas,
                'tipos_usuario' => $listaTiposUsuario,
                'tipos_documento' => $listaTiposDocumento
            ]
        ]);
    }
} else {
    // No se pidió usuario, solo áreas y tipos de usuario
    echo json_encode([
        'success' => true,
        'data' => [
            'areas' => $listaAreas,
            'tipos_usuario' => $listaTiposUsuario,
            'tipos_documento' => $listaTiposDocumento
        ]
    ]);
}

exit;
?>

