function validarFormulario() {
    let isValid = true;

    // Validar tipo de documento (aunque es select, validar que tenga valor)
    const tipoDocumento = document.getElementById('tipoDocumento');
    const tipoDocumentoValue = tipoDocumento?.value.trim() || "";

    // Validar número de documento
    const numeroDocumento = document.getElementById('numeroDocumento');
    const numeroDocumentoError = document.getElementById('numeroDocumentoError');
    const numeroDocumentoValue = numeroDocumento?.value.trim() || "";

    // Para tu caso tienes opciones "L.E / DNI" y "CARNET EXT." 
    // Puedes adaptar la validación según tipos o simplemente validar no vacío:
    if (numeroDocumentoValue === '') {
        numeroDocumentoError.textContent = 'Este campo es obligatorio.';
        numeroDocumentoError.style.display = 'block';
        isValid = false;
    } else {
        numeroDocumentoError.style.display = 'none';
    }

    // Validar nombre usuario (aunque está disabled, por si alguna vez se habilita)
    const nombreUsuario = document.getElementById('nombreUsuario');
    const nombreUsuarioError = document.getElementById('nombreUsuarioError');
    const nombreUsuarioValue = nombreUsuario?.value.trim() || "";
    if (nombreUsuario && nombreUsuario.disabled === false && nombreUsuarioValue === '') {
        nombreUsuarioError.textContent = 'Este campo es obligatorio.';
        nombreUsuarioError.style.display = 'block';
        isValid = false;
    } else {
        nombreUsuarioError.style.display = 'none';
    }

    // Apellido paterno (disabled)
    const apellidoPaterno = document.getElementById('apellidoPaterno');
    const apellidoPaternoError = document.getElementById('apellidoPaternoError');
    const apellidoPaternoValue = apellidoPaterno?.value.trim() || "";
    if (apellidoPaterno && apellidoPaterno.disabled === false && apellidoPaternoValue === '') {
        apellidoPaternoError.textContent = 'Este campo es obligatorio.';
        apellidoPaternoError.style.display = 'block';
        isValid = false;
    } else {
        apellidoPaternoError.style.display = 'none';
    }

    // Apellido materno (disabled)
    const apellidoMaterno = document.getElementById('apellidoMaterno');
    const apellidoMaternoError = document.getElementById('apellidoMaternoError');
    const apellidoMaternoValue = apellidoMaterno?.value.trim() || "";
    if (apellidoMaterno && apellidoMaterno.disabled === false && apellidoMaternoValue === '') {
        apellidoMaternoError.textContent = 'Este campo es obligatorio.';
        apellidoMaternoError.style.display = 'block';
        isValid = false;
    } else {
        apellidoMaternoError.style.display = 'none';
    }

    // Tipo de usuario (texto, obligatorio)
    const tipoUsuario = document.getElementById('tipoUsuario');
    const tipoUsuarioError = document.getElementById('tipoUsuarioError');
    const tipoUsuarioValue = tipoUsuario?.value.trim() || "";
    if (tipoUsuarioValue === '') {
        tipoUsuarioError.textContent = 'Este campo es obligatorio.';
        tipoUsuarioError.style.display = 'block';
        isValid = false;
    } else {
        tipoUsuarioError.style.display = 'none';
    }

    // Estado (select, obligatorio)
    const estadoUsuario = document.getElementById('estadoUsuario');
    const estadoUsuarioError = document.getElementById('estadoUsuarioError');
    const estadoUsuarioValue = estadoUsuario?.value.trim() || "";
    if (estadoUsuarioValue === '') {
        estadoUsuarioError.textContent = 'Este campo es obligatorio.';
        estadoUsuarioError.style.display = 'block';
        isValid = false;
    } else {
        estadoUsuarioError.style.display = 'none';
    }

    // Área (select, obligatorio)
    const areaUsuario = document.getElementById('areaUsuario');
    const areaUsuarioError = document.getElementById('areaUsuarioError');
    const areaUsuarioValue = areaUsuario?.value.trim() || "";
    if (areaUsuarioValue === '') {
        areaUsuarioError.textContent = 'Este campo es obligatorio.';
        areaUsuarioError.style.display = 'block';
        isValid = false;
    } else {
        areaUsuarioError.style.display = 'none';
    }

    // Usuario (texto, obligatorio)
    const usuario = document.getElementById('usuario');
    const usuarioError = document.getElementById('usuarioError');
    const usuarioValue = usuario?.value.trim() || "";
    if (usuarioValue === '') {
        usuarioError.textContent = 'Este campo es obligatorio.';
        usuarioError.style.display = 'block';
        isValid = false;
    } else {
        usuarioError.style.display = 'none';
    }

    // Contraseña (mínimo 8 caracteres)
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

function enviarForm() {
    if(validarFormulario()){
        const tipoDocumento = document.getElementById('tipoDocumento')?.value || "";
        const numeroDocumento = document.getElementById('numeroDocumento')?.value || "";
        const nombreUsuario = document.getElementById('nombreUsuario')?.value || "";
        const apellidoPaterno = document.getElementById('apellidoPaterno')?.value || "";
        const apellidoMaterno = document.getElementById('apellidoMaterno')?.value || "";
        const tipoUsuario = document.getElementById('tipoUsuario')?.value || "";
        const estadoUsuario = document.getElementById('estadoUsuario')?.value || "";
        const areaUsuario = document.getElementById('areaUsuario')?.value || "";
        const usuario = document.getElementById('usuario')?.value || "";
        const password = document.getElementById('password')?.value || "";

        

    }
}
    