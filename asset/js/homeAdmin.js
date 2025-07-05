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

function mostrarSpinner() {
    $("#spinner-cargando").show();
    $("#contenido-dinamico").hide();
}

function ocultarSpinner() {
    $("#spinner-cargando").hide();
    $("#contenido-dinamico").show();
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
            case "recibirTramitesInternos":
                cargarformularioRecibirTramitesInternos();
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
                }
                break;
            case "derivarTramite":
                const codigoD = localStorage.getItem("derivar_codigo");
                const asuntoD = localStorage.getItem("derivar_asunto");
                const documentoD = localStorage.getItem("derivar_documento");
                if (codigoD && asuntoD && documentoD) {
                    cargarFormularioDerivarTramite(codigoD, asuntoD, documentoD);
                }
                break;
            default:
                cargarHome();
        }
    } else {
        cargarHome();
    }
}

cargarDesdeLocalStorage();

function cargarHome() {
    verificarSesion(() => {
        mostrarSpinner();
        $("#contenido-dinamico").load("../../views/dashboard/principalAdmin.php", function () {
            ocultarSpinner();
            guardarContenidoEnLocalStorage($("#contenido-dinamico").html(), "home");
        });
    });
}

function cargarformularioGenerico(url, vista, paginadorVarName) {
    verificarSesion(() => {
        mostrarSpinner();
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            success: function (response) {
                ocultarSpinner();
                if (response.flag == 1 || response.formularioHTML) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, vista);

                    if (paginadorVarName && typeof window[paginadorVarName] !== "undefined") {
                        window[paginadorVarName].init();
                    }
                }
            },
            error: function () {
                ocultarSpinner();
            }
        });
    });
}

function cargarformularioAdministracionRemitentes() {
    cargarformularioGenerico("../../controllers/Administracion/controlAdministracionRemitentes.php", "administracionRemitentes", "remitentesPagination");
}

function cargarformularioAdministracionUsuarios() {
    cargarformularioGenerico("../../controllers/Administracion/controlAdministracionUsuarios.php", "administracionUsuarios", "usuariosPagination");
}

function cargarformularioAdministracionAreas() {
    cargarformularioGenerico("../../controllers/Administracion/controlAdministracionAreas.php", "administracionAreas", "areasPagination");
}

function cargarformularioAdministracionDocumentos() {
    cargarformularioGenerico("../../controllers/Administracion/controlAdministracionDocumentos.php", "administracionDocumentos", "tipoDocumentosPagination");
}

function cargarformularioConsultarTramitesArchivados() {
    cargarformularioGenerico("../../controllers/Consultar/controlFormConsultarTramitesArchivados.php", "consultarTramitesArchivados");
}

function cargarformularioConsultarTramitesDerivados() {
    cargarformularioGenerico("../../controllers/Consultar/controlFormConsultarTramitesDerivados.php", "consultarTramitesDerivados");
}

function cargarformularioRecibirTramitesExternos() {
    cargarformularioGenerico("../../controllers/RecibirTramiteExterno/controlFormRecibirTramiteExterno.php", "recibirTramitesExternos");
}

function cargarformularioRecibirTramitesInternos() {
    cargarformularioGenerico("../../controllers/RecibirTramiteInterno/controlFormRecibirTramiteInterno.php", "recibirTramitesInternos");
}

function cargarformularioResolverTramites() {
    cargarformularioGenerico("../../controllers/ResolverTramite/controlFormResolverTramite.php", "resolverTramites");
}

$(document).on('click', '#AdministrarRemitentes', function() {
    cargarformularioAdministracionRemitentes();
});
$(document).on('click', '#AdministrarUsuarios', function() {
    cargarformularioAdministracionUsuarios();
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
$(document).on('click', '#RecibirTramitesInternos', function() {
    cargarformularioRecibirTramitesInternos();
});
$(document).on('click', '#ResolverTramites', function() {
    cargarformularioResolverTramites();
});

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
            } else {
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
        .catch(() => {
            window.location.href = "../../index.php";
        });
}
