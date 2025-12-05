<?php
// Services/ValidacionService.php
namespace App\Services;

class ValidacionService
{
    public function validarMotivo(string $motivo, int $maxCaracteres = 100): array
    {
        if (empty(trim($motivo))) {
            return ['success' => false, 'message' => 'El motivo es obligatorio.'];
        }
        
        if (strlen($motivo) > $maxCaracteres) {
            return [
                'success' => false, 
                'message' => "El motivo no debe exceder los {$maxCaracteres} caracteres."
            ];
        }
        
        return ['success' => true, 'message' => ''];
    }
    
    public function validarAreaDestino(string $areaDestino): array
    {
        if (empty(trim($areaDestino))) {
            return ['success' => false, 'message' => 'Debe seleccionar un área de destino.'];
        }
        
        return ['success' => true, 'message' => ''];
    }
    
    public function validarNumeroExpediente(string $numeroExpediente): array
    {
        if (empty(trim($numeroExpediente))) {
            return ['success' => false, 'message' => 'El número de expediente es obligatorio.'];
        }
        
        if (!preg_match('/^\d{4}-[A-Z]*\d{10}$/i', $numeroExpediente)) {
            return ['success' => false, 'message' => 'El formato del número de expediente no es válido.'];
        }
        
        return ['success' => true, 'message' => ''];
    }
    
    public function validarFolios($folios): array
    {
        if (!isset($folios) || trim($folios) === "") {
            return ['success' => false, 'message' => 'El número de folios es obligatorio.'];
        }
        
        if (!ctype_digit($folios) || (int)$folios <= 0) {
            return ['success' => false, 'message' => 'El número de folios debe ser un número entero positivo.'];
        }
        
        return ['success' => true, 'message' => ''];
    }
}