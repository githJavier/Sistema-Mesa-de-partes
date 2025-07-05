<?php 
require_once __DIR__ . '/../../utils/log_config.php';
class formSeguimientoTramite{
    public function formSeguimientoTramiteShow($tramites, $tiposDocumento){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
            <div class="container mb-5">
            <h3 class="mb-4 border-bottom pb-2 text-dark">SEGUIMIENTO DE TRÁMITES</h3>

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
                    <label class="form-text">TIPO DE DOCUMENTO</label>
                    <div class="input-group">
                    <label class="input-group-text span-input-tramite text-light" for="filtroTipo"><i class="fas fa-file-alt"></i></label>
                    <select class="form-select" id="filtroTipo" name="tipo_documento">
                        <option value="">Todos</option>
                        <?php
                            foreach ($tiposDocumento as $documento) {
                                echo "<option value='" . $documento['tipodocumento'] . "'>" . strtoupper($documento['tipodocumento']) . "</option>";
                            }
                        ?>
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
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="date-to" class="form-text">ESTADO</label>
                    <div class="input-group">
                    <label class="input-group-text span-input-tramite text-light" for="filtroEstado"><i class="fas fa-info-circle"></i></label>
                    <select class="form-select" id="filtroEstado" name="estado_actual">
                        <option value="">Todos</option>
                        <option value="Registrado">Registrado</option>
                        <option value="Derivado">Derivado</option>
                        <option value="Archivado">Archivado</option>
                        <option value="Recibido">Recibido</option>
                    </select>
                    </div>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="button" class="btn btn-all w-100" id="filter-btn">Filtrar</button>
                        <button type="button" class="btn btn-all w-100" id="reset-btn">Limpiar</button>
                    </div>
                </div>

            </form>

            <!-- Control de cantidad -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div class="d-flex align-items-center">
                    <label for="cst-items-per-page-top" class="form-text m-0 me-2">Mostrar:</label>
                    <select id="cst-items-per-page-top" class="form-select w-auto">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span id="total-entries" class="ms-1 form-text">registros</span>
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
                        <th>CÓDIGO DE EXPEDIENTE</th>
                        <th>TIPO DE DOCUMENTO</th>
                        <th>FECHA DE REGISTRO</th>
                        <th>ESTADO</th>
                        <th>DETALLES</th>
                        </tr>
                    </thead>
                    <tbody id="tablaExpedientes" class="text-center">
                    <?php foreach ($tramites as $tramite): ?>
                        <tr>
                            <td class="td-codigo"><?= strtoupper($tramite['dt_codigo_generado']) ?></td>
                            <td class="td-tipo"><?= strtoupper($tramite['t_tipodocumento']) ?></td>
                            <td class="td-fecha"><?= strtoupper($tramite['dt_fec_recep']) ?></td>
                            <td class="td-estado"><?= strtoupper($tramite['dt_estado'] ?? 'NO DEFINIDO') ?></td>
                            <td>
                        <button class="btn btn-all btn-sm"
                            onclick="verDetalles(
                                '<?= $tramite['t_codigo_generado'] ?>',
                                '<?= addslashes($tramite['t_tipodocumento']) ?>',
                                '<?= addslashes($tramite['t_asunto']) ?>',
                                '<?= $tramite['t_fec_reg'] ?>',
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
        </style>

        <!-- Modal -->
        <div id="et-estadoTramiteModal" class="et-modal-estados-tramite">
        <div class="et-modal-dialog">
            <div class="et-modal-content">
            <div class="et-modal-header">
                <h6 class="et-modal-title">Estados del Trámite</h6>
            </div>

            <div class="et-stepper">
                <div class="et-line-registrado-recibido"></div>

                <!-- Línea horizontal desde nodo 1 hasta pivote -->
                <div class="et-line-horizontal"></div>

                <!-- Punto pivote donde bifurcan las líneas -->
                <div class="et-line-pivot"></div>

                <!-- Líneas diagonales -->
                <div class="et-line-diag-up"></div>
                <div class="et-line-diag-down"></div>

                <!-- Nodos con títulos -->
                <div class="et-step et-node-0 active" data-index="0" title="Registrado"></div>
                <div class="et-step-title et-title-0">Registrado</div>

                <div class="et-step et-node-1" data-index="1" title="Recibido"></div>
                <div class="et-step-title et-title-1">Recibido</div>

                <div class="et-step et-node-2" data-index="2" title="Archivado"></div>
                <div class="et-step-title et-title-2">Archivado</div>

                <div class="et-step et-node-3" data-index="3" title="Derivado"></div>
                <div class="et-step-title et-title-3">Derivado</div>
            </div>

            <div class="et-modal-body">
                <div class="et-modal-carousel-container">
                <button class="et-carousel-control-prev" type="button" id="et-prevSlide">
                    <span class="et-carousel-control-prev-icon" aria-hidden="true"></span>
                </button>

                <div id="et-carouselEstados">
                    <div class="et-carousel-inner">
                    <div class="et-carousel-item active">
                        <img src="https://cdn-icons-png.flaticon.com/512/3176/3176261.png" alt="Registrado">
                        <div class="et-text-content">
                        <h6>Registrado</h6>
                        <p>	Tu trámite ha sido ingresado al sistema y está en espera de revisión por parte del personal.</p>
                        </div>
                    </div>
                    <div class="et-carousel-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/870/870128.png" alt="Recibido">
                        <div class="et-text-content">
                        <h6>Recibido</h6>
                        <p>Un especialista ha evaluado tu trámite y está determinando el siguiente paso.</p>
                        </div>
                    </div>
                    <div class="et-carousel-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/2341/2341988.png" alt="Archivado">
                        <div class="et-text-content">
                        <h6>Archivado</h6>
                        <p>Tu trámite ha sido cerrado porque ya no requiere más acciones por parte de la entidad.</p>
                        </div>
                    </div>
                    <div class="et-carousel-item">
                        <img src="https://cdn-icons-png.flaticon.com/512/10988/10988154.png " alt="Derivado">
                        <div class="et-text-content">
                        <h6>Derivado</h6>
                        <p>Tu trámite ha sido enviado a un área específica para su atención o respuesta.</p>
                        </div>
                    </div>
                    </div>
                </div>

                <button class="et-carousel-control-next" type="button" id="et-nextSlide">
                    <span class="et-carousel-control-next-icon" aria-hidden="true"></span>
                </button>
                </div>
            </div>

            <div class="et-modal-footer">
                <button id="et-noMostrarBtn" class="btn btn-sm btn-secondary">No volver a mostrar</button>
                <button id="et-cerrarModalBtn" class="btn btn-sm btn-primary">Entendido</button>
            </div>
            </div>
        </div>
        </div>

        <style>
            :root {
            --fondo-oscuro: #121212;
            --fondo-panel: #1e1e1e;
            --fondo-elemento: #2d2d2d;
            --acento-primario: #981E25;
            --acento-secundario: #88c0d0;
            --texto-primario: #e5e9f0;
            --texto-secundario: #d8dee9;
            --borde: #4c566a;
            --activo: #a3be8c;
            --gris: #4c566a;
            }

            .btn.btn-primary {
            all: unset;
            background-color: var(--acento-primario);
            color: white;
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            text-align: center;
            }

            .btn.btn-primary:hover {
            background-color: #B12A30;
            transform: translateY(-2px);
            }

            .btn.btn-primary:active {
            background-color: #73161B;
            transform: translateY(0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            }

            .btn.btn-primary:focus,
            .btn.btn-primary:focus-visible {
            outline: none;
            box-shadow: none;
            }

            /* Estilos específicos del modal */
            .et-modal-estados-tramite {
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 420px;
            z-index: 1055;
            font-family: 'Segoe UI', sans-serif;
            display: none;
            }

            .et-modal-content {
            border-radius: 12px;
            background-color: var(--fondo-panel);
            color: var(--texto-primario);
            border: 1px solid var(--borde);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
            }

            .et-modal-header {
            display: flex;
            justify-content: center;     /* Centra horizontalmente */
            align-items: center;         /* Centra verticalmente */
            background-color: var(--fondo-elemento);
            border-bottom: 1px solid var(--borde);
            padding: 10px 16px;          /* Menos espacio arriba y abajo */
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            min-height: 48px;            /* Altura mínima razonable */
            text-align: center;
            }

            .et-modal-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--texto-primario);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;                   /* Elimina márgenes del título */
            }

            .et-step:hover {
            transform: scale(1.15);
            }

            .et-step.active {
            background-color: var(--activo);
            box-shadow: 0 0 0 3px rgba(163, 190, 140, 0.3);
            }

            .et-modal-body {
            background-color: var(--fondo-elemento);
            padding: 20px;
            position: relative;
            border-radius: 0 0 12px 12px;
            }

            .et-carousel-item {
            display: none;
            align-items: center;
            justify-content: flex-start;
            text-align: left;
            gap: 15px;
            position: relative;
            min-height: 100px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            }

            .et-carousel-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            flex-shrink: 0;
            margin: 0;
            }

            .et-carousel-item .et-text-content {
            flex: 1;
            }

            .et-carousel-item h6 {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: var(--texto-primario);
            font-weight: 600;
            }

            .et-carousel-item p {
            font-size: 0.9rem;
            color: var(--texto-secundario);
            margin: 0;
            line-height: 1.5;
            }

            .et-carousel-inner {
            position: relative;
            height: auto;
            min-height: 100px;
            }

            .et-carousel-item.active {
            display: flex;
            opacity: 1;
            }

            .et-modal-carousel-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            width: 100%;
            }

            .et-modal-footer {
            background-color: var(--fondo-elemento);
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-top: 1px solid var(--borde);
            border-radius: 0 0 12px 12px;
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

            .btn-secondary {
            background-color: var(--fondo-oscuro);
            border: 1px solid var(--borde);
            color: var(--texto-primario);
            }

            .btn-secondary:hover {
            background-color: #1a1a1a;
            transform: translateY(-2px);
            }

            .et-stepper {
            position: relative;
            margin: 40px auto;
            max-width: 100%;
            width: 100%;
            height: 70px;
            }

            .et-modal {
            height: 60vh;
            display: flex;
            justify-content: center;
            align-items: center;
            }

            /* Nodos circulares */
            .et-step {
            position: absolute;
            width: 24px;
            height: 24px;
            background-color: var(--gris);
            border-radius: 50%;
            z-index: 3;
            border: 2px solid var(--fondo-panel);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.5rem;
            font-weight: bold;
            color: var(--texto-primario);
            }

            /* Posiciones de los nodos (ajustadas para nodos más grandes) */
            /* Registrado */
            .et-node-0 {
            top: 25px;
            left: 60px;
            }
            /* Recibido */
            .et-node-1 {
            top: 25px;
            left: 160px;
            }
            /* Archivado */
            .et-node-2 {
            top: -20px;
            left: 290px;
            }
            /* Derivado */
            .et-node-3 {
            top: 70px;
            left: 290px;
            }

            /* Línea desde "Registrado" a "Recibido" */
            .et-line-registrado-recibido {
            position: absolute;
            top: 35px;
            left: 70px;
            width: 85px;
            height: 3px;
            background-color: var(--gris);
            z-index: 1;
            }

            /* Línea desde "Recibido" al pivote */
            .et-line-horizontal {
            position: absolute;
            top: 35px;
            left: 155px;
            width: 60px;
            height: 3px;
            background-color: var(--gris);
            z-index: 1;
            }

            /* Punto pivote */
            .et-line-pivot {
            position: absolute;
            top: 31px;
            left: 215px;
            width: 10px;
            height: 10px;
            background-color: var(--gris);
            border-radius: 50%;
            z-index: 2;
            }

            /* Línea diagonal hacia nodo arriba ("Archivado") */
            .et-line-diag-up {
            position: absolute;
            top: 35px;
            left: 215px;
            width: 85px;
            height: 3px;
            background-color: var(--gris);
            transform-origin: left center;
            transform: rotate(-27deg);
            z-index: 1;
            }

            /* Línea diagonal hacia nodo abajo ("Derivado") */
            .et-line-diag-down {
            position: absolute;
            top: 35px;
            left: 215px;
            width: 85px;
            height: 3px;
            background-color: var(--gris);
            transform-origin: left center;
            transform: rotate(27deg);
            z-index: 1;
            }

            /* Títulos debajo de los nodos */
            .et-step-title {
            position: absolute;
            width: 80px;
            text-align: center;
            font-size: 15px;
            color: #646464;
            font-weight: 600;
            }

            /* Posiciones títulos ajustadas */
            /* Registrado */
            .et-title-0 {
            top: 50px;
            left: 30px;
            }
            /* Recibido */
            .et-title-1 {
            top: 50px;
            left: 130px;
            }
            /* Archivado */
            .et-title-2 {
            top: -20px;
            left: 310px;
            }
            /* Derivado */
            .et-title-3 {
            top: 70px;
            left: 308px;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                transform: translateY(30px);
                }
                to {
                opacity: 1;
                transform: translateY(0);
                }
            }

            .et-modal-estados-tramite .et-modal-dialog {
            animation: fadeInUp 0.5s ease-out;
            }

            @keyframes slideFadeOut {
                0% {
                    opacity: 1;
                transform: translateY(0);
                scale: 1;
                }
                100% {
                opacity: 0;
                transform: translateY(40px);
                scale: 0.95;
                }
            }

            .et-modal-estados-tramite.hide-animation .et-modal-dialog {
            animation: slideFadeOut 0.5s ease-out forwards;
            }

            .et-carousel-control-prev,
            .et-carousel-control-next {
            position: static;
            transform: none;
            width: 40px;
            height: 40px;
            background-color: #cccccc; /* Fondo del botón */
            border-radius: 4px;         /* Bordes levemente redondeados */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 1;                 /* Visibilidad total */
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
            }

            .et-carousel-control-prev:hover,
            .et-carousel-control-next:hover {
            opacity: 1;
            background-color: #aaaaaa;
            }

            /* Elimina el óvalo y el ícono SVG predeterminado de Bootstrap */
            .et-carousel-control-prev-icon,
            .et-carousel-control-next-icon {
            background-image: none; /* Elimina la flecha por defecto */
            width: 0;
            height: 0;
            position: relative;
            }

            /* Agrega tus propias flechas con pseudoelementos */
            .et-carousel-control-next::after {
            content: '▶';
            /* Flecha hacia la derecha */
            font-size: 20px;
            color: black;
            }

            .et-carousel-control-prev::after {
            content: '◀';
            /* Flecha hacia la izquierda */
            font-size: 20px;
            color: black;
            }
        </style>

        <!-- html2canvas para capturar el contenido como imagen -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <!-- jsPDF para generar el PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <!-- Tu archivo JavaScript personalizado -->
        <script src="../../asset/js/seguimientoTramite.js"></script>

        <script>
        // Detener Polling de Mensajes
        delete window.habilitarPollingMensajes;
        // Detener Polling de Chat
        delete window.habilitarPollingChat;
        </Script>
        <?php
        return ob_get_clean();
    }
}
?>
