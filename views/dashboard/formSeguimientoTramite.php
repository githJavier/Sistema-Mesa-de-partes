<?php 
class formSeguimientoTramite{
    public function formSeguimientoTramiteShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Seguimiento Tramite</h1>
        <?php
        return ob_get_clean();
    }
}
?>
