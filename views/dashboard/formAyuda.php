<?php 
class formAyuda {
    public function formAyudaShow($datosRemitente) {
        ob_start();
        ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <h3 class="text-center">CONTACTATE CON EL ADMINISTRADOR</h3>
            </div> 

            <form>
                <div class="container bg-white p-3 mt-4">
                    <div class="separador-titulo">INGRESA TU CONSULTA/O SOLICITA AYUDA</div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="NOMBRE" class="form-text">NOMBRES Y APELLIDOS O RAZÓN SOCIAL</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control input-readonly" id="nombre" name="nombre" value="<?php echo strtoupper($datosRemitente['nombres']); ?>" readonly>
                            </div>
                            <span id="nombreError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label for="correo" class="form-text">CORREO ELECTRÓNICO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo strtoupper($datosRemitente['correo']); ?>" readonly>
                            </div>
                            <span id="correoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="telefono" class="form-text">TELÉFONO DE CONTACTO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="<?=$datosRemitente['telefono_celular']?>" readonly>
                            </div>
                            <span id="telefonoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="asunto" class="form-text">ASUNTO</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-tag"></i></span>
                                <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Consulta sobre trámite, error en el sistema, etc.">
                            </div>
                            <span id="asuntoError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="mensaje" class="form-text">MENSAJE O DETALLES DE LA CONSULTA</label>
                            <div class="input-group">
                                <span class="input-group-text span-input-tramite text-light"><i class="fas fa-comment-dots"></i></span>
                                <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Describe aquí tu problema o solicitud con el mayor detalle posible..."></textarea>
                            </div>
                            <span id="mensajeError" class="text-danger ms-2" style="display:none;">Este campo es obligatorio.</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 col-12 col-md-6 col-lg-4 mx-auto mt-4 mb-4">
                        <button type="button" class="btn btn-enviarTramite w-100 px-3 py-2" onclick="enviarFormAyuda()">ENVIAR CONSULTA</button>
                    </div>
                </div>
            </form>

            <script src="../../asset/js/ayuda.js"></script>
        </div>
        <?php
        return ob_get_clean();
    }
}
?>
