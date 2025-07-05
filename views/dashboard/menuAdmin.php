<?php 
class GetMenuAdmin {
    public function menuAdminShow($tipo_usuario) {
        ?>
        <!-- Menú lateral -->
        <div id="offcanvasScrolling" class="custom-offcanvas">
            <div class="container d-flex flex-column">
                <button type="button" class="menu-header"><span class="logo-text">MESA DE PARTES</span></button>
            </div>
            <hr class="separador-canva">

            <div class="container d-flex flex-column">
                <!-- HOME (Visible para todos) -->
                <button type="button" class="menu-item" onclick="cargarHome()">
                    <i class="fas fa-house"></i><span class="menu-text">HOME</span>
                </button>

                <!-- BANDEJA (Visible para todos) -->
                <button type="button" class="menu-item" data-bs-toggle="collapse" data-bs-target="#collapseBandeja" aria-expanded="false">
                    <i class="fas fa-inbox"></i><span class="menu-text">BANDEJA</span>
                </button>

                <div class="collapse collapse-tramite ms-4" id="collapseBandeja">
                    <button type="button" class="menu-item sub-item menu-text" id="RecibirTramitesExternos">
                        <i class="fas fa-inbox"></i> TRÁMITES POR RECIBIR (EXT.)
                    </button>
                    <button type="button" class="menu-item sub-item menu-text" id="RecibirTramitesInternos">
                        <i class="fas fa-envelope-open-text"></i> TRÁMITES POR RECIBIR (INT.)
                    </button>
                    <button type="button" class="menu-item sub-item menu-text" id="ResolverTramites">
                        <i class="fas fa-tasks"></i> TRÁMITES POR RESOLVER
                    </button>
                </div>

                <!-- Solo para ADMINISTRADOR -->
                <?php if ($tipo_usuario === 'ADMINISTRADOR'): ?>
                    <button type="button" class="menu-item" data-bs-toggle="collapse" data-bs-target="#collapseAdministracion" aria-expanded="false">
                        <i class="fas fa-user-cog"></i><span class="menu-text">ADMINISTRACIÓN</span>
                    </button>

                    <div class="collapse collapse-tramite ms-4" id="collapseAdministracion">
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarRemitentes">
                            <i class="fas fa-users"></i> REMITENTES
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarUsuarios">
                            <i class="fas fa-user"></i> USUARIOS
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarAreas">
                            <i class="fas fa-building"></i> ÁREAS
                        </button>
                        <button type="button" class="menu-item sub-item menu-text" id="AdministrarDocumentos">
                            <i class="fas fa-file-alt"></i> TIPO DOCUMENTOS
                        </button>
                    </div>
                <?php endif; ?>

                <!-- CONSULTAR (Visible para todos) -->
                <button type="button" class="menu-item" data-bs-toggle="collapse" data-bs-target="#collapseConsultar" aria-expanded="false">
                    <i class="fas fa-search"></i><span class="menu-text">CONSULTAR</span>
                </button>

                <div class="collapse collapse-tramite ms-4" id="collapseConsultar">
                    <button type="button" class="menu-item sub-item menu-text" id="ConsultarTramitesArchivados" onclick="cargarformularioConsultarTramitesArchivados()">
                        <i class="fas fa-archive"></i> TRÁMITES ARCHIVADOS
                    </button>
                    <button type="button" class="menu-item sub-item menu-text" id="ConsultarTramitesDerivados" onclick="cargarformularioConsultarTramitesDerivados()">
                        <i class="fas fa-share-square"></i> TRÁMITES DERIVADOS
                    </button>
                </div>
            </div>

            <?php if ($tipo_usuario === 'ADMINISTRADOR'): ?>
                <hr class="separador-canva">
                <span class="text-canva">AJUSTES</span>

                <div class="container d-flex flex-column">
                    <button type="button" class="menu-item" id="botonMensaje">
                        <i class="fas fa-comments"></i><span class="menu-text">MENSAJES</span>
                    </button>
                </div>
            <?php endif; ?>

            </div>
        <?php
    }
}
?>
