<?php 
class formSeguimientoTramite{
    public function formSeguimientoTramiteShow($tramites){
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
                        <option value="SOLICITUD">Solicitud</option>
                        <option value="APERSONAMIENTO">Apersonamiento</option>
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
            <!-- Control de cantidad -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <div class="d-flex align-items-center">
        <label for="cst-items-per-page-top" class="form-text m-0 me-2">Muestra</label>
        <select class="form-select w-auto" id="cst-items-per-page-top">
            <option value="5" >5</option>
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>
        <span id="total-entries" class="ms-1 form-text">entradas</span>
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
                            <td class="td-codigo"><?= strtoupper($tramite['codigo_generado']) ?></td>
                            <td class="td-tipo"><?= strtoupper($tramite['tipodocumento']) ?></td>
                            <td class="td-fecha"><?= strtoupper($tramite['fec_reg']) ?></td>
                            <td class="td-estado"><?= strtoupper($tramite['estado'] ?? 'NO DEFINIDO') ?></td>
                            <td>
                            <button class="btn btn-all btn-sm"
                                onclick="verDetalles(
                                    '<?= $tramite['codigo_generado'] ?>',
                                    '<?= addslashes($tramite['tipodocumento']) ?>',
                                    '<?= addslashes($tramite['asunto']) ?>',
                                    '<?= $tramite['fec_reg'] ?>',
                                    '<?= $tramite['remitente'] ?>',
                                    <?= htmlspecialchars(json_encode($tramite['detallestramite']), ENT_QUOTES, 'UTF-8') ?>
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
                    Mostrando 0 a 0 de 0 entradas
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
                            <button class="btn btn-danger btn-sm" onclick="generarPDF()">
                                <i class="bi bi-file-earmark-pdf"></i> Generar PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>
        </div>
        </div>

        <!-- html2canvas para capturar el contenido como imagen -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

        <!-- jsPDF para generar el PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <!-- Tu archivo JavaScript personalizado -->
        <script src="../../asset/js/seguimientoTramite.js"></script>

        <?php
        return ob_get_clean();
    }
}
?>
