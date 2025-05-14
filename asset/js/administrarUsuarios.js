function searchItem() {
    var searchValue = document.getElementById('search').value.trim();

    // Validar que el campo no esté vacío
    if (searchValue === "") {
        Swal.fire({
            icon: 'info', // Icono informativo
            iconColor: '#000000', // Cambiar el color del icono a negro
            title: 'Campos vacíos',
            text: 'Por favor ingrese al menos un criterio de búsqueda.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#000000', // Color del botón
            customClass: {
                confirmButton: 'custom-ok-button' // Clase CSS personalizada para el botón OK
            }
        });
        return; // Detener la búsqueda si el campo está vacío
    }
   }