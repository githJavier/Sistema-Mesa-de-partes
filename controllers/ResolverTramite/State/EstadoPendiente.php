<?php
// State/EstadoPendiente.php
namespace App\State;

class EstadoPendiente implements TramiteStateInterface
{
    public function archivar(TramiteContext $context, array $datos): bool
    {
        // Validaciones específicas para archivar desde estado pendiente
        if (empty($datos['motivo'])) {
            $context->setMensajeError("El motivo es obligatorio para archivar un trámite pendiente.");
            return false;
        }
        
        // Lógica de archivado
        $context->setEstado(new EstadoArchivado());
        return true;
    }
    
    public function derivar(TramiteContext $context, array $datos): bool
    {
        // Validaciones específicas para derivar
        if (empty($datos['area_destino'])) {
            $context->setMensajeError("Debe seleccionar un área de destino.");
            return false;
        }
        
        if (empty($datos['archivo'])) {
            $context->setMensajeError("Debe subir un archivo para derivar.");
            return false;
        }
        
        $context->setEstado(new EstadoEnProceso());
        return true;
    }
    
    public function getEstadoNombre(): string
    {
        return 'PENDIENTE';
    }
}