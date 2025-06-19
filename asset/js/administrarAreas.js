function cargarDatosArea(id) {
    fetch('../../controllers/Ajustes/controlAjustesArea.php?id=' + encodeURIComponent(id))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const area = data.data.area;

                // Llenar campos del formulario
                document.getElementById('editAreaId').value = area.cod_area || '';
                document.getElementById('editNombreArea').value = area.area || '';

                // Mostrar modal
                const editarModal = new bootstrap.Modal(document.getElementById('editarAreaModal'));
                editarModal.show();
            } else {
                alert('Error: ' + (data.message || 'No se encontraron datos del area'));
            }
        })
        .catch(error => {
            //console.error('Error al cargar area:', error);
            alert('Error al cargar area');
        });
}

function validarFormularioEdicion() {
  let esValido = true;

  // Obtener elementos
  const inputNombre = document.getElementById('editNombreArea');
  const errorNombre = document.getElementById('errorEditarNombreArea');

  const nombreValor = inputNombre.value.trim();

  // Validar Nombre del Tipo de Documento
  if (nombreValor === "") {
    errorNombre.textContent = 'Este campo es obligatorio.';
    errorNombre.style.display = 'block';
    esValido = false;
  } else {
    errorNombre.style.display = 'none';
  }

  return esValido;
}

function enviarFormEditar() {
    if(validarFormularioEdicion()){
        const id = document.getElementById('editAreaId').value;
        const area = document.getElementById('editNombreArea').value.trim();

        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlFormAjusteArea.php",
            data: {
                id: id,
                area: area,
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

function cargarCrearArea() {
    const crearAreaModal = new bootstrap.Modal(document.getElementById('crearAreaModal'));
    crearAreaModal.show();
}

function validarFormularioCreacion() {
  let esValido = true;

  // Obtener elementos
  const inputNombre = document.getElementById('crearNombreArea');
  const errorNombre = document.getElementById('errorCrearNombreArea');

  const nombreValor = inputNombre.value.trim();

  // Validar Nombre del Tipo de Documento
  if (nombreValor === "") {
    errorNombre.textContent = 'Este campo es obligatorio.';
    errorNombre.style.display = 'block';
    esValido = false;
  } else {
    errorNombre.style.display = 'none';
  }

  return esValido;
}

function cerrarModalCrearArea() {
  const modalEl = document.getElementById('crearAreaModal');
  const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
  modalInstance.hide();

  const form = document.getElementById('create-area-form');
  if (!form) return;

  // Limpiar inputs
  const inputs = form.querySelectorAll('input');
  inputs.forEach(input => {
    input.value = '';
    input.removeAttribute('disabled');
  });

  // Ocultar mensaje de error
  const errores = form.querySelectorAll('span.text-danger');
  errores.forEach(span => {
    span.style.display = 'none';
    span.textContent = '';
  });
}

function enviarFormCrear() {
  if (validarFormularioCreacion()) {
    const area = document.getElementById('crearNombreArea').value.trim();

    $.ajax({
      type: "POST",
      url: "../../controllers/Ajustes/controlCrearArea.php",
      data: {
        area: area,
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
    document.getElementById('eliminarAreaId').value = id;
    const eliminarModal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    eliminarModal.show();
}

function enviarFormEliminar() {
    const id = document.getElementById('eliminarAreaId').value;

    if (!id) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID del área no encontrado.'
        });
        return;
    }

    $.ajax({
        type: "POST",
        url: "../../controllers/Ajustes/controlEliminarArea.php",
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