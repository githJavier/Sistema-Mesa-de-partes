// Función genérica para mostrar u ocultar errores
function validarCampoRequerido(inputId, errorId, mensaje = 'Este campo es obligatorio.') {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);
    const valor = input.value.trim();

    if (valor === '') {
        error.textContent = mensaje;
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Validar número de expediente con formato personalizado
function validarFormatoExpediente(inputId, errorId, regex, ejemploFormato) {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);
    const valor = input.value.trim();

    if (valor === '') {
        error.textContent = 'Este campo es obligatorio.';
        error.style.display = 'block';
        return false;
    } else if (!regex.test(valor)) {
        error.textContent = `Formato inválido. Ejemplo válido: ${ejemploFormato}`;
        error.style.display = 'block';
        return false;
    } else {
        error.style.display = 'none';
        return true;
    }
}

// Validar archivo (obligatorio y límite de tamaño en KB)
function validarArchivo(inputId, errorId, maxKB = 1000) {
    const input = document.getElementById(inputId);
    const error = document.getElementById(errorId);

    if (input.files.length === 0) {
        error.textContent = "Debe adjuntar un documento.";
        error.style.display = "block";
        return false;
    }

    const archivo = input.files[0];
    const tamañoKB = archivo.size / 1024;

    if (tamañoKB > maxKB) {
        error.textContent = `El archivo no debe superar los ${maxKB} KB.`;
        error.style.display = "block";
        return false;
    }

    error.style.display = "none";
    return true;
}

// Validar número de folios
function validarFolios(inputId, errorId) {
    const input = document.getElementById(inputId);
    const valor = input.value.trim();
    const error = document.getElementById(errorId);

    if (valor === '') {
        error.textContent = "Este campo es obligatorio.";
        error.style.display = "block";
        return false;
    } else if (!/^\d+$/.test(valor) || parseInt(valor) <= 0) {
        error.textContent = "Ingrese un número válido de folios.";
        error.style.display = "block";
        return false;
    }

    error.style.display = "none";
    return true;
}

// -----------------------------
// VALIDACIONES POR FORMULARIO
// -----------------------------

function validarTramite() {
    let isValid = true;

    isValid &= validarCampoRequerido("ASUNTO", "asuntoError");
    isValid &= validarCampoRequerido("TIPO_DOCUMENTO", "tipoDocumentoError");
    isValid &= validarFormatoExpediente("NUMERO_TRAMITE", "numeroDocumentoError", /^\d{4}-EX\d{10}$/, '2025-EX0000000001');
    isValid &= validarArchivo("DOCUMENTO_VIRTUAL", "documentoVirtualError", 1000);
    isValid &= validarFolios("FOLIOS", "foliosError");

    return !!isValid;
}

function validarFormularioDerivarTramite() {
    let isValid = true;

    isValid &= validarCampoRequerido("AREA_DESTINO", "areaDestinoError");
    isValid &= validarArchivo("DOCUMENTO_VIRTUAL", "documentoVirtualError", 1000);
    isValid &= validarFolios("FOLIOS", "foliosError");
    isValid &= validarCampoRequerido("MOTIVO_ARCHIVO", "motivoArchivoError");

    return !!isValid;
}

// -----------------------------
// ENVÍO DE FORMULARIOS
// -----------------------------

var yaEnviando = false;

function enviarFormTramite() {
    if (yaEnviando) return; // Evita múltiples clics
    if (!validarTramite()) return;

    yaEnviando = true; // Activa bandera
    document.getElementById("btnEnviarTramite").disabled = true; // Desactiva botón

    const formData = new FormData();
    formData.append('asunto', document.getElementById("ASUNTO").value.trim());
    formData.append('tipo_documento', document.getElementById("TIPO_DOCUMENTO").value);
    formData.append('numero_tramite', document.getElementById("NUMERO_TRAMITE").value.trim());
    formData.append('remitente', document.getElementById("NOMBRE").value.trim());
    formData.append('folios', document.getElementById("FOLIOS").value.trim());
    formData.append('DOCUMENTO_VIRTUAL', document.getElementById("DOCUMENTO_VIRTUAL").files[0]);
    formData.append('btnEnviarTramite', "EnviarTramite");

    $.ajax({
        type: "POST",
        url: "../../controllers/IngresarTramite/controlIngresarTramite.php",
        data: formData,
        processData: false,
        contentType: false,
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
                // Permitir reintento si falló
                yaEnviando = false;
                document.getElementById("btnEnviarTramite").disabled = false;
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en la solicitud: ' + error
            });
            yaEnviando = false;
            document.getElementById("btnEnviarTramite").disabled = false;
        }
    });
}

function derivarTramite() {
    if (yaEnviando) return; // Evita múltiples clics
    if (!validarFormularioDerivarTramite()) return;

    yaEnviando = true; // Activa bandera
    document.getElementById("btnDerivarTramite").disabled = true; // Desactiva botón

    const formData = new FormData();
    formData.append("fecha_archivo", document.getElementById("FECHA_ARCHIVO").value.trim());
    formData.append("hora_archivo", document.getElementById("HORA_ARCHIVO").value.trim());
    formData.append("expediente", document.getElementById("EXPEDIENTE").value.trim());
    formData.append("area_destino", document.getElementById("AREA_DESTINO").value.trim());
    formData.append("folios", document.getElementById("FOLIOS").value.trim());
    formData.append("motivo_archivo", document.getElementById("MOTIVO_ARCHIVO").value.trim());
    formData.append("documento_virtual", document.getElementById("DOCUMENTO_VIRTUAL").files[0]);
    formData.append("numero_documento", document.getElementById("NUM_DOCUMENTO").value.trim());
    formData.append("codigo_detalle_tramite", document.getElementById("COD_DETALLE_TRAMITE").value.trim());
    formData.append("btnDerivarTramite", "DerivarTramite");

    $.ajax({
        type: "POST",
        url: "../../controllers/ResolverTramite/DerivarTramite/controlDerivarTramite.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response) {
            if (response.flag == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => cargarformularioResolverTramites());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error al enviar el trámite.'
                });
                // Permitir reintento si falló
                yaEnviando = false;
                document.getElementById("btnDerivarTramite").disabled = false;
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error en la solicitud',
                text: 'Error: ' + error
            });
            yaEnviando = false;
            document.getElementById("btnDerivarTramite").disabled = false;
        }
    });
}

function archivarTramite() {
    if (yaEnviando) return; // Evita múltiples clics

    const motivoArchivo = document.getElementById("MOTIVO_ARCHIVO").value.trim();
    const error = document.getElementById("motivoArchivoError");

    if (motivoArchivo === "") {
        error.textContent = 'Este campo es obligatorio.';
        error.style.display = 'block';
        return;
    } else {
        error.style.display = 'none';
    }

    yaEnviando = true; // Activa bandera
    document.getElementById("btnArchivarTramite").disabled = true; // Desactiva botón

    const formData = new FormData();
    formData.append("fecha_archivo", document.getElementById("FECHA_ARCHIVO").value.trim());
    formData.append("hora_archivo", document.getElementById("HORA_ARCHIVO").value.trim());
    formData.append("expediente", document.getElementById("EXPEDIENTE").value.trim());
    formData.append("asunto_archivo", document.getElementById("ASUNTO_ARCHIVO").value.trim());
    formData.append("motivo_archivo", motivoArchivo);
    formData.append("numero_documento", document.getElementById("NUM_DOCUMENTO").value.trim());
    formData.append("btnArchivarTramite", "ArchivarTramite");

    $.ajax({
        type: "POST",
        url: "../../controllers/ResolverTramite/ArchivarTramite/controlArchivarTramite.php",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(response) {
            if (response.flag == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Trámite archivado',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => cargarformularioResolverTramites());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Ocurrió un error al archivar el trámite.'
                });
                // Permitir reintento si falló
                yaEnviando = false;
                document.getElementById("btnArchivarTramite").disabled = false;
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error en la solicitud',
                text: 'Error: ' + error
            });
            yaEnviando = false;
            document.getElementById("btnArchivarTramite").disabled = false;
        }
    });
}

// Cargar áreas dinámicamente (sin cambios)
function cargarAreasParaDerivar() {
    fetch('../../controllers/Ajustes/controlAjustesUsuario.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const areas = data.data.areas;
                const selectAreaDestino = document.getElementById('AREA_DESTINO');
                selectAreaDestino.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'SELECCIONA UNIDAD DESTINO';
                defaultOption.selected = true;
                selectAreaDestino.appendChild(defaultOption);

                areas.forEach(areaObj => {
                    const option = document.createElement('option');
                    option.value = areaObj.area;
                    option.textContent = areaObj.area;
                    selectAreaDestino.appendChild(option);
                });
            } else {
                alert('Error: ' + (data.message || 'No se encontraron áreas disponibles.'));
            }
        })
        .catch(() => alert('Error al cargar las áreas destino.'));
}

function cerrarFormulario() {
    window.location.href = 'homeAdmin.php';
}
