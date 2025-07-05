<?php
class GetFormIngresarTramiteUsuario {
  public function formIngresarTramiteUsuarioShow($ultimoTramite, $tipoDocumento, $remitentes, $unidadesOrganicas) {
    ob_start();
    ?>
    <div class="d-flex justify-content-center">
      <h3>INGRESA TU TRÁMITE</h3>
    </div>

    <form>
      <div class="container bg-white p-0 mt-4">
        <div class="separador-titulo mt-5">DATOS DEL DOCUMENTO</div>

        <!-- Asunto -->
        <div class="row mb-3">
          <div class="col-md-12">
            <label for="ASUNTO" class="form-text">ASUNTO*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
              <input type="text" class="form-control" name="asunto" id="ASUNTO" placeholder="Ingrese el asunto del trámite">
            </div>
            <span id="asuntoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- Tipo de trámite | Número de documento -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="TIPO_TRAMITE" class="form-text">TIPO DE TRÁMITE*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-random"></i></span>
              <select class="form-select" id="TIPO_TRAMITE" name="tipo_tramite" required
                data-codigo-interno="<?php echo $ultimoTramite['codigo_interno']; ?>"
                data-codigo-externo="<?php echo $ultimoTramite['codigo_externo']; ?>">
                <option value="">SELECCIONA UN TIPO DE TRÁMITE</option>
                <option value="INTERNO">INTERNO</option>
                <option value="EXTERNO">EXTERNO</option>
              </select>
            </div>
            <span id="tipoTramiteError" class="text-danger ms-5" style="display:none;">Este campo es obligatorio.</span>
          </div>
          <div class="col-md-6">
            <label for="NUMERO_TRAMITE" class="form-text">NÚMERO DE DOCUMENTO*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-file-alt"></i></span>
              <input type="text" class="form-control input-readonly" name="numero_documento" id="NUMERO_TRAMITE" readonly>
            </div>
            <span id="numeroDocumentoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- Unidad orgánica destino | Tipo de documento -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="UNIDAD_ORGANICA_DESTINO" class="form-text">UNIDAD ORGÁNICA DESTINO*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-building"></i></span>
              <select class="form-select" id="UNIDAD_ORGANICA_DESTINO" name="unidad_organica_destino" required>
                <option value="">SELECCIONA UNA UNIDAD</option>
                <?php foreach ($unidadesOrganicas as $uo): ?>
                  <option value="<?php echo $uo['area']; ?>"><?php echo strtoupper($uo['area']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <span id="unidadOrganicaError" class="text-danger ms-5" style="display:none;">Este campo es obligatorio.</span>
          </div>
          <div class="col-md-6">
            <label for="TIPO_DOCUMENTO" class="form-text">TIPO DE DOCUMENTO*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-file-alt"></i></span>
              <select class="form-select" id="TIPO_DOCUMENTO" name="tipo_documento">
                <option value="">SELECCIONA TIPO DE DOCUMENTO</option>
                <?php foreach ($tipoDocumento as $documento): ?>
                  <option value="<?php echo $documento['cod_tipodocumento']; ?>"><?php echo strtoupper($documento['tipodocumento']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <span id="tipoDocumentoError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- Documento virtual | Folios -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="DOCUMENTO_VIRTUAL" class="form-text">DOCUMENTO VIRTUAL*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-upload"></i></span>
              <input type="file" class="form-control" name="documento_virtual" id="DOCUMENTO_VIRTUAL" accept=".pdf,.doc,.docx">
            </div>
            <span id="documentoVirtualError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
          <div class="col-md-6">
            <label for="FOLIOS" class="form-text">FOLIOS*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-edit"></i></span>
              <input type="text" class="form-control" name="folios" id="FOLIOS" placeholder="Ingrese la cantidad de folios">
            </div>
            <span id="foliosError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- Remitente | Urgente -->
        <div class="row mb-3">
          <div class="col-md-6">
            <label for="REMITENTE" class="form-text">REMITENTE*</label>
            <div class="input-group input-group-remitente">
              <span class="input-group-text span-input-tramite text-light">
                <i class="fas fa-user"></i>
              </span>
              <div class="dropdown flex-grow-1">
                <button class="btn btn-outline-dark dropdown-toggle w-100 text-start text-truncate"
                        type="button"
                        id="dropdownRemitente"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        title="SELECCIONA UN REMITENTE">
                  SELECCIONA UN REMITENTE
                </button>
                <ul class="dropdown-menu w-100"
                    aria-labelledby="dropdownRemitente"
                    style="max-height: 200px; overflow-y: auto;">
                  <?php foreach ($remitentes as $rem): ?>
                    <li>
                      <a class="dropdown-item" href="#"
                        onclick="seleccionarRemitente('<?php echo htmlspecialchars($rem['nombres'], ENT_QUOTES); ?>')">
                        <?php echo strtoupper($rem['nombres']); ?>
                      </a>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <input type="hidden" name="remitente" id="remitenteSeleccionado" required>
              </div>
            </div>
            <span id="remitenteError" class="text-danger ms-5" style="display:none;">Este campo es obligatorio.</span>
          </div>

          <div class="col-md-6">
            <label for="URGENTE" class="form-text">¿URGENTE?*</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-exclamation-circle"></i></span>
              <select class="form-select" id="URGENTE" name="urgente" required>
                <option value="">SELECCIONA UNA OPCIÓN</option>
                <option value="SI">SÍ</option>
                <option value="NO">NO</option>
              </select>
            </div>
            <span id="urgenteError" class="text-danger ms-5" style="display:none;">Este campo es obligatorio.</span>
          </div>
        </div>

        <style>
          /* Evita que el ícono salte arriba */
          .input-group-remitente {
            flex-wrap: nowrap;
            align-items: stretch;
          }

          /* Ajuste fino para prevenir salto en pantallas pequeñas */
          @media (max-width: 576px) {
            .input-group-remitente .input-group-text {
              flex: 0 0 auto;
            }

            .input-group-remitente .dropdown {
              min-width: 0;
              flex: 1 1 auto;
            }

            .input-group-remitente button.dropdown-toggle {
              white-space: nowrap;
              overflow: hidden;
              text-overflow: ellipsis;
            }
          }
        </style>

        <!-- Observación -->
        <div class="row mb-3">
          <div class="col-md-12">
            <label for="OBSERVACION" class="form-text">OBSERVACIÓN</label>
            <div class="input-group">
              <span class="input-group-text span-input-tramite text-light"><i class="fas fa-comment-dots"></i></span>
              <textarea class="form-control" name="observacion" id="OBSERVACION" rows="3" placeholder="Observaciones adicionales..."></textarea>
            </div>
            <span id="observacionError" class="text-danger ms-5" style="display:none;">ESTE CAMPO ES OBLIGATORIO.</span>
          </div>
        </div>

        <!-- Botón -->
        <div class="d-grid gap-2 col-12 col-md-6 col-lg-4 mx-auto mt-4 mb-4">
          <button id="btnEnviarTramiteUsuario" type="button" class="btn btn-enviarTramite w-100 px-3 py-2" onclick="enviarFormTramiteUsuario()">ENVIAR TRÁMITE</button>
        </div>
      </div>
    </form>

    <script src="../../asset/js/tramiteUsuario.js"></script>

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