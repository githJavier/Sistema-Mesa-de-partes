<?php
session_start();
if (isset($_SESSION['usuario'])) {
    session_destroy();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="asset/css/bootstrap-5.3.3/css/bootstrap.min.css" />
  <link rel="stylesheet" href="asset/css/fontawesome-6/css/all.min.css" />
  <link rel="stylesheet" href="asset/css/login.css" />
  <script src="asset/css/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light tema-background">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-4 card-container" style="width: 450px;">
      <!-- Encabezado -->
      <div class="text-center mb-4">
        <h2 class="txt-titulo"><i class="fa-regular fa-file-lines"></i> MESA DE PARTES VIRTUAL</h2>
        <p class="text-muted">Sistema de gestión documental</p>
      </div>


      <!-- Selector de formulario -->
      <div class="nav nav-pills nav-justified mb-4">
        <button class="nav-link active rounded-pill bg-dark text-white" onclick="mostrarFormularioRemitente()">Remitente</button>
        <button class="nav-link rounded-pill bg-light text-dark" onclick="mostrarFormularioUsuario()">Funcionario</button>
      </div>

      <!-- FORMULARIO REMITENTE -->
      <div id="formRemitente">
        <form id="loginForm">
          <!-- Radio buttons -->
          <div class="d-flex justify-content-around mb-4">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="checkboxUsuario" id="natural" checked onclick="tipoPersona()" value="DNI">
              <label class="form-check-label" for="natural">Persona Natural</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="checkboxUsuario" id="juridica" onclick="tipoPersona()" value="RUC">
              <label class="form-check-label" for="juridica">Persona Jurídica</label>
            </div>
          </div>

          <!-- Documento -->
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-id-card"></i></span>
              <input type="text" class="form-control" id="documento" placeholder="DNI" maxlength="8" name="documento" />
            </div>
            <span id="documentoError" class="text-danger ms-5" style="display:none;"></span>
          </div>

          <!-- Contraseña -->
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="password" placeholder="Contraseña" name="contrasena" />
              <button type="button" class="btn btn-outline-secondary" id="togglePassword"><i class="fa-solid fa-eye"></i></button>
            </div>
            <span id="passwordError" class="text-danger ms-5" style="display:none;"></span>
          </div>

          <!-- Botón -->
          <div class="d-flex justify-content-center mb-3">
            <button type="button" class="btn btn-dark w-75 rounded-pill" onclick="enviarForm()">Ingresar</button>
          </div>

          <div class="d-flex justify-content-around mt-3 txt-small">
            <small><a href="registro.php" class="text-decoration-none">Crear cuenta</a></small>
            <small><a href="recuperar.php" class="text-decoration-none">Recuperar contraseña</a></small>
          </div>
        </form>
      </div>

      <!-- FORMULARIO USUARIO -->
      <div id="formUsuario" class="d-none">
        <form id="loginUsuario">
          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-user-tie"></i></span>
              <input type="text" class="form-control" id="usuarioSistema" placeholder="Usuario" />
            </div>
              <span id="usuarioSistemaError" class="text-danger ms-5" style="display:none;"></span>
          </div>

          <div class="mb-4">
            <div class="input-group">
              <span class="input-group-text bg-dark text-light"><i class="fas fa-lock"></i></span>
              <input type="password" class="form-control" id="claveSistema" placeholder="Contraseña" />
              <button type="button" class="btn btn-outline-secondary" id="toggleClaveSistema"><i class="fa-solid fa-eye"></i></button>
            </div>
              <span id="claveSistemaError" class="text-danger ms-5" style="display:none;"></span>
          </div>

          <div class="d-flex justify-content-center mb-3">
            <button type="button" class="btn btn-dark w-75 rounded-pill" onclick="enviarFormUsuario()">Acceder al sistema</button>
          </div>
        </form>
      </div>

    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="asset/js/login.js"></script>

  <script>
    function mostrarFormularioUsuario() {
    document.getElementById("formRemitente").classList.add("d-none");
    document.getElementById("formUsuario").classList.remove("d-none");

    const botones = document.querySelectorAll(".nav-link");
    botones[0].classList.remove("active", "bg-dark", "text-white");
    botones[0].classList.add("bg-light", "text-dark");

    botones[1].classList.add("active", "bg-dark", "text-white");
    botones[1].classList.remove("bg-light", "text-dark");
    }

    function mostrarFormularioRemitente() {
    document.getElementById("formUsuario").classList.add("d-none");
    document.getElementById("formRemitente").classList.remove("d-none");

    const botones = document.querySelectorAll(".nav-link");
    botones[1].classList.remove("active", "bg-dark", "text-white");
    botones[1].classList.add("bg-light", "text-dark");

    botones[0].classList.add("active", "bg-dark", "text-white");
    botones[0].classList.remove("bg-light", "text-dark");
    }
  </script>

</body>
</html>
