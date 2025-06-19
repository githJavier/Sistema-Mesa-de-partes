
function configurarTipoDocumento() {
    const tipoDocumento = document.getElementById('tipoDocumento');
    const documento = document.getElementById('documento');
    const documentoError = document.getElementById('documentoError');
    const nombre = document.getElementById('nombre');

    if (!tipoDocumento || !documento || !nombre) return;
    
    function actualizarDocumento() {
        documento.value = '';
        nombre.value = '';
        documentoError.style.display = 'none';

        if (tipoDocumento.value === 'DNI') {
            documento.placeholder = 'Ingrese DNI';
            documento.maxLength = 8;
        } else if (tipoDocumento.value === 'RUC') {
            documento.placeholder = 'Ingrese RUC';
            documento.maxLength = 11;
        }
    }

    tipoDocumento.addEventListener('change', actualizarDocumento);
    actualizarDocumento();
}
function configurarNumero(){
    const telefono = document.getElementById('telefono');
    telefono.maxLength = 9;
}
function configurarPassword(){
    const password = document.getElementById('password');
    password.minLength = 8;
}

function validarFormulario() {
    let isValid = true;

    // Validar documento
    const documento = document.getElementById('documento');
    const tipoDocumento = document.getElementById('tipoDocumento');
    const documentoError = document.getElementById('documentoError');
    const documentoValue = documento?.value.trim() || "";
    const tipoDocumentoValue = tipoDocumento?.value.trim() || "";
    
    if(tipoDocumentoValue === 'DNI'){
        if (documentoValue === '') {
            documentoError.textContent = 'Este campo es obligatorio.';
            documentoError.style.display = 'block';
            isValid = false;
        } else if(documentoValue.length<8){
            documentoError.textContent = 'Ingrese DNI valido';
            documentoError.style.display = 'block';
            isValid = false;
        }
        else {
            documentoError.style.display = 'none';
        }
    }else if(tipoDocumentoValue === 'RUC'){
        if (documentoValue === '') {
            documentoError.textContent = 'Este campo es obligatorio.';
            documentoError.style.display = 'block';
            isValid = false;
        } else if(documentoValue.length<11){
            documentoError.textContent = 'Ingrese RUC valido';
            documentoError.style.display = 'block';
            isValid = false;
        }
        else {
            documentoError.style.display = 'none';
        }
    }
    //validar nombre
    const nombre = document.getElementById('nombre');
    const nombreError = document.getElementById('nombreError');
    const nombreValue = nombre.value.trim();

    if(nombreValue === ''){
        nombreError.textContent = 'Este campo es obligatorio.';
        nombreError.style.display = 'block';
        isValid = false;
    }else {
       nombreError.style.display = 'none';
    }

    // Validar correo electrónico
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

    // Validar teléfono
    const telefono = document.getElementById('telefono');
    const telefonoError = document.getElementById('telefonoError');
    const telefonoValue = telefono.value.trim();

    if (telefonoValue === '') {
        telefonoError.textContent = 'Este campo es obligatorio.';
        telefonoError.style.display = 'block';
        isValid = false;
    } else if (!/^\d{9,}$/.test(telefonoValue)) { 
        telefonoError.textContent = 'Ingrese un número válido.';
        telefonoError.style.display = 'block';
        isValid = false;
    } else {
        telefonoError.style.display = 'none';
    }

    // Validar contraseña
    const password = document.getElementById('password');
    const passwordError = document.getElementById('passwordError');
    const passwordValue = password.value.trim();

    if (passwordValue === '') {
        passwordError.textContent = 'Este campo es obligatorio.';
        passwordError.style.display = 'block';
        isValid = false;
    } else if (passwordValue.length < 8) {
        passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        passwordError.style.display = 'block';
        isValid = false;
    } else {
        passwordError.style.display = 'none';
        // Verificar igualdad de contraseñas
        const passwordR = document.getElementById('passwordR');
        const passwordRError = document.getElementById('passwordRError');
        const passwordRValue = passwordR.value.trim();

        if (passwordRValue === '') {
            passwordRError.textContent = 'Este campo es obligatorio.';
            passwordRError.style.display = 'block';
            isValid = false;
        } else if (passwordRValue !== passwordValue) {
            passwordRError.textContent = 'Las contraseñas no coinciden.';
            passwordRError.style.display = 'block';
            isValid = false;
        } else {
        passwordRError.style.display = 'none';
        }
    }

    

    // Validar checkbox de términos y condiciones
    const termsCheck = document.getElementById('termsCheck');
    const termsCheckError = document.getElementById('termsCheckError');

    if (!termsCheck.checked) {
        termsCheckError.textContent = 'Debe aceptar los términos y condiciones.';
        termsCheckError.style.display = 'block';
        isValid = false;
    } else {
        termsCheckError.style.display = 'none';
    }

    return isValid;
}

function consultarDocumento() {
    const documento = document.getElementById("documento")?.value.trim() || "";

    if (!/^\d{8}$/.test(documento) && !/^\d{11}$/.test(documento)) {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Ingrese un número de documento válido (DNI: 8 dígitos, RUC: 11 dígitos).'
        });
        return;
    }

    $.ajax({
        type: "POST",
        url: "./controllers/CrearRemitente/consultaDocumento.php",
        data: { documento: documento },
        dataType: 'json',
        
        success: function(response) {
            if (response.success && response.data) {
                if (response.tipo === "DNI") {
                    let nombreCompleto = response.data.nombre_completo.trim();
                    document.getElementById('nombre').value = nombreCompleto;
                } else if (response.tipo === "RUC") {
                    let razonSocial = response.data.razon_social.trim();
                    document.getElementById('nombre').value = razonSocial;
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'No se encontraron datos.'
                });
            }
        },
        error: function(xhr, status, error) {
            //console.error("Error en la consulta: ", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo conectar con la API.'
            });
        }
    });
}

function enviarForm() {
    if (validarFormulario()) {
        const tipoDocumento = document.getElementById('tipoDocumento')?.value || "";
        const documento = document.getElementById("documento")?.value || "";
        const nombre = document.getElementById('nombre')?.value || "";
        const email = document.getElementById('email')?.value || "";
        const telefono = document.getElementById('telefono')?.value || "";
        const contrasena = document.getElementById("password")?.value || "";
        const rContrasena = document.getElementById("passwordR")?.value || "";
        const termsCheck = document.getElementById('termsCheck').checked;

        let tipoPersona = '';
        if (tipoDocumento === 'DNI') {
            tipoPersona = 'PERSONA NATURAL';
        } else if (tipoDocumento === 'RUC') {
            tipoPersona = 'PERSONA JURIDICA';
        }

        $.ajax({
            type: "POST",
            url: "./controllers/CrearRemitente/controlCrearRemitente.php",
            data: {
                tipoPersona: tipoPersona,
                tipoDocumento: tipoDocumento,
                documento: documento,
                nombre: nombre,
                email: email,
                telefono: telefono,
                contrasena: contrasena,
                rContrasena: rContrasena,
                termsCheck: termsCheck,
                btnRegistrar: "Registrar"
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

document.getElementById('documento')?.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, ''); // Elimina caracteres no numéricos
});

document.getElementById('telefono')?.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, ''); // Elimina caracteres no numéricos
});

document.addEventListener('DOMContentLoaded', function () {
    configurarTipoDocumento();
    configurarNumero();
});
