window.TramitesPagination = (function () {
    let currentPage = 1;
    let rowsPerPage = 10;  // Valor por defecto

    // Cargar el valor guardado de filas por página
    const savedRowsPerPage = localStorage.getItem('tramitesRowsPerPage');
    if (savedRowsPerPage) {
        rowsPerPage = parseInt(savedRowsPerPage, 10);
    }

    function updatePagination() {
        const table = document.getElementById("tramites-table");
        if (!table) return;
        const rows = table.querySelectorAll("tbody tr");
        const totalRows = rows.length;
        const totalPages = Math.ceil(totalRows / rowsPerPage);

        rows.forEach((row, index) => {
            const isVisible = index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage;
            row.style.display = isVisible ? "" : "none";
        });
        document.getElementById("pagination-info").innerText = totalRows > 0
            ? `Mostrando del ${(currentPage - 1) * rowsPerPage + 1} al ${Math.min(currentPage * rowsPerPage, totalRows)} de ${totalRows} registros`
            : "Mostrando del 0 al 0 de 0 registros";

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
            const table = document.getElementById("tramites-table");
            if (!table) return;
            const totalRows = table.querySelectorAll("tbody tr").length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });

        // Obtener el select de filas por página
        const selectPageSize = document.getElementById("cst-items-per-page-top");
        if (selectPageSize) {
            // Establecer el valor guardado al select al iniciar
            selectPageSize.value = rowsPerPage;

            selectPageSize.addEventListener("change", function () {
                rowsPerPage = parseInt(this.value, 10);
                localStorage.setItem('tramitesRowsPerPage', rowsPerPage); // Guardar selección
                currentPage = 1; // Resetear a página 1 cuando cambia filas por página
                updatePagination();
            });
        }

        // Resto del código (filtro de búsqueda)
        document.getElementById("search").addEventListener("input", function () {
            const input = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll("#tramites-table tbody tr");
            let found = false;

            rows.forEach(row => {
            const codigoCell = row.querySelector(".td-codigo"); // solo la celda con el código
            const text = codigoCell ? codigoCell.textContent.toLowerCase() : "";
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

    // Botón "Limpiar"
    document.getElementById('reset-btn').addEventListener('click', function () {
        document.getElementById('search').value = '';
        document.getElementById('filtroTipo').value = '';
        document.getElementById('date-from').value = '';
        document.getElementById('date-to').value = '';

        updatePagination();

        document.getElementById("no-results").classList.add("d-none");
        document.getElementById("pagination-info").style.display = "block";
        document.getElementById("prev-page").style.display = "inline-block";
        document.getElementById("next-page").style.display = "inline-block";

    });

    return {
        init
    };
})();

window.TramitesPagination.init();

function verDetalles(codigo, tipoDocumento, asunto, fechaRegistro, remitente, flujosJSON, archivoAdjuntoJSON) {
    const flujos = JSON.parse(flujosJSON);
    const archivoAdjunto = JSON.parse(archivoAdjuntoJSON);

    document.getElementById('modal-codigo').textContent = codigo;
    document.getElementById('modal-tipodocumento').textContent = tipoDocumento;
    document.getElementById('modal-asunto').textContent = asunto;
    document.getElementById('modal-fecharegistro').textContent = fechaRegistro;
    document.getElementById('modal-remitente').textContent = remitente;
    const cuerpoTabla = document.getElementById('tabla-detalles-tramite');
    cuerpoTabla.innerHTML = '';

    if (Array.isArray(flujos)) {
        flujos.forEach(flujo => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${flujo.f_area_origen || ''}</td>
                <td>${flujo.f_estado || ''}</td>
                <td>${flujo.f_area_destino || ''}</td>
                <td>${flujo.f_fec_recep || ''}</td>
                <td>${flujo.f_hora_recep || ''}</td>
                <td>${flujo.f_folio || ''}</td>
                <td>${flujo.f_comentario || ''}</td>
            `;
            cuerpoTabla.appendChild(fila);
        });
    } else {
        const fila = document.createElement('tr');
        fila.innerHTML = `<td colspan="7" class="text-center">No hay detalles disponibles</td>`;
        cuerpoTabla.appendChild(fila);
    }

    // Ruta base de acceso público a los archivos almacenados en Supabase.
    // ⚠️ Si se cambia de proveedor de almacenamiento en el futuro (por ejemplo, a S3 o Cloudinary),
    // esta base debe actualizarse para reflejar la nueva estructura de URLs.
    const supabaseBaseUrl = 'https://xozmffgvhrucxbpltgch.supabase.co'; // URL del proyecto Supabase
    const bucket = 'documentos';
    const rutaBase = `${supabaseBaseUrl}/storage/v1/object/public/${bucket}/`;

    // Manejo de botones de adjuntos
    const btnRemitente = document.getElementById('btn-remitente');
    const btnDerivado = document.getElementById('btn-derivado');

    // Buscar archivos específicos
    const archivoINI = archivoAdjunto.find(nombre => nombre.includes('_00INI00_'));
    const archivosDRV = archivoAdjunto.filter(nombre => nombre.includes('_00DRV00_'));

    // Botón Remitente
    if (archivoINI) {
        btnRemitente.href = rutaBase + archivoINI;
        btnRemitente.classList.remove('btn-secondary', 'disabled-link');
        btnRemitente.classList.add('btn-danger');
        btnRemitente.setAttribute('target', '_blank');
        btnRemitente.disabled = false;
    } else {
        btnRemitente.removeAttribute('href');
        btnRemitente.classList.remove('btn-danger');
        btnRemitente.classList.add('btn-secondary', 'disabled-link');
        btnRemitente.setAttribute('aria-disabled', 'true');
    }

    btnDerivado.style.display = 'inline-block'; // Siempre visible

    // Botón Derivado
    if (archivosDRV.length > 0) {
        const cantidad = archivosDRV.length;
        btnDerivado.innerHTML = `
            <i class="bi bi-paperclip"></i> ${cantidad === 1 ? 'Documento de derivación' : `Documentos de derivación (${cantidad})`}
        `;
        btnDerivado.classList.remove('btn-secondary', 'disabled-link');
        btnDerivado.classList.add('btn-danger');
        btnDerivado.removeAttribute('aria-disabled');

        if (cantidad === 1) {
            btnDerivado.href = rutaBase + archivosDRV[0];
            btnDerivado.setAttribute('target', '_blank');
            btnDerivado.removeAttribute('onclick');
            delete btnDerivado.dataset.archivosDerivacion;
        } else {
            btnDerivado.removeAttribute('href');
            btnDerivado.removeAttribute('target');
            btnDerivado.dataset.archivosDerivacion = JSON.stringify(archivosDRV);
            btnDerivado.onclick = abrirModalDerivacion;
        }
    } else {
        btnDerivado.innerHTML = `<i class="bi bi-paperclip"></i> Documentos de derivación`;
        btnDerivado.removeAttribute('href');
        btnDerivado.removeAttribute('target');
        btnDerivado.removeAttribute('onclick');
        delete btnDerivado.dataset.archivosDerivacion;
        btnDerivado.classList.remove('btn-danger');
        btnDerivado.classList.add('btn-secondary', 'disabled-link');
        btnDerivado.setAttribute('aria-disabled', 'true');
    }

    // Mostrar modal
    const modalFondo = document.getElementById('modalFondo');
    const modalVentana = document.getElementById('modalVentana');

    modalFondo.style.display = 'flex';
    void modalVentana.offsetWidth;
    modalVentana.classList.remove('animar-salida');
    modalVentana.classList.add('animar-entrada');
}

function abrirModalDerivacion() {
    const btn = document.getElementById('btn-derivado');
    const lista = document.getElementById('lista-derivaciones');
    const archivos = JSON.parse(btn.dataset.archivosDerivacion || '[]');

    if (archivos.length <= 1) {
        return; // Protección adicional
    }

    const supabaseBaseUrl = 'https://xozmffgvhrucxbpltgch.supabase.co';
    const rutaBase = `${supabaseBaseUrl}/storage/v1/object/public/documentos/`;

    lista.innerHTML = ''; // Limpiar lista

    // Valor aproximado de altura por ítem (ajusta si tienes paddings/margins grandes)
    const alturaPorItem = 50; // px
    const maxItemsVisibles = 7;

    archivos.forEach(nombre => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `
                            <span class="nombre-archivo fw-semibold">${nombre}</span>
                            <a href="${rutaBase + nombre}" class="btn btn-sm btn-danger" target="_blank">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        `;
        lista.appendChild(li);
        // Después de agregar todos los <li>...
        setTimeout(() => {
            const modalBody = document.querySelector('#modal-derivaciones .modal-body');
            if (archivos.length > maxItemsVisibles) {
                modalBody.style.maxHeight = (alturaPorItem * maxItemsVisibles) + 'px';
                modalBody.style.overflowY = 'auto';
            } else {
                modalBody.style.maxHeight = 'none';
                modalBody.style.overflowY = 'visible';
            }
        }, 0);
    });

    // Ajustar altura dinámica del modal-body
    const modalBody = document.querySelector('#modal-derivaciones .modal-body');
    const maxVisible = 7;
    const itemHeight = 60; // Puedes ajustar según el estilo real de tus ítems
    const paddingExtra = 20;

    if (archivos.length <= maxVisible) {
        modalBody.style.maxHeight = (archivos.length * itemHeight + paddingExtra) + 'px';
    } else {
        modalBody.style.maxHeight = (maxVisible * itemHeight + paddingExtra) + 'px';
    }

    document.getElementById('modal-derivaciones').style.display = 'flex';
}

function cerrarModalDerivacion() {
    document.getElementById('modal-derivaciones').style.display = 'none';
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

function validarFiltroTramitesArchivados() {
    let dateFrom = document.getElementById("date-from").value;
    let dateTo = document.getElementById("date-to").value;

    if (
        dateFrom === "" &&
        dateTo === "" &&
        document.getElementById("filtroTipo").value === ""
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

    const tipo = document.getElementById('filtroTipo').value.toLowerCase();
    const fechaDesde = document.getElementById('date-from').value;
    const fechaHasta = document.getElementById('date-to').value;

    const filas = document.querySelectorAll('#tramites-table tbody tr');
    let found = false;

    filas.forEach(fila => {
        const tipoDoc = fila.querySelector('.td-tipo').textContent.toLowerCase();
        const fechaRegistro = fila.querySelector('.td-fecha').textContent;

        let mostrar = true;

        if (tipo && tipo !== tipoDoc) mostrar = false;
        if (fechaDesde && fechaRegistro < fechaDesde) mostrar = false;
        if (fechaHasta && fechaRegistro > fechaHasta) mostrar = false;

        fila.style.display = mostrar ? '' : 'none';
        if (mostrar) found = true;
    });

        // Mostrar u ocultar elementos según si hay coincidencias
        document.getElementById("no-results").classList.toggle("d-none", found);
        document.getElementById("pagination-info").style.display = "none";
        document.getElementById("prev-page").style.display = "none";
        document.getElementById("next-page").style.display = "none";
});

async function generarPDF() {
    const btnRemitente = document.getElementById('btn-remitente');
    const btnDerivado = document.getElementById('btn-derivado');
    const btnPDF = event.target;

    const visibleRemitente = btnRemitente && btnRemitente.style.display !== 'none';
    const visibleDerivado = btnDerivado && btnDerivado.style.display !== 'none';

    btnPDF.style.display = 'none';
    if (btnRemitente) btnRemitente.style.display = 'none';
    if (btnDerivado) btnDerivado.style.display = 'none';

    await new Promise(resolve => setTimeout(resolve, 300));

    const modal = document.getElementById("modalVentana");

    html2canvas(modal, { scale: 2 }).then(canvas => {
        btnPDF.style.display = 'inline-block';
        if (btnRemitente) btnRemitente.style.display = visibleRemitente ? 'inline-block' : 'none';
        if (btnDerivado) btnDerivado.style.display = visibleDerivado ? 'inline-block' : 'none';

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
            const nombreArchivo = `${codigoTramite}_seguimiento_tramite.pdf`;
            pdf.save(nombreArchivo);
        };
    });
}