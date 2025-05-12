function validarAyuda() {
    let isValid = true;

    // Validar nombre
    let nombre = document.getElementById("nombre");
    let nombreValue = nombre.value.trim();
    let nombreError = document.getElementById("nombreError");

    if (nombreValue === '') {
        nombreError.textContent = 'Este campo es obligatorio.';
        nombreError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else {
        nombreError.style.display = 'none'; // Ocultar el error
    }

    // Validar correo (debe ser un correo electrónico válido)
    let correo = document.getElementById("correo");
    let correoValue = correo.value.trim();
    let correoError = document.getElementById("correoError");

    // Expresión regular para validar un correo electrónico
    let correoRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (correoValue === '') {
        correoError.textContent = 'Este campo es obligatorio.';
        correoError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else if (!correoRegex.test(correoValue)) {
        correoError.textContent = 'Por favor, ingrese un correo electrónico válido.';
        correoError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else {
        correoError.style.display = 'none'; // Ocultar el error
    }

    // Validar teléfono (debe empezar con 9 y contener solo 9 dígitos)
    let telefono = document.getElementById("telefono");
    let telefonoValue = telefono.value.trim();
    let telefonoError = document.getElementById("telefonoError");

    // Expresión regular para validar teléfono (debe comenzar con 9 y tener exactamente 9 dígitos)
    let telefonoRegex = /^9\d{8}$/;

    if (telefonoValue === '') {
        telefonoError.textContent = 'Este campo es obligatorio.';
        telefonoError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else if (!telefonoRegex.test(telefonoValue)) {
        telefonoError.textContent = 'El teléfono debe comenzar con 9 y ser solo números, con un total de 9 dígitos.';
        telefonoError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else {
        telefonoError.style.display = 'none'; // Ocultar el error
    }

    // Validar asunto
    let asunto = document.getElementById("asunto");
    let asuntoValue = asunto.value.trim();
    let asuntoError = document.getElementById("asuntoError");

    if (asuntoValue === '') {
        asuntoError.textContent = 'Este campo es obligatorio.';
        asuntoError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else {
        asuntoError.style.display = 'none'; // Ocultar el error
    }

    // Validar mensaje
    let mensaje = document.getElementById("mensaje");
    let mensajeValue = mensaje.value.trim();
    let mensajeError = document.getElementById("mensajeError");

    if (mensajeValue === '') {
        mensajeError.textContent = 'Este campo es obligatorio.';
        mensajeError.style.display = 'block'; // Mostrar el error
        isValid = false;
    } else {
        mensajeError.style.display = 'none'; // Ocultar el error
    }

    return isValid;
}

function enviarFormAyuda() {
    if (validarAyuda()) {
        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("correo").value.trim();
        const telefono = document.getElementById("telefono").value.trim();
        const asunto = document.getElementById("asunto").value.trim();
        const mensaje = document.getElementById("mensaje").value.trim();

        $.ajax({
            type: "POST",
            url: "../../controllers/Ayuda/controlIngresarAyuda.php",
            data: {
                nombre: nombre,
                email: email,
                telefono: telefono,
                asunto: asunto,
                mensaje: mensaje,
                btnGuardarDatos: "EnviarConsulta"
            },
            dataType: "json",
            success: function(response) {
                if (response.flag == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => window.location.href = response.redirect);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Ocurrió un error al enviar el trámite.'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Estado:", status);
                console.error("Error:", error);
                console.error("Respuesta del servidor:", xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud: ' + error
                });
            }
        });
    }
}
