<?php 
class formAdministrarRemitentes {
    public function formAdministrarRemitentesShow($remitentes) {
        ob_start();
        ?>
        <div class="container py-4">
            <h3 class="mb-4 border-bottom pb-2 text-dark"> <i class="fas fa-address-book text-dark me-2"></i>Listado de Remitentes</h3>

            <!-- Filtro y Botones -->
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <input type="text" id="search" placeholder="ID, Nombres, celular..." class="form-control">
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex align-items-end gap-2">
                    <button id="search-btn" class="btn btn-dark flex-fill" onclick="searchItem()">
                        <i class="fas fa-search me-1"></i> Buscar
                    </button>
                    <button id="create-btn" class="btn btn-dark flex-fill" data-bs-toggle="modal" data-bs-target="#crearRemitenteModal">
                        <i class="fas fa-plus me-1"></i> Crear
                    </button>
                </div>
            </div>
            <div class="mb-3 d-flex align-items-center gap-2">
                <label for="select-page-size" class="mb-0">Mostrar:</label>
                <select id="select-page-size" class="form-select form-select-sm w-auto">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>registros</span>
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
                        foreach ($remitentes as $remitente){?>
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
                        }?>
                    </tbody>
                </table>
                <div id="no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
            <div id="pagination-info" class="text-muted text-center text-md-start">
                <!-- Este contenido se actualizará dinámicamente -->
            </div>

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
        <div class="modal fade" id="crearRemitenteModal" tabindex="-1" aria-labelledby="crearRemitenteModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="crearRemitenteModalLabel"><i class="fas fa-user-plus me-2"></i>Crear Remitente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <form id="create-form">
                  <div class="mb-3">
                    <label for="nombre" class="form-label">Nombres</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-user"></i></span>
                      <input type="text" class="form-control" id="nombre" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="celular" class="form-label">Celular</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      <input type="text" class="form-control" id="celular" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      <input type="email" class="form-control" id="correo" required>
                    </div>
                  </div>
                  <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-dark">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Script para manejar el envío del formulario -->
        <script>
            document.getElementById('create-form').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'success',
                    title: 'Remitente creado',
                    text: 'El remitente se ha creado correctamente.',
                    confirmButtonColor: '#000000'
                });
                const modal = bootstrap.Modal.getInstance(document.getElementById('crearRemitenteModal'));
                modal.hide();
            });
        </script>

        <!-- Script propio -->
        <script src="../../asset/js/administrarRemitentes.js"></script>
        <?php
        return ob_get_clean();
    }
}
?>
