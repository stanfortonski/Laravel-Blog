if (document.querySelector('.c-sidebar')){
    let sidebarMinimizer = document.querySelector('.c-sidebar-minimizer');
    if (sidebarMinimizer){
        let sidebar = document.querySelector('.c-sidebar');
        sidebarMinimizer.addEventListener('click', () => {
            sidebar.classList.remove('c-sidebar-show');
        });
    }

    let sidebarTogglers = [].slice.call(document.querySelectorAll('.sidebar-toggler'));
    sidebarTogglers.map(togglerEl => {
        togglerEl.addEventListener('click', () => {
            let sidebar = document.querySelector('.c-sidebar');
            if (sidebar.classList.contains('c-sidebar-show'))
                sidebar.classList.remove('c-sidebar-show');
            else sidebar.classList.add('c-sidebar-show');
        });
    });
}
