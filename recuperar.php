<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="asset/css/bootstrap-5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/fontawesome-6/css/all.min.css">
    <link rel="stylesheet" href="asset/css/recuperar.css">
    <script src="asset/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
    <title>Recuperar Contraseña</title>
</head>
<body class="tema-background">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow p-4 card-container">
            <h2 class="text-center mb-3 txt-titulo"><i class="fa-light fa-file"></i>  RECUPERAR CUENTA</h2>
            
            <div class="alert alert-secondary text-center" role="alert">
                <strong>Necesitamos comprobar tu identidad.</strong><br>
                Para ello, ingresa el correo electrónico asociado a tu cuenta, donde te enviaremos los pasos para recuperar tus credenciales.
            </div>

            <form>
                <div class="mb-4">
                    <label for="documento" class="form-label txt-label">Ingrese sus datos<span id="" class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="text" class="form-control" id="documento" placeholder="Ingrese su DNI/RUC">
                    </div>
                    <span id="documentoError" class="text-danger" style="display:none;">Este campo es obligatorio.</span>
                </div>
                <div class="mb-4">
                    <label for="correo" class="form-label txt-label">Correo Electrónico<span id="" class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="email" placeholder="Ej. example@example.com">
                    </div>
                    <span id="emailError" class="text-danger" style="display:none;">Este campo es obligatorio.</span>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn w-75 btn-recuperar" id="btnRecuperar" name="btnRecupera"  value="Recuperar" onclick="enviarForm()">Recuperar</button>
                </div>
            </form>

            <div class="text-center mt-3 txt-small">
                <small>¿Ya estás registrado? <a href="login.php" class="">Iniciar Sesión</a></small>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="asset/js/recuperar.js"></script>
</body>
</html>
