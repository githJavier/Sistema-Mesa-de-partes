<?php

require_once 'IGeneradorCodigo.php';

class GeneradorEstandar implements IGeneradorCodigo {

    public function generarSiguiente(?string $ultimoCodigo, string $anio, string $tipo): string {
        
        // 1. Si no hay código anterior o el formato no coincide, reiniciamos el contador.
        $patron = '/(\d{4}-' . preg_quote($tipo) . ')(\d{10})/';
        
        if ($ultimoCodigo === null || $ultimoCodigo === false || !preg_match($patron, $ultimoCodigo, $matches)) {
            // Retorna el 1 con padding (ej: 2025-DOC-0000000001)
            return $anio . "-" . $tipo . str_pad(1, 10, "0", STR_PAD_LEFT);
        }

        // 2. Si existe, extraemos el número, sumamos 1 y reformateamos.
        $consecutivo = (int) $matches[2] + 1;
        
        return $anio . "-" . $tipo . str_pad($consecutivo, 10, "0", STR_PAD_LEFT);
    }
}
?>