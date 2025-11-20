<?php
class formAdministrarUsuarios {
    public function formAdministrarUsuariosShow($usuarios) {
        ob_start();
        ?>
        <div class="container py-4">
            <h3 class="mb-4 border-bottom pb-2 text-dark">
                <i class="fas fa-users text-dark me-2"></i>Listado de Usuarios
            </h3>

            <!-- Filtro y Botones -->
            <div class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-auto d-flex align-items-center">
                        <label for="usuarios-select-page-size" class="me-2 mb-0">Mostrar:</label>
                        <select id="usuarios-select-page-size" class="form-select form-select-sm w-auto">
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
                                <input type="text" id="usuarios-search" placeholder="ID, Nombres, tipo, estado..." class="form-control" />
                            </div>
                            <div class="col-12 col-md-auto">
                                <button class="btn btn-dark w-100" onclick="cargarDatosCrearUsuario()">
                                    <i class="fas fa-user-plus"></i> Crear Usuario
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="usuarios-table">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Tipo</th>
                            <th>Area</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($usuarios as $usuario){ ?>
                        <tr> 
                            <td><?=$contador?></td>
                            <td><?php echo $usuario['nombre']." ".$usuario['ap_paterno']." ".$usuario['ap_materno'];?></td>
                            <td><?=$usuario['tipo'];?></td>
                            <td><?=$usuario['area'];?></td>
                            <td>
                                <?php echo ($usuario['estado'] == 1) ? 'Activo' : 'Inactivo'; ?>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button
                                    type="button"
                                    title="Editar"
                                    class="btn"
                                    onclick="cargarDatosUsuario(<?= $usuario['cod_usuario']; ?>);">
                                    <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button 
                                    type="button"
                                    title="Eliminar"
                                    class="btn"
                                    onclick="cargarDatosEliminar(<?= $usuario['cod_usuario']; ?>)">
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
                <div id="usuarios-no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div id="usuarios-pagination-info" class="text-muted text-center text-md-start"></div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-dark" id="usuarios-prev-page">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </button>
                    <button class="btn btn-dark" id="usuarios-next-page">
                        Siguiente <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Bootstrap para crear usuario -->
        <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="crearUsuarioModalLabel">
                  <i class="fas fa-user-plus me-2"></i> Crear Usuario
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="create-form">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="createTipoDocumento" class="form-label">Tipo de Documento</label>
                      <div class="input-group">
                        <select class="form-select" id="createTipoDocumento">
                          <!-- Se llenará con JS -->
                        </select>
                      </div>
                      <span id="createTipoDocumentoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="col-md-6">
                      <label for="createNumeroDocumento" class="form-label">Número de Documento</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control" id="createNumeroDocumento" placeholder="Ingrese DNI o RUC">
                      </div>
                      <span id="createNumeroDocumentoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12">
                      <label for="createNombreUsuario" class="form-label">Nombre</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="createNombreUsuario" placeholder="Ingrese nombre">
                      </div>
                      <span id="createNombreUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="createApellidoPaterno" class="form-label">Apellido Paterno</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="createApellidoPaterno" placeholder="Ingrese apellido paterno">
                      </div>
                      <span id="createApellidoPaternoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="col-md-6">
                      <label for="createApellidoMaterno" class="form-label">Apellido Materno</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="createApellidoMaterno" placeholder="Ingrese apellido materno">
                      </div>
                      <span id="createApellidoMaternoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="createTipoUsuario" class="form-label">Tipo</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <select class="form-select" id="createTipoUsuario">
                          <!-- Se llenará con JS -->
                        </select>
                      </div>
                      <span id="createTipoUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="col-md-6">
                      <label for="createEstadoUsuario" class="form-label">Estado</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <select class="form-select" id="createEstadoUsuario">
                          <!-- Se llenará con JS -->
                        </select>
                      </div>
                      <span id="createEstadoUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12">
                      <label for="createAreaUsuario" class="form-label">Área</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <select class="form-select" id="createAreaUsuario">
                          <!-- Se llenará con JS -->
                        </select>
                      </div>
                      <span id="createAreaUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="createUsuario" class="form-label">Usuario</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="createUsuario" placeholder="Ingrese usuario">
                      </div>
                      <span id="createUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="col-md-6">
                      <label for="createPassword" class="form-label">Contraseña</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" id="createPassword" placeholder="Ingrese contraseña">
                      </div>
                      <span id="createPasswordError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalCrearUsuario()">Cancelar</button>
                    <button type="button" class="btn btn-dark" onclick="enviarForm()" id="registrarUsuario">Guardar</button>
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
                  <input type="hidden" id="eliminarUsuarioId">
                  ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-dark" id="btnEliminarConfirmado" onclick="enviarFormEliminar()">Eliminar</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Bootstrap para editar usuario -->
          <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editarUsuarioModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Editar Usuario
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                  <form id="edit-form">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="hidden" id="editUsuarioId">
                        <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                        <div class="input-group">
                          <select class="form-select" id="editTipoDocumento">
                            <!-- Se llenará con JS -->
                          </select>
                        </div>
                        <span id="editTipoDocumentoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                      </div>
                      <div class="col-md-6">
                        <label for="numeroDocumento" class="form-label">Número de Documento</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                          <input type="text" class="form-control" id="editNumeroDocumento" placeholder="Ingrese DNI o RUC">
                        </div>
                        <span id="editNumeroDocumentoError" class="form-text text-danger" style="display:none;"></span>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-12">
                        <label for="nombreUsuario" class="form-label">Nombre</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                          <input type="text" class="form-control" id="editNombreUsuario" placeholder="Ingrese nombre">
                        </div>
                        <span id="editNombreUsuarioError" class="form-text text-danger" style="display:none;"></span>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-6">
                        <label for="apellidoPaterno" class="form-label">Apellido Paterno</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                          <input type="text" class="form-control" id="editApellidoPaterno" placeholder="Ingrese apellido paterno">
                        </div>
                        <span id="editApellidoPaternoError" class="form-text text-danger" style="display:none;"></span>
                      </div>
                      <div class="col-md-6">
                        <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                          <input type="text" class="form-control" id="editApellidoMaterno" placeholder="Ingrese apellido materno">
                        </div>
                        <span id="editApellidoMaternoError" class="form-text text-danger" style="display:none;"></span>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-6">
                        <label for="editTipoUsuario" class="form-label">Tipo</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                          <select class="form-select" id="editTipoUsuario">
                            <!-- Se llenará con JS -->
                          </select>
                        </div>
                        <span id="editTipoUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                      </div>
                      <div class="col-md-6">
                        <label for="estadoUsuario" class="form-label">Estado</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                          <select class="form-select" id="editEstadoUsuario">
                            <!-- Se llenará con JS -->
                          </select>
                        </div>
                        <span id="editEstadoUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-12">
                        <label for="editAreaUsuario" class="form-label">Área</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-building"></i></span>
                          <select class="form-select" id="editAreaUsuario">
                            <!-- Opciones se insertan dinámicamente con JavaScript -->
                          </select>
                        </div>
                        <span id="editAreaUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-6">
                        <label for="usuario" class="form-label">Usuario</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                          <input type="text" class="form-control" id="editUsuario" placeholder="Ingrese usuario">
                        </div>
                        <span id="editUsuarioError" class="form-text text-danger" style="display:none;"></span>
                      </div>

                      <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fas fa-key"></i></span>
                          <input type="password" class="form-control" id="editPassword" placeholder="Ingrese nueva contraseña">
                        </div>
                        <span id="editPasswordError" class="form-text text-danger" style="display:none;"></span>
                      </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-dark" onclick="enviarFormEditar()" id="editarUsuario">Actualizar</button>
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
        <script src="../../asset/js/administrarUsuarios.js"></script>
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
