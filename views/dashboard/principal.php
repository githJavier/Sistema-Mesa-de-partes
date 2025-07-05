<?php
// Aquí podrías poner session_start(); si fuera necesario
?>

<!-- Título de bienvenida -->
<h2 class="text-center text-md-start mx-auto mx-md-0 fw-bold">
    BIENVENIDO A LA MESA DE PARTES VIRTUAL
</h2>

<!-- Contenedor de tarjetas -->
<div class="container text-center p-0 mt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 g-lg-2 justify-content-center justify-content-md-start">

        <!-- Tarjeta: Ingresar Trámite -->
        <div class="col">
            <div class="card mx-auto mx-md-0 text-center d-flex flex-column h-100" style="max-width: 18rem;">
                <img src="../../asset/img/ingresoTramite.png" class="card-img-top img-fluid" alt="Ingresar Trámite">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Ingresar Trámite</h5>
                        <p class="card-text">En esta sección podrás ingresar un trámite.</p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" onclick="cargarFormularioTramite()">INGRESAR</button>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Seguir Trámite -->
        <div class="col">
            <div class="card mx-auto mx-md-0 text-center d-flex flex-column h-100" style="max-width: 18rem;">
                <img src="../../asset/img/seguimientoTramite.png" class="card-img-top img-fluid" alt="Seguir Trámite">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Seguir Trámite</h5>
                        <p class="card-text">En esta sección podrás ver el estado de tus trámites.</p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3" onclick="cargarFormularioSeguimiento()">SEGUIMIENTO</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Script para detener polling de mensajes y chat -->
<script>
    delete window.habilitarPollingMensajes;
    delete window.habilitarPollingChat;
</script>
