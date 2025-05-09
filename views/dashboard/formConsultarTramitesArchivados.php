<?php 
class formConsultarTramitesArchivados{
    public function formConsultarTramitesArchivadosShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Tramites Archivados</h1>
        <?php
        return ob_get_clean();
    }
}
?>
