<?php 
class formAdministrarRemitentes {
    public function formAdministrarRemitentesShow($remitentes) {
        ob_start();
        ?>
        <div class="container py-4">
            <h3 class="mb-4 border-bottom pb-2 text-dark">
                <i class="fas fa-address-book text-dark me-2"></i>Listado de Remitentes
            </h3>

            <!-- Filtro y Botones -->
            <div class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-auto d-flex align-items-center">
                        <label for="select-page-size" class="me-2 mb-0">Mostrar:</label>
                        <select id="select-page-size" class="form-select form-select-sm w-auto">
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
                                <input type="text" id="search" placeholder="ID, Nombres, celular..." class="form-control" />
                            </div>
                            <div class="col-12 col-md-auto">
                                <button class="btn btn-dark w-100" data-bs-toggle="modal" data-bs-target="#crearRemitenteModal">
                                    <i class="fas fa-plus"></i> Crear Remitente
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="data-table">
                    <thead class="table-dark text-nowrap">
                        <tr>
                            <th>ID</th>
                            <th>Nombres</th>
                            <th>Celular</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $contador = 1;
                        foreach ($remitentes as $remitente){ ?>
                        <tr> 
                            <td><?=$contador?></td>
                            <td><?=$remitente['nombres'];?></td>
                            <td><?=$remitente['telefono_celular'];?></td>
                            <td><?=$remitente['correo'];?></td>
                            <td>
                                <a href="editar.php?id=<?= urlencode($remitente['idremite']); ?>" title="Editar">
                                    <i class="fas fa-edit icon-table"></i>
                                </a>
                                &nbsp;&nbsp;
                                <a href="eliminar.php?id=<?= urlencode($remitente['idremite']); ?>" title="Eliminar" onclick="return confirm('¿Estás seguro?');">
                                    <i class="fas fa-trash-alt icon-table"></i>
                                </a>
                            </td>
                        </tr>
                        <?php 
                        $contador++;
                        } ?>
                    </tbody>
                </table>
                <div id="no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div id="pagination-info" class="text-muted text-center text-md-start"></div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-dark" id="prev-page">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button class="btn btn-dark" id="next-page">
                        Siguiente <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Bootstrap para crear remitente -->
        <!-- Modal -->
        <div class="modal fade" id="crearRemitenteModal" tabindex="-1" aria-labelledby="crearRemitenteModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="crearRemitenteModalLabel">
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
                        <option selected>DNI</option>
                        <option>RUC</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label for="documento" class="form-label">Número de Documento</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="documento" placeholder="Ingrese DNI o RUC">
                        <button type="button" class="btn btn-dark input-group-text" onclick="consultarDocumento()">
                          <i class="fa fa-search"></i>
                        </button>
                      </div>
                      <span id="documentoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    
                  </div>

                  <div class="row mt-3">
                        <div class="col-md-12">
                          <label for="nombre" class="form-label">Nombre o Razón Social</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="nombre" placeholder="Ingrese nombre o razón social" disabled>
                          </div>
                          <span id="nombreError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                  </div>
                  
                  <div class="row mt-3">
                        <div class="col-md-12">
                          <label for="correo" class="form-label">Correo Electrónico</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="text" class="form-control" id="email" placeholder="Ingrese correo electrónico">
                          </div>
                          <span id="emailError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                  </div>

                  <div class="row mt-3">
                      <div class="col-md-6">
                          <label for="telefono" class="form-label">Teléfono</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" id="telefono" placeholder="Ingrese teléfono">
                          </div>
                          <span id="telefonoError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-md-6">
                          <label for="password" class="form-label">Contraseña</label>
                          <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" placeholder="Ingrese contraseña">
                          </div>
                          <span id="passwordError" class="form-text text-danger" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                  <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-dark" onclick="enviarForm()">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Scripts -->
        <script src="../../asset/js/administrarRemitentes.js"></script>
        
        <?php
        return ob_get_clean();
    }
}
?>
