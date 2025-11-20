<?php
class GetFormDerivarTramite {
  public function formDerivarTramiteShow($codigo_tramite, $asunto, $fechaRegistro, $horaRegistro, $num_documento, $cod_detalle_tramite) {
    ob_start();
    ?>
    <div class="d-flex justify-content-center">
      <h3>DERIVAR TRÁMITE</h3>
    </div> 

    <form>
      <div class="container bg-white p-0">
        <div class="separador-titulo mt-2">DATOS PARA DERIVACIÓN</div>

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

        <!-- Campos ocultos -->
        <input type="hidden" id="NUM_DOCUMENTO" name="NUM_DOCUMENTO" value="<?= htmlspecialchars($num_documento) ?>">
        <input type="hidden" id="COD_DETALLE_TRAMITE" name="COD_DETALLE_TRAMITE" value="<?= htmlspecialchars($cod_detalle_tramite) ?>">

        <!-- ASUNTO -->
        <div class="row mb-3">
          <div class="col-md-12">
            <label for="ASUNTO_ARCHIVO" class="form-text">ASUNTO</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
              <input type="text" class="form-control input-readonly" id="ASUNTO_ARCHIVO" name="ASUNTO_ARCHIVO" value="<?= htmlspecialchars($asunto) ?>" readonly>
            </div>
          </div>
        </div>

        <!-- EXPEDIENTE y UNIDAD DESTINO -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="EXPEDIENTE" class="form-text">N° DE EXPEDIENTE</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-folder-open"></i></span>
              <input type="text" class="form-control input-readonly" id="EXPEDIENTE" name="EXPEDIENTE" value="<?= htmlspecialchars($codigo_tramite) ?>" readonly>
            </div>
          </div>

          <div class="col-md-6">
            <label for="AREA_DESTINO" class="form-text">SIGUIENTE UNIDAD ORGÁNICA DESTINO</label>
            <div class="input-group">
              <label class="input-group-text span-input-tramite text-light" for="AREA_DESTINO">
                <i class="fas fa-building"></i>
              </label>
              <select class="form-select" id="AREA_DESTINO" name="AREA_DESTINO">
                <option selected value="">SELECCIONA UNIDAD DESTINO</option>
              </select>
            </div>
            <span id="areaDestinoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- DOCUMENTO y FOLIOS -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="DOCUMENTO_VIRTUAL" class="form-text">DOCUMENTO VIRTUAL</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-upload"></i></span>
              <input type="file" class="form-control" name="DOCUMENTO_VIRTUAL" id="DOCUMENTO_VIRTUAL" accept=".pdf,.doc,.docx">
            </div>
            <span id="documentoVirtualError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>

          <div class="col-md-6">
            <label for="FOLIOS" class="form-text">FOLIOS</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
              <input type="text" class="form-control" name="FOLIOS" id="FOLIOS" placeholder="Ingrese la cantidad de folios">
            </div>
            <span id="foliosError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- MOTIVO -->
        <div class="row mb-4">
          <div class="col-md-12">
            <label for="MOTIVO_ARCHIVO" class="form-text">MOTIVO DE LA DERIVACIÓN</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" name="MOTIVO_ARCHIVO" id="MOTIVO_ARCHIVO" rows="4" placeholder="Escriba el motivo de la derivación"></textarea>
            </div>
            <span id="motivoArchivoError" class="text-danger ms-5" style="display:none;"></span>
          </div>
        </div>

        <!-- BOTONES -->
        <div class="d-grid gap-2 col-12 col-md-6 col-lg-4 mx-auto mt-4 mb-4">
          <button id="btnDerivarTramite" type="button" class="btn btn-enviarTramite w-100 px-3 py-2" onclick="derivarTramite()">DERIVAR</button>
          <button type="button" class="btn btn-secondary w-100 px-3 py-2 mt-2" onclick="cargarformularioResolverTramites()">CANCELAR</button>
        </div>
      </div>
    </form>

    <script src="../../asset/js/tramite.js"></script>
    <script>
        cargarAreasParaDerivar();
    </script>
    <script>
    // Detener Polling de Mensajes
    delete window.habilitarPollingMensajes;
    </Script>
    <?php
    return ob_get_clean();
  }
}
?>
