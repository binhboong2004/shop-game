document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const filterBtn = document.getElementById('filterBtn');
    const rows = document.querySelectorAll('.withdraw-row');

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const dateValue = dateFilter.value;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search').toLowerCase();
            const statusData = row.getAttribute('data-status');
            const dateData = row.getAttribute('data-date');

            let matchSearch = searchData.includes(searchTerm);
            let matchStatus = statusValue === 'all' || statusData === statusValue;
            let matchDate = dateValue === 'all' || dateData === dateValue || (dateValue === 'week' && (dateData === 'today' || dateData === 'week')); // Simplified date logic

            if (matchSearch && matchStatus && matchDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (filterBtn) {
        filterBtn.addEventListener('click', applyFilters);
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
    if (dateFilter) {
        dateFilter.addEventListener('change', applyFilters);
    }

    if (statusFilter && rows.length > 0) {
        applyFilters();
    }

    const approveModal = document.getElementById('approveModal');
    const btnApproveList = document.querySelectorAll('.btn-approve');
    let currentApproveId = null;

    btnApproveList.forEach(btn => {
        btn.addEventListener('click', function() {
            currentApproveId = this.getAttribute('data-id');
            const agentName = this.getAttribute('data-agent');
            const amount = this.getAttribute('data-amount');
            
            document.getElementById('approveAgent').textContent = agentName;
            document.getElementById('approveAmount').textContent = amount;
            
            openModal(approveModal);
        });
    });

    document.getElementById('btnConfirmApprove').addEventListener('click', function() {
        if (currentApproveId) {
            if (window.showToast) {
                window.showToast('Đã duyệt yêu cầu rút tiền thành công!', 'success');
            } else {
                alert('Đã duyệt yêu cầu rút tiền thành công!');
            }
            closeModal(approveModal);
        }
    });

    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');
    const btnRejectList = document.querySelectorAll('.btn-reject');
    let currentRejectId = null;

    btnRejectList.forEach(btn => {
        btn.addEventListener('click', function() {
            currentRejectId = this.getAttribute('data-id');
            const agentName = this.getAttribute('data-agent');
            const amount = this.getAttribute('data-amount');
            
            document.getElementById('rejectAgent').textContent = agentName;
            document.getElementById('rejectAmount').textContent = amount;
            document.getElementById('rejectReason').value = '';
            
            openModal(rejectModal);
        });
    });

    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const reason = document.getElementById('rejectReason').value;
            
            if (currentRejectId && reason) {
                if (window.showToast) {
                    window.showToast('Đã từ chối yêu cầu.', 'success');
                } else {
                    alert('Đã từ chối yêu cầu. Lý do: ' + reason);
                }
                closeModal(rejectModal);
            }
        });
    }

    const deleteModal = document.getElementById('deleteModal');
    const btnDeleteList = document.querySelectorAll('.btn-delete');
    let currentDeleteId = null;

    btnDeleteList.forEach(btn => {
        btn.addEventListener('click', function() {
            currentDeleteId = this.getAttribute('data-id');
            openModal(deleteModal);
        });
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        if (currentDeleteId) {
            if (window.showToast) {
                window.showToast('Đã xóa dữ liệu thành công!', 'success');
            } else {
                alert('Đã xóa dữ liệu thành công!');
            }
            closeModal(deleteModal);
        }
    });

    function openModal(modal) {
        if (modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('active');
            }, 10);
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    const btnCancelList = document.querySelectorAll('.btn-cancel');
    btnCancelList.forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.fixed');
            closeModal(modal);
        });
    });

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
            closeModal(e.target);
        }
    });
});
