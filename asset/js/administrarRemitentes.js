// Solo permitir números en documento y teléfono
document.getElementById('documento')?.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});
document.getElementById('telefono')?.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Configurar tipo de documento (DNI o RUC)
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
    actualizarDocumento(); // Inicializa en carga
}
configurarTipoDocumento();

function validarFormulario(){
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
    const passwordValue = password?.value.trim() || "";

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
    }


    return isValid;
}
// Validar y enviar formulario
function enviarForm() {
    if(validarFormulario()){
        const tipoDocumento = document.getElementById('tipoDocumento')?.value || "";
        const documento = document.getElementById("documento")?.value || "";
        const nombre = document.getElementById('nombre')?.value || "";
        const email = document.getElementById('email')?.value || "";
        const telefono = document.getElementById('telefono')?.value || "";
        const contrasena = document.getElementById("password")?.value || "";

        let tipoPersona = '';
        if (tipoDocumento === 'DNI') {
            tipoPersona = 'PERSONA NATURAL';
        } else if (tipoDocumento === 'RUC') {
            tipoPersona = 'PERSONA JURIDICA';
        }


        $.ajax({
            type: "POST",
            url: "../../controllers/CrearRemitente/controlCrearRemitenteAdmin.php",
            data: {
                tipoPersona: tipoPersona,
                tipoDocumento: tipoDocumento,
                documento: documento,
                nombre: nombre,
                email: email,
                telefono: telefono,
                contrasena: contrasena,
                rContrasena: contrasena,
                termsCheck: true,
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
        url: "../../controllers/CrearRemitente/consultaDocumento.php",
        data: { documento: documento },
        dataType: 'json',
        
        success: function(response) {
            if (response.success) {  
                if (response.tipo === "DNI") {
                    let nombreCompleto = `${response.nombres} ${response.apellidoPaterno} ${response.apellidoMaterno}`;
                    document.getElementById('nombre').value = nombreCompleto;
                } else if (response.tipo === "RUC") {
                    document.getElementById('nombre').value = response.razonSocial;
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
            console.error("Error en la consulta: ", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo conectar con la API.'
            });
        }
    });
}


function cargarDatosRemitente(id) {
    fetch('../../controllers/Ajustes/controlAjustesRemitente.php?id=' + encodeURIComponent(id))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const remitente = data.data;

                // Guardar el ID del remitente en un campo oculto
                document.getElementById('editRemitenteId').value = id;

                document.getElementById('editTipoDocumento').value = remitente.retipo_docu || '';
                document.getElementById('editDocumento').value = remitente.docu_num || '';
                document.getElementById('editNombre').value = remitente.nombres || '';
                document.getElementById('editEmail').value = remitente.correo || '';
                document.getElementById('editTelefono').value = remitente.telefono_celular || '';

                // Limpiar campo contraseña
                document.getElementById('editPassword').value = '';

                // Ocultar mensajes de error
                document.getElementById('editEmailError').style.display = 'none';
                document.getElementById('editTelefonoError').style.display = 'none';
                document.getElementById('editPasswordError').style.display = 'none';

                // Abrir modal
                const editarModal = new bootstrap.Modal(document.getElementById('editarRemitenteModal'));
                editarModal.show();
            } else {
                alert('Error: ' + (data.message || 'No se encontraron datos'));
            }
        })
        .catch(error => {
            console.error('Error al cargar remitente:', error);
            alert('Error al cargar remitente');
        });
}




function validarFormularioEdicion() {
    let isValid = true;


    // Validar correo electrónico
    const email = document.getElementById('editEmail');
    const emailError = document.getElementById('editEmailError');
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
    const telefono = document.getElementById('editTelefono');
    const telefonoError = document.getElementById('editTelefonoError');
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

    // Validar contraseña (puede dejarse vacía si no quiere cambiarla)
    const password = document.getElementById('editPassword');
    
    const passwordError = document.getElementById('editPasswordError');
    const passwordValue = password?.value.trim() || "";

    if (passwordValue.length < 8 && passwordValue.length > 0) {
        passwordError.textContent = 'La contraseña debe tener al menos 8 caracteres.';
        passwordError.style.display = 'block';
        isValid = false;
    } else {
        passwordError.style.display = 'none';
    }

    return isValid;
}

function enviarFormEditar() {
    if(validarFormularioEdicion()){
        const id = document.getElementById('editRemitenteId').value;
        const email = document.getElementById('editEmail').value.trim();
        const telefono = document.getElementById('editTelefono').value.trim();
        const password = document.getElementById('editPassword').value.trim();
        
        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlFormajusteRemitente.php",
            data: {
                id: id,
                email: email,
                telefono: telefono,
                password: password,
                btnEditar: "Editar"
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
        });

    }
}

function cargarDatosEliminar(id) {
    document.getElementById('eliminarUsuarioId').value = id;
    const eliminarModal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    eliminarModal.show();
}

function enviarFormEliminar() {
    const id = document.getElementById('eliminarRemitenteId').value;

    if (!id) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID del remitente no encontrado.'
        });
        return;
    }

    $.ajax({
        type: "POST",
        url: "../../controllers/Ajustes/controlEliminarRemitente.php",
        data: {
            id: id,
            btnEliminar: "Eliminar"
        },
        dataType: "json",
        success: function(response) {
            if (response.flag == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
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







   




