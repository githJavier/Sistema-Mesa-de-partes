<?php 
class formAdministrarDocumentos{
    public function formAdministrarDocumentosShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Documentos</h1>
        <?php
        return ob_get_clean();
    }
}
?>
