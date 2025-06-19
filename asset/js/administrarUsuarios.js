function validarFormulario() {
  let isValid = true;

  // Validar contraseña: obligatoria y debe tener al menos 8 caracteres
  const passwordInput = document.getElementById('createPassword');
  const passwordError = document.getElementById('createPasswordError');
  const passwordValue = passwordInput?.value.trim() || "";

  if (passwordValue === "") {
    passwordError.textContent = 'Requerido.';
    passwordError.style.display = 'block';
    isValid = false;
  } else if (passwordValue.length < 8) {
    passwordError.textContent = 'Mínimo 8 caracteres alfanuméricos.';
    passwordError.style.display = 'block';
    isValid = false;
  } else {
    passwordError.style.display = 'none';
  }

  // Validar usuario: obligatorio y mínimo 4 caracteres
  const usuarioInput = document.getElementById('createUsuario');
  const usuarioError = document.getElementById('createUsuarioError');
  const usuarioValue = usuarioInput?.value.trim() || "";

  if (usuarioValue === "") {
    usuarioError.textContent = 'Requerido.';
    usuarioError.style.display = 'block';
    isValid = false;
  } else if (usuarioValue.length < 4) {
    usuarioError.textContent = 'Mínimo 4 caracteres.';
    usuarioError.style.display = 'block';
    isValid = false;
  } else {
    usuarioError.style.display = 'none';
  }

  // ========== VALIDACIÓN APELLIDO MATERNO ==========
  const apMaterno = document.getElementById('createApellidoMaterno');
  const apMaternoError = document.getElementById('createApellidoMaternoError');
  const apMaternoValue = apMaterno?.value.trim() || "";

  if (apMaternoValue === "" || apMaternoValue.length < 2 || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apMaternoValue)) {
    apMaternoError.textContent = 'Apellido no válido.';
    apMaternoError.style.display = 'block';
    isValid = false;
  } else {
    apMaternoError.style.display = 'none';
  }

  // ========== VALIDACIÓN APELLIDO PATERNO ==========
  const apPaterno = document.getElementById('createApellidoPaterno');
  const apPaternoError = document.getElementById('createApellidoPaternoError');
  const apPaternoValue = apPaterno?.value.trim() || "";

  if (apPaternoValue === "" || apPaternoValue.length < 2 || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apPaternoValue)) {
    apPaternoError.textContent = 'Apellido no válido.';
    apPaternoError.style.display = 'block';
    isValid = false;
  } else {
    apPaternoError.style.display = 'none';
  }

  // ========== VALIDACIÓN NOMBRE ==========
  const nombre = document.getElementById('createNombreUsuario');
  const nombreError = document.getElementById('createNombreUsuarioError');
  const nombreValue = nombre?.value.trim() || "";

  if (nombreValue === "" || nombreValue.length < 2 || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreValue)) {
    nombreError.textContent = 'Nombre no válido.';
    nombreError.style.display = 'block';
    isValid = false;
  } else {
    nombreError.style.display = 'none';
  }

  // ========== VALIDACIÓN NÚMERO DE DOCUMENTO ==========
  const tipoDocumento = document.getElementById('createTipoDocumento')?.value;
  const numeroDocumento = document.getElementById('createNumeroDocumento');
  const numeroDocumentoError = document.getElementById('createNumeroDocumentoError');
  const docValue = numeroDocumento?.value.trim() || "";

  let docValido = true;
  if (docValue === "") {
    numeroDocumentoError.textContent = 'Requerido.';
    docValido = false;
  } else {
    switch (tipoDocumento) {
      case 'L.E / DNI':
        docValido = /^\d{8}$/.test(docValue);
        if (!docValido) numeroDocumentoError.textContent = 'DNI debe tener 8 dígitos.';
        break;
      case 'CARNET EXT.':
        docValido = /^[a-zA-Z0-9]{9,}$/.test(docValue);
        if (!docValido) numeroDocumentoError.textContent = 'Mínimo 9 caracteres alfanuméricos.';
        break;
      case 'PASAPORTE':
        docValido = /^[a-zA-Z0-9]{6,}$/.test(docValue);
        if (!docValido) numeroDocumentoError.textContent = 'Mínimo 6 caracteres alfanuméricos.';
        break;
      case 'OTRO':
        docValido = docValue.length >= 4;
        if (!docValido) numeroDocumentoError.textContent = 'Mínimo 4 caracteres.';
        break;
      default:
        docValido = false;
        numeroDocumentoError.textContent = 'Tipo de documento inválido.';
    }
  }

  if (!docValido) {
    numeroDocumentoError.style.display = 'block';
    isValid = false;
  } else {
    numeroDocumentoError.style.display = 'none';
  }

  return isValid;
}

function cerrarModalCrearUsuario() {
  const modalEl = document.getElementById('crearUsuarioModal');
  const modalInstance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
  modalInstance.hide();

  const form = document.getElementById('create-form');
  if (!form) return;

  // Limpiar todos los inputs
  const inputs = form.querySelectorAll('input');
  inputs.forEach(input => {
    input.value = '';
    input.removeAttribute('disabled');
  });

  // Resetear todos los selects (poner primer valor visible)
  const selects = form.querySelectorAll('select');
  selects.forEach(select => {
    select.selectedIndex = 0;
  });

  // Ocultar todos los mensajes de error visibles
  const errores = form.querySelectorAll('span.text-danger');
  errores.forEach(span => {
    span.style.display = 'none';
    span.textContent = ''; // Limpia texto si fue modificado dinámicamente
  });
}

function enviarForm() {
    if(validarFormulario()){
        const tipoDocumento = document.getElementById('createTipoDocumento').value;
        const numeroDocumento = document.getElementById('createNumeroDocumento').value.trim();
        const nombre = document.getElementById('createNombreUsuario').value.trim();
        const apellidoPaterno = document.getElementById('createApellidoPaterno').value.trim();
        const apellidoMaterno = document.getElementById('createApellidoMaterno').value.trim();
        const tipoUsuario = document.getElementById('createTipoUsuario').value;
        const estadoUsuario = document.getElementById('createEstadoUsuario').value;
        const areaUsuario = document.getElementById('createAreaUsuario').value;
        const usuario = document.getElementById('createUsuario').value.trim();
        const password = document.getElementById('createPassword').value.trim();

        $.ajax({
            type: "POST",
            url: "../../controllers/Administracion/controlCrearUsuario.php",
            data: {
                tipoDocumento: tipoDocumento,
                numeroDocumento: numeroDocumento,
                nombre: nombre,
                apellidoPaterno: apellidoPaterno,
                apellidoMaterno: apellidoMaterno,
                tipoUsuario: tipoUsuario,
                estadoUsuario: estadoUsuario,
                areaUsuario: areaUsuario,
                usuario: usuario,
                password: password,
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


function validarFormularioEdicion() {
  let isValid = true;

  // Validar contraseña: opcional, pero si se llena, debe tener al menos 8 caracteres
  const passwordInput = document.getElementById('editPassword');
  const passwordError = document.getElementById('editPasswordError');
  const passwordValue = passwordInput?.value.trim() || "";

  if (passwordValue.length > 0 && passwordValue.length < 8) {
    passwordError.textContent = 'Debe tener al menos 8 caracteres.';
    passwordError.style.display = 'block';
    isValid = false;
  } else {
    passwordError.style.display = 'none';
  }

  // Validar usuario: obligatorio y mínimo 4 caracteres
  const usuarioInput = document.getElementById('editUsuario');
  const usuarioError = document.getElementById('editUsuarioError');
  const usuarioValue = usuarioInput?.value.trim() || "";

  if (usuarioValue === "") {
    usuarioError.textContent = 'Requerido.';
    usuarioError.style.display = 'block';
    isValid = false;
  } else if (usuarioValue.length < 4) {
    usuarioError.textContent = 'Mínimo 4 caracteres.';
    usuarioError.style.display = 'block';
    isValid = false;
  } else {
    usuarioError.style.display = 'none';
  }

    // ========== VALIDACIÓN APELLIDO MATERNO ==========
  const apMaterno = document.getElementById('editApellidoMaterno');
  const apMaternoError = document.getElementById('editApellidoMaternoError');
  const apMaternoValue = apMaterno?.value.trim() || "";

  if (apMaternoValue === "" || apMaternoValue.length < 2 || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apMaternoValue)) {
    apMaternoError.textContent = 'Apellido no válido.';
    apMaternoError.style.display = 'block';
    isValid = false;
  } else {
    apMaternoError.style.display = 'none';
  }

    // ========== VALIDACIÓN APELLIDO PATERNO ==========
  const apPaterno = document.getElementById('editApellidoPaterno');
  const apPaternoError = document.getElementById('editApellidoPaternoError');
  const apPaternoValue = apPaterno?.value.trim() || "";

  if (apPaternoValue === "" || apPaternoValue.length < 2 || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(apPaternoValue)) {
    apPaternoError.textContent = 'Apellido no válido.';
    apPaternoError.style.display = 'block';
    isValid = false;
  } else {
    apPaternoError.style.display = 'none';
  }

    // ========== VALIDACIÓN NOMBRE ==========
  const nombre = document.getElementById('editNombreUsuario');
  const nombreError = document.getElementById('editNombreUsuarioError');
  const nombreValue = nombre?.value.trim() || "";

  if (nombreValue === "" || nombreValue.length < 2 || !/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(nombreValue)) {
    nombreError.textContent = 'Nombre no válido.';
    nombreError.style.display = 'block';
    isValid = false;
  } else {
    nombreError.style.display = 'none';
  }

    // ========== VALIDACIÓN NÚMERO DE DOCUMENTO ==========
  const tipoDocumento = document.getElementById('editTipoDocumento')?.value;
  const numeroDocumento = document.getElementById('editNumeroDocumento');
  const numeroDocumentoError = document.getElementById('editNumeroDocumentoError');
  const docValue = numeroDocumento?.value.trim() || "";

  let docValido = true;
  if (docValue === "") {
    numeroDocumentoError.textContent = 'Requerido.';
    docValido = false;
  } else {
    switch (tipoDocumento) {
      case 'L.E / DNI':
        docValido = /^\d{8}$/.test(docValue);
        if (!docValido) numeroDocumentoError.textContent = 'DNI debe tener 8 dígitos.';
        break;
      case 'CARNET EXT.':
        docValido = /^[a-zA-Z0-9]{9,}$/.test(docValue);
        if (!docValido) numeroDocumentoError.textContent = 'Mínimo 9 caracteres alfanuméricos.';
        break;
      case 'PASAPORTE':
        docValido = /^[a-zA-Z0-9]{6,}$/.test(docValue);
        if (!docValido) numeroDocumentoError.textContent = 'Mínimo 6 caracteres alfanuméricos.';
        break;
      case 'OTRO':
        docValido = docValue.length >= 4;
        if (!docValido) numeroDocumentoError.textContent = 'Mínimo 4 caracteres.';
        break;
      default:
        docValido = false;
        numeroDocumentoError.textContent = 'Tipo de documento inválido.';
    }
  }

  if (!docValido) {
    numeroDocumentoError.style.display = 'block';
    isValid = false;
  } else {
    numeroDocumentoError.style.display = 'none';
  }


  return isValid;
}



function enviarFormEditar() {
    if(validarFormularioEdicion()){
        const id = document.getElementById('editUsuarioId').value;
        const tipoDocumento = document.getElementById('editTipoDocumento').value;
        const numeroDocumento = document.getElementById('editNumeroDocumento').value.trim();
        const nombre = document.getElementById('editNombreUsuario').value.trim();
        const apellidoPaterno = document.getElementById('editApellidoPaterno').value.trim();
        const apellidoMaterno = document.getElementById('editApellidoMaterno').value.trim();
        const tipoUsuario = document.getElementById('editTipoUsuario').value;
        const estadoUsuario = document.getElementById('editEstadoUsuario').value;
        const areaUsuario = document.getElementById('editAreaUsuario').value;
        const usuario = document.getElementById('editUsuario').value.trim();
        const password = document.getElementById('editPassword').value.trim();

        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlFormajusteUsuario.php",
            data: {
                id: id,
                tipoDocumento: tipoDocumento,
                numeroDocumento: numeroDocumento,
                nombre: nombre,
                apellidoPaterno: apellidoPaterno,
                apellidoMaterno: apellidoMaterno,
                tipoUsuario: tipoUsuario,
                estadoUsuario: estadoUsuario,
                areaUsuario: areaUsuario,
                usuario: usuario,
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

function cargarDatosUsuario(id) {
    fetch('../../controllers/Ajustes/controlAjustesUsuario.php?id=' + encodeURIComponent(id))
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const usuario = data.data.usuario;
                const areas = data.data.areas;
                const tiposUsuario = data.data.tipos_usuario;

                // ---------------------- ÁREAS ----------------------
                const selectArea = document.getElementById('editAreaUsuario');
                selectArea.innerHTML = '';
                areas.forEach(areaObj => {
                    const option = document.createElement('option');
                    option.value = areaObj.cod_area;
                    option.textContent = areaObj.area;
                    if (areaObj.cod_area === usuario.cod_area) {
                        option.selected = true;
                    }
                    selectArea.appendChild(option);
                });

                // ---------------------- TIPOS DE USUARIO ----------------------
                const selectTipo = document.getElementById('editTipoUsuario');
                selectTipo.innerHTML = '';
                tiposUsuario.forEach(tipoObj => {
                    const option = document.createElement('option');
                    option.value = tipoObj.tipo_usuario;
                    option.textContent = tipoObj.tipo_usuario;
                    if (tipoObj.tipo_usuario === usuario.tipo) {
                        option.selected = true;
                    }
                    selectTipo.appendChild(option);
                });

                // ---------------------- TIPOS DE DOCUMENTO ----------------------
                const tiposDocumentoDisponibles = ['L.E / DNI', 'CARNET EXT.', 'PASAPORTE', 'OTRO']; // ejemplo
                const selectTipoDocumento = document.getElementById('editTipoDocumento');
                selectTipoDocumento.innerHTML = '';
                tiposDocumentoDisponibles.forEach(tipo => {
                const option = document.createElement('option');
                option.value = tipo;
                option.textContent = tipo;
                if (tipo === usuario.tipo_doc) {
                    option.selected = true;
                }
                selectTipoDocumento.appendChild(option);
                });

                // ---------------------------------------------------------
                const estados = [
                { value: '1', label: 'Activo' },
                { value: '0', label: 'Inactivo' }
                ];

                const selectEstado = document.getElementById('editEstadoUsuario');
                selectEstado.innerHTML = ''; // Limpiar opciones

                estados.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.value;
                option.textContent = estado.label;
                if (estado.value === String(usuario.activo)) {
                    option.selected = true;
                }
                selectEstado.appendChild(option);
                });

                // ---------------------- OTROS CAMPOS ----------------------
                document.getElementById('editUsuarioId').value = id;
                document.getElementById('editTipoDocumento').value = usuario.tipo_doc || '';
                document.getElementById('editNumeroDocumento').value = usuario.num_doc || '';
                document.getElementById('editNombreUsuario').value = usuario.nombre || '';
                document.getElementById('editApellidoPaterno').value = usuario.ap_paterno || '';
                document.getElementById('editApellidoMaterno').value = usuario.ap_materno || '';
                document.getElementById('editEstadoUsuario').value = usuario.estado || '';
                document.getElementById('editUsuario').value = usuario.usuario || '';
                document.getElementById('editPassword').value = '';

                const editarModal = new bootstrap.Modal(document.getElementById('editarUsuarioModal'));
                editarModal.show();
            } else {
                alert('Error: ' + (data.message || 'No se encontraron datos'));
            }
        })
        .catch(error => {
            //console.error('Error al cargar usuario:', error);
            alert('Error al cargar usuario');
        });
}

function cargarDatosCrearUsuario() {
    fetch('../../controllers/Ajustes/controlAjustesUsuario.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const areas = data.data.areas;
                const tiposUsuario = data.data.tipos_usuario;
                const tiposDocumentoDisponibles = ['L.E / DNI', 'CARNET EXT.', 'PASAPORTE', 'OTRO'];
                const estados = [
                    { value: '1', label: 'Activo' },
                    { value: '0', label: 'Inactivo' }
                ];

                // ---------------------- ÁREAS ----------------------
                const selectArea = document.getElementById('createAreaUsuario');
                selectArea.innerHTML = '';
                areas.forEach((areaObj, index) => {
                    const option = document.createElement('option');
                    option.value = areaObj.cod_area;
                    option.textContent = areaObj.area;
                    if (index === 0) option.selected = true;
                    selectArea.appendChild(option);
                });

                // ---------------------- TIPOS DE USUARIO ----------------------
                const selectTipo = document.getElementById('createTipoUsuario');
                selectTipo.innerHTML = '';
                tiposUsuario.forEach((tipoObj, index) => {
                    const option = document.createElement('option');
                    option.value = tipoObj.tipo_usuario;
                    option.textContent = tipoObj.tipo_usuario;
                    if (index === 0) option.selected = true;
                    selectTipo.appendChild(option);
                });

                // ---------------------- TIPOS DE DOCUMENTO ----------------------
                const selectTipoDocumento = document.getElementById('createTipoDocumento');
                selectTipoDocumento.innerHTML = '';
                tiposDocumentoDisponibles.forEach((tipo, index) => {
                    const option = document.createElement('option');
                    option.value = tipo;
                    option.textContent = tipo;
                    if (index === 0) option.selected = true;
                    selectTipoDocumento.appendChild(option);
                });

                // ---------------------- ESTADO ----------------------
                const selectEstado = document.getElementById('createEstadoUsuario');
                selectEstado.innerHTML = '';
                estados.forEach((estado, index) => {
                    const option = document.createElement('option');
                    option.value = estado.value;
                    option.textContent = estado.label;
                    if (index === 0) option.selected = true;
                    selectEstado.appendChild(option);
                });

                // ---------------------- LIMPIAR CAMPOS ----------------------
                document.getElementById('createNumeroDocumento').value = '';
                document.getElementById('createNombreUsuario').value = '';
                document.getElementById('createApellidoPaterno').value = '';
                document.getElementById('createApellidoMaterno').value = '';
                document.getElementById('createUsuario').value = '';
                document.getElementById('createPassword').value = '';

                // ---------------------- ABRIR MODAL ----------------------
                const crearModal = new bootstrap.Modal(document.getElementById('crearUsuarioModal'));
                crearModal.show();
            } else {
                alert('Error: ' + (data.message || 'No se encontraron datos'));
            }
        })
        .catch(error => {
            //console.error('Error al cargar datos del formulario:', error);
            alert('Error al cargar datos del formulario');
        });
}

function cargarDatosEliminar(id) {
    document.getElementById('eliminarUsuarioId').value = id;
    const eliminarModal = new bootstrap.Modal(document.getElementById('modalConfirmarEliminar'));
    eliminarModal.show();
}

function enviarFormEliminar() {
    const id = document.getElementById('eliminarUsuarioId').value;

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
        url: "../../controllers/Ajustes/controlEliminarUsuario.php",
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