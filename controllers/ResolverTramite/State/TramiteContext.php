<?php
// State/TramiteContext.php
namespace App\State;

class TramiteContext
{
    private TramiteStateInterface $estado;
    private string $mensaje = "";
    private bool $success = false;
    
    public function __construct(TramiteStateInterface $estadoInicial = null)
    {
        $this->estado = $estadoInicial ?? new EstadoPendiente();
    }
    
    public function archivar(array $datos): bool
    {
        $this->success = $this->estado->archivar($this, $datos);
        return $this->success;
    }
    
    public function derivar(array $datos): bool
    {
        $this->success = $this->estado->derivar($this, $datos);
        return $this->success;
    }
    
    public function setEstado(TramiteStateInterface $estado): void
    {
        $this->estado = $estado;
    }
    
    public function getEstado(): TramiteStateInterface
    {
        return $this->estado;
    }
    
    public function setMensajeError(string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }
    
    public function setMensajeExito(string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }
    
    public function getMensaje(): string
    {
        return $this->mensaje;
    }
    
    public function isSuccess(): bool
    {
        return $this->success;
    }
}