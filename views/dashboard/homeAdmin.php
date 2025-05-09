<?php 
/*
if (isset($_SESSION['usuario'])) {
    session_destroy();
}*/


include_once("head.php");
include_once("menuAdmin.php");
include_once("headerAdmin.php");

class panelPrincipal {
    public function panelPrincipalShow() {
        //$usuario = $_SESSION['usuario'];
        //$datos = $_SESSION['datos'];
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
                    //$getHeader->headerShow($datos['tipo_remitente'], $datos['nombres'], $datos['retipo_docu'], $usuario);
                    $getHeader->headerAdminShow("Administrador", "Pedro Javier Pablo Pascual", "DNI", "70905907");
                    ?>
                    <div class="container mt-4 container-dinamico" id="contenido-dinamico">
                        
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="../../asset/js/homeAdmin.js"></script>
                <script src="../../asset/js/menu.js"></script>
            </body>
        </html>
        <?php
    }
}
?>
