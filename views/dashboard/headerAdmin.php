<?php
 class GetHeaderAdmin{
    public function headerAdminShow($tipo_remitente, $nombres, $retipo_docu, $usuario){
        ?>
            <header class="d-flex flex-wrap justify-content-between align-items-center px-3">    
                <!-- Botón de menú a la izquierda -->
                <div class="d-flex align-items-center">
                    <button class="btn btn-toggle-menu" type="button" onclick="toggleMenu()">☰</button>
                </div>

                <!-- Dropdowns a la derecha -->
                <div class="d-flex align-items-center">
                    <!-- Dropdown usuario -->
                    <div class="dropdown">
                        <button class="btn d-flex align-items-center" id="userDropdown" onclick="toggleUserMenu(event)">
                            <div class="profile-img me-2">
                                <?php if ($tipo_remitente === 'PERSONA JURIDICA'): ?>
                                <i class="fas fa-building"></i>
                                <?php else: ?>
                                <i class="fas fa-user"></i>
                                <?php endif; ?>
                            </div>
                            <span class="txt-span-header"><?= $tipo_remitente ?></span>
                        </button>
                        <div id="userMenu" class="user-menu">
                            <div class="text-center">
                                <div class="profile-img mx-auto">
                                    <?php if ($tipo_remitente === 'PERSONA JURIDICA'): ?>
                                    <i class="fas fa-building"></i>
                                    <?php else: ?>
                                    <i class="fas fa-user"></i>
                                    <?php endif; ?>
                                </div>
                                <p class="mb-0"><?=$nombres?></p>
                                <small class="text-muted"><?= $retipo_docu ?>: <?php echo $usuario?></small>
                            </div>
                            <hr>
                            <a href="../../cerrarSesion.php" class="btn-cerrarSesion w-100" id="cerrarSesion">Cerrar Sesión</a>
                        </div>
                    </div>

                </div>
                
            </header>
        <?php
    }
 }
?>
