// ----------------------------
// VALIDACIONES GENÉRICAS
// ----------------------------

// Mostrar u ocultar errores para campos comunes
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

// Validar el formato del número de trámite
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

// Validar archivo obligatorio y tamaño
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

// Validar número entero positivo para folios
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

// ----------------------------
// VALIDAR FORMULARIO COMPLETO
// ----------------------------

function validarTramite() {
  let isValid = true;

  isValid &= validarCampoRequerido("ASUNTO", "asuntoError");
  isValid &= validarCampoRequerido("TIPO_DOCUMENTO", "tipoDocumentoError", "Seleccione un tipo de documento.");
  // Si se desea ampliar los prefijos admitidos usar lo siguiente: /^\d{4}-(EX|IN|DOC)\d{10}$/
  isValid &= validarFormatoExpediente("NUMERO_TRAMITE", "numeroDocumentoError", /^\d{4}-(EX|IN)\d{10}$/, '2025-EX0000000001 o 2025-IN0000000001');
  isValid &= validarArchivo("DOCUMENTO_VIRTUAL", "documentoVirtualError", 1000);
  isValid &= validarFolios("FOLIOS", "foliosError");
  isValid &= validarCampoRequerido("TIPO_TRAMITE", "tipoTramiteError", "Seleccione un tipo de trámite.");
  isValid &= validarCampoRequerido("UNIDAD_ORGANICA_DESTINO", "unidadOrganicaError", "Seleccione una unidad orgánica.");
  isValid &= validarCampoRequerido("remitenteSeleccionado", "remitenteError", "Seleccione un remitente.");
  isValid &= validarCampoRequerido("URGENTE", "urgenteError", "Seleccione si es urgente.");
  isValid &= validarCampoRequerido("OBSERVACION", "observacionError");

  return !!isValid;
}

// ----------------------------
// ENVIAR FORMULARIO SI ES VÁLIDO
// ----------------------------

var yaEnviando = false;

function enviarFormTramiteUsuario() {
  if (yaEnviando) return; // Evita múltiples clics
  if (!validarTramite()) return;

  yaEnviando = true; // Activa bandera
  document.getElementById("btnEnviarTramiteUsuario").disabled = true; // Desactiva botón

  const formData = new FormData();
  formData.append('asunto', document.getElementById("ASUNTO").value.trim());
  formData.append('tipo_tramite', document.getElementById("TIPO_TRAMITE").value);
  formData.append('numero_tramite', document.getElementById("NUMERO_TRAMITE").value.trim());
  formData.append('unidad_organica_destino', document.getElementById("UNIDAD_ORGANICA_DESTINO").value);
  formData.append('tipo_documento', document.getElementById("TIPO_DOCUMENTO").value);
  formData.append('DOCUMENTO_VIRTUAL', document.getElementById("DOCUMENTO_VIRTUAL").files[0]);
  formData.append('folios', document.getElementById("FOLIOS").value.trim());
  formData.append('remitente', document.getElementById("remitenteSeleccionado").value.trim());
  formData.append('urgente', document.getElementById("URGENTE").value);
  formData.append('observacion', document.getElementById("OBSERVACION").value.trim());
  formData.append('btnEnviarTramiteUsuario', "EnviarTramiteUsuario");

  $.ajax({
        type: "POST",
        url: "../../controllers/IngresarTramiteUsuario/controlIngresarTramiteUsuario.php",
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
                document.getElementById("btnEnviarTramiteUsuario").disabled = false;
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error en la solicitud: ' + error
            });
            yaEnviando = false;
            document.getElementById("btnEnviarTramiteUsuario").disabled = false;
        }
  });

}

// ----------------------------
// MANEJO CAMBIO EN TIPO_TRAMITE
// ----------------------------

document.addEventListener('change', function (e) {
  if (e.target && e.target.id === 'TIPO_TRAMITE') {
    const inputNumero = document.getElementById('NUMERO_TRAMITE');
    const codigoInterno = e.target.dataset.codigoInterno;
    const codigoExterno = e.target.dataset.codigoExterno;

    if (e.target.value === 'INTERNO') {
      inputNumero.value = codigoInterno;
    } else if (e.target.value === 'EXTERNO') {
      inputNumero.value = codigoExterno;
    } else {
      inputNumero.value = '';
    }
  }
});

// ----------------------------
// SELECCIONAR REMITENTE
// ----------------------------

function seleccionarRemitente(valor) {
  const btn = document.getElementById('dropdownRemitente');
  btn.textContent = valor.length > 50 ? valor.substring(0, 50) + '...' : valor;
  btn.setAttribute('title', valor);
  document.getElementById('remitenteSeleccionado').value = valor;
}