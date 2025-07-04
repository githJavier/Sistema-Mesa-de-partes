<?php 
require_once __DIR__ . '/../../utils/log_config.php';
class formResolverTramites{
    public function formResolverTramitesShow($tramites){
        ob_start();
        //Formularios para los Tramites Por Resolver
        ?>
            <div class="container mb-5">
            <h3 class="mb-4 border-bottom pb-2 text-dark">TRAMITES POR RESOLVER</h3>

            <!-- Formulario de filtros -->
            <form id="form-filtros" class="row g-2 mb-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="search" class="form-text">CÓDIGO DE EXPEDIENTE</label>
                    <div class="input-group">
                    <span class="input-group-text span-input-tramite text-light"><i class="fas fa-barcode"></i></span>
                    <input type="text" class="form-control" id="search" placeholder="Ingrese código...">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <label class="form-text">PRIORIDAD</label>
                    <div class="input-group">
                        <label class="input-group-text span-input-tramite text-light" for="filtroPrioridad">
                            <i class="fas fa-exclamation-circle"></i>
                        </label>
                        <select class="form-select" id="filtroPrioridad" name="prioridad">
                            <option value="">Todos</option>
                            <option value="SI">Urgente</option>
                            <option value="NO">No urgente</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="date-from" class="form-text">FECHA DESDE</label>
                    <div class="input-group">
                        <span class="input-group-text span-input-tramite text-light"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" class="form-control" id="date-from">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="date-to" class="form-text">FECHA HASTA</label>
                    <div class="input-group">
                        <span class="input-group-text span-input-tramite text-light"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" class="form-control" id="date-to">
                    </div>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="button" class="btn btn-all w-100" id="filter-btn">Filtrar</button>
                        <button type="button" class="btn btn-all w-100" id="reset-btn">Limpiar</button>
                    </div>
                </div>

            </form>

            <!-- Cantidad de los expedientes presentes en la tabla -->
            <div id="alert-expedientes" class="alert alert-secondary d-flex align-items-center justify-content-between px-4 py-2 rounded mb-3 shadow-sm">
            <strong class="text-dark m-0">Usted tiene <span id="cantidad-expedientes"><?= count($tramites) ?></span> expediente(s) por resolver</strong>
            </div>

            <!-- Control de cantidad -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center">
                    <label for="cst-items-per-page-top" class="form-text m-0 me-2">Mostrar</label>
                    <select id="cst-items-per-page-top" class="form-select w-auto">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span id="total-entries" class="ms-1 form-text">por página</span>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-all" id="prev-page">Anterior</button>
                    <button class="btn btn-all" id="next-page">Siguiente</button>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered mt-3" id="tramites-table">
                    <thead class="table-dark text-center">
                        <tr>
                        <th>URGENTE</th>
                        <th>CÓDIGO DE EXPEDIENTE</th>
                        <th>FECHA</th>
                        <th>HORA</th>
                        <th>AREA DE ORIGEN</th>
                        <th>ESTADO</th>
                        <th>AREA DE DESTINO</th>
                        <th>ACCIONES</th>
                        <th>DETALLES</th>
                        </tr>
                    </thead>
                    <tbody id="tablaExpedientes" class="text-center">
                    <?php foreach ($tramites as $tramite): ?>
                        <tr>
                            <td class="td-prioridad"><?= strtoupper($tramite['dt_urgente'] ?? 'NO DEFINIDO') ?></td>
                            <td class="td-codigo"><?= strtoupper($tramite['dt_codigo_generado'] ?? 'NO DEFINIDO') ?></td>
                            <td class="td-fecha"><?= strtoupper($tramite['dt_fec_recep'] ?? 'NO DEFINIDO') ?></td>
                            <td class="td-hora"><?= strtoupper($tramite['dt_hora_recep'] ?? 'NO DEFINIDO') ?></td>
                            <td class="td-area"><?= strtoupper($tramite['dt_area_origen'] ?? 'NO DEFINIDO') ?></td>
                            <td class="td-estado"><?= strtoupper($tramite['dt_estado'] ?? 'NO DEFINIDO') ?></td>
                            <td class="td-area"><?= strtoupper($tramite['dt_area_destino'] ?? 'NO DEFINIDO') ?></td>
                            <td>
                            <button class="btn btn-all btn-sm"
                                id = "ArchivarTramites"
                                onclick="cargarFormularioArchivarTramite(
                                '<?= addslashes($tramite['t_codigo_generado']) ?>',
                                '<?= addslashes($tramite['t_asunto']) ?>',
                                '<?= addslashes($tramite['t_num_documento']) ?>'
                                )">
                                <i class="fas fa-folder-minus me-1"></i> Archivar
                            </button>
                            <button class="btn btn-all btn-sm"
                                onclick="cargarFormularioDerivarTramite(
                                '<?= addslashes($tramite['t_codigo_generado']) ?>',
                                '<?= addslashes($tramite['t_asunto']) ?>',
                                '<?= addslashes($tramite['t_num_documento']) ?>',
                                '<?= addslashes($tramite['dt_cod_detalletramite']) ?>'
                                )">
                                <i class="fas fa-paper-plane me-1"></i> Derivar
                            </button>
                            </td>
                            <td>
                            <button class="btn btn-all btn-sm"
                                onclick="verDetalles(
                                    '<?= addslashes($tramite['t_codigo_generado']) ?>',
                                    '<?= addslashes($tramite['t_tipodocumento']) ?>',
                                    '<?= addslashes($tramite['t_asunto']) ?>',
                                    '<?= addslashes($tramite['t_fec_reg']) ?>',
                                    '<?= addslashes($tramite['t_remitente']) ?>',
                                    '<?= htmlspecialchars(json_encode($tramite['flujo']), ENT_QUOTES, 'UTF-8') ?>',
                                    '<?= htmlspecialchars(json_encode($tramite['archivos']), ENT_QUOTES, 'UTF-8') ?>'
                                )">
                                <i class="fas fa-eye me-1"></i> Ver
                            </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div id="pagination-info" class="form-text text-muted text-center text-md-start">
                </div>
                
            </div>
        </div>

        <style>
            
        /* Fondo del modal */
        .modal-fondo {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1050;
        }

        /* Aplica a modal-content para la animación */
        #modalVentana {
            transform: scale(0.8);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* Animaciones */
        #modalVentana.animar-entrada {
            transform: scale(1);
            opacity: 1;
        }

        #modalVentana.animar-salida {
            transform: scale(0.8);
            opacity: 0;
        }

        /* Botón cerrar */
        .cerrar, .btn-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
        }
        </style>

        <!-- Modal con fondo oscuro y estructura mejorada -->
        <div id="modalFondo" class="modal" tabindex="-1" style="display: none; background-color: rgba(0,0,0,0.6);">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div id="modalVentana" class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h5 class="modal-title mb-0">Detalles del trámite</h5>
                <button type="button" class="btn-close" onclick="cerrarModal()" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <strong>Código:</strong> <span id="modal-codigo" class="ms-1"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Tipo de documento:</strong> <span id="modal-tipodocumento" class="ms-1"></span>
                        </div>
                        <div class="col-md-12 mb-2">
                            <strong>Asunto:</strong> <span id="modal-asunto" class="ms-1"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de registro:</strong> <span id="modal-fecharegistro" class="ms-1"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Remitente:</strong> <span id="modal-remitente" class="ms-1"></span>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mt-3 mb-3">Historial del trámite</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-sm text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Área Origen</th>
                                    <th>Estado</th>
                                    <th>Área Destino</th>
                                    <th>Fecha Trámite</th>
                                    <th>Hora Trámite</th>
                                    <th>Folios</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-detalles-tramite">
                                <!-- Se insertan filas con JS -->
                            </tbody>
                        </table>
                        <!-- Botón centrado debajo de la tabla -->
                        <div class="text-center my-3">
                            <!-- Botón para generar PDF -->
                            <button class="btn btn-danger btn-sm" onclick="generarPDF()">
                                <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                            </button>
                            <!-- Botón para ver archivo subido por remitente -->
                            <a id="btn-remitente" class="btn btn-danger btn-sm" target="_blank">
                                <i class="bi bi-paperclip"></i> Documento inicial
                            </a>
                            <!-- Botón para ver archivo adjunto en la derivación -->
                            <a id="btn-derivado" class="btn btn-danger btn-sm" target="_blank" style="display: none;" >
                                <i class="bi bi-paperclip"></i> Documento(s) de derivación
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>
        </div>
        </div>

        <!-- Modal para mostrar lista de documentos de derivación -->
        <div id="modal-derivaciones" class="modal" tabindex="-1" style="display: none; background-color: rgba(0,0,0,0.6);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Documentos de derivación</h5>
                        <button type="button" class="btn-close" onclick="cerrarModalDerivacion()" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="lista-derivaciones" class="list-group">
                            <!-- Aquí se insertarán enlaces dinámicamente -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #modal-derivaciones .modal-body {
                overflow-y: auto;
                transition: max-height 0.3s ease;
            }

            #modal-derivaciones .modal-header {
                position: sticky;
                top: 0;
                background-color: white;
                z-index: 10;
                border-bottom: 1px solid #dee2e6;
            }

            #modal-derivaciones .modal-dialog {
                max-height: 80vh;
                overflow: hidden;
            }

            .nombre-archivo {
                display: block;
                max-width: 90%;
                word-break: break-all;
                white-space: normal;
                overflow-wrap: break-word;
                line-height: 1.2;
                font-size: 0.875rem; /* opcional: ajusta el tamaño si quieres que quepa más */
            }
        </style>

        <style>
            .disabled-link {
            pointer-events: none;        /* impide clics */
            opacity: 0.5;                /* aspecto apagado */
            color: #aaa !important;      /* letra más gris */
            background-color: #e0e0e0 !important;  /* fondo gris claro */
            border-color: #ccc !important;
            cursor: not-allowed;         /* cursor de bloqueo */
            text-decoration: none;
            }
            
            .btn {
            border-radius: 6px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 8px 12px;
            min-width: auto;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            }
        </style>

        <!-- html2canvas para capturar el contenido como imagen -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <!-- jsPDF para generar el PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <!-- Tu archivo JavaScript personalizado -->
        <script src="../../asset/js/ResolverTramitesForms.js"></script>
        <script src="../../asset/js/ResolverTramites.js"></script>
        <script>
        // Detener Polling de Mensajes
        delete window.habilitarPollingMensajes;
        // Detener Polling de Chat Admin
        delete window.habilitarPollingChatAdmin;
        </Script>
        <?php
        return ob_get_clean();
    }
}
?>
