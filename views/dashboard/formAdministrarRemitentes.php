<?php 
class formAdministrarRemitentes {
    public function formAdministrarRemitentesShow() {
        ob_start();
        ?>
        <div class="container py-4">
            <!-- Título con ícono Font Awesome -->
            <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center text-center mb-4 gap-3">
                <i class="fas fa-address-book fa-3x text-dark"></i>
                <h1 class="text-dark mb-0">Listado de Remitentes</h1>
            </div>

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
                        <tr>
                            <td>1</td>
                            <td>Remitente 1</td>
                            <td>994040464</td>
                            <td>jeampierbarrios04@gmail.com</td>
                            <td>
                                <button class="btn btn-sm btn-dark" onclick="editItem(1)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-dark" onclick="deleteItem(1)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="no-results" class="text-center text-muted fst-italic py-3 d-none">
                    No hay ningún registro
                </div>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                <div id="pagination-info" class="text-muted text-center text-md-start">
                    Mostrando 0 a 0 de 0 entradas
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <button class="btn btn-dark disabled" id="prev-page">
                        <i class="fas fa-arrow-left"></i> Anterior
                    </button>
                    <button class="btn btn-dark disabled" id="next-page">
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
