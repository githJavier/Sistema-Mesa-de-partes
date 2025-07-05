// =======================
// Funciones del Spinner
// =======================
function mostrarSpinner() {
    $("#spinner-cargando").fadeIn(100);
    $("#contenido-dinamico").hide();
}

function ocultarSpinner() {
    $("#spinner-cargando").fadeOut(100, function () {
        $("#contenido-dinamico").fadeIn(100);
    });
}

// =======================
// Menú y usuarios
// =======================
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

function toggleUserMenu(event) {
    event.stopPropagation();
    document.getElementById('userMenu').classList.toggle('active');
}

function toggleCalendar() {
    document.getElementById('calendarOffcanvas').classList.toggle('show');
}

window.addEventListener("resize", initializeMenu);

document.addEventListener("click", function (event) {
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

// =======================
// LocalStorage
// =======================
function guardarContenidoEnLocalStorage(html, vista) {
    localStorage.setItem("contenidoDinamico", html);
    if (vista) {
        localStorage.setItem("vistaActual", vista);
    }
}

function cargarDesdeLocalStorage() {
    const vista = localStorage.getItem("vistaActual");
    if (vista) {
        switch (vista) {
            case "home": cargarHome(); break;
            case "tramite": cargarFormularioTramite(); break;
            case "ajustes": cargarAjustesDatos(); break;
            case "seguimiento": cargarFormularioSeguimiento(); break;
            case "ayuda": cargarformularioAyuda(); break;
            case "mensajes": cargarformularioMensaje(); break;
            default: cargarHome();
        }
    } else {
        cargarHome();
    }
}

cargarDesdeLocalStorage();

// =======================
// Carga de formularios
// =======================
function cargarHome() {
    verificarSesionRemitente(() => {
        mostrarSpinner();
        $("#contenido-dinamico").load("../../views/dashboard/principal.php", function () {
            ocultarSpinner();
            guardarContenidoEnLocalStorage($("#contenido-dinamico").html(), "home");
        });
    });
}

function cargarFormularioTramite() {
    verificarSesionRemitente(() => {
        mostrarSpinner();
        $.ajax({
            type: "POST",
            url: "../../controllers/IngresarTramite/controlFormIngresarTramite.php",
            dataType: "json",
            success: function (response) {
                ocultarSpinner();
                if (response.flag == 1) {
                    if (response.message) {
                        Swal.fire({ icon: 'info', title: 'Aviso', text: response.message }).then(() => {
                            $("#contenido-dinamico").html(response.formularioHTML);
                            guardarContenidoEnLocalStorage(response.formularioHTML, "tramite");
                            cargarDepartamentos();
                        });
                    } else {
                        $("#contenido-dinamico").html(response.formularioHTML);
                        guardarContenidoEnLocalStorage(response.formularioHTML, "tramite");
                        cargarDepartamentos();
                    }
                } else if (response.flag == 2) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "tramite");
                }
            },
            error: function () {
                ocultarSpinner();
                alert("Error al cargar el formulario.");
            }
        });
    });
}

function cargarformularioAyuda() {
    verificarSesionRemitente(() => {
        mostrarSpinner();
        $.ajax({
            type: "POST",
            url: "../../controllers/Ayuda/controlFormAyuda.php",
            dataType: "json",
            success: function (response) {
                ocultarSpinner();
                if (response.flag == 1 || response.flag == 2) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "ayuda");
                    cargarDepartamentos();
                }
            },
            error: ocultarSpinner
        });
    });
}

function cargarFormularioSeguimiento() {
    verificarSesionRemitente(() => {
        mostrarSpinner();
        $.ajax({
            type: "POST",
            url: "../../controllers/SeguimientoTramite/controlFormSeguimientoTramite.php",
            dataType: "json",
            success: function (response) {
                ocultarSpinner();
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "seguimiento");
                    setTimeout(() => inicializarModalEstadosTramite(), 100);
                }
            },
            error: function () {
                ocultarSpinner();
                alert("Error al cargar seguimiento.");
            }
        });
    });
}

function cargarAjustesDatos() {
    verificarSesionRemitente(() => {
        mostrarSpinner();
        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlFormAjustarDatos.php",
            dataType: "json",
            success: function (response) {
                ocultarSpinner();
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "ajustes");
                    cargarDepartamentos(response.departamento, response.provincia, response.distrito);
                }
            },
            error: ocultarSpinner
        });
    });
}

function cargarformularioMensaje() {
    verificarSesionRemitente(() => {
        mostrarSpinner();
        $.ajax({
            type: "POST",
            url: "../../controllers/Mensaje/controlFormMensaje.php",
            dataType: "json",
            success: function (response) {
                ocultarSpinner();
                if (response.flag == 1) {
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "mensajes");
                }
            },
            error: ocultarSpinner
        });
    });
}

// =======================
// Botones de navegación
// =======================
$(document).on('click', '#botonTramite', cargarFormularioTramite);
$(document).on('click', '#botonSeguimiento', cargarFormularioSeguimiento);
$(document).on('click', '#botonAjustes', cargarAjustesDatos);
$(document).on('click', '#botonAyuda', cargarformularioAyuda);
$(document).on('click', '#botonMensaje', cargarformularioMensaje);

// =======================
// Verificación de sesión
// =======================
function verificarSesionRemitente(callback) {
    fetch("../../utils/verificarSesionRemitente.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "found") {
                if (typeof callback === "function") callback();
            } else {
                window.location.href = "../../index.php";
            }
        })
        .catch(() => {
            window.location.href = "../../index.php";
        });
}

// =======================
// Cierre de sesión
// =======================
document.getElementById("cerrarSesion")?.addEventListener("click", function () {
    localStorage.removeItem("contenidoDinamico");
    localStorage.removeItem("vistaActual");
});
