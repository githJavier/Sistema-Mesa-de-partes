<?php
class GetFormArchivarTramite {
  public function formArchivarTramiteShow($codigo_tramite, $asunto, $fechaRegistro, $horaRegistro, $num_documento) {
    ob_start();
    ?>
    <div class="d-flex justify-content-center">
      <h3>ARCHIVAR TRÁMITE</h3>
    </div> 

    <form>
      <div class="container bg-white p-0">
        <div class="separador-titulo mt-2">DATOS PARA ARCHIVO</div>
        
        <!-- FECHA y HORA -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="FECHA_ARCHIVO" class="form-text">FECHA</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-calendar-alt"></i></span>
              <input type="text" class="form-control input-readonly" id="FECHA_ARCHIVO" name="FECHA_ARCHIVO" value="<?= htmlspecialchars($fechaRegistro) ?>" readonly>
            </div>
          </div>

          <div class="col-md-6">
            <label for="HORA_ARCHIVO" class="form-text">HORA</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-clock"></i></span>
              <input type="text" class="form-control input-readonly" id="HORA_ARCHIVO" name="HORA_ARCHIVO" value="<?= htmlspecialchars($horaRegistro) ?>" readonly>
            </div>
          </div>
        </div>

        <!-- Campo oculto para num_documento -->
        <input type="hidden" id="NUM_DOCUMENTO" name="NUM_DOCUMENTO" value="<?= htmlspecialchars($num_documento) ?>">

        <!-- EXPEDIENTE y ASUNTO -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="EXPEDIENTE" class="form-text">N° DE EXPEDIENTE</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-folder-open"></i></span>
              <input type="text" class="form-control input-readonly" id="EXPEDIENTE" name="EXPEDIENTE" value="<?= htmlspecialchars($codigo_tramite) ?>" readonly>
            </div>
          </div>

          <div class="col-md-6">
            <label for="ASUNTO_ARCHIVO" class="form-text">ASUNTO</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
              <input type="text" class="form-control input-readonly" id="ASUNTO_ARCHIVO" name="ASUNTO_ARCHIVO" value="<?= htmlspecialchars($asunto) ?>" readonly>
            </div>
          </div>
        </div>

        <!-- MOTIVO -->
        <div class="row mb-4">
          <div class="col-md-12">
            <label for="MOTIVO_ARCHIVO" class="form-text">MOTIVO DEL ARCHIVO</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" name="MOTIVO_ARCHIVO" id="MOTIVO_ARCHIVO" rows="4" placeholder="Escriba el motivo del archivo"></textarea>
            </div>
            <span id="motivoArchivoError" class="text-danger ms-5" style="display:none;"></span>
          </div>
        </div>

        <!-- BOTONES -->
        <div class="d-grid gap-2 col-12 col-md-6 col-lg-4 mx-auto mt-4 mb-4">
          <button type="button" class="btn btn-enviarTramite w-100 px-3 py-2" onclick="archivarTramite()">ARCHIVAR</button>
          <button type="button" class="btn btn-secondary w-100 px-3 py-2 mt-2" onclick="cargarformularioResolverTramites()">CANCELAR</button>
        </div>
      </div>
    </form>

    <script src="../../asset/js/tramite.js"></script>
    <?php
    return ob_get_clean();
  }
}
?>
