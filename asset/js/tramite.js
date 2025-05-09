
function validarTramite(){
    let isValid = true;

    //validar asunto
    let asunto = document.getElementById("ASUNTO");
    let asuntoValue = asunto.value.trim();  
    let asuntoError = document.getElementById("asuntoError");
    if(asuntoValue === ''){
        asuntoError.textContent = 'Este campo es obligatorio.';
        asuntoError.style.display = 'block';
        isValid = false;
    }else{
        asuntoError.style.display = 'none';
    }

    //validar tipo documento
    let tipoDocumento = document.getElementById("TIPO_DOCUMENTO");
    let tipoDocumentoError = document.getElementById('tipoDocumentoError');
    if(tipoDocumento.value === ''){
        tipoDocumentoError.textContent = 'Este campo es obligatorio.'
        tipoDocumentoError.style.display = 'block';
        isValid = false;
    }else{
        tipoDocumentoError.style.display = 'none';
    }

    //validar numero tramite
    let numeroTramite = document.getElementById("NUMERO_TRAMITE");
    let numeroTramiteValue = numeroTramite.value.trim();
    let numeroTramiteError = document.getElementById("numeroDocumentoError");

    if (numeroTramiteValue === '') {
        numeroTramiteError.textContent = 'Este campo es obligatorio.';
        numeroTramiteError.style.display = 'block';
        isValid = false;
    } else if (!/^\d{4}-DOC\d{10}$/.test(numeroTramiteValue)) {
        numeroTramiteError.textContent = 'Formato inválido. Ejemplo válido: 2025-DOC0000000001';
        numeroTramiteError.style.display = 'block';
        isValid = false;
    } else {
        numeroTramiteError.style.display = 'none';
    }


    // Validar DOCUMENTO_VIRTUAL (obligatorio y máximo 1000 KB)
    let documentoVirtual = document.getElementById("DOCUMENTO_VIRTUAL");
    let documentoVirtualError = document.getElementById("documentoVirtualError");

    if (documentoVirtual.files.length === 0) {
        documentoVirtualError.textContent = "Debe adjuntar un documento.";
        documentoVirtualError.style.display = "block";
        isValid = false;
    } else {
        let archivo = documentoVirtual.files[0];
        let tamañoKB = archivo.size / 1024; // convertir a KB

        if (tamañoKB > 1000) {
            documentoVirtualError.textContent = "El archivo no debe superar los 1000 KB.";
            documentoVirtualError.style.display = "block";
            isValid = false;
        } else {
            documentoVirtualError.style.display = "none";
        }
    }



    let folios = document.getElementById("FOLIOS");
    let foliosValue = folios.value.trim();
    let foliosError = document.getElementById("foliosError");

    if(foliosValue === ''){
        foliosError.textContent = "Este campo es obligatorio.";
        foliosError.style.display = "block";
        isValid = false;
    }else if (!/^\d+$/.test(foliosValue) || parseInt(foliosValue) <= 0) {
        foliosError.textContent = "Ingrese un número válido de folios.";
        foliosError.style.display = "block";
        isValid = false;
    } else {
        foliosError.style.display = "none";
    }

    return isValid; 
    
}


document.getElementById("FOLIOS").addEventListener("input", function(e) {
    // Eliminar cualquier caracter que no sea número
    let soloNumeros = this.value.replace(/\D/g, '');

    // Eliminar ceros iniciales
    soloNumeros = soloNumeros.replace(/^0+/, '');
});


// Enviar formulario
function enviarFormTramite() {
    if (validarTramite()) {
        const asunto = document.getElementById("ASUNTO").value.trim();
        const tipoDocumento = document.getElementById("TIPO_DOCUMENTO").value;
        const numeroTramite = document.getElementById("NUMERO_TRAMITE").value.trim();
        const remitente = document.getElementById("NOMBRE").value.trim();
        const folios = document.getElementById("FOLIOS").value.trim();
        const documentoVirtual = document.getElementById("DOCUMENTO_VIRTUAL").files[0];

        // Crear objeto FormData y añadir todos los datos
        let formData = new FormData();
        formData.append('asunto', asunto);
        formData.append('tipo_documento', tipoDocumento);
        formData.append('numero_tramite', numeroTramite);
        formData.append('remitente', remitente);
        formData.append('folios', folios);
        formData.append('DOCUMENTO_VIRTUAL', documentoVirtual);
        formData.append('btnEnviarTramite', "EnviarTramite");

        
        $.ajax({
            type: "POST",
            url: "../../controllers/IngresarTramite/controlIngresarTramite.php",
            data: formData,
            processData: false, // No procesar los datos (necesario para FormData)
            contentType: false, // No establecer Content-Type (lo hace FormData automáticamente)
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

