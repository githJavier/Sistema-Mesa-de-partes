<?php 
class formConsultarTramitesDerivados{
    public function formConsultarTramitesDerivadosShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <h1>Hola Tramites Derivados</h1>
        <?php
        return ob_get_clean();
    }
}
?>
