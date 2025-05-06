// Cambiar el placeholder y el maxlength según el radio seleccionado
function tipoPersona() {
    const documento = document.getElementById('documento');
    const documentoError = document.getElementById('documentoError');

    if (!documento) return; // Evitar errores si el elemento no existe

    documento.value = ''; // Limpiar valor
    documentoError.style.display = 'none'; // Ocultar error

    if (document.getElementById('natural')?.checked) {
        documento.placeholder = 'DNI';
        documento.maxLength = 8;
    } else if (document.getElementById('juridica')?.checked) {
        documento.placeholder = 'RUC';
        documento.maxLength = 11;
    }
}

// Validar que solo se ingresen números en el campo de documento
document.getElementById('documento')?.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, ''); // Elimina caracteres no numéricos
});

// Mostrar/ocultar contraseña
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const passwordIcon = document.getElementById('togglePassword');

    if (!passwordField || !passwordIcon) return; // Evitar errores

    const isPasswordHidden = passwordField.type === 'password';
    passwordField.type = isPasswordHidden ? 'text' : 'password';
    passwordIcon.innerHTML = isPasswordHidden 
        ? '<i class="fa-solid fa-eye-slash"></i>' 
        : '<i class="fa-solid fa-eye"></i>';
}

// Validar campos del formulario
function validarFormulario() {
    let isValid = true;

    const documento = document.getElementById('documento');
    const documentoError = document.getElementById('documentoError');
    const documentoValue = documento?.value.trim() || "";
    const isNatural = document.getElementById('natural')?.checked;
    const isJuridica = document.getElementById('juridica')?.checked;

    if (!documento) return false; // Evitar errores

    if (documentoValue === '') {
        documentoError.textContent = 'Este campo es obligatorio.';
        isValid = false;
    } else if (isNatural && documentoValue.length !== 8) {
        documentoError.textContent = 'El DNI debe tener 8 caracteres.';
        isValid = false;
    } else if (isJuridica && documentoValue.length !== 11) {
        documentoError.textContent = 'El RUC debe tener 11 caracteres.';
        isValid = false;
    } else {
        documentoError.textContent = '';
    }
    documentoError.style.display = isValid ? 'none' : 'block';

    // Validar contraseña
    const password = document.getElementById('password');
    const passwordError = document.getElementById('passwordError');
    const passwordValue = password?.value.trim() || "";

    if (!password) return false; // Evitar errores

    if (passwordValue === '') {
        passwordError.textContent = 'Este campo es obligatorio.';
        isValid = false;
    } else if (passwordValue.length < 8) {
        passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }
    passwordError.style.display = isValid ? 'none' : 'block';

    return isValid;
}

function enviarForm() {
    if (validarFormulario()) {
        const documento = document.getElementById("documento")?.value || "";
        const contrasena = document.getElementById("password")?.value || "";
        const tipoPersona = document.querySelector('input[name="checkboxUsuario"]:checked')?.value || '';

        $.ajax({
            type: "POST",
            url: "./controllers/AutenticarUsuario/controlAutenticarUsuario.php",
            data: {
                documento: documento,
                contrasena: contrasena,
                tipoPersona: tipoPersona,
                btnLogin: "Ingresar"
            },
            dataType: "json", // Asegurar que se reciba JSON
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
        });
    }
}

// Inicializar eventos
document.addEventListener('DOMContentLoaded', () => {
    tipoPersona();
    
    const togglePasswordButton = document.getElementById('togglePassword');
    if (togglePasswordButton) {
        togglePasswordButton.addEventListener('click', togglePasswordVisibility);
    }

    document.querySelectorAll('input[name="checkboxUsuario"]').forEach(radio => {
        radio.addEventListener('change', tipoPersona);
    });
});
