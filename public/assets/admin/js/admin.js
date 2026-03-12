document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggleBtn = document.getElementById('sidebar-toggle');
    const sidebarCloseBtn = document.getElementById('sidebar-close');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-overlay');

    if (sidebarToggleBtn && sidebar && overlay) {
        sidebarToggleBtn.addEventListener('click', function() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        });

        overlay.addEventListener('click', closeSidebar);
        if (sidebarCloseBtn) {
            sidebarCloseBtn.addEventListener('click', closeSidebar);
        }
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    const dropdownToggles = document.querySelectorAll('[data-toggle="dropdown"]');
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const targetId = this.getAttribute('data-target');
            const targetMenu = document.getElementById(targetId);
            
            dropdownToggles.forEach(otherToggle => {
                if (otherToggle !== this) {
                    const otherTarget = document.getElementById(otherToggle.getAttribute('data-target'));
                    if (otherTarget && !otherTarget.classList.contains('hidden')) {
                        otherTarget.classList.add('hidden');
                        otherToggle.querySelector('.material-symbols-outlined.transition-transform')?.classList.remove('rotate-180');
                    }
                }
            });

            if (targetMenu) {
                targetMenu.classList.toggle('hidden');
                const arrow = this.querySelector('.material-symbols-outlined.transition-transform');
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('[data-toggle="dropdown"]') && !e.target.closest('.dropdown-menu')) {
            const dropdowns = document.querySelectorAll('.dropdown-menu');
            dropdowns.forEach(menu => {
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });
            const arrows = document.querySelectorAll('.material-symbols-outlined.transition-transform.rotate-180');
            arrows.forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });
        }
    });
});

window.showToast = function(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed top-4 right-4 z-[9999] flex flex-col gap-2 pointer-events-none';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-[#20222a] border-emerald-500/30' : 'bg-[#20222a] border-[#E70814]/30';
    const iconColor = type === 'success' ? 'text-emerald-500' : 'text-[#E70814]';
    const iconName = type === 'success' ? 'check_circle' : 'error';
    
    toast.className = `flex items-center gap-3 px-4 py-3 rounded-lg border shadow-xl transform transition-all duration-300 translate-x-full opacity-0 pointer-events-auto min-w-[300px] ${bgColor}`;
    
    toast.innerHTML = `
        <span class="material-symbols-outlined ${iconColor}">${iconName}</span>
        <p class="text-white text-sm font-medium pr-4 flex-1">${message}</p>
        <button class="text-gray-400 hover:text-white transition-colors" onclick="this.parentElement.remove()">
            <span class="material-symbols-outlined text-[18px]">close</span>
        </button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
    }, 10);

    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
};
