document.addEventListener('DOMContentLoaded', () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Helper to show toast
    const showToast = (message, type = 'success') => {
        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-emerald-600' : 'bg-[#E70814]';
        toast.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-md shadow-lg flex items-center gap-3 z-[9999] transform transition-all duration-300 translate-y-0 opacity-100`;
        toast.innerHTML = `
            <span class="material-symbols-outlined">${type === 'success' ? 'check_circle' : 'error'}</span>
            <span class="font-medium">${message}</span>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('translate-y-[-1rem]', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    };

    // --- Duyệt Nạp Tiền ---
    const approveModal = document.getElementById('approveModal');
    const btnConfirmApprove = document.getElementById('btnConfirmApprove');
    let currentApproveId = null;

    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const btnEl = e.target.closest('.btn-approve');
            currentApproveId = btnEl.dataset.id;
            
            // Update Modal Info
            approveModal.querySelector('.text-sm.font-bold.text-white').textContent = '#' + currentApproveId;
            approveModal.querySelector('.text-blue-400').textContent = btnEl.dataset.user;
            approveModal.querySelector('.text-emerald-400').textContent = btnEl.dataset.amount;

            approveModal.classList.remove('hidden');
            setTimeout(() => {
                approveModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                approveModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    btnConfirmApprove.addEventListener('click', async () => {
        if (!currentApproveId) return;
        
        btnConfirmApprove.disabled = true;
        btnConfirmApprove.textContent = 'Đang xử lý...';

        try {
            const response = await fetch(`/admin/quan-ly-nap-tien/${currentApproveId}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            const data = await response.json();

            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(data.message || 'Lỗi khi duyệt nạp tiền', 'error');
                btnConfirmApprove.disabled = false;
                btnConfirmApprove.textContent = 'Xác Nhận Duyệt';
            }
        } catch (error) {
            console.error(error);
            showToast('Lỗi hệ thống!', 'error');
            btnConfirmApprove.disabled = false;
            btnConfirmApprove.textContent = 'Xác Nhận Duyệt';
        }
    });

    // --- Từ Chối Nạp Tiền ---
    const rejectModal = document.getElementById('rejectModal');
    const btnConfirmReject = document.getElementById('btnConfirmReject');
    const rejectReason = document.getElementById('rejectReason');
    let currentRejectId = null;

    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            currentRejectId = e.target.closest('.btn-reject').dataset.id;
            rejectReason.value = '';
            
            rejectModal.classList.remove('hidden');
            setTimeout(() => {
                rejectModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                rejectModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    btnConfirmReject.addEventListener('click', async () => {
        const reason = rejectReason.value.trim();
        if (!reason) {
            rejectReason.classList.add('border-[#E70814]');
            return;
        }

        btnConfirmReject.disabled = true;
        btnConfirmReject.textContent = 'Đang xử lý...';

        try {
            const response = await fetch(`/admin/quan-ly-nap-tien/${currentRejectId}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ reason })
            });
            const data = await response.json();

            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showToast(data.message || 'Lỗi khi từ chối', 'error');
                btnConfirmReject.disabled = false;
                btnConfirmReject.textContent = 'Xác Nhận Từ Chối';
            }
        } catch (error) {
            console.error(error);
            showToast('Lỗi hệ thống!', 'error');
        }
    });

    // --- Xem Lý Do (Trực tiếp) ---
    document.querySelectorAll('.btn-view-reason-direct').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const reason = e.target.dataset.reason;
            const reasonModal = document.getElementById('reasonModal');
            reasonModal.querySelector('p').textContent = `"${reason}"`;
            
            reasonModal.classList.remove('hidden');
            setTimeout(() => {
                reasonModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                reasonModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    });

    // --- Cộng Tiền Thủ Công ---
    const addFundsModal = document.getElementById('addFundsModal');
    const addFundsBtn = document.getElementById('addFundsBtn');
    const addFundsForm = document.getElementById('addFundsForm');

    if (addFundsBtn) {
        addFundsBtn.addEventListener('click', () => {
            addFundsModal.classList.remove('hidden');
            setTimeout(() => {
                addFundsModal.querySelector('.bg-\\[\\#20222a\\]').classList.remove('scale-95', 'opacity-0');
                addFundsModal.querySelector('.bg-\\[\\#20222a\\]').classList.add('scale-100', 'opacity-100');
            }, 10);
        });
    }

    if (addFundsForm) {
        addFundsForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = addFundsForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;

            const payload = {
                user_identifier: document.getElementById('addFundsUser').value,
                amount: document.getElementById('addFundsAmount').value,
                reason: document.getElementById('addFundsReason').value
            };

            try {
                const response = await fetch('/admin/quan-ly-nap-tien/manual-add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();

                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showToast(data.message || 'Lỗi khi cộng tiền', 'error');
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                showToast('Lỗi hệ thống!', 'error');
                submitBtn.disabled = false;
            }
        });
    }

    // --- Bộ Lọc (Server-side) ---
    const filterBtn = document.getElementById('filterBtn');
    if (filterBtn) {
        filterBtn.addEventListener('click', () => {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;

            const url = new URL(window.location.href);
            if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
            if (status !== 'all') url.searchParams.set('status', status); else url.searchParams.delete('status');
            if (date) url.searchParams.set('date', date); else url.searchParams.delete('date');
            
            window.location.href = url.toString();
        });
    }

    // --- Đóng Modal General ---
    const closeModal = (modal) => {
        if (!modal) return;
        const modalContent = modal.querySelector('.bg-\\[\\#20222a\\]');
        if (modalContent) {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => modal.classList.add('hidden'), 300);
    };

    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.fixed.inset-0')));
    });

    document.querySelectorAll('.fixed.inset-0').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal(modal);
        });
    });
});
