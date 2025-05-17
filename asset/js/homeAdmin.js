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
            default:
                cargarHome();
        }
    } else {
        cargarHome(); // por defecto
    }
}
cargarDesdeLocalStorage();

function cargarHome() {
    $("#contenido-dinamico").load("../../views/dashboard/principalAdmin.php", function() {
        guardarContenidoEnLocalStorage($("#contenido-dinamico").html(), "home");
    });
}

function cargarformularioAdministracionRemitentes() {
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
}

    });
}

function cargarformularioAdministracionUsuarios(){
    $.ajax({
        type: "POST",
        url: "../../controllers/Administracion/controlAdministracionUsuarios.php",
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "administracionUsuarios");

                setTimeout(() => {
                    if (typeof window.usuariosPagination !== "undefined") {
                        window.usuariosPagination.init();
                    }
                }, 100);
            }
        }
    })
}


function cargarformularioAdministracionAreas(){
    $.ajax({
        type: "POST",
        url: "../../controllers/Administracion/controlAdministracionAreas.php",
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "administracionAreas");
            }
        }
    })
}

function cargarformularioAdministracionDocumentos(){
    $.ajax({
        type: "POST",
        url: "../../controllers/Administracion/controlAdministracionDocumentos.php",
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "administracionDocumentos");
            }
        }
    })
}

function cargarformularioConsultarTramitesArchivados(){
    $.ajax({
        type: "POST",
        url: "../../controllers/Consultar/controlConsultarTramitesArchivados.php",
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "consultarTramitesArchivados");
            }
        }
    })
}

function cargarformularioConsultarTramitesDerivados(){
    $.ajax({
        type: "POST",
        url: "../../controllers/Consultar/controlConsultarTramitesDerivados.php",
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "consultarTramitesDerivados");
            }
        }
    })
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


// ✅ Cierre de sesión: eliminar el contenido almacenado
document.getElementById("cerrarSesion")?.addEventListener("click", function () {
    localStorage.removeItem("contenidoDinamico");
    localStorage.removeItem("vistaActual");
});