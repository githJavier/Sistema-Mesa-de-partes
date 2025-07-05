<?php 
require_once __DIR__ . '/../../utils/log_config.php';

class FormMensaje {
    public function formMensajeShow($consultas) {
        ob_start();
        ?>

        <div class="container mb-5 ma-container">
            <h3 class="mb-4 border-bottom pb-2 text-dark ma-titulo">MIS MENSAJES ENVIADOS</h3>

            <!-- Filtros -->
            <form id="ma-form-filtros" class="row g-2 mb-4">
                <div class="col-md-4">
                    <label class="form-label" for="ma-filtro-asunto">Buscar por asunto</label>
                    <input type="text" class="form-control" id="ma-filtro-asunto" placeholder="Ingrese asunto...">
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="ma-filtro-estado">Filtrar por estado</label>
                    <select class="form-select" id="ma-filtro-estado">
                        <option value="">Todos</option>
                        <option value="Enviado">Enviado</option>
                        <option value="En proceso">En proceso</option>
                        <option value="Resuelto">Resuelto</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="button" class="btn btn-primary w-100" id="ma-btn-filtrar">Filtrar</button>
                        <button type="reset" class="btn btn-secondary w-100" id="ma-btn-limpiar">Limpiar</button>
                    </div>
                </div>
            </form>

            <!-- Resultados -->
            <div class="ma-lista-mensajes">
                <?php if (is_array($consultas) && count($consultas) > 0): ?>
                    <?php foreach ($consultas as $consulta): 
                        $ayuda = $consulta['ayuda'];
                        $remitente = $consulta['remitente'];
                        $estado = $ayuda['estado']; // temporal, luego vendrá de la BD
                    ?>
                        <?php
                            $fechaAdm = !empty($ayuda['fecha_ultimo_mensaje_admin']) ? $ayuda['fecha_ultimo_mensaje_admin'] : $ayuda['fecha'];
                            $horaAdm = !empty($ayuda['hora_ultimo_mensaje_admin']) ? $ayuda['hora_ultimo_mensaje_admin'] : $ayuda['hora'];
                        ?>
                        <div class="card mb-3 shadow-sm"
                            data-id="<?= htmlspecialchars($ayuda['id_ayuda']) ?>"
                            data-fecha-administrador="<?= htmlspecialchars($fechaAdm) ?>"
                            data-hora-administrador="<?= htmlspecialchars($horaAdm) ?>"
                            data-fecha="<?= htmlspecialchars($ayuda['fecha']) ?>"
                            data-hora="<?= htmlspecialchars($ayuda['hora']) ?>"
                        >
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span class="badge bg-<?= strtolower(str_replace(' ', '-', $estado)) ?>">
                                    <?= $estado ?>
                                </span>
                                <span class="text-muted"><?= $ayuda['fecha'] ?> <?= substr($ayuda['hora'], 0, 5) ?></span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($ayuda['asunto']) ?></h5>
                                <p class="card-text"><?= nl2br(htmlspecialchars($ayuda['mensaje'])) ?></p>
                                <div class="text-end mt-2 d-flex justify-content-end align-items-center gap-3 flex-wrap">
                                    <small class="text-muted">
                                        <?php if (!empty($ayuda['fecha_ultimo_mensaje_admin']) && !empty($ayuda['hora_ultimo_mensaje_admin'])): ?>
                                            Última respuesta del administrador: 
                                            <?= htmlspecialchars($ayuda['fecha_ultimo_mensaje_admin']) ?> 
                                            <?= substr($ayuda['hora_ultimo_mensaje_admin'], 0, 5) ?>
                                        <?php else: ?>
                                            Aún sin respuesta del administrador
                                        <?php endif; ?>
                                    </small>
                                    <button class="btn btn-outline-dark btn-sm"
                                        onclick="cargarFormularioResponderMensaje('<?= addslashes($ayuda['id_ayuda']) ?>')">
                                        <i class="fas fa-comments"></i> Ver mensajes
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- ⚠️ Este reemplaza al echo PHP que decías -->
            <div id="no-initial-messages" class="alert alert-secondary text-center mt-3 <?= (empty($consultas)) ? '' : 'd-none' ?>">
                No hay mensajes para mostrar.
            </div>

            <!-- Este es el mensaje JS para resultados filtrados -->
            <div id="no-results-msg" class="text-center text-muted d-none mt-3" aria-live="polite">
                No se encontraron resultados.
            </div>

            <!-- Paginación -->
            <nav aria-label="Page navigation" class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <label for="ma-items-page" class="form-label">Mostrar:</label>
                    <select id="ma-items-page" class="form-select d-inline-block w-auto">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                    </select>
                    mensajes
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" id="ma-prev-page">Anterior</button>
                    <button class="btn btn-outline-primary" id="ma-next-page">Siguiente</button>
                </div>
                <div id="pagination-info" class="mt-2"></div>
            </nav>

        </div>
        <link rel="stylesheet" href="../../asset/css/mensaje.css">
        <script src="../../asset/js/mensaje.js"></script>
        <audio id="sonidoNuevoMensaje" src="../../asset/sounds/notification.mp3" preload="auto"></audio>
        <script src="../../asset/js/ResponderConsultasForms.js"></script>
        <script>
        // Detener Polling de Chat
        delete window.habilitarPollingChat;
        </Script>
        <?php
        return ob_get_clean();
    }
}
