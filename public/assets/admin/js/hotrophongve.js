document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const topicFilter = document.getElementById('topicFilter');
    const filterBtn = document.getElementById('filterBtn');
    const ticketRows = document.querySelectorAll('.ticket-row');

    const replyModal = document.getElementById('replyModal');
    const deleteModal = document.getElementById('deleteModal');
    const closeTicketModal = document.getElementById('closeTicketModal');
    
    const replyForm = document.getElementById('replyForm');
    const btnConfirmDelete = document.getElementById('btnConfirmDelete');
    const btnConfirmCloseTicket = document.getElementById('btnConfirmCloseTicket');
    const btnQuickClose = document.getElementById('btnQuickClose');
    
    let currentTicketId = null;

    function showModal(modal) {
        if (!modal) return;
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        const modalContent = modal.querySelector('div.transform');
        if (modalContent) {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }
    }

    function hideModal(modal) {
        if (!modal) return;
        const modalContent = modal.querySelector('div.transform');
        if (modalContent) {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    if (filterBtn) {
        filterBtn.addEventListener('click', filterTickets);
    }

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            filterTickets();
        }
    });

    function filterTickets() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const topicValue = topicFilter.value;

        ticketRows.forEach(row => {
            const rowSearch = row.dataset.search.toLowerCase();
            const rowStatus = row.dataset.status;
            const rowTopic = row.dataset.topic;

            const matchSearch = searchTerm === '' || rowSearch.includes(searchTerm);
            const matchStatus = statusValue === 'all' || rowStatus === statusValue;
            const matchTopic = topicValue === 'all' || rowTopic === topicValue;

            if (matchSearch && matchStatus && matchTopic) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.querySelectorAll('.btn-reply').forEach(btn => {
        btn.addEventListener('click', function() {
            currentTicketId = this.dataset.id;
            document.getElementById('replyTicketId').textContent = '#' + currentTicketId;
            document.getElementById('replyCustomerName').textContent = this.dataset.customer;
            document.getElementById('replyTicketTitle').textContent = this.dataset.title;
            document.getElementById('replyContent').value = '';
            showModal(replyModal);
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            currentTicketId = this.dataset.id;
            showModal(deleteModal);
        });
    });

    document.querySelectorAll('.btn-close-ticket').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.dataset.id) {
                currentTicketId = this.dataset.id;
            }
            if(!replyModal.classList.contains('hidden')){
                hideModal(replyModal);
            }
            showModal(closeTicketModal);
        });
    });
    
    if(btnQuickClose){
        btnQuickClose.addEventListener('click', function() {
            hideModal(replyModal);
            showModal(closeTicketModal);
        });
    }

    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.fixed.inset-0');
            if (modal) hideModal(modal);
        });
    });

    document.querySelectorAll('.fixed.inset-0').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal(this);
            }
        });
    });

    if (replyForm) {
        replyForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const content = document.getElementById('replyContent').value;
            if(!content.trim()) return;
            
            if (typeof window.showToast === 'function') {
                window.showToast('Đã gửi phản hồi thành công!', 'success');
            } else {
                alert('Đã gửi phản hồi!');
            }
            
            hideModal(replyModal);
        });
    }

    if (btnConfirmDelete) {
        btnConfirmDelete.addEventListener('click', function() {
            const row = document.querySelector(`.ticket-row .btn-delete[data-id="${currentTicketId}"]`).closest('tr');
            if (row) {
                row.remove();
            }
            
            hideModal(deleteModal);
            
            if (typeof window.showToast === 'function') {
                window.showToast('Gỡ vé hỗ trợ thành công!', 'success');
            }
        });
    }

    if (btnConfirmCloseTicket) {
        btnConfirmCloseTicket.addEventListener('click', function() {
            hideModal(closeTicketModal);
            
            const row = document.querySelector(`.ticket-row .btn-reply[data-id="${currentTicketId}"]`).closest('tr');
            if (row) {
                row.dataset.status = 'closed';
                const statusTd = row.querySelectorAll('td')[4];
                if (statusTd) {
                    statusTd.innerHTML = '<span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">Đã đóng</span>';
                }
            }
            
            if (typeof window.showToast === 'function') {
                window.showToast('Vé đã được đóng thành công!', 'success');
            }
        });
    }
});
