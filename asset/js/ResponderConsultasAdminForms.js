function cargarFormularioResponderMensajeAdmin(id_ayuda) {
    $.ajax({
        type: "POST",
        url: "../../controllers/Mensaje/controlFormResponderMensajeAdmin.php",
        data: {
            id_ayuda: id_ayuda,
            btnAbrirChatResponderMensajeAdmin: "AbrirChatResponderMensajeAdmin"
        },
        dataType: "json",
        success: function(response) {
            if (response.flag == 1) {
                $("#contenido-dinamico").html(response.formularioHTML);
                guardarContenidoEnLocalStorage(response.formularioHTML, "chatAdmin");
                guardarParametrosChatAdmin(id_ayuda);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un problema al cargar el chat.'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor.'
            });
        }
    });
}
