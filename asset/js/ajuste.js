function validarTramite() {
    let isValid = true;

    let celular = document.getElementById("CELULAR");
    let celularValue = celular.value.trim();
    let celularError = document.getElementById("celularError");

    if (celularValue === '') {
        celularError.textContent = 'Este campo es obligatorio.';
        celularError.style.display = 'block';
        isValid = false;
    } else if (!/^\d{9}$/.test(celularValue)) { 
        celularError.textContent = 'Ingrese un número válido.';
        celularError.style.display = 'block';
        isValid = false;
    } else {
        celularError.style.display = 'none';
    }

    let departamento = document.getElementById("DEPARTAMENTO");
    let departamentoError = document.getElementById("departamentoError");
    if (departamento.value === "") {
        departamentoError.style.display = "block";
        isValid = false;
    } else {
        departamentoError.style.display = "none";
    }

    let provincia = document.getElementById("PROVINCIA");
    let provinciaError = document.getElementById("provinciaError");
    if (provincia.value === "") {
        provinciaError.style.display = "block";
        isValid = false;
    } else {
        provinciaError.style.display = "none";
    }

    let distrito = document.getElementById("DISTRITO");
    let distritoError = document.getElementById("distritoError");
    if (distrito.value === "") {
        distritoError.style.display = "block";
        isValid = false;
    } else {
        distritoError.style.display = "none";
    }

    let direccion = document.getElementById("DIRECCION");
    let direccionError = document.getElementById("domicilioError");
    if (direccion.value.trim() === "") {
        direccionError.style.display = "block";
        isValid = false;
    } else {
        direccionError.style.display = "none";
    }
    return isValid; 
}


// Permitir solo números y máximo 9 dígitos en el input de celular
document.getElementById("CELULAR").addEventListener("input", function(e) {
    // Solo números
    let soloNumeros = this.value.replace(/\D/g, '');

    // Validar que comience con 9
    if (soloNumeros.length > 0 && soloNumeros[0] !== '9') {
        soloNumeros = ''; // Si no empieza con 9, borra todo
    }

    // Limita a 9 dígitos
    this.value = soloNumeros.slice(0, 9);
});

function enviarFormAjuste() {
    if (validarTramite()) {
        const celular = document.getElementById("CELULAR")?.value.trim() || "";

        const departamentoSelect = document.getElementById("DEPARTAMENTO");
        const departamento = departamentoSelect.options[departamentoSelect.selectedIndex].text;

        const provinciaSelect = document.getElementById("PROVINCIA");
        const provincia = provinciaSelect.options[provinciaSelect.selectedIndex].text;

        const distritoSelect = document.getElementById("DISTRITO");
        const distrito = distritoSelect.options[distritoSelect.selectedIndex].text;

        const direccion = document.getElementById("DIRECCION")?.value.trim() || "";

        $.ajax({
            type: "POST",
            url: "../../controllers/Ajustes/controlAjustes.php",
            data: {
                celular: celular,
                departamento: departamento,
                provincia: provincia,
                distrito: distrito,
                direccion: direccion,
                btnGuardarDatos: "GuardarDatos"
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
                        text: response.message || 'Ocurrió un error al enviar el trámite.'
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

