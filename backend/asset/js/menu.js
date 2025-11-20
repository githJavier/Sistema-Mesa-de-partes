// ==== CONTROL DE MENÚ LATERAL Y DE USUARIO ==== //
function toggleMenu() {
    const menu = document.getElementById("offcanvasScrolling");
    const isSmallScreen = window.innerWidth < 992;

    if (isSmallScreen) {
        menu.classList.toggle("open");
        // Guardar el estado en localStorage
        localStorage.setItem('menuAbierto', menu.classList.contains('open') ? 'true' : 'false');
    } else {
        menu.classList.toggle("fixed");
        document.body.classList.toggle("menu-open", menu.classList.contains("fixed"));
        // Guardar el estado en localStorage
        localStorage.setItem('menuAbierto', menu.classList.contains('fixed') ? 'true' : 'false');
    }
}


function initializeMenu() {
    const menu = document.getElementById("offcanvasScrolling");
    const menuAbierto = localStorage.getItem('menuAbierto');

    if (menuAbierto === 'true') {
        // Si el estado es 'true', el menú debe estar abierto
        menu.classList.add("open");
        if (window.innerWidth >= 992) {
            menu.classList.add("fixed");
            document.body.classList.add("menu-open");
        }
    } else {
        // Si el estado es 'false', el menú debe estar cerrado
        menu.classList.remove("open", "fixed");
        document.body.classList.remove("menu-open");
    }
}


function toggleUserMenu(event) {
    event.stopPropagation();
    document.getElementById('userMenu').classList.toggle('active');
}

function toggleCalendar() {
    document.getElementById('calendarOffcanvas').classList.toggle('show');
}

// ==== ESCUCHA CLICS FUERA DE MENÚ ==== //
document.addEventListener("click", function (event) {
    const menu = document.getElementById("offcanvasScrolling");
    const button = document.querySelector(".btn-toggle-menu");
    const userMenu = document.getElementById('userMenu');
    const userButton = document.getElementById('userDropdown');

    // Cierre menú lateral
    if (window.innerWidth < 992 && menu.classList.contains("open") && !menu.contains(event.target) && !button.contains(event.target)) {
        menu.classList.remove("open");
    }

    // Cierre menú usuario
    if (!userButton.contains(event.target) && !userMenu.contains(event.target)) {
        userMenu.classList.remove('active');
    }
});

window.addEventListener("resize", initializeMenu);
