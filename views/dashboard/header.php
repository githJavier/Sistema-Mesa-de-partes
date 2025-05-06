<?php
 class GetHeader{
    public function headerShow($tipo_remitente, $nombres, $retipo_docu, $usuario){
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

                    <!-- Dropdown calendario -->
                    <div class="dropdown">
                        <button class="btn d-flex align-items-center" onclick="toggleCalendar()">
                            <div class="profile-img d-flex align-items-center me-2">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <span class="txt-span-header">CALENDARIO DE ACTIVIDADES</span>
                        </button>
                    </div>
                </div>
                
                <!-- Offcanvas del calendario -->
                <div id="calendarOffcanvas" class="offcanvas-calendar">
                    <div class="container-mes-calendario d-flex align-items-center justify-content-center">
                        <h5 class="text-center"><?=$_SESSION['mes']?></h5>
                    </div>
                    <div class="container mt-4">
                        <p>Aquí se mostrará el calendario de actividades.</p>
                    </div>
                </div>
            </header>
        <?php
    }
 }
?>
