const dashboard = document.querySelector('.news-admin');
const sidebar = document.querySelector('#dashboard-sidebar');
const shell = document.querySelector('.dashboard-shell');
const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const backdrop = document.querySelector('[data-sidebar-close]');
const compactLayout = window.matchMedia('(max-width: 1080px)');
const dropdowns = [...document.querySelectorAll('.dashboard-dropdown')];

function updateSidebar() {
    const expanded = compactLayout.matches
        ? dashboard.classList.contains('sidebar-open')
        : !dashboard.classList.contains('sidebar-collapsed');

    sidebarToggle.setAttribute('aria-expanded', String(expanded));
    sidebar.inert = !expanded;
    const mobileOpen = compactLayout.matches && expanded;
    backdrop.hidden = !mobileOpen;
    shell.inert = mobileOpen;
}

function closeCompactSidebar() {
    dashboard.classList.remove('sidebar-open');
    updateSidebar();
    sidebarToggle.focus();
}

sidebarToggle.addEventListener('click', () => {
    dashboard.classList.toggle(compactLayout.matches ? 'sidebar-open' : 'sidebar-collapsed');
    updateSidebar();

    if (compactLayout.matches && !backdrop.hidden) {
        sidebar.querySelector('.dashboard-brand').focus();
    }
});
backdrop.addEventListener('click', closeCompactSidebar);
compactLayout.addEventListener('change', () => {
    dashboard.classList.remove('sidebar-open');
    updateSidebar();
});
updateSidebar();

document.addEventListener('click', event => {
    dropdowns.forEach(dropdown => {
        if (dropdown.open && !dropdown.contains(event.target)) {
            dropdown.open = false;
        }
    });
});
document.addEventListener('keydown', event => {
    if (event.key !== 'Escape') {
        return;
    }

    if (compactLayout.matches && !backdrop.hidden) {
        closeCompactSidebar();
        return;
    }

    const currentDropdown = dropdowns.find(dropdown => dropdown.open);
    if (currentDropdown) {
        currentDropdown.open = false;
        currentDropdown.querySelector('summary').focus();
    }
});
