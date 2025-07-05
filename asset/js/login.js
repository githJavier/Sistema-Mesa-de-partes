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

// Función para mostrar/ocultar contraseña principal
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const passwordIcon = document.getElementById('togglePassword');

    if (!passwordField || !passwordIcon) return;

    const isHidden = passwordField.type === 'password';
    passwordField.type = isHidden ? 'text' : 'password';
    passwordIcon.innerHTML = isHidden
        ? '<i class="fa-solid fa-eye-slash"></i>'
        : '<i class="fa-solid fa-eye"></i>';
}

// Función para mostrar/ocultar clave del sistema
function toggleClaveSistemaVisibility() {
    const passwordField = document.getElementById('claveSistema');
    const passwordIcon = document.getElementById('toggleClaveSistema');

    if (!passwordField || !passwordIcon) return;

    const isHidden = passwordField.type === 'password';
    passwordField.type = isHidden ? 'text' : 'password';
    passwordIcon.innerHTML = isHidden
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

    if (!documento) return false;

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

    const password = document.getElementById('password');
    const passwordError = document.getElementById('passwordError');
    const passwordValue = password?.value.trim() || "";

    if (!password) return false;

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

    // Validar que el reCAPTCHA esté marcado
    const recaptchaResponse = grecaptcha.getResponse(widgetRemitente);
    if (!recaptchaResponse) {
        Swal.fire({
            icon: 'warning',
            title: 'Verificación requerida',
            text: 'Por favor, marca el reCAPTCHA para continuar.'
        });
        isValid = false;
    }

    return isValid;
}

function validarFormularioUsuario() {
    let isValid = true;

    // Validar usuario
    const usuario = document.getElementById('usuarioSistema');
    const usuarioError = document.getElementById('usuarioSistemaError');
    const usuarioValue = usuario?.value.trim() || "";

    if (!usuario) return false; // Evitar errores

    if (usuarioValue === '') {
        usuarioError.textContent = 'Este campo es obligatorio.';
        isValid = false;
    } else {
        usuarioError.textContent = '';
    }
    usuarioError.style.display = isValid ? 'none' : 'block';

    // Validar contraseña
    const clave = document.getElementById('claveSistema');
    const claveError = document.getElementById('claveSistemaError');
    const claveValue = clave?.value.trim() || "";

    if (!clave) return false; // Evitar errores

    if (claveValue === '') {
        claveError.textContent = 'Este campo es obligatorio.';
        isValid = false;
    } else if (claveValue.length < 4) {
        claveError.textContent = 'La contraseña debe tener al menos 4 caracteres.';
        isValid = false;
    } else {
        claveError.textContent = '';
    }
    claveError.style.display = isValid ? 'none' : 'block';

    // Validar que el reCAPTCHA esté marcado
    const recaptchaResponse = grecaptcha.getResponse(widgetUsuario);
    if (!recaptchaResponse) {
        Swal.fire({
            icon: 'warning',
            title: 'Verificación requerida',
            text: 'Por favor, marca el reCAPTCHA para continuar.'
        });
        isValid = false;
    }

    return isValid;
}

function enviarForm() {
    if (validarFormulario()) {
        const documento = document.getElementById("documento")?.value || "";
        const contrasena = document.getElementById("password")?.value || "";
        const tipoPersona = document.querySelector('input[name="checkboxUsuario"]:checked')?.value || '';
        const recaptchaResponse = grecaptcha.getResponse(widgetRemitente);

        $.ajax({
            type: "POST",
            url: "./controllers/AutenticarUsuario/controlAutenticarUsuario.php",
            data: {
                documento: documento,
                contrasena: contrasena,
                tipoPersona: tipoPersona,
                recaptcha: recaptchaResponse,
                btnLogin: "Ingresar"
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
                    grecaptcha.reset();
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error en la solicitud: ' + error
                });
                grecaptcha.reset();
            }
        });
    }
}


function enviarFormUsuario() {
    if (validarFormularioUsuario()) {
        const usuario = document.getElementById("usuarioSistema")?.value || "";
        const clave = document.getElementById("claveSistema")?.value || "";
        const recaptchaResponse = grecaptcha.getResponse(widgetUsuario);
        $.ajax({
            type: "POST",
            url: "./controllers/AutenticarUsuario/controlAutenticarAdmin.php",
            data: {
                usuario: usuario,
                contrasena: clave,
                recaptcha: recaptchaResponse,
                btnLogin: "Acceder"
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
                //console.error("Estado:", status);
                //console.error("Error:", error);
                //console.error("Respuesta del servidor:", xhr.responseText);
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
    
    // Botón para mostrar/ocultar contraseña del login
    const togglePasswordButton = document.getElementById('togglePassword');
    if (togglePasswordButton) {
        togglePasswordButton.addEventListener('click', togglePasswordVisibility);
    }

    // Botón para mostrar/ocultar contraseña del sistema
    const toggleClaveSistemaButton = document.getElementById('toggleClaveSistema');
    if (toggleClaveSistemaButton) {
        toggleClaveSistemaButton.addEventListener('click', toggleClaveSistemaVisibility);
    }

    document.querySelectorAll('input[name="checkboxUsuario"]').forEach(radio => {
        radio.addEventListener('change', tipoPersona);
    });
});
