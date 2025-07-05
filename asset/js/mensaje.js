window.MensajesPagination = (function () {
    let currentPage = 1;
    let rowsPerPage = 10; // Valor por defecto
    const selectId = "ma-items-page";
    const btnPrevId = "ma-prev-page";
    const btnNextId = "ma-next-page";
    const tableId = "ma-lista-mensajes"; // ID del contenedor de mensajes

    // Cargar la configuración guardada
    const loadSavedConfig = () => {
        const savedRowsPerPage = localStorage.getItem('mensajesRowsPerPage');
        if (savedRowsPerPage) {
            rowsPerPage = parseInt(savedRowsPerPage, 10);
        }
    };

    // Guardar la configuración en localStorage
    const saveConfig = () => {
        localStorage.setItem('mensajesRowsPerPage', rowsPerPage);
    };

    // Actualizar la paginación
    const updatePagination = () => {
        const cards = document.querySelectorAll(".ma-lista-mensajes .card");
        const totalRows = cards.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        // Mostrar u ocultar los mensajes según la página actual
        cards.forEach((card, index) => {
            card.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });

        // Actualizar botones de paginación
        document.getElementById(btnPrevId).disabled = currentPage === 1;
        document.getElementById(btnNextId).disabled = currentPage === totalPages || totalPages === 0;

        // Actualizar información de paginación
        const paginationInfo = document.getElementById("pagination-info");
        if (paginationInfo) {
            paginationInfo.innerText = totalRows > 0
                ? `Mostrando del ${(currentPage - 1) * rowsPerPage + 1} al ${Math.min(currentPage * rowsPerPage, totalRows)} de ${totalRows} mensajes`
                : "No hay mensajes que mostrar.";
        }
    };

    // Inicializar la paginación y los eventos
    const init = () => {
        loadSavedConfig();

        const select = document.getElementById(selectId);
        if (select) {
            select.value = rowsPerPage;
            select.addEventListener("change", function () {
                rowsPerPage = parseInt(this.value, 10);
                currentPage = 1; // Reiniciar a la primera página
                saveConfig();
                updatePagination();
            });
        }

        const btnPrev = document.getElementById(btnPrevId);
        const btnNext = document.getElementById(btnNextId);

        if (btnPrev) {
            btnPrev.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });
        }

        if (btnNext) {
            btnNext.addEventListener("click", () => {
                const totalRows = document.querySelectorAll(".ma-lista-mensajes .card").length;
                const totalPages = Math.ceil(totalRows / rowsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });
        }

        updatePagination(); // Inicializar la paginación al cargar
    };

    return {
        init
    };
})();

document.getElementById("ma-filtro-asunto").addEventListener("input", function () {
    const input = this.value.trim().toLowerCase();
    const cards = document.querySelectorAll(".ma-lista-mensajes .card");

    // Mostrar u ocultar tarjetas según si el asunto contiene el texto escrito
    cards.forEach(card => {
        const asunto = card.querySelector(".card-title").textContent.toLowerCase();
        const match = asunto.includes(input);
        card.style.display = match ? "" : "none";
    });

    // Contar cuántas tarjetas están visibles
    const visibleCards = document.querySelectorAll(".ma-lista-mensajes .card:not([style*='display: none'])");
    const visibleCount = visibleCards.length;

    // Ocultar la paginación sin importar el resultado (forzadamente)
    const paginationNav = document.querySelector("nav[aria-label='Page navigation']");
    if (paginationNav) {
        paginationNav.style.setProperty("display", "none", "important");
    }

    // Mostrar u ocultar el mensaje de "no se encontraron resultados"
    const noResultsMsg = document.getElementById("no-results-msg");
    if (noResultsMsg) {
        noResultsMsg.classList.toggle("d-none", visibleCount > 0);
    }
});

document.getElementById("ma-btn-filtrar").addEventListener("click", function () {
    const estado = document.getElementById("ma-filtro-estado").value;

    // Validar que el estado seleccionado sea válido
    if (!["Enviado", "En proceso", "Resuelto"].includes(estado)) {
        Swal.fire({
            icon: 'warning',
            title: 'Estado inválido',
            text: 'Seleccione un estado válido para filtrar.'
        });
        return;
    }

    // Mostrar u ocultar tarjetas según el estado seleccionado
    const cards = document.querySelectorAll(".ma-lista-mensajes .card");
    cards.forEach(card => {
        const badge = card.querySelector(".badge").textContent.trim();
        card.style.display = (badge === estado) ? "" : "none";
    });

    // Contar cuántas tarjetas están visibles
    const visibleCards = document.querySelectorAll(".ma-lista-mensajes .card:not([style*='display: none'])");
    const visibleCount = visibleCards.length;

    // Ocultar la paginación sin importar el resultado (forzadamente)
    const paginationNav = document.querySelector("nav[aria-label='Page navigation']");
    if (paginationNav) {
        paginationNav.style.setProperty("display", "none", "important");
    }

    // Mostrar u ocultar el mensaje de "no se encontraron resultados"
    const noResultsMsg = document.getElementById("no-results-msg");
    if (noResultsMsg) {
        noResultsMsg.classList.toggle("d-none", visibleCount > 0);
    }
});

// Evento al presionar el botón "Limpiar"
document.getElementById("ma-btn-limpiar").addEventListener("click", function () {
    // Mostrar todas las tarjetas
    const cards = document.querySelectorAll(".ma-lista-mensajes .card");
    cards.forEach(card => {
        card.style.display = ""; // Mostrar todas
    });

    // Ocultar el mensaje de "no se encontraron resultados"
    const noResultsMsg = document.getElementById("no-results-msg");
    if (noResultsMsg) {
        noResultsMsg.classList.add("d-none");
    }

    // Mostrar nuevamente la paginación
    const paginationNav = document.querySelector("nav[aria-label='Page navigation']");
    if (paginationNav) {
        paginationNav.style.setProperty("display", "flex", "important");
    }

    // Reiniciar la página actual a la 1 y actualizar paginación
    if (window.MensajesPagination && typeof window.MensajesPagination.init === "function") {
        // Reiniciar paginación desde cero
        window.MensajesPagination.init();
    }
});

/** ===================================================== **/
/** ===================================================== **/
/** ========== POLLING DE MENSAJES AYUDA ADMIN ========== **/
/** ===================================================== **/
/** ===================================================== **/

// ==================== VARIABLES ==================== //
if (typeof ultimaFechaHoraActividad === "undefined") {
    // Tratar de recuperar desde localStorage
    const guardado = localStorage.getItem("ultimaFechaHoraActividad");
    if (guardado) {
        var ultimaFechaHoraActividad = guardado;
    } else {
        // Calcular desde el DOM
        var ultimaFechaHoraActividad = obtenerUltimaFechaHoraActividad();
    }
}

if (typeof idsMensajesInsertados === "undefined") {
    var idsMensajesInsertados = new Set();
}

// ==================== FUNCIONES ==================== //

function obtenerUltimaFechaHoraActividad() {
    const cards = document.querySelectorAll(".ma-lista-mensajes .card");
    if (cards.length === 0) return "0000-00-00 00:00:00";

    const card = cards[0]; // el primero es el más reciente
    const fecha = card.getAttribute("data-fecha-administrador") || card.getAttribute("data-fecha");
    const hora = card.getAttribute("data-hora-administrador") || card.getAttribute("data-hora");
    return `${fecha} ${hora}`;
}

function insertarNuevoMensaje(data) {
    const contenedor = document.querySelector(".ma-lista-mensajes");

    data.reverse().forEach(fila => {
        const id = fila.id_ayuda;

        // Eliminar mensaje viejo si ya estaba
        const existente = contenedor.querySelector(`[data-id='${id}']`);
        if (existente) {
            contenedor.removeChild(existente);
        }

        idsMensajesInsertados.add(id); // Guardar para evitar duplicados

        const fechaRef = fila.fecha_ultimo_mensaje_admin || fila.fecha;
        const horaRef = fila.hora_ultimo_mensaje_admin || fila.hora;

        const html = `
                    <div class="card mb-3 shadow-sm"
                        data-id="${fila.id_ayuda}"
                        data-fecha="${fila.fecha}"
                        data-hora="${fila.hora}"
                        data-fecha-administrador="${fila.fecha_ultimo_mensaje_admin || ''}"
                        data-hora-administrador="${fila.hora_ultimo_mensaje_admin || ''}">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span class="badge bg-${fila.estado.toLowerCase().replace(/ /g, '-')}">
                                ${fila.estado}
                            </span>
                            <span class="text-muted">${fila.fecha} ${fila.hora.slice(0, 5)}</span>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">${fila.asunto}</h5>
                            <p class="card-text">${fila.mensaje.replace(/\n/g, '<br>')}</p>
                            <footer class="blockquote-footer">
                                Por: ${fila.nombres}
                                <cite>(${fila.retipo_docu} ${fila.docu_num})</cite>
                            </footer>
                            <div class="text-end mt-2 d-flex justify-content-end align-items-center gap-3 flex-wrap">
                                <small class="text-muted d-flex align-items-center gap-2">
                                    <i class="fas fa-envelope text-primary"></i>
                                    <strong>
                                        ${fila.fecha_ultimo_mensaje_admin && fila.hora_ultimo_mensaje_admin
                                            ? `Última respuesta del administrador: ${fila.fecha_ultimo_mensaje_admin} ${fila.hora_ultimo_mensaje_admin.slice(0, 5)}`
                                            : `Aún sin respuesta del administrador`
                                        }
                                    </strong>
                                </small>
                                <button class="btn btn-outline-dark btn-sm" onclick="cargarFormularioResponderMensaje('${fila.id_ayuda}')">
                                    <i class="fas fa-comments"></i> Ver mensajes
                                </button>
                            </div>
                        </div>
                    </div>`;

        contenedor.insertAdjacentHTML("afterbegin", html);

        // Actualizar la última fecha-hora registrada
        const nuevaFechaHora = `${fechaRef} ${horaRef}`;
        if (!ultimaFechaHoraActividad || nuevaFechaHora > ultimaFechaHoraActividad) {
            ultimaFechaHoraActividad = nuevaFechaHora;
            localStorage.setItem("ultimaFechaHoraActividad", ultimaFechaHoraActividad);
        }
    });

    if (data.length > 0 && window.sonidoHabilitado) {
        const audio = document.getElementById("sonidoNuevoMensaje");
        if (audio) audio.play().catch(err => console.warn("Error al reproducir sonido:", err));
    }

    if (window.MensajesPagination && typeof window.MensajesPagination.init === "function") {
        window.MensajesPagination.init();
    }

    actualizarMensajesVacios();
}

function reproducirSonido() {
    if (window.sonidoHabilitado) {
        document.getElementById("sonidoNuevoMensaje").play().catch(err => {
            //console.warn("Error al reproducir sonido:", err);
        });
    }
}

function actualizarMensajesVacios() {
    const mensajes = document.querySelectorAll(".ma-lista-mensajes .card");
    const sinIniciales = document.getElementById("no-initial-messages");

    if (sinIniciales) {
        sinIniciales.classList.toggle("d-none", mensajes.length > 0);
    }
}

// ==================== POLLING ==================== //

if (typeof window.intervaloMensajes === "undefined") {
    window.habilitarPollingMensajes = true;

    window.intervaloMensajes = setInterval(() => {
        if (!window.habilitarPollingMensajes) {
            clearInterval(window.intervaloMensajes);
            delete window.intervaloMensajes;
            return;
        }
        fetch(`../../controllers/Mensaje/verificarNuevosMensajes.php?ultima_actividad=${encodeURIComponent(ultimaFechaHoraActividad)}`)
            .then(res => res.json())
            .then(data => {
                if (data.nuevos && data.nuevos.length > 0) {
                    insertarNuevoMensaje(data.nuevos);
                }
            })
            .catch(error => {
                //console.error("Error al verificar nuevos mensajes:", error);
            });
    }, 5000);
}

