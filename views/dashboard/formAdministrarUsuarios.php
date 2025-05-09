<?php 
class formAdministrarUsuarios{
    public function formAdministrarUsuariosShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Usuarios</h1>
        <?php
        return ob_get_clean();
    }
}
?>
