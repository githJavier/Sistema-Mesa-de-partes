<?php
include_once("head.php");
include_once("menuRemitente.php");
include_once("header.php");

class panelPrincipal {
    public function panelPrincipalShow() {
        $usuario = $_SESSION['usuario'];
        $datos = $_SESSION['datos'];
        $getHead = new GetHead;
        $getMenu = new GetMenu;
        $getHeader = new GetHeader;
        ?>
        <!DOCTYPE html>
        <html lang="es">
            <?php $getHead->headShow("home.css","formulariosHome.css"); ?>
            <body onload="initializeMenu()">
                <?php 
                $getMenu->menuShow();
                ?>
                <!-- Contenido principal -->
                <div class="main-content">
                    <?php 
                    $getHeader->headerShow($datos['tipo_remitente'], $datos['nombres'], $datos['retipo_docu'], $usuario);
                    ?>
                    <div class="container mt-4 container-dinamico" id="contenido-dinamico">
                        
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="../../asset/js/home.js"></script>
                <script src="../../asset/js/menu.js"></script>
            </body>
        </html>
        <?php
    }
}
?>
