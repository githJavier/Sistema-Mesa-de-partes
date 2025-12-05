<?php
// controllers/Command/CommandController.php

// Configurar encabezados para JSON
header('Content-Type: application/json');

try {
    // Incluir CommandFactory
    require_once __DIR__ . '/CommandFactory.php';
    
    // Obtener comando
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;
    
    $commandName = $data['command'] ?? '';
    
    if (empty($commandName)) {
        throw new Exception('No se especificó el comando');
    }
    
    // Obtener parámetros
    $params = [];
    if (isset($data['params']) && is_string($data['params'])) {
        $params = json_decode($data['params'], true) ?: [];
    } elseif (isset($data['params']) && is_array($data['params'])) {
        $params = $data['params'];
    }
    
    // Crear y ejecutar comando
    $command = \Command\CommandFactory::create($commandName, $params);
    $result = $command->execute();
    
    // Asegurar que las rutas sean relativas desde la raíz web
    $response = [
        'flag' => 1,
        'command' => $commandName,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    if ($result['type'] === 'direct_view') {
        $response['viewType'] = 'direct';
        $response['viewPath'] = '../../' . $result['view']; // Desde views/admin/
    } else {
        $response['viewType'] = 'ajax';
        $response['controllerPath'] = '../../' . $result['controller']; // Desde views/admin/
    }
    
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'flag' => 0,
        'error' => $e->getMessage(),
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}