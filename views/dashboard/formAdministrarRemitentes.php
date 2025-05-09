<?php 
class formAdministrarRemitentes{
    public function formAdministrarRemitentesShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Remitentes</h1>
        <?php
        return ob_get_clean();
    }
}
?>
