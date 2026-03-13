document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Helper to show toast
    const showNotice = (message, type = 'success') => {
        if (window.showToast) {
            window.showToast(message, type);
        } else {
            alert(message);
        }
    };

    // --- Filters ---
    const filterBtn = document.getElementById('filterBtn');
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;

            const url = new URL(window.location.href);
            if (search) url.searchParams.set('search', search); else url.searchParams.delete('search');
            if (status !== 'all') url.searchParams.set('status', status); else url.searchParams.delete('status');
            if (date !== 'all') url.searchParams.set('date', date); else url.searchParams.delete('date');

            window.location.href = url.toString();
        });
    }

    // --- Modal Logic ---
    function openModal(modal) {
        if (!modal) return;
        modal.classList.remove('hidden');
        setTimeout(() => {
            const content = modal.querySelector('.bg-\\[\\#20222a\\]');
            if (content) {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }
        }, 10);
    }

    function closeModal(modal) {
        if (!modal) return;
        const content = modal.querySelector('.bg-\\[\\#20222a\\]');
        if (content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // --- Actions ---
    let currentId = null;

    // Approve
    const approveModal = document.getElementById('approveModal');
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {
            currentId = this.dataset.id;
            document.getElementById('approveAgent').textContent = this.dataset.agent;
            document.getElementById('approveAmount').textContent = this.dataset.amount;
            openModal(approveModal);
        });
    });

    document.getElementById('btnConfirmApprove').addEventListener('click', async function() {
        if (!currentId) return;
        const btn = this;
        btn.disabled = true;
        btn.textContent = 'Đang xử lý...';

        try {
            const response = await fetch(`/admin/kiem-duyet-rut-tien/${currentId}/approve`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' }
            });
            const data = await response.json();
            if (data.success) {
                showNotice(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotice(data.message, 'error');
                btn.disabled = false;
                btn.textContent = 'Xác nhận Đã Chuyển';
            }
        } catch (e) {
            showNotice('Lỗi hệ thống!', 'error');
            btn.disabled = false;
            btn.textContent = 'Xác nhận Đã Chuyển';
        }
    });

    // Reject
    const rejectModal = document.getElementById('rejectModal');
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            currentId = this.dataset.id;
            document.getElementById('rejectAgent').textContent = this.dataset.agent;
            document.getElementById('rejectAmount').textContent = this.dataset.amount;
            document.getElementById('rejectReason').value = '';
            openModal(rejectModal);
        });
    });

    document.getElementById('rejectForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!currentId) return;

        const reason = document.getElementById('rejectReason').value.trim();
        const btn = document.getElementById('btnConfirmReject');
        btn.disabled = true;

        try {
            const response = await fetch(`/admin/kiem-duyet-rut-tien/${currentId}/reject`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
                body: JSON.stringify({ reason })
            });
            const data = await response.json();
            if (data.success) {
                showNotice(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotice(data.message, 'error');
                btn.disabled = false;
            }
        } catch (e) {
            showNotice('Lỗi hệ thống!', 'error');
            btn.disabled = false;
        }
    });

    // Delete
    const deleteModal = document.getElementById('deleteModal');
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            currentId = this.dataset.id;
            openModal(deleteModal);
        });
    });

    document.getElementById('btnConfirmDelete').addEventListener('click', async function() {
        if (!currentId) return;
        const btn = this;
        btn.disabled = true;

        try {
            const response = await fetch(`/admin/kiem-duyet-rut-tien/${currentId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken }
            });
            const data = await response.json();
            if (data.success) {
                showNotice(data.message, 'success');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showNotice(data.message, 'error');
                btn.disabled = false;
            }
        } catch (e) {
            showNotice('Lỗi hệ thống!', 'error');
            btn.disabled = false;
        }
    });

    // View Note/Reason
    document.querySelectorAll('.btn-view-note').forEach(btn => {
        btn.addEventListener('click', function() {
            alert("Lý do từ chối: " + this.dataset.note);
        });
    });

    // Cancel UI
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => closeModal(btn.closest('.fixed')));
    });

    document.querySelectorAll('.fixed.inset-0').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal(modal);
        });
    });
});
