<?php
// State/EstadoArchivado.php
namespace App\State;

class EstadoArchivado implements TramiteStateInterface
{
    public function archivar(TramiteContext $context, array $datos): bool
    {
        $context->setMensajeError("Un trámite archivado no puede archivarse nuevamente.");
        return false;
    }
    
    public function derivar(TramiteContext $context, array $datos): bool
    {
        $context->setMensajeError("Un trámite archivado no puede derivarse.");
        return false;
    }
    
    public function getEstadoNombre(): string
    {
        return 'ARCHIVADO';
    }
}