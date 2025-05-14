function verDetalles(codigo, tipoDocumento, asunto, fechaRegistro, remitente, detallestramite) {
    document.getElementById('modal-codigo').textContent = codigo;
    document.getElementById('modal-tipodocumento').textContent = tipoDocumento;
    document.getElementById('modal-asunto').textContent = asunto;
    document.getElementById('modal-fecharegistro').textContent = fechaRegistro;
    document.getElementById('modal-remitente').textContent = remitente;
    const cuerpoTabla = document.getElementById('tabla-detalles-tramite');
    cuerpoTabla.innerHTML = '';

    if (Array.isArray(detallestramite)) {
        detallestramite.forEach(detalle => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${detalle.area_origen || ''}</td>
                <td>${detalle.estado || ''}</td>
                <td>${detalle.area_destino || ''}</td>
                <td>${detalle.fec_recep || ''}</td>
                <td>${detalle.hora_recep || ''}</td>
                <td>${detalle.folio || ''}</td>
                <td>${detalle.comentario || ''}</td>
            `;
            cuerpoTabla.appendChild(fila);
        });
    } else {
        const fila = document.createElement('tr');
        fila.innerHTML = `<td colspan="7" class="text-center">No hay detalles disponibles</td>`;
        cuerpoTabla.appendChild(fila);
    }

    const modalFondo = document.getElementById('modalFondo');
    const modalVentana = document.getElementById('modalVentana');

    modalFondo.style.display = 'flex';
    void modalVentana.offsetWidth;
    modalVentana.classList.remove('animar-salida');
    modalVentana.classList.add('animar-entrada');
}

function cerrarModal() {
    const modalFondo = document.getElementById('modalFondo');
    const modalVentana = document.getElementById('modalVentana');

    modalVentana.classList.remove('animar-entrada');
    modalVentana.classList.add('animar-salida');

    setTimeout(() => {
        modalFondo.style.display = 'none';
    }, 300);
}

// Variables para paginación
let currentPage = 1;
let itemsPerPage = parseInt(document.getElementById('cst-items-per-page-top').value);
const tableBody = document.getElementById('tablaExpedientes');
const rows = Array.from(tableBody.querySelectorAll('tr'));
const paginationInfo = document.getElementById('pagination-info');
const totalEntriesSpan = document.getElementById('total-entries');

function updatePagination() {
    const totalItems = rows.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;

    rows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? '' : 'none';
    });

    const showingStart = totalItems === 0 ? 0 : start + 1;
    const showingEnd = Math.min(end, totalItems);
    paginationInfo.textContent = `Mostrando ${showingStart} a ${showingEnd} de ${totalItems} entradas`;
    totalEntriesSpan.textContent = `${totalItems} entradas`;

    document.getElementById('prev-page').disabled = currentPage === 1;
    document.getElementById('next-page').disabled = currentPage === totalPages || totalPages === 0;
}

// Listeners para botones de paginación
document.getElementById('prev-page').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        updatePagination();
    }
});

document.getElementById('next-page').addEventListener('click', () => {
    const totalPages = Math.ceil(rows.length / itemsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        updatePagination();
    }
});

// Listener para cambio de items por página
document.getElementById('cst-items-per-page-top').addEventListener('change', (e) => {
    itemsPerPage = parseInt(e.target.value);
    currentPage = 1;
    updatePagination();
});

// Inicializar al cargar
window.addEventListener('load', () => {
    updatePagination();
});
setTimeout(updatePagination, 0);

function validarFiltroTramitesArchivados() {
    let searchValue = document.getElementById("search").value.trim();
    let dateFrom = document.getElementById("date-from").value;
    let dateTo = document.getElementById("date-to").value;

    if (searchValue !== "" && searchValue.length < 3) {
        Swal.fire({
            icon: 'warning',
            title: 'Dato inválido',
            text: 'El campo de búsqueda debe tener al menos 3 caracteres si se utiliza.'
        });
        return false;
    }

    if (
        searchValue === "" &&
        dateFrom === "" &&
        dateTo === "" &&
        document.getElementById("filtroTipo").value === "" &&
        document.getElementById("filtroEstado").value === ""
    ) {
        Swal.fire({
            icon: 'info',
            title: 'Campos vacíos',
            text: 'Por favor ingrese al menos un criterio de búsqueda.'
        });
        return false;
    }

    if ((dateFrom !== "" && dateTo === "") || (dateFrom === "" && dateTo !== "")) {
        Swal.fire({
            icon: 'warning',
            title: 'Fechas incompletas',
            text: 'Debe completar ambas fechas para filtrar por rango.'
        });
        return false;
    }

    if (dateFrom !== "" && dateTo !== "") {
        if (new Date(dateFrom) > new Date(dateTo)) {
            Swal.fire({
                icon: 'warning',
                title: 'Rango de fechas inválido',
                text: 'La fecha "desde" no puede ser mayor que la fecha "hasta".'
            });
            return false;
        }
    }

    return true;
}

// Botón "Filtrar"
document.getElementById('filter-btn').addEventListener('click', function () {
    if (!validarFiltroTramitesArchivados()) return;

    const codigo = document.getElementById('search').value.toLowerCase().trim();
    const tipo = document.getElementById('filtroTipo').value.toLowerCase();
    const estado = document.getElementById('filtroEstado').value.toLowerCase();
    const fechaDesde = document.getElementById('date-from').value;
    const fechaHasta = document.getElementById('date-to').value;

    const filas = document.querySelectorAll('#tramites-table tbody tr');

    filas.forEach(fila => {
        const codExp = fila.querySelector('.td-codigo').textContent.toLowerCase();
        const tipoDoc = fila.querySelector('.td-tipo').textContent.toLowerCase();
        const estadoActual = fila.querySelector('.td-estado').textContent.toLowerCase();
        const fechaRegistro = fila.querySelector('.td-fecha').textContent;

        let mostrar = true;

        if (codigo && !codExp.includes(codigo)) mostrar = false;
        if (tipo && tipo !== tipoDoc) mostrar = false;
        if (estado && estado !== estadoActual) mostrar = false;
        if (fechaDesde && fechaRegistro < fechaDesde) mostrar = false;
        if (fechaHasta && fechaRegistro > fechaHasta) mostrar = false;

        fila.style.display = mostrar ? '' : 'none';
    });
});

// Botón "Limpiar"
document.getElementById('reset-btn').addEventListener('click', function () {
    document.getElementById('search').value = '';
    document.getElementById('filtroTipo').value = '';
    document.getElementById('filtroEstado').value = '';
    document.getElementById('date-from').value = '';
    document.getElementById('date-to').value = '';

    const filas = document.querySelectorAll('#tramites-table tbody tr');
    filas.forEach(fila => fila.style.display = '');
    updatePagination();
});

async function generarPDF() {
    const botonPDF = event.target;
    botonPDF.style.display = 'none';
    await new Promise(resolve => setTimeout(resolve, 300));

    const modal = document.getElementById("modalVentana");

    html2canvas(modal, { scale: 2 }).then(canvas => {
        botonPDF.style.display = 'inline-block';

        const imgData = canvas.toDataURL("image/png");
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'mm', 'a4');

        const pageWidth = pdf.internal.pageSize.getWidth();
        const margin = 15;
        let y = 15;

        const fecha = new Date();
        const fechaStr = fecha.toLocaleDateString();
        const horaStr = fecha.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        const logo = new Image();
        logo.src = "../../asset/img/logo_tacidh.png";

        logo.onload = function () {
            const logoWidth = 60;
            const logoHeight = (logo.height / logo.width) * logoWidth;
            const logoX = margin;
            const logoY = y;

            pdf.addImage(logo, 'PNG', logoX, logoY, logoWidth, logoHeight);

            const textX = pageWidth - margin - 60;
            pdf.setFontSize(12);
            pdf.setFont("helvetica", "normal");
            pdf.text(`Fecha: ${fechaStr}`, textX, y + 5);
            pdf.text(`Hora: ${horaStr}`, textX, y + 12);

            y += Math.max(logoHeight, 20) + 5;
            pdf.setDrawColor(150);
            pdf.setLineWidth(0.3);
            pdf.line(margin, y, pageWidth - margin, y);

            y += 10;
            const imgWidth = pageWidth - margin * 2;
            const imgHeight = canvas.height * imgWidth / canvas.width;
            pdf.addImage(imgData, 'PNG', margin, y, imgWidth, imgHeight);

            const codigoTramite = document.getElementById("modal-codigo").textContent.trim() || "detalle_tramite";
            const nombreArchivo = `detalle_${codigoTramite}.pdf`;
            pdf.save(nombreArchivo);
        };
    });
}
