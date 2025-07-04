<?php 
include_once("head.php");
include_once("menuAdmin.php");
include_once("headerAdmin.php");

class panelPrincipal {
    public function panelPrincipalShow() {
        $usuario = $_SESSION['usuario'];
        $datos = $_SESSION['datos'];
        $getHead = new GetHead;
        $getMenu = new GetMenuAdmin;
        $getHeader = new GetHeaderAdmin;
        ?>
        <!DOCTYPE html>
        <html lang="es">
            <?php $getHead->headShow("home.css","formulariosHome.css"); ?>
            <body onload="initializeMenu()">
                <?php 
                $getMenu->menuAdminShow();
                ?>
                <!-- Contenido principal -->
                <div class="main-content">
                    <?php 
                    $getHeader->headerAdminShow($datos['usuario'], $datos['tipo'], $datos['nombre_completo'], $datos['tipo_doc'], $datos['num_doc'], $datos['area']);
                    ?>
                    <div class="container mt-4 container-dinamico" id="contenido-dinamico">
                        
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="../../asset/js/ResolverTramitesForms.js"></script>
                <script src="../../asset/js/ResponderConsultasAdminForms.js"></script>
                <script src="../../asset/js/homeAdmin.js"></script>
                <script src="../../asset/js/menu.js"></script>
            </body>
        </html>
        <?php
    }
}
?>
