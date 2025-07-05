<?php
require_once __DIR__ . '/../../utils/log_config.php';

class GetFormResponderMensaje {
    public function formResponderMensajeShow($datosAyuda, $datosRemitente, $mensajesChat) {
        ob_start();
        ?>
        <div class="rma-container">
            <!-- CABECERA DEL CHAT -->
            <div class="rma-header">
                <div class="rma-user-header">
                    <div class="rma-user-info">
                        <input type="hidden" id="rma-id-remitente" value="<?= htmlspecialchars($datosRemitente['id_remitente']) ?>">
                        <h2 class="rma-user-name"><i class="fas fa-user-shield me-2"></i>ADMINISTRADOR DEL SISTEMA</h2>
                    </div>
                    <div class="rma-user-btn">
                    <button class="btn btn-outline-light fw-semibold d-flex align-items-center gap-2 px-4 py-2 rounded-2 border-2" onclick="toggleInfoCard(this)">
                        <i class="fas fa-envelope-open-text fa-lg"></i> Detalle de mi solicitud
                    </button>
                    </div>

                </div>

                <div class="rma-case-info-card" style="display: none;">
                    <input type="hidden" id="rma-id-ayuda" value="<?= htmlspecialchars($datosAyuda['id_ayuda']) ?>">

                    <div class="rma-case-asunto-box">
                        <p class="rma-case-asunto-text"><?= htmlspecialchars($datosAyuda['asunto']) ?></p>
                    </div>

                    <div class="rma-case-mensaje-box">
                        <p class="rma-case-mensaje-text"><?= nl2br(htmlspecialchars($datosAyuda['mensaje'])) ?></p>
                    </div>
                </div>
            </div>

            <!-- CUERPO DEL CHAT -->
            <div class="rma-chat-box" id="rma-chat-box">
                <?php if (empty($mensajesChat)): ?>
                    <div class="rma-chat-empty">
                        <i class="fas fa-comments rma-chat-empty-icon"></i>
                        <p class="rma-chat-placeholder">
                            Aún no has recibido respuesta del administrador <i class="far fa-clock ms-1"></i>
                        </p>
                    </div>
                <?php else: ?>
                    <?php foreach ($mensajesChat as $mensaje): ?>
                        <div class="rma-message-wrapper <?= $mensaje['remitente_tipo'] === 'admin' ? 'rma-message-admin' : 'rma-message-remitente' ?>"
                            data-id-mensaje="<?= htmlspecialchars($mensaje['id']) ?>">
                            <div class="rma-message-bubble">
                                <p class="rma-message-text"><?= nl2br(htmlspecialchars($mensaje['mensaje'])) ?></p>
                                <span class="rma-message-time">
                                    <?= htmlspecialchars($mensaje['fecha']) ?> <?= substr($mensaje['hora'], 0, 5) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- INPUT PARA NUEVO MENSAJE -->
            <div class="rma-input-area">
                <textarea id="rma-input-message" class="rma-input-message" rows="1" placeholder="Escribe un mensaje..." autocomplete="off"></textarea>
                <button id="rma-btn-send" class="rma-btn-send" disabled>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>

        </div>

        <!-- CARGA DE ESTILOS E ICONOS -->
        <link rel="stylesheet" href="../../asset/css/responderMensaje.css">
        <script src="../../asset/js/responderMensaje.js"></script>
        <script>
        // Detener Polling de Mensajes
        delete window.habilitarPollingMensajes;
        // Esperar a que el DOM esté pintado completamente antes de mover el scroll
        setTimeout(() => {
            const chatBox = document.getElementById("rma-chat-box");
            if (chatBox) {
                chatBox.style.scrollBehavior = "auto";
                chatBox.scrollTop = chatBox.scrollHeight;

                // Restaurar comportamiento suave después
                setTimeout(() => {
                    chatBox.style.scrollBehavior = "smooth";
                }, 50);
            }
        }, 50);
        </Script>
        <?php
        return ob_get_clean();
    }
}
?>