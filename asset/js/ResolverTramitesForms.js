function cargarFormularioArchivarTramite(codigo_tramite, asunto, num_documento){
    $.ajax({
        type: "POST",
        url: "../../controllers/ResolverTramite/ArchivarTramite/controlFormArchivarTramite.php",
        data: {
            codigo_tramite: codigo_tramite,
            asunto: asunto,
            num_documento: num_documento,
            btnArchivarTramite: "ArchivarTramite"
        },
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                // Guardamos HTML y datos en localStorage
                guardarContenidoEnLocalStorage(response.formularioHTML, "archivarTramite");
                guardarParametrosArchivarTramite(codigo_tramite, asunto, num_documento);
            }
        }
    })
}

function cargarFormularioDerivarTramite(codigo_tramite, asunto, num_documento, cod_detalle_tramite){
    $.ajax({
        type: "POST",
        url: "../../controllers/ResolverTramite/DerivarTramite/controlFormDerivarTramite.php",
        data: {
            codigo_tramite: codigo_tramite,
            asunto: asunto,
            num_documento: num_documento,
            cod_detalle_tramite: cod_detalle_tramite,
            btnDerivarTramite: "DerivarTramite"
        },
        dataType: "json",
        success: function(response){
            if(response.flag == 1){
                $("#contenido-dinamico").html(response.formularioHTML);
                // Guardamos HTML y datos en localStorage
                guardarContenidoEnLocalStorage(response.formularioHTML, "derivarTramite");
                guardarParametrosDerivarTramite(codigo_tramite, asunto, num_documento);
            }
        }
    })
}