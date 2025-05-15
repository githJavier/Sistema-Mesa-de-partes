// pagination.js
export function createPagination({
  tableId,
  searchInputId,
  prevBtnId,
  nextBtnId,
  pageSizeSelectId,
  paginationInfoId,
  noResultsId,
  defaultRowsPerPage = 5,
  storageKey
}) {
  // ... Aquí va todo el código de createPagination igual como antes
  let currentPage = 1;
  let rowsPerPage = defaultRowsPerPage;
  let isPaginating = false;
  let filteredRows = [];

  if (storageKey) {
    const saved = localStorage.getItem(storageKey);
    if (saved) rowsPerPage = parseInt(saved, 10);
  }

  function updatePagination() {
    const table = document.getElementById(tableId);
    if (!table) return;

    const allRows = table.querySelectorAll("tbody tr");
    allRows.forEach(row => (row.style.display = "none"));

    const totalRows = filteredRows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);

    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    filteredRows.slice(start, end).forEach(row => (row.style.display = ""));

    const infoEl = document.getElementById(paginationInfoId);
    if (infoEl) {
      infoEl.innerText =
        totalRows > 0
          ? `Mostrando ${start + 1} a ${Math.min(end, totalRows)} de ${totalRows} entradas`
          : "Mostrando 0 a 0 de 0 entradas";
    }

    const prevBtn = document.getElementById(prevBtnId);
    const nextBtn = document.getElementById(nextBtnId);
    if (prevBtn) prevBtn.disabled = currentPage === 1;
    if (nextBtn) nextBtn.disabled = currentPage === totalPages || totalPages === 0;
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
    const inputEl = document.getElementById(searchInputId);
    if (!inputEl) return;

    const input = inputEl.value.toLowerCase().trim();
    const allRows = Array.from(document.querySelectorAll(`#${tableId} tbody tr`));
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

    const noResultsEl = document.getElementById(noResultsId);
    if (noResultsEl) noResultsEl.classList.toggle("d-none", found);

    const infoEl = document.getElementById(paginationInfoId);
    if (infoEl) infoEl.style.display = found ? "block" : "none";

    const prevBtn = document.getElementById(prevBtnId);
    const nextBtn = document.getElementById(nextBtnId);
    if (prevBtn) prevBtn.style.display = found ? "inline-block" : "none";
    if (nextBtn) nextBtn.style.display = found ? "inline-block" : "none";
  }

  function init() {
    currentPage = 1;

    filteredRows = Array.from(document.querySelectorAll(`#${tableId} tbody tr`));

    const prevBtn = document.getElementById(prevBtnId);
    const nextBtn = document.getElementById(nextBtnId);

    if (prevBtn) prevBtn.addEventListener("click", () => safePaginate("prev"));
    if (nextBtn) nextBtn.addEventListener("click", () => safePaginate("next"));

    const selectPageSize = document.getElementById(pageSizeSelectId);
    if (selectPageSize) {
      selectPageSize.value = rowsPerPage;
      selectPageSize.addEventListener("change", function () {
        rowsPerPage = parseInt(this.value, 10);
        if (storageKey) localStorage.setItem(storageKey, rowsPerPage);
        currentPage = 1;
        updatePagination();
      });
    }

    const searchInput = document.getElementById(searchInputId);
    if (searchInput) searchInput.addEventListener("input", applyFilterAndPaginate);

    updatePagination();
  }

  return { init };
}
