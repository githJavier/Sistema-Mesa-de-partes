<?php 
class formAyuda{
    public function formAyudaShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Ayuda</h1>
        <?php
        return ob_get_clean();
    }
}
?>
