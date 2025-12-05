<?php 
require_once __DIR__ . '/../../utils/log_config.php';

class GetMenuAdmin {
    public function menuAdminShow() {
        ?>
            <!-- Menú lateral -->
            <div id="offcanvasScrolling" class="custom-offcanvas">
                <div class="container d-flex flex-column">
                    <button type="button" class="menu-header"><span class="logo-text">MESA DE PARTES</span></button>
                </div>
                <hr class="separador-canva">
                <div class="container d-flex flex-column">
                    <!-- HOME con data-command -->
                    <button type="button" class="menu-item" data-command="home">
                        <i class="fas fa-house"></i><span class="menu-text">HOME</span>
                    </button>
                    
                    <button type="button" class="menu-item d" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseBandeja" aria-expanded="false">
                        <i class="fas fa-inbox"></i><span class="menu-text">BANDEJA</span>
                    </button>

                    <!-- Contenido colapsable BANDEJA -->
                    <div class="collapse collapse-tramite ms-4" id="collapseBandeja">
                        <?php if (isset($_SESSION['datos']['area']) && $_SESSION['datos']['area'] === 'OFICINA TRAMITE DOCUMENTARIO') : ?>
                        <!-- TRÁMITES POR RECIBIR (EXT.) con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="recibirTramitesExternos">
                            <i class="fas fa-file-import"></i>TRÁMITES POR RECIBIR (EXT.)
                        </button>
                        <?php endif; ?>
                        
                        <!-- TRÁMITES POR RECIBIR (INT.) con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="recibirTramitesInternos">
                            <i class="fas fa-file-import" style="transform: scaleX(-1);"></i></i>TRÁMITES POR RECIBIR (INT.)
                        </button>
                        
                        <!-- TRÁMITES POR RESOLVER con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="resolverTramites">
                            <i class="fas fa-tasks"></i>TRÁMITES POR RESOLVER
                        </button>
                    </div>

                    <!-- INGRESAR TRÁMITE con data-command -->
                    <button type="button" class="menu-item" data-command="ingresarTramite">
                        <i class="fas fa-file-signature"></i><span class="menu-text">INGRESAR TRÁMITE</span>
                    </button>

                    <button type="button" class="menu-item d-none" id="botonMensaje">
                        <i class="fas fa-paper-plane"></i><span class="menu-text">TRÁMITE</span>
                    </button>

                    <?php if (isset($_SESSION['datos']['area']) && $_SESSION['datos']['area'] === 'JEFE DE SISTEMAS') : ?>
                    <button type="button" class="menu-item" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseAdministracion" aria-expanded="false">
                        <i class="fas fa-user-cog"></i><span class="menu-text">ADMINISTRACIÓN</span>
                    </button>

                    <!-- Contenido colapsable ADMINISTRACIÓN -->
                    <div class="collapse collapse-tramite ms-4" id="collapseAdministracion">
                        <!-- REMITENTES con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="administracionRemitentes">
                            <i class="fas fa-users"></i>REMITENTES
                        </button>
                        
                        <!-- USUARIOS con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="administracionUsuarios">
                            <i class="fas fa-user"></i>USUARIOS
                        </button>
                        
                        <!-- AREAS con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="administracionAreas">
                            <i class="fas fa-building"></i>AREAS
                        </button>
                        
                        <!-- TIPO DOCUMENTOS con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="administracionDocumentos">
                            <i class="fas fa-file-alt"></i>TIPO DOCUMENTOS
                        </button>
                    </div>
                    <?php endif; ?>

                    <button type="button" class="menu-item" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseConsultar" aria-expanded="false">
                        <i class="fas fa-search"></i><span class="menu-text">CONSULTAR</span>
                    </button>

                    <!-- Contenido colapsable CONSULTAR -->
                    <div class="collapse collapse-tramite ms-4" id="collapseConsultar">
                        <!-- TRÁMITES ARCHIVADOS con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="consultarTramitesArchivados">
                            <i class="fas fa-archive"></i>TRÁMITES ARCHIVADOS
                        </button>
                        
                        <!-- TRÁMITES DERIVADOS con data-command -->
                        <button type="button" class="menu-item sub-item menu-text" data-command="consultarTramitesDerivados">
                            <i class="fas fa-share-square"></i>TRÁMITES DERIVADOS
                        </button>
                    </div>
                    
                </div>
                
                <?php if (isset($_SESSION['datos']['area']) && $_SESSION['datos']['area'] === 'JEFE DE SISTEMAS') : ?>
                <hr class="separador-canva">
                <span class="text-canva">AJUSTES</span>
                <div class="container d-flex flex-column">
                    <!-- MENSAJES con data-command -->
                    <button type="button" class="menu-item" data-command="mensajesAdmin">
                        <i class="fas fa-comments"></i><span class="menu-text">MENSAJES</span>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        <?php
    }
}
?>