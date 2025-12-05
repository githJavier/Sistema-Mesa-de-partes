<?php
// State/TramiteStateInterface.php
namespace App\State;

interface TramiteStateInterface
{
    public function archivar(TramiteContext $context, array $datos): bool;
    public function derivar(TramiteContext $context, array $datos): bool;
    public function getEstadoNombre(): string;
}