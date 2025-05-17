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
                                <button class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#crearUsuarioModal">
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
                                    onclick="">
                                    <i class="fas fa-pen-to-square"></i>
                                    </button>
                                    <button 
                                    type="button"
                                    title="Eliminar"
                                    class="btn"
                                    onclick="">
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

        <!-- Modal Bootstrap para crear remitente -->
        <div class="modal fade" id="crearUsuarioModal" tabindex="-1" aria-labelledby="crearUsuarioModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="crearUsuarioModalLabel">
                  <i class="fas fa-user-plus me-2"></i> Crear Remitente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="create-form">
                  <div class="row">
                    <div class="col-md-6">
                      <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                      <select class="form-select" id="tipoDocumento">
                        <option selected>L.E / DNI</option>
                        <option>CARNET EXT.</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="numeroDocumento" class="form-label">Número de Documento</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control" id="numeroDocumento" placeholder="Ingrese DNI o RUC">
                      </div>
                      <span id="numeroDocumentoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12">
                      <label for="nombreUsuario" class="form-label">Nombre</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="nombreUsuario" placeholder="Ingrese nombre">
                      </div>
                      <span id="nombreUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="apellidoPaterno" class="form-label">Apellido Paterno</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="apellidoPaterno" placeholder="Ingrese apellido paterno">
                      </div>
                      <span id="apellidoPaternoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="col-md-6">
                      <label for="apellidoMaterno" class="form-label">Apellido Materno</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="apellidoMaterno" placeholder="Ingrese apellido materno">
                      </div>
                      <span id="apellidoMaternoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="tipoUsuario" class="form-label">Tipo</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                        <input type="text" class="form-control" id="tipoUsuario" placeholder="Ingrese tipo de usuario">
                      </div>
                      <span id="tipoUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="col-md-6">
                      <label for="estadoUsuario" class="form-label">Estado</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                        <select class="form-select" id="estadoUsuario">
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                        </select>
                      </div>
                      <span id="estadoUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12">
                      <label for="areaUsuario" class="form-label">Área</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                        <select class="form-select" id="areaUsuario">
                          <option value="20">OFICINA TRÁMITE DOCUMENTARIO</option>
                          <option value="21">JEFE DE SISTEMAS</option>
                          <option value="22">GERENCIA</option>
                        </select>
                      </div>
                      <span id="areaUsuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="usuario" class="form-label">Usuario</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                        <input type="text" class="form-control" id="usuario" placeholder="Ingrese usuario">
                      </div>
                      <span id="usuarioError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>

                    <div class="col-md-6">
                      <label for="password" class="form-label">Contraseña</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input type="password" class="form-control" id="password" placeholder="Ingrese contraseña">
                      </div>
                      <span id="passwordError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
                <input type="hidden" id="eliminarRemitenteId">
                ¿Estás seguro de que deseas eliminar este remitente? Esta acción no se puede deshacer.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-dark" id="btnEliminarConfirmado" onclick="enviarFormEliminar()">Eliminar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal Bootstrap para editar remitente -->
        <div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editarUsuarioModalLabel">
                  <i class="fas fa-user-pen me-2"></i> Editar Remitente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="edit-form">
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label">Tipo de Documento</label>
                      <input type="text" class="form-control" id="editTipoDocumento" readonly>
                    </div>

                    <div class="col-md-6">
                      <label for="editDocumento" class="form-label">Número de Documento</label>
                      <input type="text" class="form-control" id="editDocumento" readonly>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12">
                      <label for="editNombre" class="form-label">Nombre o Razón Social</label>
                      <input type="text" class="form-control" id="editNombre" readonly>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-12">
                      <label for="editEmail" class="form-label">Correo Electrónico</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control" id="editEmail" placeholder="Ingrese correo electrónico">
                      </div>
                      <span id="editEmailError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-md-6">
                      <label for="editTelefono" class="form-label">Teléfono</label>
                      <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                        <input type="text" class="form-control" id="editTelefono" placeholder="Ingrese teléfono">
                      </div>
                      <span id="editTelefonoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>

                    <div class="col-md-6">
                      <label for="editEstado" class="form-label">Estado</label>
                      <select class="form-select" id="editEstado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      </select>
                    </div>
                  </div>

                  <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-dark" onclick="enviarFormEditar()" id="Editar" name="Editar">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <script src="../../asset/js/pagination.js"></script>
        <script src="../../asset/js/administrarUsuarios.js"></script>
        <?php 
        return ob_get_clean();
    }
}
?>
