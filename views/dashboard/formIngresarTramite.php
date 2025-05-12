<?php
class GetFormIngresarTramite {
  public function formIngresarTramiteShow($ultimoTramite, $tipoDocumento, $datosRemitente) {
    ob_start();
    ?>
      <div class="d-flex justify-content-center">
        <h3>INGRESA TU TRÁMITE</h3>
      </div> 
      <form>
        <div class="container bg-white p-0 mt-4">
          <div class="separador-titulo">DATOS DEL REMITENTE</div>
          <div class="row mb-3">
            <div class="col-md-5">
              <label for="NOMBRE" class="form-text">APELLIDOS Y NOMBRES O RAZÓN SOCIAL</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-user"></i></span>
                <input type="text" class="form-control input-readonly" id="NOMBRE" name="NOMBRE" value="<?php echo strtoupper($datosRemitente['nombres']); ?>" readonly>
              </div>
              <span id="nombreError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>

            <div class="col-md-3">
              <label for="DOCU_NUM" class="form-text">DOCUMENTO DE IDENTIDAD</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-id-card"></i></span>
                <input type="text" class="form-control input-readonly" maxlength="11" name="DOCUMENTO" id="DOCU_NUM" value="<?php echo $datosRemitente['docu_num']; ?>" readonly>
              </div>
              <span id="documentoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>

            <div class="col-md-4">
              <label for="CORREO" class="form-text">CORREO ELECTRÓNICO</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-envelope"></i></span>
                <input type="email" class="form-control input-readonly" name="CORREO" id="CORREO" value="<?php echo strtoupper($datosRemitente['correo']); ?>" readonly>
              </div>
              <span id="correoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12 ">
              <label for="DIRECCION" class="form-text">DOMICILIO</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map-marker-alt"></i></span>
                <input type="text" class="form-control input-readonly" name="DOMICILIO" id="DIRECCION" value="<?php echo $datosRemitente['direccion']; ?>" readonly>
              </div>
              <span id="domicilioError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4 ">
              <label for="DEPARTAMENTO" class="form-text">DEPARTAMENTO</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map"></i></span>
                <input type="text" class="form-control input-readonly" name="DEPARTAMENTO" id="DEPARTAMENTO" value="<?php echo strtoupper($datosRemitente['departamento']); ?>" readonly>
              </div>
              <span id="departamentoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>

            <div class="col-md-4 ">
              <label for="PROVINCIA" class="form-text">PROVINCIA</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map"></i></span>
                <input type="text" class="form-control input-readonly" name="PROVINCIA" id="PROVINCIA" value="<?php echo strtoupper($datosRemitente['provincia']); ?>" readonly>
              </div>
              <span id="provinciaError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>

            <div class="col-md-4 ">
              <label for="DISTRITO" class="form-text">DISTRITO</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map"></i></span>
                <input type="text" class="form-control input-readonly" name="DISTRITO" id="DISTRITO" value="<?php echo strtoupper($datosRemitente['distrito']); ?>" readonly>
              </div>
              <span id="distritoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
          </div>
          
          <div class="separador-titulo mt-5">DATOS DEL DOCUMENTO</div>
          <div class="row mb-3">
            <div class="col-md-12">
              <label for="ASUNTO" class="form-text">ASUNTO*</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
                <input type="text" class="form-control" name="ASUNTO" id="ASUNTO" placeholder="Ingrese el asunto del trámite">
              </div>
              <span id="asuntoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="TIPO_DOCUMENTO" class="form-text">TIPO DE DOCUMENTO*</label>
              <div class="input-group">
                <label class="input-group-text span-input-tramite text-light" for="TIPO_DOCUMENTO"><i class="fas fa-file-alt"></i></label>
                <select class="form-select" id="TIPO_DOCUMENTO" name="TIPO_DOCUMENTO">
                  <option selected value="">SELECCIONA TIPO DE DOCUMENTO</option>
                  <?php
                    foreach ($tipoDocumento as $documento) {
                        echo "<option value='" . $documento['cod_tipodocumento'] . "'>" . strtoupper($documento['tipodocumento']) . "</option>";
                    }
                  ?>
                </select>
              </div>
              <span id="tipoDocumentoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>

            <div class="col-md-6">
              <label for="NUMERO_TRAMITE" class="form-text">NÚMERO DE DOCUMENTO*</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-file-alt"></i></span>
                <input type="text" class="form-control input-readonly" name="NUMERO_DOCUMENTO" id="NUMERO_TRAMITE" value="<?php echo $ultimoTramite; ?>" readonly>
              </div>
              <span id="numeroDocumentoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="DOCUMENTO_VIRTUAL" class="form-text">DOCUMENTO VIRTUAL*</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-upload"></i></span>
                <input type="file" class="form-control" name="DOCUMENTO_VIRTUAL" id="DOCUMENTO_VIRTUAL" accept=".pdf,.doc,.docx">
              </div>
              <span id="documentoVirtualError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
            <div class="col-md-6">
              <label for="FOLIOS" class="form-text">FOLIOS*</label>
              <div class="input-group">
                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
                <input type="text" class="form-control" name="FOLIOS" id="FOLIOS" placeholder="Ingrese la cantidad de folios">
              </div>
              <span id="foliosError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
            </div>
          </div>
          
          <div class="d-grid gap-2 col-12 col-md-6 col-lg-4 mx-auto mt-4 mb-4">
            <button type="button" class="btn btn-enviarTramite w-100 px-3 py-2"  onclick="enviarFormTramite()">ENVIAR TRÁMITE</button>
          </div>

        </div>
      </form>

      <script src="../../asset/js/tramite.js"></script>
    <?php
    return ob_get_clean();
  }
}
?>
