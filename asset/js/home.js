window.sonidoHabilitado = false;

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

function toggleCalendar() {
    document.getElementById('calendarOffcanvas').classList.toggle('show');
}

window.addEventListener("resize", initializeMenu);

function validarFormularioIngresar(){
    let isValid = true;
}

function guardarParametrosChat(id_ayuda) {
    localStorage.setItem("chat_id_ayuda", id_ayuda);
}

// ✅ Cargar contenido desde localStorage si existe
function cargarDesdeLocalStorage() {
    const vista = localStorage.getItem("vistaActual");
    if (vista) {
        switch (vista) {
            case "home":
                cargarHome();
                break;
            case "tramite":
                cargarFormularioTramite();
                break;
            case "ajustes":
                cargarAjustesDatos();
                break;
            case "seguimiento":
                cargarFormularioSeguimiento();
                break;
            case "ayuda":
                cargarformularioAyuda();
                break;
            case "mensajes":
                cargarformularioMensaje();
                esperarPrimeraInteraccionParaHabilitarSonido();
                break;
            case "chat":
                const chat_id_ayuda = localStorage.getItem("chat_id_ayuda");
                if (chat_id_ayuda) {
                    cargarFormularioResponderMensaje(chat_id_ayuda);
                } else {
                    //console.warn("⚠️ Faltan parámetros para cargar chat.");
                }
                break;
            default:
                cargarHome();
        }
    } else {
        cargarHome(); // por defecto
    }
}

function esperarPrimeraInteraccionParaHabilitarSonido() {
    const activarSonido = () => {
        window.sonidoHabilitado = true;
        document.removeEventListener("click", activarSonido);
        document.removeEventListener("keydown", activarSonido);
    };

    // Espera cualquier interacción simple
    document.addEventListener("click", activarSonido);
    document.addEventListener("keydown", activarSonido);
}

cargarDesdeLocalStorage();

// ✅ Guardar contenido y vista en localStorage
function guardarContenidoEnLocalStorage(html, vista) {
    localStorage.setItem("contenidoDinamico", html);
    if (vista) {
        localStorage.setItem("vistaActual", vista);
    }
}

function cargarHome() {

    verificarSesionRemitente(() => {
        $("#contenido-dinamico").load("../../views/dashboard/principal.php", function() {
            guardarContenidoEnLocalStorage($("#contenido-dinamico").html(), "home");
        });
    });
}

function cargarFormularioTramite() {

    verificarSesionRemitente(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/IngresarTramite/controlFormIngresarTramite.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    if(response.message){
                        Swal.fire({
                            icon: 'info',
                            title: 'Aviso',
                            text: response.message
                        }).then(()=>{
                            $("#contenido-dinamico").html(response.formularioHTML);
                            guardarContenidoEnLocalStorage(response.formularioHTML, "tramite");
                            cargarDepartamentos();
                        })
                    }else{
                        $("#contenido-dinamico").html(response.formularioHTML);
                        guardarContenidoEnLocalStorage(response.formularioHTML, "tramite");
                        cargarDepartamentos();
                    }
                }else if(response.flag == 2){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "tramite");
                }
            }
        })
    });
}

function cargarformularioAyuda(){

    verificarSesionRemitente(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Ayuda/controlFormAyuda.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    if(response.message){
                        Swal.fire({
                            icon: 'info',
                            title: 'Aviso',
                            text: response.message
                        }).then(()=>{
                            $("#contenido-dinamico").html(response.formularioHTML);
                            guardarContenidoEnLocalStorage(response.formularioHTML, "ayuda");
                            cargarDepartamentos();
                        })
                    }else{
                        $("#contenido-dinamico").html(response.formularioHTML);
                        guardarContenidoEnLocalStorage(response.formularioHTML, "ayuda");
                        cargarDepartamentos();
                    }
                    
                }else if(response.flag ==2){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "ayuda");
                }
            }
        })
    });
}

function cargarFormularioSeguimiento(){

    verificarSesionRemitente(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/SeguimientoTramite/controlFormSeguimientoTramite.php",
            dataType: "json",
            success: function(response) {
            if (response.flag == 1) {
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "seguimiento");
                // Esperar brevemente a que el DOM procese el nuevo HTML
                setTimeout(() => {
                inicializarModalEstadosTramite();
                }, 100);
            } else {
                alert("Ocurrió un problema al cargar el formulario.");
            }
            },
            error: function(xhr, status, error) {
            //console.error("Error en AJAX: ", error);
            alert("Error en la comunicación con el servidor.");
            }
        });
    });
}

function cargarAjustesDatos() {

    verificarSesionRemitente(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlFormAjustarDatos.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    guardarContenidoEnLocalStorage(response.formularioHTML, "ajustes");

                    const datoDepartamento = response.departamento;
                    const datoProvincia = response.provincia;
                    const datoDistrito = response.distrito;
                    cargarDepartamentos(datoDepartamento, datoProvincia, datoDistrito);
                }
            }
        });
    });
}

function cargarformularioMensaje(){

    verificarSesionRemitente(() => {
        $.ajax({
            type: "POST",
            url: "../../controllers/Mensaje/controlFormMensaje.php",
            dataType: "json",
            success: function(response){
                if(response.flag == 1){
                    $("#contenido-dinamico").html(response.formularioHTML);
                    window.MensajesPagination.init();
                    guardarContenidoEnLocalStorage(response.formularioHTML, "mensajes");
                }
            }
        })
    });
}

$(document).on('click', '#botonTramite', function() {
    cargarFormularioTramite();
});

$(document).on('click', '#botonSeguimiento', function() {
    cargarFormularioSeguimiento();
});

$(document).on('click', '#botonAjustes', function() {
    cargarAjustesDatos();
});

$(document).on('click', '#botonAyuda', function() {
    cargarformularioAyuda();
});

$(document).on('click', '#botonMensaje', function(event) {
    // Registrar cualquier tipo de interacción (click ya lo es)
    window.sonidoHabilitado = true;

    // Para navegadores que solo habilitan audio tras interacción
    const audio = document.getElementById("sonidoNuevoMensaje");
    if (audio) {
        audio.play().catch(() => {
            // No es necesario mostrar error, solo intentamos activar
        });
    }

    cargarformularioMensaje();
});

function cargarDepartamentos(datoDepartamento = null, datoProvincia = null, datoDistrito = null) {
    $.ajax({
        type: "POST",
        url: "../../controllers/Ajustes/controlAjustesUbicacion.php",
        dataType: "json",
        success: function(response) {
            if (response.flag == 1 && Array.isArray(response.departamentos)) {
                const select = $('#DEPARTAMENTO');
                select.empty();
                select.append('<option value="">-- Selecciona un departamento --</option>');

                response.departamentos.forEach(function(departamento) {
                    if (datoDepartamento && datoDepartamento === departamento.departamento) {
                        select.append(`<option value="${departamento.idDepa}" selected>${departamento.departamento}</option>`);
                    } else {
                        select.append(`<option value="${departamento.idDepa}">${departamento.departamento}</option>`);
                    }
                });

                if (datoDepartamento) {
                    cargarProvincias(datoDepartamento, datoProvincia, datoDistrito);
                }
            } else {
                //console.error("Error en los datos recibidos:", response);
            }
        },
        error: function(xhr, status, error) {
            //console.error("Error AJAX:", status, error);
        }
    });
}

$(document).on('change', '#DEPARTAMENTO', function () {
    const Depa = $('#DEPARTAMENTO option:selected').text();
    if (Depa !== "") {
        cargarProvincias(Depa);
        $('#DISTRITO').val('');
        $('#DISTRITO').html('<option value="">-- Selecciona un distrito --</option>');
    } else {
        $('#PROVINCIA').val('');
        $('#PROVINCIA').html('<option value="">-- Selecciona una provincia --</option>');
        $('#DISTRITO').val('');
        $('#DISTRITO').html('<option value="">-- Selecciona un distrito --</option>');
    }
});

function cargarProvincias(datoDepartamento, datoProvincia = null, datoDistrito = null) {
    $.ajax({
        type: "POST",
        url: "../../controllers/Ajustes/controlAjustesUbicacion.php",
        data: { action: 'provincias', Depa: datoDepartamento },
        dataType: "json",
        success: function(response) {
            const select = $('#PROVINCIA');
            select.empty();
            select.append('<option value="">-- Selecciona una provincia --</option>');

            if (response.flag === 1 && Array.isArray(response.provincias)) {
                response.provincias.forEach(function(prov) {
                    if (datoProvincia && datoProvincia === prov.provincia) {
                        select.append(`<option value="${prov.idProv}" selected>${prov.provincia}</option>`);
                    } else {
                        select.append(`<option value="${prov.idProv}">${prov.provincia}</option>`);
                    }
                });

                if (datoProvincia) {
                    cargarDistritos(datoProvincia, datoDistrito);
                }
            } else {
                //console.error("No se recibieron provincias correctamente:", response);
            }
        },
        error: function(xhr, status, error) {
            //console.error("Error al cargar provincias:", error);
        }
    });
}

$(document).on('change', '#PROVINCIA', function () {
    const provincia = $('#PROVINCIA option:selected').text();
    if (provincia !== "") {
        cargarDistritos(provincia);
    } else {
        $('#DISTRITO').html('<option value="">-- Selecciona un distrito --</option>');
    }
});

function cargarDistritos(datoProvincia, datoDistrito = null) {
    $.ajax({
        type: "POST",
        url: "../../controllers/Ajustes/controlAjustesUbicacion.php",
        data: { action: 'distritos', provincia: datoProvincia },
        dataType: "json",
        success: function(response) {
            const select = $('#DISTRITO');
            select.empty();
            select.append('<option value="">-- Selecciona un distrito --</option>');

            if (response.flag === 1 && Array.isArray(response.distritos)) {
                response.distritos.forEach(function(dist) {
                    if (datoDistrito && datoDistrito === dist.distrito) {
                        select.append(`<option value="${dist.idDist}" selected>${dist.distrito}</option>`);
                    } else {
                        select.append(`<option value="${dist.idDist}">${dist.distrito}</option>`);
                    }
                });
            } else {
                //console.error("No se recibieron distritos correctamente:", response);
            }
        },
        error: function(xhr, status, error) {
            //console.error("Error al cargar distritos:", error);
        }
    });
}

// ✅ Cierre de sesión: eliminar el contenido almacenado
document.getElementById("cerrarSesion")?.addEventListener("click", function () {
    localStorage.removeItem("contenidoDinamico");
    localStorage.removeItem("vistaActual");
});

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
            // Fallback ante error de red o del servidor
            window.location.href = "../../index.php";
        });
}