document.addEventListener('DOMContentLoaded', function() {
    setupFilters();
});

function setupFilters() {
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const nickItems = document.querySelectorAll('.nick-item');
    
    let currentFilter = 'all';
    let searchQuery = '';

    if(searchInput) {
        searchInput.addEventListener('input', function(e) {
            searchQuery = e.target.value.toLowerCase().trim();
            filterItems();
        });
    }

    if(filterButtons) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => {
                    b.classList.remove('text-white', 'bg-agent-border/50');
                    b.classList.add('text-agent-muted');
                });
                
                this.classList.remove('text-agent-muted');
                this.classList.add('text-white', 'bg-agent-border/50');
                
                currentFilter = this.getAttribute('data-filter');
                if(categorySelect) categorySelect.value = currentFilter;
                
                filterItems();
            });
        });
    }
    
    if(categorySelect) {
        categorySelect.addEventListener('change', function(e) {
            currentFilter = e.target.value;
            filterButtons.forEach(b => {
                if(b.getAttribute('data-filter') === currentFilter) {
                    b.classList.remove('text-agent-muted');
                    b.classList.add('text-white', 'bg-agent-border/50');
                } else {
                    b.classList.remove('text-white', 'bg-agent-border/50');
                    b.classList.add('text-agent-muted');
                }
            });
            
            filterItems();
        });
    }

    function filterItems() {
        nickItems.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            const code = item.getAttribute('data-code').toLowerCase();
            const category = item.getAttribute('data-category');
            
            const matchSearch = name.includes(searchQuery) || code.includes(searchQuery);
            const matchCategory = currentFilter === 'all' || category === currentFilter;
            
            if (matchSearch && matchCategory) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
}

let currentItemToDelete = null;

function showDeleteModal(btn) {
    currentItemToDelete = btn.closest('tr');
    
    const modal = document.getElementById('deleteModal');
    const modalContent = modal.querySelector('div.bg-\\[\\#1a1c23\\]');
    
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = modal.querySelector('div.bg-\\[\\#1a1c23\\]');
    
    modal.classList.add('opacity-0');
    modalContent.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        currentItemToDelete = null;
    }, 300);
}

function confirmDelete() {
    if(currentItemToDelete) {
        currentItemToDelete.remove();
        closeDeleteModal();
    }
}

function showVisibilityModal(btn) {
    const row = btn.closest('tr');
    if(!row) return;
    
    const name = row.getAttribute('data-name');
    const code = row.getAttribute('data-code');
    const price = row.getAttribute('data-price');
    const game = row.getAttribute('data-game');
    const status = row.getAttribute('data-status');
    const statusClass = row.getAttribute('data-status-class') || 'text-white';
    const buyerName = row.getAttribute('data-buyer-name');
    const buyerId = row.getAttribute('data-buyer-id');
    
    document.getElementById('detail-name').textContent = name;
    document.getElementById('detail-code').textContent = code;
    document.getElementById('detail-price').textContent = price;
    document.getElementById('detail-game').textContent = game;
    
    const buyerContainer = document.getElementById('buyer-info-container');
    if(buyerName && buyerId) {
        document.getElementById('detail-buyer-name').textContent = buyerName;
        document.getElementById('detail-buyer-id').textContent = 'ID: ' + buyerId;
        buyerContainer.style.display = 'flex';
    } else {
        buyerContainer.style.display = 'none';
    }
    
    const statusEl = document.getElementById('detail-status');
    statusEl.textContent = status;
    statusEl.className = 'text-right font-bold ' + statusClass;
    
    const modal = document.getElementById('visibilityModal');
    const modalContent = modal.querySelector('div.bg-agent-card');
    
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modalContent.classList.remove('scale-95');
    }, 10);
}

function closeVisibilityModal() {
    const modal = document.getElementById('visibilityModal');
    const modalContent = modal.querySelector('div.bg-agent-card');
    
    modal.classList.add('opacity-0');
    modalContent.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }, 300);
}
