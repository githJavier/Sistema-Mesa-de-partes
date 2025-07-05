<?php
session_start();
?>
<h2 class="text-center fw-bold"
    style="font-size: 2.5rem; color:rgb(3, 3, 3); text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);">
    BIENVENIDO A LA MESA DE PARTES VIRTUAL
</h2>

<div class="container text-center p-0 mt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 g-lg-2 justify-content-center">

        <!-- Ingresar trámite -->
        <div class="col d-flex align-items-stretch justify-content-center">
            <div class="card mx-auto text-center" style="width: 100%; max-width: 18rem; min-height: 420px;">
                <img src="../../asset/img/ingresoTramite.jpg" class="card-img-top img-fluid"
                    style="height: 292px; object-fit: cover; margin-top: 20px;" alt="Ingresar Trámite">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Ingresar Trámite</h5>
                        <p class="card-text">En esta sección podrás ingresar un trámite.</p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3"
                        onclick="cargarformularioIngresarTramite()">INGRESAR</button>
                </div>
            </div>
        </div>

        <!-- Trámites externos por recibir -->
        <?php if (!isset($_SESSION['datos']['area']) || $_SESSION['datos']['area'] !== 'JEFE DE SISTEMAS') : ?>
        <div class="col d-flex align-items-stretch justify-content-center">
            <div class="card mx-auto text-center" style="width: 100%; max-width: 18rem; min-height: 420px;">
                <img src="../../asset/img/tramitesExternos.jpg" class="card-img-top img-fluid"
                    style="height: 282px; object-fit: cover; margin-top: 20px;" alt="Trámites Externos">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Trámites Externos por Recibir</h5>
                        <p class="card-text">Aquí podrás ver los trámites externos que has recibido.</p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3"
                        onclick="cargarformularioRecibirTramitesExternos()">VER</button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Trámites internos por recibir -->
        <div class="col d-flex align-items-stretch justify-content-center">
            <div class="card mx-auto text-center" style="width: 100%; max-width: 18rem; min-height: 420px;">
                <img src="../../asset/img/tramitesInternos.jpg" class="card-img-top img-fluid"
                    style="height: 282px; object-fit: cover; margin-top: 20px;" alt="Trámites Internos">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Trámites Internos por Recibir</h5>
                        <p class="card-text">Aquí podrás ver los trámites internos que has recibido.</p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3"
                        onclick="cargarformularioRecibirTramitesInternos()">VER</button>
                </div>
            </div>
        </div>

        <!-- Trámites por resolver -->
        <div class="col d-flex align-items-stretch justify-content-center">
            <div class="card mx-auto text-center" style="width: 100%; max-width: 18rem; min-height: 420px;">
                <img src="../../asset/img/tramitesPorResolver.jpg" class="card-img-top img-fluid"
                    style="height: 282px; object-fit: cover; margin-top: 20px;" alt="Trámites por Resolver">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">Trámites por Resolver</h5>
                        <p class="card-text">Aquí podrás ver los trámites que están pendientes por resolver.</p>
                    </div>
                    <button class="btn btn-primary w-100 mt-3"
                        onclick="cargarformularioResolverTramites()">VER</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Scripts para detener polling innecesario -->
<script>
    delete window.habilitarPollingMensajes;
    delete window.habilitarPollingChatAdmin;
</script>
