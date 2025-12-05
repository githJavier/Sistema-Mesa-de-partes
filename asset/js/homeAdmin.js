// homeAdmin.js - VERSIÓN FUNCIONAL SIMPLIFICADA

// Configuración global
window.sonidoHabilitado = false;

// ========== COMMAND DISPATCHER SIMPLIFICADO ==========
class CommandDispatcher {
    constructor() {
        this.init();
    }
    
    init() {
        console.log("✅ CommandDispatcher inicializado");
        this.setupEventListeners();
    }
    
    setupEventListeners() {
        // Solo escucha data-command
        $(document).on('click', '[data-command]', (event) => {
            let button = event.target.closest('[data-command]');
            if (!button) return;
            
            let commandName = button.getAttribute('data-command');
            if (commandName) {
                event.preventDefault();
                this.executeCommand(commandName);
            }
        });
    }
    
    executeCommand(commandName, params = {}) {
        console.log(`🎯 Ejecutando comando: ${commandName}`);
        
        // Manejo especial para mensajes
        if (commandName === 'mensajesAdmin') {
            window.sonidoHabilitado = true;
            const audio = document.getElementById("sonidoNuevoMensaje");
            if (audio) audio.play().catch(() => {});
        }
        
        verificarSesion(() => {
            this.loadCommand(commandName, params);
        });
    }
    
    loadCommand(commandName, params = {}) {
        mostrarSpinner();
        
        // Mapeo directo de comandos a controladores (SIN CommandController.php)
        const commandMap = {
            'home': {
                type: 'direct',
                url: '../../views/dashboard/principalAdmin.php'
            },
            'administracionRemitentes': {
                type: 'ajax',
                url: '../../controllers/Administracion/controlAdministracionRemitentes.php'
            },
            'administracionUsuarios': {
                type: 'ajax',
                url: '../../controllers/Administracion/controlAdministracionUsuarios.php'
            },
            'administracionAreas': {
                type: 'ajax',
                url: '../../controllers/Administracion/controlAdministracionAreas.php'
            },
            'administracionDocumentos': {
                type: 'ajax',
                url: '../../controllers/Administracion/controlAdministracionDocumentos.php'
            },
            'consultarTramitesArchivados': {
                type: 'ajax',
                url: '../../controllers/Consultar/controlFormConsultarTramitesArchivados.php'
            },
            'consultarTramitesDerivados': {
                type: 'ajax',
                url: '../../controllers/Consultar/controlFormConsultarTramitesDerivados.php'
            },
            'recibirTramitesExternos': {
                type: 'ajax',
                url: '../../controllers/RecibirTramiteExterno/controlFormRecibirTramiteExterno.php'
            },
            'recibirTramitesInternos': {
                type: 'ajax',
                url: '../../controllers/RecibirTramiteInterno/controlFormRecibirTramiteInterno.php'
            },
            'resolverTramites': {
                type: 'ajax',
                url: '../../controllers/ResolverTramite/controlFormResolverTramite.php'
            },
            'ingresarTramite': {
                type: 'ajax',
                url: '../../controllers/IngresarTramiteUsuario/controlFormIngresarTramiteUsuario.php'
            },
            'mensajesAdmin': {
                type: 'ajax',
                url: '../../controllers/Mensaje/controlFormMensajeAdmin.php'
            }
        };
        
        const config = commandMap[commandName];
        
        if (!config) {
            console.error(`❌ Comando no encontrado: ${commandName}`);
            ocultarSpinner();
            return;
        }
        
        if (config.type === 'direct') {
            // Carga directa
            $("#contenido-dinamico").load(config.url, () => {
                this.finalizeLoad(commandName);
            });
        } else {
            // Carga AJAX
            $.ajax({
                type: "POST",
                url: config.url,
                dataType: "json",
                success: (response) => {
                    if (response.flag == 1) {
                        $("#contenido-dinamico").html(response.formularioHTML);
                        this.finalizeLoad(commandName);
                        this.executePostLoad(commandName);
                    } else {
                        console.error(`❌ Error en ${commandName}:`, response);
                        ocultarSpinner();
                    }
                },
                error: (xhr, status, error) => {
                    console.error(`❌ Error AJAX en ${commandName}:`, error);
                    console.log("URL intentada:", config.url);
                    ocultarSpinner();
                }
            });
        }
    }
    
    finalizeLoad(commandName) {
        ocultarSpinner();
        
        // Guardar en localStorage
        guardarContenidoEnLocalStorage(
            $("#contenido-dinamico").html(), 
            commandName
        );
    }
    
    executePostLoad(commandName) {
        setTimeout(() => {
            const paginationMap = {
                'administracionRemitentes': 'remitentesPagination',
                'administracionUsuarios': 'usuariosPagination',
                'administracionAreas': 'areasPagination',
                'administracionDocumentos': 'tipoDocumentosPagination',
                'mensajesAdmin': 'MensajesPagination'
            };
            
            const paginationVar = paginationMap[commandName];
            if (paginationVar && typeof window[paginationVar] !== "undefined") {
                window[paginationVar].init();
                console.log(`✅ Paginación ${paginationVar} inicializada`);
            }
        }, 100);
    }
}

// ========== FUNCIONES AUXILIARES ==========
function mostrarSpinner() {
    $("#spinner-cargando").fadeIn(100);
    $("#contenido-dinamico").hide();
}

function ocultarSpinner() {
    $("#spinner-cargando").fadeOut(100, function () {
        $("#contenido-dinamico").fadeIn(100);
    });
}

function guardarContenidoEnLocalStorage(html, vista) {
    localStorage.setItem("contenidoDinamico", html);
    if (vista) {
        localStorage.setItem("vistaActual", vista);
    }
}

// ========== FUNCIONES PÚBLICAS (compatibilidad) ==========
function cargarHome() {
    window.commandDispatcher.executeCommand('home');
}

function cargarformularioAdministracionRemitentes() {
    window.commandDispatcher.executeCommand('administracionRemitentes');
}

function cargarformularioAdministracionUsuarios() {
    window.commandDispatcher.executeCommand('administracionUsuarios');
}

function cargarformularioAdministracionAreas() {
    window.commandDispatcher.executeCommand('administracionAreas');
}

function cargarformularioAdministracionDocumentos() {
    window.commandDispatcher.executeCommand('administracionDocumentos');
}

function cargarformularioConsultarTramitesArchivados() {
    window.commandDispatcher.executeCommand('consultarTramitesArchivados');
}

function cargarformularioConsultarTramitesDerivados() {
    window.commandDispatcher.executeCommand('consultarTramitesDerivados');
}

function cargarformularioRecibirTramitesExternos() {
    window.commandDispatcher.executeCommand('recibirTramitesExternos');
}

function cargarformularioRecibirTramitesInternos() {
    window.commandDispatcher.executeCommand('recibirTramitesInternos');
}

function cargarformularioResolverTramites() {
    window.commandDispatcher.executeCommand('resolverTramites');
}

function cargarformularioIngresarTramite() {
    window.commandDispatcher.executeCommand('ingresarTramite');
}

function cargarformularioMensaje() {
    window.commandDispatcher.executeCommand('mensajesAdmin');
}

// ========== FUNCIONES DE INTERFAZ ==========
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

// ========== FUNCIONES DE PARÁMETROS ==========
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

function guardarParametrosChatAdmin(id_ayuda) {
    localStorage.setItem("chat_id_ayuda", id_ayuda);
}

// ========== FUNCIONES DE CARGA INICIAL ==========
function cargarDesdeLocalStorage() {
    const vista = localStorage.getItem("vistaActual");
    if (vista) {
        window.commandDispatcher.executeCommand(vista);
    } else {
        cargarHome();
    }
}

function esperarPrimeraInteraccionParaHabilitarSonido() {
    const activarSonido = () => {
        window.sonidoHabilitado = true;
        document.removeEventListener("click", activarSonido);
        document.removeEventListener("keydown", activarSonido);
    };

    document.addEventListener("click", activarSonido);
    document.addEventListener("keydown", activarSonido);
}

// ========== FUNCIONES DE SEGURIDAD ==========
function verificarSesion(callback) {
    fetch("../../utils/verificarSesion.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "active") {
                if (typeof callback === "function") callback();
            } else if (data.status === "no_session") {
                window.location.href = "../../index.php";
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
        .catch(error => {
            console.error("Error al verificar sesión:", error);
            window.location.href = "../../index.php";
        });
}

// ========== INICIALIZACIÓN ==========
$(document).ready(function() {
    console.log("🔄 Inicializando sistema...");
    
    // Crear el dispatcher
    window.commandDispatcher = new CommandDispatcher();
    
    // Cargar vista desde localStorage
    cargarDesdeLocalStorage();
    
    // Configurar cierre de sesión
    document.getElementById("cerrarSesion")?.addEventListener("click", function () {
        localStorage.clear();
    });
    
    // Inicializar menú
    initializeMenu();
    
    // Configurar eventos de menú
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
    
    // Habilitar sonido
    esperarPrimeraInteraccionParaHabilitarSonido();
    
    // Configurar resize
    window.addEventListener("resize", initializeMenu);
    
    console.log("✅ Sistema inicializado correctamente");
});

// ========== COMPATIBILIDAD ==========
window.cargarHome = cargarHome;
window.cargarformularioAdministracionRemitentes = cargarformularioAdministracionRemitentes;
window.cargarformularioAdministracionUsuarios = cargarformularioAdministracionUsuarios;
window.cargarformularioAdministracionAreas = cargarformularioAdministracionAreas;
window.cargarformularioAdministracionDocumentos = cargarformularioAdministracionDocumentos;
window.cargarformularioConsultarTramitesArchivados = cargarformularioConsultarTramitesArchivados;
window.cargarformularioConsultarTramitesDerivados = cargarformularioConsultarTramitesDerivados;
window.cargarformularioRecibirTramitesExternos = cargarformularioRecibirTramitesExternos;
window.cargarformularioRecibirTramitesInternos = cargarformularioRecibirTramitesInternos;
window.cargarformularioResolverTramites = cargarformularioResolverTramites;
window.cargarformularioIngresarTramite = cargarformularioIngresarTramite;
window.cargarformularioMensaje = cargarformularioMensaje;
window.toggleMenu = toggleMenu;
window.toggleUserMenu = toggleUserMenu;
window.initializeMenu = initializeMenu;
window.verificarSesion = verificarSesion;