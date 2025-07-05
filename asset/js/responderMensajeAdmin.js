function toggleInfoCard(btn) {
    const card = document.querySelector('.rma-case-info-card');
    const isVisible = card.style.display === 'block';

    if (!isVisible) {
        card.style.display = 'block';
        card.animate([{ transform: 'translateY(-10px)', opacity: 0 }, { transform: 'translateY(0)', opacity: 1 }], {
            duration: 250,
            easing: 'ease-out',
        });
    } else {
        card.animate([{ transform: 'translateY(0)', opacity: 1 }, { transform: 'translateY(-10px)', opacity: 0 }], {
            duration: 200,
            easing: 'ease-in',
        }).onfinish = () => {
            card.style.display = 'none';
        };
    }
}

/**Envio de mensajes**/

function obtenerUltimoIdMensaje() {
    const mensajes = document.querySelectorAll(".rma-message-wrapper[data-id-mensaje]");
    if (mensajes.length === 0) return 0;

    const ultimo = mensajes[mensajes.length - 1];
    return parseInt(ultimo.getAttribute("data-id-mensaje"), 10);
}

window.obtenerUltimoIdMensaje = obtenerUltimoIdMensaje;
window.ultimoIdMensaje = obtenerUltimoIdMensaje();

// Al principio del archivo
//window.idAyuda = undefined;
window.idAyuda = document.getElementById("rma-id-ayuda").value;

if (typeof window.intervaloChatAdmin === "undefined") {
    window.habilitarPollingChatAdmin = true;

    const inputMensaje = document.getElementById("rma-input-message");
    const botonEnviar = document.getElementById("rma-btn-send");
    //window.idAyuda = document.getElementById("rma-id-ayuda").value;
    const idRemitente = document.getElementById("rma-id-remitente").value;

    let enviandoMensaje = false; // Flag de protección

    // Activar/desactivar el botón según contenido
    inputMensaje.addEventListener("input", () => {
        botonEnviar.disabled = inputMensaje.value.trim() === "";
    });

    // Detectar Enter (sin Shift) para enviar
    inputMensaje.addEventListener("keydown", function(e) {
        if (e.key === "Enter" && !e.shiftKey) {
            e.preventDefault(); // No se inserta salto de línea
            if (!botonEnviar.disabled && !enviandoMensaje) {
                enviarMensaje();
            }
        }
    });

    // Validar contenido del mensaje
    function validarMensaje() {
        const valor = inputMensaje.value.trim();
        return valor !== "";
    }

    // Enviar mensaje (una sola vez hasta recibir respuesta)
    function enviarMensaje() {
        if (!validarMensaje() || enviandoMensaje) return;

        enviandoMensaje = true; // Activar flag

        const mensaje = inputMensaje.value.trim();

        $.ajax({
            type: "POST",
            url: "../../controllers/Mensaje/EnviarMensaje/controlEnviarMensajeAdmin.php",
            data: {
                mensaje: mensaje,
                idAyuda: window.idAyuda,
                idRemitente: idRemitente,
                btnEnviarMensaje: "EnviarMensaje"
            },
            dataType: "json",
            success: function(response) {
                //console.log("Respuesta del servidor:", response); // 👈 Esto muestra todo el contenido
                enviandoMensaje = false; // Liberar flag

                if (response.flag == 1) {
                    inputMensaje.value = "";
                    botonEnviar.disabled = true;
                    // actualizarChat(); // Si lo deseas activar
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo enviar el mensaje.'
                    });
                }
            },
            error: function(xhr, status, error) {
                enviandoMensaje = false; // Asegúrate de liberar el flag
                //console.error("Error AJAX:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema en la solicitud.'
                });
            }
        });
    }

    // Enviar con clic en botón (solo si no está ya enviando)
    botonEnviar.addEventListener("click", () => {
        if (!enviandoMensaje) {
            enviarMensaje();
        }
    });

    window.intervaloChatAdmin = setInterval(() => {
        if (!window.habilitarPollingChatAdmin) {
            clearInterval(window.intervaloChatAdmin);
            delete window.intervaloChatAdmin;
            return;
        }

        $.ajax({
            type: "POST",
            url: "../../controllers/Mensaje/RecibirMensaje/controlRecibirMensaje.php",
            data: { 
                idAyuda: window.idAyuda,
                ultimoIdMensaje: window.ultimoIdMensaje // 👈 se pasa dinámicamente
            },
            success: function(response) {
                const chatBox = document.getElementById("rma-chat-box");

                if (chatBox && !chatBox.classList.contains("active")) {
                    if (response.trim() !== "") {
                        const emptyMsg = document.querySelector(".rma-chat-empty");
                        if (emptyMsg) {
                            emptyMsg.remove();
                        }

                        // Crear un contenedor temporal para parsear el HTML recibido
                        const tempDiv = document.createElement("div");
                        tempDiv.innerHTML = response;

                        const nuevosMensajes = tempDiv.children;
                        let hayMensajesNuevos = false;

                        for (let mensaje of nuevosMensajes) {
                            const nuevoId = mensaje.getAttribute("data-id-mensaje");

                            // Solo insertar si no existe ya un mensaje con ese ID
                            if (!document.querySelector(`.rma-message-wrapper[data-id-mensaje="${nuevoId}"]`)) {
                                chatBox.appendChild(mensaje);
                                hayMensajesNuevos = true;
                            }
                        }

                        if (hayMensajesNuevos) {
                            chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll solo si hubo nuevos
                        }
                    }
                }

                // Siempre actualizamos el ID del último mensaje tras la inserción
                window.ultimoIdMensaje = window.obtenerUltimoIdMensaje();
            },
            error: function(xhr, status, error) {
                //console.error("Error al obtener mensajes:", error);
            }
        });
    }, 500);
}