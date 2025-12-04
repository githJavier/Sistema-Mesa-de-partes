<?php

interface IGeneradorCodigo {
    public function generarSiguiente(?string $ultimoCodigo, string $anio, string $tipo): string;
}
?>