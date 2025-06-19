<?php 
class GetMenuAdmin{
    public function menuAdminShow(){
        ?>
            <!-- Menú lateral -->
            <div id="offcanvasScrolling" class="custom-offcanvas">
                <div class="container d-flex flex-column">
                    <button type="button" class="menu-header"><span class="logo-text">MESA DE PARTES</span></button>
                </div>
                <hr class="separador-canva">
                <div class="container d-flex flex-column">
                    <button type="button" class="menu-item" onclick="cargarHome()">
                        <i class="fas fa-house"></i><span class="menu-text">HOME</span>
                    </button>
                    <button type="button" class="menu-item d" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseBandeja" aria-expanded="false">
                        <i class="fas fa-inbox"></i><span class="menu-text">BANDEJA</span>
                    </button>

                    <!-- Contenido colapsable -->
                    <div class="collapse collapse-tramite ms-4" id="collapseBandeja">
                        <button type="button" class="menu-item sub-item menu-text" id="RecibirTramitesExternos">
                            <i class="fas fa-file-import"></i>TRAMITES POR RECIBIR (EXT.)
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="ResolverTramites">
                            <i class="fas fa-tasks"></i>TRAMITES POR RESOLVER
                        </button>
                    </div>

                    <button type="button" class="menu-item" id="IngresarTramite">
                        <i class="fas fa-file-signature"></i><span class="menu-text">INGRESAR TRÁMITE</span>
                    </button>

                    <button type="button" class="menu-item d-none" id="botonMensaje">
                        <i class="fas fa-paper-plane"></i><span class="menu-text">TRAMITE</span>
                    </button>

                    <button type="button" class="menu-item" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseAdministracion" aria-expanded="false">
                        <i class="fas fa-user-cog"></i><span class="menu-text">ADMINISTRACIÓN</span>
                    </button>

                    <!-- Contenido colapsable -->
                    <div class="collapse collapse-tramite ms-4" id="collapseAdministracion">
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarRemitentes">
                            <i class="fas fa-users"></i>REMITENTES
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarUsuarios">
                            <i class="fas fa-user"></i>USUARIOS
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarAreas">
                            <i class="fas fa-building"></i>AREAS
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarDocumentos">
                            <i class="fas fa-file-alt"></i>TIPO DOCUMENTOS
                        </button>
                    </div>

                    <button type="button" class="menu-item" id="linkTramite" data-bs-toggle="collapse" data-bs-target="#collapseConsultar" aria-expanded="false">
                        <i class="fas fa-search"></i><span class="menu-text">CONSULTAR</span>
                    </button>

                    <!-- Contenido colapsable -->
                    <div class="collapse collapse-tramite ms-4" id="collapseConsultar">
                        <button type="button" class="menu-item sub-item menu-text" id="ConsultarTramitesArchivados" onclick="cargarformularioConsultarTramitesArchivados()">
                            <i class="fas fa-archive"></i>TRAMITES ARCHIVADOS
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="ConsultarTramitesDerivados" onclick="cargarformularioConsultarTramitesDerivados()">
                            <i class="fas fa-share-square"></i>TRAMITES DERIVADOS
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
