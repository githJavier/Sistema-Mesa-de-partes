<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Mesa Virtual</title>
    <link rel="stylesheet" href="asset/css/bootstrap-5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/fontawesome-6/css/all.min.css">
    <script src="asset/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="asset/css/registro.css">
</head>
<body class="tema-background">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-3 card-container">
            <h2 class="text-center mb-3 txt-titulo"><i class="fa-light fa-file"></i>  DATOS DE SUSCRIPCIÓN</h2>
            <!-- Mensaje informativo -->
            <div class="alert alert-secondary text-center">
                Lo ingresado en la siguiente ficha será usado como datos de suscripción para la Solicitud Arbitral y administración de sus casos.
            </div>

            <form>
                <!-- Tipo de Documento -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipoDocumento" class="form-label">Tipo de Documento<span id="" class="form-text text-danger">*</span></label>
                        <select class="form-select" id="tipoDocumento">
                            <option selected>DNI</option>
                            <option>RUC</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dni" class="form-label">Número de Documento<span id="" class="form-text text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="documento" placeholder="Ingrese DNI">
                            <button type="button" class="btn btn-dark input-group-text" id="buscarDocumento" onclick="consultarDocumento()">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <span id="documentoError" class="form-text text-danger ms-1" style="display:none;"></span>
                    </div>
                </div>

                <!-- Nombre o Razón Social -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre o Razón Social<span id="" class="form-text text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese su nombre o razón social" disabled>
                    </div>
                    <span id="nombreError" class="form-text text-danger ms-1" style="display:none;"></span>
                </div>

                <div class="row">
                    <!-- Correo Electrónico -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Correo Electrónico<span id="" class="form-text text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" placeholder="Ingrese su correo">
                        </div>
                        <span id="emailError" class="form-text text-danger ms-1" style="display:none;"></span>
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono<span id="" class="form-text text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            <input type="text" class="form-control" id="telefono" placeholder="Ej. 99999999">
                        </div>
                        <span id="telefonoError" class="form-text text-danger ms-1" style="display:none;"></span>
                    </div>
                </div>

                <div class="row">
                    <!-- Contraseña -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Contraseña<span id="" class="form-text text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña">
                        </div>
                        <span id="passwordError" class="form-text text-danger ms-1" style="display:none;"></span>
                    </div>

                    <!-- Repetir Contraseña -->
                    <div class="col-md-6 mb-3">
                        <label for="password2" class="form-label">Repetir Contraseña<span id="" class="form-text text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="passwordR" placeholder="Repita su contraseña">
                        </div>
                        <span id="passwordRError" class="form-text text-danger ms-1" style="display:none;"></span>
                    </div>
                </div>

                <!-- Aceptación de Términos --> 
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="termsCheck">
                    <small class="form-check-label" for="termsCheck">
                        Acepto haber leído y estar de acuerdo con los 
                        <a href="#" class="" data-bs-toggle="modal" data-bs-target="#modalTerminos">Términos y Condiciones</a>.
                    </small>
                    <div id="termsCheckError" class="form-text text-danger ms-1" style="display: none;"></div>
                </div>
                <!-- Modal de Términos y Condiciones -->
                <div class="modal fade" id="modalTerminos" tabindex="-1" aria-labelledby="modalTerminosLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <p class="modal-title fw-bold" id="modalTerminosLabel">Al registrarse tener en cuenta lo siguiente:</p>
                            </div>
                            <div class="modal-body pt-0 pb-0">
                                <p class="text-justify">
                                    Al aceptar, usted autoriza que sus datos personales sean almacenados y 
                                    utilizados por el Centro de Arbitraje Empresa con fines administrativos e informativos. 
                                    Sus datos se resguardarán en una base de datos administrada por la Empresa, ubicada 
                                    en Av. dirección. Esta autorización tiene una duración indefinida, pero puede ser 
                                    revocada en cualquier momento enviando un correo electrónico a empres@arbitraje.com
                                </p>
                            </div>
                            <div class="form-check ms-3 me-3">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <small class="form-check-label d-block text-justify" for="flexCheckDefault">
                                    También doy mi consentimiento para que mis datos sean utilizados con el propósito 
                                    de enviarme invitaciones a eventos organizados por el Centro de Arbitraje.
                                </small>
                            </div>
                            <div class="modal-footer pt-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center ">
                    <button type="button" class="btn btn-custom w-50" id="btnRegistrar" name="btnRegistrar" value="GuardarDatos" onclick="enviarForm()">Registrarse</button>
                </div>

                <div class="text-center mt-3 txt-small">
                    <small>¿Ya estás registrado? <a href="login.php" class="">Iniciar Sesión</a></small>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="asset/js/registro.js"></script>
</body>
</html>
