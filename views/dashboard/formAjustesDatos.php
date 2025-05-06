<?php
class GetFormAjustesDatos {
    public function formAjustesDatos($datosRemitente) {
        ob_start();
        ?>
        <div class="container-fluid px-2">
            <div class="d-flex justify-content-center">
                <h3 class="text-center">DETALLES DEL REMITENTE</h3>
            </div> 

            <form>
                <div class="container bg-white p-3 mt-4">

                    <div class="separador-titulo">CONFIGURACIÓN DE DATOS</div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="TIPO_REMITENTE" class="form-text">TIPO DE REMITENTE</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control input-readonly" id="TIPO_REMITENTE" name="TIPO_REMITENTE" value="<?=$datosRemitente['tipo_remitente']?>" readonly>
                            </div>
                            <span id="tipoRemitenteError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="TIPO_DOCUMENTO" class="form-text">TIPO DE DOCUMENTO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control input-readonly" maxlength="11" name="TIPO_DOCUMENTO" id="TIPO_DOCUMENTO" value="<?=$datosRemitente['retipo_docu']?>" readonly>
                            </div>
                            <span id="tipoDocumentoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="NUM_DOCUMENTO" class="form-text">NÚMERO DE DOCUMENTO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-id-card"></i></span>
                                <input type="text" class="form-control input-readonly" name="NUM_DOCUMENTO" id="NUM_DOCUMENTO" value="<?=$datosRemitente['docu_num']?>" readonly>
                            </div>
                            <span id="numDocumentoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-5 mb-3 mb-md-0">
                            <label for="NOMBRE_COMPLETO" class="form-text">NOMBRES Y APELLIDOS O RAZÓN SOCIAL</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control input-readonly" id="NOMBRE_COMPLETO" name="NOMBRE_COMPLETO" value="<?=$datosRemitente['nombres']?>" readonly>
                            </div>
                            <span id="nombreCompletoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label for="CELULAR" class="form-text">TELÉFONO CELULAR</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" maxlength="9" name="CELULAR" id="CELULAR" value="<?=$datosRemitente['telefono_celular']?>" >
                            </div>
                            <span id="celularError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="EMAIL" class="form-text">CORREO ELECTRÓNICO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control input-readonly" name="EMAIL" id="EMAIL" value="<?=$datosRemitente['correo']?>" readonly>
                            </div>
                            <span id="emailError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="DEPARTAMENTO" class="form-text">DEPARTAMENTO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map"></i></span>
                                <select class="form-select" name="DEPARTAMENTO" id="DEPARTAMENTO">
                                    <option value="">-- Selecciona un departamento --</option>
                                </select>
                            </div>
                            <span id="departamentoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label for="PROVINCIA" class="form-text">PROVINCIA</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map"></i></span>
                                <select class="form-select" name="PROVINCIA" id="PROVINCIA">
                                    <option value="">-- Selecciona una provincia --</option>
                                </select>
                            </div>
                            <span id="provinciaError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="DISTRITO" class="form-text">DISTRITO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map"></i></span>
                                <select class="form-select" name="DISTRITO" id="DISTRITO">
                                    <option value="">-- Selecciona un distrito --</option>
                                </select>
                            </div>
                            <span id="distritoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="DIRECCION" class="form-text">DOMICILIO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-map-marker-alt"></i></span>
                                <input type="text" class="form-control" name="DOMICILIO" id="DIRECCION" value="<?=$datosRemitente['direccion']?>">
                            </div>
                            <span id="domicilioError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-12 col-lg-4  col-md-6 mx-auto mt-4 mb-4">
                        <button type="button" class="btn btn-enviarTramite w-100 w-md-25 px-3 py-2" 
                                name="btnGuardarDatos" 
                                value="Registrar" 
                                onclick="enviarFormAjuste()">
                            GUARDAR DATOS
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <script src="../../asset/js/ajuste.js"></script>
        <?php
        return ob_get_clean();
    }
}
?>
