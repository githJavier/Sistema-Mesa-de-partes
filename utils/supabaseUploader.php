<?php

class SupabaseUploader {
    private $url;
    private $apiKey;
    public $message;

    // Tipos MIME permitidos
    private $tiposPermitidos = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    public function __construct() {
        $this->url = getenv('SUPABASE_URL');
        $this->apiKey = getenv('SUPABASE_ANON_KEY');
    }

    public function subirDocumento($archivo, $nombreArchivo) {
        if (!isset($archivo['tmp_name']) || empty($archivo['tmp_name'])) {
            $this->message = "Archivo no válido.";
            return false;
        }

        if (!in_array($archivo['type'], $this->tiposPermitidos)) {
            $this->message = "Tipo de archivo no permitido: {$archivo['type']}";
            return false;
        }

        // El bucket se llama 'documentos'
        $bucket = 'documentos';

        $uploadUrl = rtrim($this->url, '/') . "/storage/v1/object/$bucket/$nombreArchivo";

        $data = file_get_contents($archivo['tmp_name']);

        $ch = curl_init($uploadUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: {$archivo['type']}",
            "Authorization: Bearer {$this->apiKey}",
            "x-upsert: true"
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($error) {
            $this->message = "Error cURL: $error";
            return false;
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            $publicUrl = rtrim($this->url, '/') . "/storage/v1/object/public/$bucket/$nombreArchivo";
            $this->message = "Documento subido correctamente.";
            return $publicUrl;
        } else {
            $this->message = "Error al subir a Supabase. Código HTTP: $httpCode. Respuesta: $response";
            return false;
        }
    }

}