function crearPaginacion(nombreStorage, tablaID, inputBusquedaID, sinResultadosID, infoPaginacionID, botonPrevID, botonNextID, selectPageSizeID) {
    let currentPage = 1;
    let rowsPerPage = 5;
    let isPaginating = false;
    let filteredRows = [];

    const savedRowsPerPage = localStorage.getItem(nombreStorage + 'RowsPerPage');
    if (savedRowsPerPage) {
        rowsPerPage = parseInt(savedRowsPerPage, 10);
    }

    function updatePagination() {
        const table = document.getElementById(tablaID);
        if (!table) return;

        const allRows = table.querySelectorAll("tbody tr");
        allRows.forEach(row => row.style.display = "none");

        const totalRows = filteredRows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        filteredRows.slice(start, end).forEach(row => row.style.display = "");

        document.getElementById(infoPaginacionID).innerText = totalRows > 0
            ? `Mostrando ${start + 1} a ${Math.min(end, totalRows)} de ${totalRows} entradas`
            : "Mostrando 0 a 0 de 0 entradas";

        document.getElementById(botonPrevID).disabled = currentPage === 1;
        document.getElementById(botonNextID).disabled = currentPage === totalPages || totalPages === 0;
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
        const input = document.getElementById(inputBusquedaID).value.toLowerCase().trim();
        const allRows = Array.from(document.querySelectorAll(`#${tablaID} tbody tr`));
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

        document.getElementById(sinResultadosID).classList.toggle("d-none", found);
        document.getElementById(infoPaginacionID).style.display = found ? "block" : "none";
        document.getElementById(botonPrevID).style.display = found ? "inline-block" : "none";
        document.getElementById(botonNextID).style.display = found ? "inline-block" : "none";
    }

    function init() {
        currentPage = 1;

        const allRows = Array.from(document.querySelectorAll(`#${tablaID} tbody tr`));
        filteredRows = allRows;

        document.getElementById(botonPrevID).addEventListener("click", () => safePaginate("prev"));
        document.getElementById(botonNextID).addEventListener("click", () => safePaginate("next"));

        const selectPageSize = document.getElementById(selectPageSizeID);
        if (selectPageSize) {
            selectPageSize.value = rowsPerPage;

            selectPageSize.addEventListener("change", function () {
                rowsPerPage = parseInt(this.value, 10);
                localStorage.setItem(nombreStorage + 'RowsPerPage', rowsPerPage);
                currentPage = 1;
                updatePagination();
            });
        }

        document.getElementById(inputBusquedaID).addEventListener("input", applyFilterAndPaginate);

        updatePagination();
    }

    return {
        init
    };
}

window.remitentesPagination = crearPaginacion(
    "remitentes",      // localStorage key prefix
    "data-table",       // tabla
    "search",           // input de búsqueda
    "no-results",       // div que se muestra cuando no hay resultados
    "pagination-info",  // info de paginación
    "prev-page",        // botón anterior
    "next-page",        // botón siguiente
    "select-page-size"  // selector de cantidad por página
);

window.usuariosPagination = crearPaginacion(
    "usuarios",
    "usuarios-table",
    "usuarios-search",
    "usuarios-no-results",
    "usuarios-pagination-info",
    "usuarios-prev-page",
    "usuarios-next-page",
    "usuarios-select-page-size"
);

