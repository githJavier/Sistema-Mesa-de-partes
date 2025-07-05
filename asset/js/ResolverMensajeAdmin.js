var yaResuelto = false;

function marcarComoResuelto(id_ayuda) {
    if (yaResuelto) return; // Evita múltiples clics

    yaResuelto = true; // Bandera
    const btn = document.getElementById("ma-btn-resolver");
    if (btn) btn.disabled = true;

    $.ajax({
        type: "POST",
        url: "../../controllers/Mensaje/controlResolverMensajeAdmin.php",
        data: {
            id_ayuda: id_ayuda,
            btnResolverMensaje: "ResolverMensaje"
        },
        dataType: "json",
        success: function(response) {
            if (response.flag == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Mensaje resuelto',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "../../views/redireccion/homeAdmin.php";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error desconocido.'
                });
                yaResuelto = false;
                if (btn) btn.disabled = false;
            }
        },
        error: function(xhr, status, error) {
            //console.error("Estado:", status);
            //console.error("Error:", error);
            //console.error("Respuesta del servidor:", xhr.responseText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en la solicitud: ' + error
            });
            yaResuelto = false;
            if (btn) btn.disabled = false;
        }
    });
}

function mostrarModalResolver(id_ayuda) {
  const input = document.getElementById("id-ayuda-a-resolver");
  if (input) input.value = id_ayuda;

  const modal = new bootstrap.Modal(document.getElementById("modalConfirmarResolver"));
  modal.show();
}

document.addEventListener("click", function (e) {
  if (e.target && e.target.id === "btn-confirmar-resolver") {
    const id = document.getElementById("id-ayuda-a-resolver").value;
    if (id) marcarComoResuelto(id);
  }
});
