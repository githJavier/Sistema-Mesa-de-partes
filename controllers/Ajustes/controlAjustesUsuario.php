<?php
include_once("getAjustes.php");
include_once("../../models/area.php");
include_once("../../models/usuario.php");
include_once("../../models/tipoDocumento.php");
session_start();

header('Content-Type: application/json');

$miArea = $_SESSION['datos']['area'];

$getAjustes = new GetAjustes();
$areaModel = new Area();
$usuarioModel = new Usuario();
$tipoDocumentoModel = new TipoDocumento();

$listaAreas = $areaModel->obtenerAreas();
$areasFiltradas = array_filter($listaAreas, function($area) use ($miArea) {
    return $area['area'] !== $miArea;
});
$areasFiltradas = array_values($areasFiltradas); // <- Reindexa para que sea un array puro

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
                'areas' => $areasFiltradas,
                'tipos_usuario' => $listaTiposUsuario,
                'tipos_documento' => $listaTiposDocumento
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró usuario',
            'data' => [
                'areas' => $areasFiltradas,
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
            'areas' => $areasFiltradas,
            'tipos_usuario' => $listaTiposUsuario,
            'tipos_documento' => $listaTiposDocumento
        ]
    ]);
}

exit;
?>

