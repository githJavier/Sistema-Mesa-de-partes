window.remitentesPagination = (function () {
    let currentPage = 1;
    let rowsPerPage = 5;
    let isPaginating = false;
    let filteredRows = [];

    const savedRowsPerPage = localStorage.getItem('remitentesRowsPerPage');
    if (savedRowsPerPage) {
        rowsPerPage = parseInt(savedRowsPerPage, 10);
    }

    function updatePagination() {
        const table = document.getElementById("data-table");
        if (!table) return;

        const allRows = table.querySelectorAll("tbody tr");
        allRows.forEach(row => row.style.display = "none");

        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        filteredRows.slice(start, end).forEach(row => row.style.display = "");

        document.getElementById("pagination-info").innerText = totalRows > 0
            ? `Mostrando ${start + 1} a ${Math.min(end, totalRows)} de ${totalRows} entradas`
            : "Mostrando 0 a 0 de 0 entradas";

        document.getElementById("prev-page").disabled = currentPage === 1;
        document.getElementById("next-page").disabled = currentPage === totalPages || totalPages === 0;
    }

    function safePaginate(direction) {
        if (isPaginating) return;
        isPaginating = true;

        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        if (direction === "prev" && currentPage > 1) {
            currentPage--;
        } else if (direction === "next" && currentPage < totalPages) {
            currentPage++;
        }

        updatePagination();

        setTimeout(() => {
            isPaginating = false;
        }, 200);
    }

    function applyFilterAndPaginate() {
        const input = document.getElementById("search").value.toLowerCase().trim();
        const allRows = Array.from(document.querySelectorAll("#data-table tbody tr"));
        let found = false;

        if (input === "") {
            filteredRows = allRows;
            found = true;
        } else {
            filteredRows = allRows.filter(row => {
                const text = row.innerText.toLowerCase();
                const match = text.includes(input);
                if (match) found = true;
                return match;
            });
        }

        currentPage = 1;
        updatePagination();

        document.getElementById("no-results").classList.toggle("d-none", found);
        document.getElementById("pagination-info").style.display = found ? "block" : "none";
        document.getElementById("prev-page").style.display = found ? "inline-block" : "none";
        document.getElementById("next-page").style.display = found ? "inline-block" : "none";
    }

    function init() {
        currentPage = 1;

        const allRows = Array.from(document.querySelectorAll("#data-table tbody tr"));
        filteredRows = allRows;

        document.getElementById("prev-page").addEventListener("click", () => safePaginate("prev"));
        document.getElementById("next-page").addEventListener("click", () => safePaginate("next"));

        const selectPageSize = document.getElementById("select-page-size");
        if (selectPageSize) {
            selectPageSize.value = rowsPerPage;

            selectPageSize.addEventListener("change", function () {
                rowsPerPage = parseInt(this.value, 10);
                localStorage.setItem('remitentesRowsPerPage', rowsPerPage);
                currentPage = 1;
                updatePagination();
            });
        }

        document.getElementById("search").addEventListener("input", applyFilterAndPaginate);

        updatePagination();
    }

    return {
        init
    };
})();

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
        $.ajax({
            type: "POST",
            url: "",
            dataType: "json",
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Éxito',
                showConfirmButton: false,
                timer: 1500
                })
            }
        });
    }
}

