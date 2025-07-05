<?php
class formAdministrarAreas{
    public function formAdministrarAreasShow($areas){
        ob_start();
        //Formularios para ver las áreas
        ?>
        <div class="container py-4">
            <h3 class="mb-4 border-bottom pb-2 text-dark">
                <i class="fas fa-building text-dark me-2"></i>Gestión de áreas
            </h3>

            <!-- Filtro y Botones -->
            <div class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-auto d-flex align-items-center">
                        <label for="areas-select-page-size" class="me-2 mb-0">Mostrar:</label>
                        <select id="areas-select-page-size" class="form-select form-select-sm w-auto">
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
                                <input type="text" id="areas-search" placeholder="Buscar área..." class="form-control" />
                            </div>
                            <div class="col-12 col-md-auto">
                                <button class="btn btn-dark w-100" onclick="cargarCrearArea()">
                                    <i class="fas fa-plus"></i> Crear Área
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Áreas -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="areas-table">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th>ID</th>
                            <th>Área</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($areas as $area){ ?>
                        <tr> 
                            <td><?=$contador?></td>
                            <td><?=$area['area'];?></td>
                            <td>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button
                                    type="button"
                                    title="Editar"
                                    class="btn"
                                    onclick="cargarDatosArea(<?= $area['cod_area']; ?>);">
                                    <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button 
                                    type="button"
                                    title="Eliminar"
                                    class="btn"
                                    onclick="cargarDatosEliminar(<?= $area['cod_area']; ?>)">
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
                <!-- Mensaje cuando no haya resultados -->
                <div id="areas-no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>


            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div id="areas-pagination-info" class="text-muted text-center text-md-start"></div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-dark" id="areas-prev-page">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </button>
                    <button class="btn btn-dark" id="areas-next-page">
                        Siguiente <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Modal para Crear Área -->
            <div class="modal fade" id="crearAreaModal" tabindex="-1" aria-labelledby="crearAreaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearAreaModalLabel">
                                <i class="fas fa-building me-2"></i> Crear Área
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form id="create-area-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="crearNombreArea" class="form-label">Nombre del Área</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            <input type="text" class="form-control" id="crearNombreArea" name="crearNombreArea" placeholder="Ingrese nombre del área">
                                        </div>
                                        <span id="errorCrearNombreArea" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-secondary" onclick="cerrarModalCrearArea()">Cancelar</button>
                                    <button type="button" class="btn btn-dark" id="btnCrearArea" onclick="enviarFormCrear()">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Confirmar Eliminación -->
            <div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalConfirmarEliminarLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalConfirmarEliminarLabel">
                                <i class="fas fa-trash me-2"></i> Confirmar Eliminación
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="eliminarAreaId"> <!-- ID del área a eliminar -->
                            <p>¿Estás seguro de que deseas eliminar esta área? Esta acción no se puede deshacer.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-dark" id="btnEliminarArea"
                                onclick="enviarFormEliminar()">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal para Editar Área -->
            <div class="modal fade" id="editarAreaModal" tabindex="-1" aria-labelledby="editarAreaModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarAreaModalLabel">
                                <i class="fas fa-edit me-2"></i> Editar Área
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form id="edit-area-form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="nombreAreaEdit" class="form-label">Nombre del Área</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            <input type="text" class="form-control" id="editNombreArea" placeholder="Ingrese nombre del área">
                                        </div>
                                        <span id="errorEditarNombreArea" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                                    </div>
                                </div>

                                <input type="hidden" id="editAreaId"> <!-- Campo oculto para el ID del área -->

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <!-- El botón "Cancelar" debería cerrar el modal correctamente -->
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-dark" onclick="enviarFormEditar()">Guardar</button>
                                </div>
                            </form>
                        </div>
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
        <script src="../../asset/js/administrarAreas.js"></script>
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
