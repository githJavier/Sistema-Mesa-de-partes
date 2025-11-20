<?php 
class GetMenu{
    public function menuShow(){
        ?>
            <!-- Menú lateral -->
            <div id="offcanvasScrolling" class="custom-offcanvas">
                <div class="container d-flex flex-column">
                    <button type="button" class="menu-header"><span class="logo-text">MESA DE PARTES</span></button>
                </div>
                <hr class="separador-canva">
                <div class="container d-flex flex-column">
                    <button type="button" class="menu-item" onclick="cargarHome()">
                        <i class="fas fa-home"></i><span class="menu-text">HOME</span>
                    </button>
                    <button type="button" class="menu-item" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseTramite" aria-expanded="false">
                        <i class="fa-solid fa-sheet-plastic"></i><span class="menu-text">TRÁMITE</span>
                    </button>

                    <!-- Contenido colapsable -->
                    <div class="collapse collapse-tramite ms-4" id="collapseTramite">
                        <button type="button" class="menu-item sub-item menu-text" id="botonTramite">
                            <i class="fas fa-file-signature"></i>INGRESAR
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="botonSeguimiento">
                            <i class="fas fa-clipboard-list"></i>SEGUIMIENTO
                        </button>
                    </div>
                </div>
                <hr class="separador-canva">
                <span class="text-canva">AJUSTES</span>
                <div class="container d-flex flex-column">
                    <button type="button" class="menu-item" id="botonMensaje">
                        <i class="fas fa-comments"></i><span class="menu-text">MENSAJES</span>
                    </button>

                    <button type="button" class="menu-item" id="linkAjuste" data-bs-toggle="collapse" data-bs-target="#collapseUbicacion" aria-expanded="false">
                        <i class="fas fa-cogs"></i><span class="menu-text">AJUSTE</span>
                    </button>

                    <!-- Contenido colapsable -->
                    <div class="collapse collapse-Tramite ms-4" id="collapseUbicacion">
                        <button type="button" class="menu-item sub-item menu-text" id="botonAjustes">
                            <i class="fas fa-map-marker-alt"></i> DATOS
                        </button>
                    </div>
                    <button type="button" class="menu-item" id="botonAyuda">
                        <i class="fas fa-life-ring"></i><span class="menu-text">AYUDA</span>
                    </button>
                </div>
            </div>
        <?php
    }
}
?>
