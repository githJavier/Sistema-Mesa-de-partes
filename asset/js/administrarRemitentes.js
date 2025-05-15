window.remitentesPagination = (function () {
    let currentPage = 1;
    let rowsPerPage = 5;  // Valor por defecto

    // Cargar el valor guardado de filas por página
    const savedRowsPerPage = localStorage.getItem('remitentesRowsPerPage');
    if (savedRowsPerPage) {
        rowsPerPage = parseInt(savedRowsPerPage, 10);
    }

    function updatePagination() {
        const table = document.getElementById("data-table");
        if (!table) return;
        const rows = table.querySelectorAll("tbody tr");
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        rows.forEach((row, index) => {
            row.style.display = (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) ? "" : "none";
        });

        document.getElementById("pagination-info").innerText = totalRows > 0
            ? `Mostrando ${(currentPage - 1) * rowsPerPage + 1} a ${Math.min(currentPage * rowsPerPage, totalRows)} de ${totalRows} entradas`
            : "Mostrando 0 a 0 de 0 entradas";

        document.getElementById("prev-page").disabled = currentPage === 1;
        document.getElementById("next-page").disabled = currentPage === totalPages || totalPages === 0;
    }

    function init() {
        currentPage = 1;

        document.getElementById("prev-page").addEventListener("click", function () {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });

        document.getElementById("next-page").addEventListener("click", function () {
            const table = document.getElementById("data-table");
            if (!table) return;
            const totalRows = table.querySelectorAll("tbody tr").length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });

        // Obtener el select de filas por página
        const selectPageSize = document.getElementById("select-page-size");
        if (selectPageSize) {
            // Establecer el valor guardado al select al iniciar
            selectPageSize.value = rowsPerPage;

            selectPageSize.addEventListener("change", function () {
                rowsPerPage = parseInt(this.value, 10);
                localStorage.setItem('remitentesRowsPerPage', rowsPerPage); // Guardar selección
                currentPage = 1; // Resetear a página 1 cuando cambia filas por página
                updatePagination();
            });
        }

        // Resto del código (filtro de búsqueda)
        document.getElementById("search").addEventListener("input", function () {
            const input = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll("#data-table tbody tr");
            let found = false;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const match = text.includes(input);
                row.style.display = match ? "" : "none";
                if (match) found = true;
            });

            document.getElementById("no-results").classList.toggle("d-none", found);
            document.getElementById("pagination-info").style.display = found ? "block" : "none";
            document.getElementById("prev-page").style.display = found ? "inline-block" : "none";
            document.getElementById("next-page").style.display = found ? "inline-block" : "none";
        });

        updatePagination();
    }

    return {
        init
    };
})();

function searchItem() {
    var searchValue = document.getElementById('search').value.trim();

    if (searchValue === "") {
        Swal.fire({
            icon: 'info',
            iconColor: '#000000',
            title: 'Campos vacíos',
            text: 'Por favor ingrese al menos un criterio de búsqueda.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#000000',
            customClass: {
                confirmButton: 'custom-ok-button'
            }
        });
        return;
    }

    // Si no está vacío, ejecutamos el filtro
    const searchInput = document.getElementById('search');
    searchInput.dispatchEvent(new Event('input')); // o llama directamente a la función de filtro si la haces global
}

