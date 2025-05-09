<?php 
class formMensaje{
    public function formMensajeShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola mensaje</h1>
        <?php
        return ob_get_clean();
    }
}
?>
