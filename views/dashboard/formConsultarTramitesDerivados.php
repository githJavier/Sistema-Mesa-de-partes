<?php 
class formConsultarTramitesDerivados{
    public function formConsultarTramitesDerivadosShow(){
        ob_start();
        //Formularios para ver el seguimiento de los Tramites
        ?>
        <div class="container my-5 p-4 bg-white rounded shadow">
            <h1 class="mb-4 border-bottom pb-2 text-dark">CONSULTAR TRÁMITES DERIVADOS</h1>

            <!-- Formulario de filtros -->
            <form class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="search" class="form-label">Buscar:</label>
                    <input type="text" class="form-control" id="search" placeholder="ID, expediente, área...">
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date-from" class="form-label">Fecha desde:</label>
                    <input type="date" class="form-control" id="date-from">
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label for="date-to" class="form-label">Fecha hasta:</label>
                    <input type="date" class="form-control" id="date-to">
                </div>
                <div class="col-12 col-sm-6 col-md-3 d-flex align-items-end gap-2">
                    <button type="button" class="btn btn-all w-50" id="filter-btn">Filtrar</button>
                    <button type="button" class="btn btn-all w-50" id="reset-btn">Limpiar</button>
                </div>
            </form>

            <!-- Control de cantidad -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <label for="cst-items-per-page-top" class="form-label m-0">Muestra</label>
                <select class="form-select w-auto" id="cst-items-per-page-top">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span id="total-entries" class="ms-1">entradas</span>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tramites-table">
                    <thead class="table-dark">
                        <tr>
                            <th data-field="id">ID</th>
                            <th data-field="expediente">Expediente</th>
                            <th data-field="hora">Hora</th>
                            <th data-field="fecha">Fecha</th>
                            <th data-field="area">Área Destino</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Datos dinámicos -->
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
                    <button class="btn btn-all disabled" id="prev-page">Anterior</button>
                    <button class="btn btn-all disabled" id="next-page">Siguiente</button>
                </div>
            </div>
        </div>
        <script src="../../asset/js/tramiteDerivado.js"></script>
        <?php
        return ob_get_clean();
    }
}
?>