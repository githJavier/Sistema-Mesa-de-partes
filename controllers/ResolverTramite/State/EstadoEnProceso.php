<?php
// State/EstadoEnProceso.php
namespace App\State;

class EstadoEnProceso implements TramiteStateInterface
{
    public function archivar(TramiteContext $context, array $datos): bool
    {
        // Validaciones específicas para archivar desde estado en proceso
        if (empty($datos['motivo'])) {
            $context->setMensajeError("El motivo es obligatorio.");
            return false;
        }
        
        $context->setEstado(new EstadoArchivado());
        return true;
    }
    
    public function derivar(TramiteContext $context, array $datos): bool
    {
        // Desde estado en proceso, se puede seguir derivando
        if (empty($datos['area_destino'])) {
            $context->setMensajeError("Debe seleccionar un área de destino.");
            return false;
        }
        
        // El estado sigue siendo EnProceso después de derivar
        return true;
    }
    
    public function getEstadoNombre(): string
    {
        return 'EN_PROCESO';
    }
}