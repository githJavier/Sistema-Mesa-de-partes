<?php 
class formAdministrarAreas{
    public function formAdministrarAreasShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Areas</h1>
        <?php
        return ob_get_clean();
    }
}
?>
