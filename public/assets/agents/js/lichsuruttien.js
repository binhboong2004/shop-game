document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-tab');
    const tableRows = document.querySelectorAll('#history-tbody tr');
    const emptyState = document.getElementById('empty-state');
    const tableContainer = document.querySelector('.overflow-x-auto > table');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => {
                t.classList.remove('active', 'text-agent-primary');
                t.classList.add('text-agent-muted');
                const indicator = t.querySelector('.bg-agent-primary');
                if (indicator) {
                    indicator.remove();
                }
            });

            tab.classList.add('active', 'text-agent-primary');
            tab.classList.remove('text-agent-muted');
            const indicatorHTML = `<div class="absolute bottom-0 left-0 w-full h-[2px] bg-agent-primary"></div>`;
            tab.insertAdjacentHTML('beforeend', indicatorHTML);

            const status = tab.getAttribute('data-tab');
            let visibleCount = 0;
            tableRows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || status === rowStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (visibleCount === 0) {
                tableContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                tableContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        });
    });
});
