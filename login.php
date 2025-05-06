<?php
session_start();
if (isset($_SESSION['usuario'])) {
    session_destroy();
}
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
    <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="asset/css/bootstrap-5.3.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="asset/css/fontawesome-6/css/all.min.css">
        <link rel="stylesheet" href="asset/css/login.css">
        <script src="asset/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
        <title>Iniciar Sesión</title>
    </head>
    <body class="tema-background">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="card shadow p-4 card-container">
                <h2 class="text-center mb-4 txt-titulo"><i class="fa-light fa-file"></i> MESA VIRTUAL</h2>
                <form id="loginForm">
                    <div class="d-flex justify-content-around my-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="checkboxUsuario" id="natural" checked onclick="tipoPersona()" value="DNI">
                            <label class="form-check-label" for="natural">
                                Persona Natural
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="checkboxUsuario" id="juridica" onclick="tipoPersona()" value="RUC">
                            <label class="form-check-label" for="juridica">
                                Persona Jurídica
                            </label>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text text-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="text" class="form-control" id="documento" placeholder="DNI" aria-label="DNI" maxlength="8" name="documento">
                        </div>
                        <span id="documentoError" class="text-danger ms-5" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="mb-5">
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-light">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password" placeholder="CONTRASEÑA" name="contrasena">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <span id="passwordError" class="text-danger ms-5" style="display:none;">Este campo es obligatorio.</span>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn w-75 btnIngresarSistema" id="btnLogin" name="btnLogin" value="Ingresar" onclick="enviarForm()">Login</button>
                    </div>
                </form>
                <div class="text-center my-4 d-flex align-items-center">
                    <hr class="flex-grow-1 hr-custom" />
                    <span class="mx-2 text-muted"> Or </span>
                    <hr class="flex-grow-1 hr-custom" />
                </div>
                <div class="d-flex justify-content-around mt-3 txt-small">
                    <small><a href="registro.php" class="text-decoration-none">Crear una cuenta</a></small>
                    <small><a href="recuperar.php" class="text-decoration-none">Olvidé mi contraseña</a></small>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="asset/js/login.js"></script>
    </body>
    </html>
        
    



