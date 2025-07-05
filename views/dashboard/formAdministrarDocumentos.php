<?php 
class formAdministrarDocumentos{
    public function formAdministrarDocumentosShow($tiposDocumento){
        ob_start();
        //Formularios para ver los Tipo de Documento
        ?>
        <div class="container py-4">
            <h3 class="mb-4 border-bottom pb-2 text-dark">
                <i class="fas fa-users text-dark me-2"></i>Gestión de Tipos de Documento
            </h3>

            <!-- Filtro y Botones -->
            <div class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-auto d-flex align-items-center">
                        <label for="tipoDocumentos-select-page-size" class="me-2 mb-0">Mostrar:</label>
                        <select id="tipoDocumentos-select-page-size" class="form-select form-select-sm w-auto">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                        <span class="ms-2">registros</span>
                    </div>

                    <div class="col-12 col-md">
                        <div class="row justify-content-md-end g-2">
                            <div class="col-12 col-md-auto">
                                <input type="text" id="tipoDocumentos-search" placeholder="ID, Nombres, tipo, estado..." class="form-control" />
                            </div>
                            <div class="col-12 col-md-auto">
                                <button class="btn btn-dark w-100" onclick="cargarCrearTipoDocumento()">
                                    <i class="fas fa-user-plus"></i> Crear Nuevo Tipo de Documento
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tipoDocumentos-table">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Abreviatura</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($tiposDocumento as $tipoDocumento){ ?>
                        <tr> 
                            <td><?=$contador?></td>
                            <td><?=$tipoDocumento['tipodocumento'];?></td>
                            <td><?=$tipoDocumento['abreviatura'];?></td>
                            <td>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button
                                    type="button"
                                    title="Editar"
                                    class="btn"
                                    onclick="cargarDatosTipoDocumento(<?= $tipoDocumento['cod_tipodocumento']; ?>);">
                                    <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button 
                                    type="button"
                                    title="Eliminar"
                                    class="btn"
                                    onclick="cargarDatosEliminar(<?= $tipoDocumento['cod_tipodocumento']; ?>)">
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php 
                        $contador++;
                        } ?>
                    </tbody>
                </table>
                <div id="tipoDocumentos-no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div id="tipoDocumentos-pagination-info" class="text-muted text-center text-md-start"></div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-dark" id="tipoDocumentos-prev-page">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </button>
                    <button class="btn btn-dark" id="tipoDocumentos-next-page">
                        Siguiente <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Bootstrap para crear tipo de documento -->
        <div class="modal fade" id="crearTipoDocumentoModal" tabindex="-1" aria-labelledby="crearTipoDocumentoModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="crearTipoDocumentoModalLabel">
                  <i class="fas fa-file-alt me-2"></i> Crear Tipo de Documento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="formCrearTipoDocumento">
                  <div class="mb-3">
                    <label for="crearNombreTipoDocumento" class="form-label">Nombre del Tipo de Documento</label>
                    <input type="text" class="form-control" id="crearNombreTipoDocumento" name="nombreTipoDocumento">
                    <span id="errorCrearNombreTipoDocumento" class="form-text text-danger" style="display: none;">Este campo es obligatorio.</span>
                  </div>

                  <div class="mb-3">
                    <label for="crearAbreviaturaTipoDocumento" class="form-label">Abreviatura</label>
                    <input type="text" class="form-control" id="crearAbreviaturaTipoDocumento" name="abreviaturaTipoDocumento">
                    <span id="errorCrearAbreviaturaTipoDocumento" class="form-text text-danger" style="display: none;">Este campo es obligatorio.</span>
                  </div>

                  <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalCrearTipoDocumento()">Cancelar</button>
                    <button type="button" class="btn btn-dark" id="btnCrearTipoDocumento" onclick="enviarFormCrear()">Crear</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>


        <!-- Modal Confirmar Eliminar -->
        <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-triangle-exclamation me-2"></i> Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" id="eliminarTipoDocumentoId">
                ¿Estás seguro de que deseas eliminar este tipo de documento? Esta acción no se puede deshacer.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-dark" id="btnEliminarConfirmado" onclick="enviarFormEliminar()">Eliminar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Bootstrap para editar tipo de documento -->
        <div class="modal fade" id="editarTipoDocumentoModal" tabindex="-1" aria-labelledby="editarTipoDocumentoModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editarTipoDocumentoModalLabel">
                   <i class="fas fa-file-alt me-2"></i> Editar Tipo de Documento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="formEditarTipoDocumento">
                  <input type="hidden" id="editTipoDocumentoId"> <!-- ID oculto para editar -->

                  <div class="mb-3">
                    <label for="nombreTipoDocumento" class="form-label">Nombre del Tipo de Documento</label>
                    <input type="text" class="form-control" id="editNombreTipoDocumento" name="nombreTipoDocumento">
                    <span id="errorNombreTipoDocumento" class="form-text text-danger" style="display: none;">Este campo es obligatorio.</span>
                  </div>

                  <div class="mb-3">
                    <label for="abreviaturaTipoDocumento" class="form-label">Abreviatura</label>
                    <input type="text" class="form-control" id="editAbreviaturaTipoDocumento" name="abreviaturaTipoDocumento">
                    <span id="errorAbreviaturaTipoDocumento" class="form-text text-danger" style="display: none;">Este campo es obligatorio.</span>
                  </div>

                  <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-dark" id="btnActualizarTipoDocumento" onclick="enviarFormEditar()">Actualizar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <style>
          .form-text.text-danger {
            margin-top: 2px;  /* Bien pegado al input */
            font-size: 0.85rem;
          }
        </style>

        <script src="../../asset/js/pagination.js"></script>
        <script src="../../asset/js/administrarTiposDocumento.js"></script>
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
