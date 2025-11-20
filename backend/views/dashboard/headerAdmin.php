<?php
require_once __DIR__ . '/../../shared/utils/log_config.php';

class GetHeaderAdmin {
    public function headerAdminShow($nombre_usuario, $tipo_usuario, $nombres_reales, $tipo_docu, $nume_docu, $area) {
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
                            <?php if ($tipo_usuario === 'ADMINISTRADOR'): ?>
                                <i class="fas fa-user-shield"></i>
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                        <span class="txt-span-header"><?= $tipo_usuario . ': ' . $nombre_usuario ?></span>
                    </button>

                    <div id="userMenu" class="user-menu">
                        <div class="user-info text-center">
                            <div class="user-name"><?= htmlspecialchars($nombres_reales) ?></div>
                            <div class="user-doc"><?= htmlspecialchars($tipo_docu) ?>: <?= htmlspecialchars($nume_docu) ?></div>
                            <div class="user-area"><?= htmlspecialchars($area) ?></div>
                        </div>
                        <hr>
                        <a href="../../services/auth/cerrarSesion.php" class="btn-logout" id="cerrarSesion">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                        </a>
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
                    <h5 class="text-center"><?= $_SESSION['mes'] ?></h5>
                </div>
                <div class="container mt-4">
                    <p>Aquí se mostrará el calendario de actividades.</p>
                </div>
            </div>
        </header>

        <style>
            .user-menu {
                position: absolute;
                top: 100%;
                left: 50%;
                transform: translateX(-50%);
                background-color: #fff;
                border: 1px solid #ddd;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                padding: 1.2rem;
                min-width: 270px;
                max-width: 300px;
                z-index: 1000;
                font-family: 'Segoe UI', sans-serif;
                color: #2b2b2b;
            }

            .user-info {
                margin-bottom: 0.6rem;
            }

            .user-name {
                font-size: 1.05rem;
                font-weight: 600;
                color: #111;
                margin-bottom: 0.4rem;
            }

            .user-doc {
                font-size: 0.9rem;
                color: #555;
                margin-bottom: 0.2rem;
            }

            .user-area {
                font-size: 0.9rem;
                color: #777;
                white-space: pre-line;
            }

            hr {
                border-top: 1px solid #e5e5e5;
                margin: 0.5rem 0;
            }

            .btn-logout {
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #111;
                color: #fff;
                padding: 0.6rem;
                font-size: 0.9rem;
                font-weight: 500;
                text-decoration: none;
                border-radius: 8px;
                transition: background-color 0.2s ease-in-out;
            }

            .btn-logout:hover {
                background-color: #333;
            }
        </style>
        <?php
    }
}
?>
