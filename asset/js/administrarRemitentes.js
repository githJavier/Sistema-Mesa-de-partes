import { createPagination } from './pagination.js';

const remitentesPagination = createPagination({
  tableId: "data-table",
  searchInputId: "search",
  prevBtnId: "prev-page",
  nextBtnId: "next-page",
  pageSizeSelectId: "select-page-size",
  paginationInfoId: "pagination-info",
  noResultsId: "no-results",
  defaultRowsPerPage: 5,
  storageKey: "remitentesRowsPerPage"
});

remitentesPagination.init();
