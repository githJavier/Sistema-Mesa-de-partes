function cargarDatosTipoDocumento(id) {
    fetch('../../controllers/Ajustes/controlAjustesTipoDocumento.php?id=' + encodeURIComponent(id))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tipoDocumento = data.data.tipoDocumento;

                // Llenar campos del formulario
                document.getElementById('editTipoDocumentoId').value = tipoDocumento.cod_tipodocumento || '';
                document.getElementById('editNombreTipoDocumento').value = tipoDocumento.tipodocumento || '';
                document.getElementById('editAbreviaturaTipoDocumento').value = tipoDocumento.abreviatura || '';

                // Mostrar modal
                const editarModal = new bootstrap.Modal(document.getElementById('editarTipoDocumentoModal'));
                editarModal.show();
            } else {
                alert('Error: ' + (data.message || 'No se encontraron datos del tipo de documento'));
            }
        })
        .catch(error => {
            //console.error('Error al cargar tipo de documento:', error);
            alert('Error al cargar tipo de documento');
        });
}

function validarFormularioEdicion() {
  let esValido = true;

  // Obtener elementos
  const inputNombre = document.getElementById('editNombreTipoDocumento');
  const inputAbreviatura = document.getElementById('editAbreviaturaTipoDocumento');
  const errorNombre = document.getElementById('errorNombreTipoDocumento');
  const errorAbreviatura = document.getElementById('errorAbreviaturaTipoDocumento');

  const nombreValor = inputNombre.value.trim();
  const abreviaturaValor = inputAbreviatura.value.trim();

  // Validar Nombre del Tipo de Documento
  if (nombreValor === "") {
    errorNombre.textContent = 'Este campo es obligatorio.';
    errorNombre.style.display = 'block';
    esValido = false;
  } else {
    errorNombre.style.display = 'none';
  }

  // Validar Abreviatura
  if (abreviaturaValor === "") {
    errorAbreviatura.textContent = 'Este campo es obligatorio.';
    errorAbreviatura.style.display = 'block';
    esValido = false;
  } else {
    errorAbreviatura.style.display = 'none';
  }

  return esValido;
}

function enviarFormEditar() {
    if(validarFormularioEdicion()){
        const id = document.getElementById('editTipoDocumentoId').value;
        const tipoDocumento = document.getElementById('editNombreTipoDocumento').value.trim();
        const abreviatura = document.getElementById('editAbreviaturaTipoDocumento').value.trim();

        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlFormAjusteTipoDocumento.php",
            data: {
                id: id,
                tipoDocumento: tipoDocumento,
                abreviatura: abreviatura,
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

function cargarCrearTipoDocumento() {
    const crearTipoDocumentoModal = new bootstrap.Modal(document.getElementById('crearTipoDocumentoModal'));
    crearTipoDocumentoModal.show();
}

function validarFormularioCreacion() {
  let esValido = true;

  // Obtener elementos
  const inputNombre = document.getElementById('crearNombreTipoDocumento');
  const inputAbreviatura = document.getElementById('crearAbreviaturaTipoDocumento');
  const errorNombre = document.getElementById('errorCrearNombreTipoDocumento');
  const errorAbreviatura = document.getElementById('errorCrearAbreviaturaTipoDocumento');

  const nombreValor = inputNombre.value.trim();
  const abreviaturaValor = inputAbreviatura.value.trim();

  // Validar Nombre del Tipo de Documento
  if (nombreValor === "") {
    errorNombre.textContent = 'Este campo es obligatorio.';
    errorNombre.style.display = 'block';
    esValido = false;
  } else {
    errorNombre.style.display = 'none';
  }

  // Validar Abreviatura
  if (abreviaturaValor === "") {
    errorAbreviatura.textContent = 'Este campo es obligatorio.';
    errorAbreviatura.style.display = 'block';
    esValido = false;
  } else {
    errorAbreviatura.style.display = 'none';
  }

  return esValido;
}

function cerrarModalCrearTipoDocumento() {
  const modalEl = document.getElementById('crearTipoDocumentoModal');
  const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
  modalInstance.hide();

  const form = document.getElementById('formCrearTipoDocumento');
  if (!form) return;

  // Limpiar inputs
  const inputs = form.querySelectorAll('input');
  inputs.forEach(input => {
    input.value = '';
    input.removeAttribute('disabled');
  });

  // Ocultar y limpiar mensajes de error
  const errores = form.querySelectorAll('span.text-danger');
  errores.forEach(span => {
    span.style.display = 'none';
    span.textContent = '';
  });
}

function enviarFormCrear() {
  if (validarFormularioCreacion()) {
    const tipoDocumento = document.getElementById('crearNombreTipoDocumento').value.trim();
    const abreviatura = document.getElementById('crearAbreviaturaTipoDocumento').value.trim();

    $.ajax({
      type: "POST",
      url: "../../controllers/Ajustes/controlCrearTipoDocumento.php",
      data: {
        tipoDocumento: tipoDocumento,
        abreviatura: abreviatura,
        btnCrear: "Crear"
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
    document.getElementById('eliminarTipoDocumentoId').value = id;
    const eliminarModal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    eliminarModal.show();
}

function enviarFormEliminar() {
    const id = document.getElementById('eliminarTipoDocumentoId').value;

    if (!id) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID del tipo de documento no encontrado.'
        });
        return;
    }

    $.ajax({
        type: "POST",
        url: "../../controllers/Ajustes/controlEliminarTipoDocumento.php",
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