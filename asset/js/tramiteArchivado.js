function validarFiltroTramitesArchivados() {
                let isValid = true;

                // Validar campo 'Buscar'
                let search = document.getElementById("search");
                let searchValue = search.value.trim();
                if (searchValue !== "" && searchValue.length < 3) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Dato inválido',
                        text: 'El campo de búsqueda debe tener al menos 3 caracteres si se utiliza.'
                    });
                    isValid = false;
                    return isValid;
                }

                // Validar fechas
                let dateFrom = document.getElementById("date-from").value;
                let dateTo = document.getElementById("date-to").value;

                // Validar si ambos campos de fecha están vacíos
                if (searchValue === "" && dateFrom === "" && dateTo === "") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Campos vacíos',
                        text: 'Por favor ingrese al menos un criterio de búsqueda (texto o rango de fechas).'
                    });
                    isValid = false;
                    return isValid;
                }

                // Validar si solo una fecha está completada
                if ((dateFrom === "" && dateTo !== "") || (dateFrom !== "" && dateTo === "")) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Fechas incompletas',
                        text: 'Debe completar ambas fechas para filtrar por rango.'
                    });
                    isValid = false;
                    return isValid;
                }

                // Validar rango de fechas
                if (dateFrom !== "" && dateTo !== "") {
                    if (new Date(dateFrom) > new Date(dateTo)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Rango de fechas inválido',
                            text: 'La fecha "desde" no puede ser mayor que la fecha "hasta".'
                        });
                        isValid = false;
                    }
                }

                return isValid;
            }

            // Asociar validación al botón "Filtrar"
            document.getElementById("filter-btn").addEventListener("click", function() {
                if (validarFiltroTramitesArchivados()) {
                    // Aquí se llamaría la función que hace la búsqueda, por ejemplo:
                    // buscarTramitesArchivados();
                    //console.log("Validación exitosa. Procediendo con búsqueda...");
                }
            });

            // Función para limpiar el formulario (manteniendo tu estilo)
            document.getElementById("reset-btn").addEventListener("click", function() {
                document.getElementById("search").value = "";
                document.getElementById("date-from").value = "";
                document.getElementById("date-to").value = "";
                //console.log("Formulario limpiado");
            });