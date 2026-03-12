document.addEventListener('DOMContentLoaded', () => {
    const approveModal = document.getElementById('approveModal');
    const btnApproveList = document.querySelectorAll('.btn-approve');
    const btnConfirmApprove = document.getElementById('btnConfirmApprove');

    btnApproveList.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tr = e.target.closest('tr');
            const rowID = tr.getAttribute('data-search') ? tr.getAttribute('data-search').split(' ')[0] : 'Không xác định';

            approveModal.classList.remove('hidden');
            setTimeout(() => {
                approveModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                approveModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    btnConfirmApprove.addEventListener('click', () => {

        closeModal(approveModal);
        
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-md shadow-lg flex items-center gap-3 z-50 transform transition-all duration-300 translate-y-0 opacity-100';
        toast.innerHTML = `
            <span class="material-symbols-outlined">check_circle</span>
            <span class="font-medium">Đã duyệt nạp tiền thành công!</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('translate-y-[-1rem]', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });

    const rejectModal = document.getElementById('rejectModal');
    const btnRejectList = document.querySelectorAll('.btn-reject');
    const btnConfirmReject = document.getElementById('btnConfirmReject');
    const rejectReason = document.getElementById('rejectReason');

    btnRejectList.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            rejectReason.value = '';
            rejectReason.classList.remove('border-[#E70814]', 'ring-[#E70814]');
            
            rejectModal.classList.remove('hidden');
            setTimeout(() => {
                rejectModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                rejectModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    btnConfirmReject.addEventListener('click', () => {
        if (!rejectReason.value.trim()) {
            rejectReason.classList.add('border-[#E70814]', 'ring-1', 'ring-[#E70814]');
            rejectReason.focus();
            return;
        }

        closeModal(rejectModal);
        
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-md shadow-lg flex items-center gap-3 z-50 transform transition-all duration-300 translate-y-0 opacity-100';
        toast.innerHTML = `
            <span class="material-symbols-outlined">check_circle</span>
            <span class="font-medium">Đã từ chối giao dịch!</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('translate-y-[-1rem]', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });

    const reasonModal = document.getElementById('reasonModal');
    const btnViewReason = document.querySelectorAll('.btn-view-reason');

    btnViewReason.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            reasonModal.classList.remove('hidden');
            setTimeout(() => {
                reasonModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                reasonModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    const addFundsModal = document.getElementById('addFundsModal');
    const addFundsBtn = document.getElementById('addFundsBtn');
    const addFundsForm = document.getElementById('addFundsForm');

    if (addFundsBtn && addFundsModal) {
        addFundsBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (addFundsForm) addFundsForm.reset();
            
            addFundsModal.classList.remove('hidden');
            setTimeout(() => {
                addFundsModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                addFundsModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    }

    if (addFundsForm) {
        addFundsForm.addEventListener('submit', (e) => {
            e.preventDefault();

            closeModal(addFundsModal);
            
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-6 py-3 rounded-md shadow-lg flex items-center gap-3 z-50 transform transition-all duration-300 translate-y-0 opacity-100';
            toast.innerHTML = `
                <span class="material-symbols-outlined">check_circle</span>
                <span class="font-medium">Đã cộng tiền thủ công thành công!</span>
            `;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('translate-y-[-1rem]', 'opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        });
    }

    const btnCancels = document.querySelectorAll('.btn-cancel');
    btnCancels.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modal = btn.closest('.fixed.inset-0');
            closeModal(modal);
        });
    });

    [approveModal, rejectModal, reasonModal].forEach(modal => {
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
        }
    });

    function closeModal(modal) {
        if (!modal) return;
        const modalContent = modal.querySelector('.bg-\\[\\#20222a\\]');
        if (modalContent) {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    const filterBtn = document.getElementById('filterBtn');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const dateFilter = document.getElementById('dateFilter');
    const rows = document.querySelectorAll('.transaction-row');

    if (filterBtn) {
        filterBtn.addEventListener('click', () => {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            rows.forEach(row => {
                const searchData = row.getAttribute('data-search') ? row.getAttribute('data-search').toLowerCase() : '';
                const rowStatus = row.getAttribute('data-status') ? row.getAttribute('data-status') : 'all';
                
                const matchSearch = searchTerm === '' || searchData.includes(searchTerm);
                const matchStatus = statusValue === 'all' || rowStatus === statusValue;
                
                if (matchSearch && matchStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') {
                filterBtn.click();
            }
        });
    }
});
