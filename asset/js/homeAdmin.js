function toggleMenu() {
    let menu = document.getElementById("offcanvasScrolling");
    let isSmallScreen = window.innerWidth < 992;

    if (isSmallScreen) {
        menu.classList.toggle("open");
    } else {
        menu.classList.toggle("fixed");
        document.body.classList.toggle("menu-open", menu.classList.contains("fixed"));
    }
}

function initializeMenu() {
    let menu = document.getElementById("offcanvasScrolling");
    menu.classList.remove("open", "fixed");
}

document.addEventListener("click", function(event) {
    let menu = document.getElementById("offcanvasScrolling");
    let button = document.querySelector(".btn-toggle-menu");
    let userMenu = document.getElementById('userMenu');
    let userButton = document.getElementById('userDropdown');

    if (window.innerWidth < 992 && menu.classList.contains("open") && !menu.contains(event.target) && !button.contains(event.target)) {
        menu.classList.remove("open");
    }

    if (!userButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.remove('active');
    }
});

function toggleUserMenu(event) {
    event.stopPropagation();
    document.getElementById('userMenu').classList.toggle('active');
}

window.addEventListener("resize", initializeMenu);

// ✅ Guardar contenido y vista en localStorage
function guardarContenidoEnLocalStorage(html, vista) {
    localStorage.setItem("contenidoDinamico", html);
    if (vista) {
        localStorage.setItem("vistaActual", vista);
    }
}

function guardarParametrosArchivarTramite(codigo, asunto, documento) {
    localStorage.setItem("archivar_codigo", codigo);
    localStorage.setItem("archivar_asunto", asunto);
    localStorage.setItem("archivar_documento", documento);
}

function guardarParametrosDerivarTramite(codigo, asunto, documento) {
    localStorage.setItem("derivar_codigo", codigo);
    localStorage.setItem("derivar_asunto", asunto);
    localStorage.setItem("derivar_documento", documento);
}


// ✅ Cargar contenido desde localStorage si existe
function cargarDesdeLocalStorage() {
    const vista = localStorage.getItem("vistaActual");
    if (vista) {
        switch (vista) {
            case "home":
                cargarHome();
                break;
            case "administracionRemitentes":
                cargarformularioAdministracionRemitentes();
                break;
            case "administracionUsuarios":
                cargarformularioAdministracionUsuarios();
                break;
            case "administracionAreas":
                cargarformularioAdministracionAreas();
                break;
            case "administracionDocumentos":
                cargarformularioAdministracionDocumentos();
                break;
            case "consultarTramitesArchivados":
                cargarformularioConsultarTramitesArchivados();
                break;
            case "consultarTramitesDerivados":
                cargarformularioConsultarTramitesDerivados();
                break;
            case "recibirTramitesExternos":
                cargarformularioRecibirTramitesExternos();
                break;
            case "resolverTramites":
                cargarformularioResolverTramites();
                break;
            case "archivarTramite":
                const codigoA = localStorage.getItem("archivar_codigo");
                const asuntoA = localStorage.getItem("archivar_asunto");
                const documentoA = localStorage.getItem("archivar_documento");
                if (codigoA && asuntoA && documentoA) {
                    cargarFormularioArchivarTramite(codigoA, asuntoA, documentoA);
                } else {
                    //console.warn("⚠️ Faltan parámetros para cargar archivarTramite.");
                }
                break;

            case "derivarTramite":
                const codigoD = localStorage.getItem("derivar_codigo");
                const asuntoD = localStorage.getItem("derivar_asunto");
                const documentoD = localStorage.getItem("derivar_documento");
                if (codigoD && asuntoD && documentoD) {
                    cargarFormularioDerivarTramite(codigoD, asuntoD, documentoD);
                } else {
                    //console.warn("⚠️ Faltan parámetros para cargar derivarTramite.");
                }
                break;

            default:
                cargarHome();
        }
    } else {
        cargarHome(); // por defecto
    }
}

// Llamar al cargar la página
cargarDesdeLocalStorage();

function cargarHome() {

    verificarSesion(() => {
        $("#contenido-dinamico").load("../../views/dashboard/principalAdmin.php", function() {
            guardarContenidoEnLocalStorage($("#contenido-dinamico").html(), "home");
        });
    });
}

function cargarformularioAdministracionRemitentes() {

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Administracion/controlAdministracionRemitentes.php",
            dataType: "json",
            success: function(response) {
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "administracionRemitentes");

                setTimeout(() => {
                    if (typeof window.remitentesPagination !== "undefined") {
                        window.remitentesPagination.init();
                    }
                }, 100);
            },
            error: function(xhr, status, error) {
                //console.error("Error al cargar el formulario de remitentes:", error);
            }
        });
    });
}

function cargarformularioAdministracionUsuarios() {

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Administracion/controlAdministracionUsuarios.php",
            dataType: "json",
            success: function(response) {
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "administracionUsuarios");

                    setTimeout(() => {
                        if (typeof window.usuariosPagination !== "undefined") {
                            window.usuariosPagination.init();
                        }
                    }, 100);
                }
            },
            error: function(xhr, status, error) {
                //console.error("Error al cargar el formulario de usuarios:", error);
            }
        });
    });
}

function cargarformularioAdministracionAreas() {

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Administracion/controlAdministracionAreas.php",
            dataType: "json",
            success: function(response) {
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "administracionAreas");
                    setTimeout(() => {
                        if (typeof window.areasPagination !== "undefined") {
                            window.areasPagination.init();
                        }
                    }, 100);
                }
            },
            error: function(xhr, status, error) {
                //console.error("Error al cargar el formulario de áreas:", error);
            }
        });
    });
}

function cargarformularioAdministracionDocumentos() {

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Administracion/controlAdministracionDocumentos.php",
            dataType: "json",
            success: function(response) {
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "administracionDocumentos");
                    setTimeout(() => {
                        if (typeof window.tipoDocumentosPagination !== "undefined") {
                            window.tipoDocumentosPagination.init();
                        }
                    }, 100);
                }
            },
            error: function(xhr, status, error) {
                //console.error("Error al cargar el formulario de documentos:", error);
            }
        });
    });
}

function cargarformularioConsultarTramitesArchivados(){

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Consultar/controlFormConsultarTramitesArchivados.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "consultarTramitesArchivados");
                }
            }
        })
    });
}

function cargarformularioConsultarTramitesDerivados(){

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Consultar/controlFormConsultarTramitesDerivados.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "consultarTramitesDerivados");
                }
            }
        })
    });
}

function cargarformularioRecibirTramitesExternos(){
      
    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/RecibirTramiteExterno/controlFormRecibirTramiteExterno.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "recibirTramitesExternos");
                }
            }
        })
    });
}

function cargarformularioResolverTramites(){

    verificarSesion(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/ResolverTramite/controlFormResolverTramite.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "resolverTramites");
                }
            }
        })
    });
}

$(document).on('click', '#AdministrarRemitentes', function() {
    cargarformularioAdministracionRemitentes();
});
$(document).on('click', '#AdministrarUsuarios', function() {
    cargarformularioAdministracionUsuarios()
});
$(document).on('click', '#AdministrarAreas', function() {
    cargarformularioAdministracionAreas();
});
$(document).on('click', '#AdministrarDocumentos', function() {
    cargarformularioAdministracionDocumentos();
});
$(document).on('click', '#ConsultarTramitesArchivados', function() {
    cargarformularioConsultarTramitesArchivados();
});
$(document).on('click', '#ConsultarTramitesDerivados', function() {
    cargarformularioConsultarTramitesDerivados();
});
$(document).on('click', '#RecibirTramitesExternos', function() {
    cargarformularioRecibirTramitesExternos();
});
$(document).on('click', '#ResolverTramites', function() {
    cargarformularioResolverTramites();
});

// ✅ Cierre de sesión: eliminar el contenido almacenado
document.getElementById("cerrarSesion")?.addEventListener("click", function () {
    localStorage.removeItem("contenidoDinamico");
    localStorage.removeItem("vistaActual");
});

function verificarSesion(callback) {
    fetch("../../utils/verificarSesion.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "active") {
                if (typeof callback === "function") callback();
            } else if (data.status === "no_session") {
                // Redirección inmediata, sin modal
                window.location.href = "../../index.php";
            } else {
                // Para 'inactive', 'not_found', etc.
                Swal.fire({
                    icon: 'warning',
                    title: 'Sesión cerrada',
                    text: 'Tu sesión ha expirado o tu cuenta ha sido desactivada.',
                    confirmButtonColor: '#981e25'
                }).then(() => {
                    window.location.href = "../../index.php";
                });
            }
        })
        .catch(error => {
            //console.error("Error al verificar sesión:", error);
            window.location.href = "../../index.php";
        });
}