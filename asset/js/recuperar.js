document.addEventListener('DOMContentLoaded', function() {
    configurarDocumento();
});

function configurarDocumento() {
    const documento = document.getElementById('documento');
    if (!documento) return;

    documento.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    documento.setAttribute('maxlength', '11');
}

function validarFormulario() {
    let isValid = true;

    // Validar documento
    const documento = document.getElementById('documento');
    const documentoError = document.getElementById('documentoError');
    const documentoValue = documento?.value.trim() || "";
    
    if (documentoValue === "") {
        documentoError.textContent = 'Este campo es obligatorio.';
        documentoError.style.display = 'block';
        isValid = false;
    } else if (documentoValue.length !== 8 && documentoValue.length !== 11) {
        documentoError.textContent = 'Ingrese un documento válido';
        documentoError.style.display = 'block';
        isValid = false;
    } else {
        documentoError.style.display = 'none';
    }
    // Validar Correo
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailValue = email.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (emailValue === '') {
        emailError.textContent = 'Este campo es obligatorio.';
        emailError.style.display = 'block';
        isValid = false;
    } else if (!emailRegex.test(emailValue)) {
        emailError.textContent = 'Ingrese un correo válido.';
        emailError.style.display = 'block';
        isValid = false;
    } else {
        emailError.style.display = 'none';
    }

    return isValid;
}

function enviarForm() {
    if (validarFormulario()) {
        const email = document.getElementById('email')?.value || "";
        const documento = document.getElementById('documento')?.value || "";

        $.ajax({
            type: "POST",
            url: "./controllers/RestablecerUsuario/controlRestablecerUsuario.php",
            data: {
                email: email,
                documento: documento,
                btnRecuperar: "Recuperar",
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
                        text: response.message || 'Ocurrió un error desconocido.'
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
        })
    }
}
