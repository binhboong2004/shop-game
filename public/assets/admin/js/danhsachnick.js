document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const gameFilter = document.getElementById('gameFilter');
    const filterBtn = document.getElementById('filterBtn');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function filterData() {
        const searchTerm = searchInput ? searchInput.value.trim() : '';
        const statusTerm = statusFilter ? statusFilter.value : 'all';
        const gameTerm = gameFilter ? gameFilter.value : 'all';

        const params = new URLSearchParams();
        if (searchTerm) params.append('search', searchTerm);
        if (statusTerm && statusTerm !== 'all') params.append('status', statusTerm);
        if (gameTerm && gameTerm !== 'all') params.append('game', gameTerm);

        window.location.href = `/admin/danh-sach-nick?${params.toString()}`;
    }

    if(filterBtn) {
        filterBtn.addEventListener('click', filterData);
    }

    if(searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') filterData();
        });
    }

    // Modal Variables
    const removeModal = document.getElementById('removeModal');
    const toggleStatusModal = document.getElementById('toggleStatusModal');
    let currentActionId = null;
    let currentActionType = null; // 'hide', 'show', 'delete'

    function showModal(modal) {
        if(modal) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.children[0].classList.remove('scale-95', 'opacity-0');
                modal.children[0].classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    }

    function hideModal(modal) {
        if(modal) {
            modal.children[0].classList.remove('scale-100', 'opacity-100');
            modal.children[0].classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    }

    // Close Modals on cancel or clicking outside
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', function() {
            const modal = this.closest('.fixed.inset-0');
            hideModal(modal);
        });
    });

    document.querySelectorAll('.fixed.inset-0').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal(this);
            }
        });
    });

    // Delete Nick
    const btnRemoveNicks = document.querySelectorAll('.btn-remove-nick');
    const confirmDeleteBtn = removeModal ? removeModal.querySelector('.bg-gray-600') : null;
    
    btnRemoveNicks.forEach(btn => {
        btn.addEventListener('click', function() {
            currentActionId = this.getAttribute('data-id');
            showModal(removeModal);
        });
    });

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if(!currentActionId) return;

            const originalText = confirmDeleteBtn.innerText;
            confirmDeleteBtn.innerText = 'Đang xử lý...';
            confirmDeleteBtn.disabled = true;

            fetch(`/admin/quan-ly-nick/${currentActionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                hideModal(removeModal);
                if (data.success) {
                    if (window.showToast) window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    if (window.showToast) window.showToast(data.message || 'Lỗi khi xóa', 'error');
                }
            })
            .catch(err => {
                hideModal(removeModal);
                if (window.showToast) window.showToast('Lỗi mạng', 'error');
            })
            .finally(() => {
                confirmDeleteBtn.innerText = originalText;
                confirmDeleteBtn.disabled = false;
            });
        });
    }

    // Toggle Status
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleTitle = document.getElementById('toggleTitle');
    const toggleMessage = document.getElementById('toggleMessage');
    const toggleConfirmBtn = document.getElementById('toggleConfirmBtn');

    function openToggleModal(id, action) {
        currentActionId = id;
        currentActionType = action;

        if (action === 'hide') {
            toggleIcon.textContent = 'visibility_off';
            toggleIcon.parentElement.className = 'w-16 h-16 rounded-full bg-yellow-500/10 text-yellow-500 flex items-center justify-center mx-auto mb-4 border border-yellow-500/20';
            toggleTitle.textContent = 'Xác nhận Ẩn';
            toggleMessage.textContent = 'Bạn có chắc chắn muốn ẩn nick này? Khách hàng sẽ không thể thấy và mua nick.';
            toggleConfirmBtn.className = 'w-full px-4 py-2.5 rounded-lg bg-yellow-600 text-white font-medium hover:bg-yellow-700 shadow-[0_2px_10px_rgba(202,138,4,0.3)] transition-colors';
            toggleConfirmBtn.textContent = 'Ẩn Ngay';
        } else {
            toggleIcon.textContent = 'visibility';
            toggleIcon.parentElement.className = 'w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto mb-4 border border-emerald-500/20';
            toggleTitle.textContent = 'Xác nhận Hiện';
            toggleMessage.textContent = 'Bạn có chắc chắn muốn hiện nick này? Khách hàng sẽ có thể thấy và mua nick bình thường.';
            toggleConfirmBtn.className = 'w-full px-4 py-2.5 rounded-lg bg-emerald-500 text-white font-medium hover:bg-emerald-600 shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-colors';
            toggleConfirmBtn.textContent = 'Hiện Ngay';
        }
        showModal(toggleStatusModal);
    }

    document.querySelectorAll('.btn-status-toggle, .btn-hide-nick').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const action = this.getAttribute('data-action') || (this.getAttribute('data-current') === 'pending_approval' ? 'show' : 'hide');
            openToggleModal(id, action);
        });
    });

    if (toggleConfirmBtn) {
        toggleConfirmBtn.addEventListener('click', function() {
            if(!currentActionId) return;

            const originalText = toggleConfirmBtn.innerText;
            toggleConfirmBtn.innerText = 'Đang xử lý...';
            toggleConfirmBtn.disabled = true;

            fetch(`/admin/quan-ly-nick/${currentActionId}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                hideModal(toggleStatusModal);
                if (data.success) {
                    if (window.showToast) window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    if (window.showToast) window.showToast(data.message || 'Lỗi khi thay đổi trạng thái', 'error');
                }
            })
            .catch(err => {
                hideModal(toggleStatusModal);
                if (window.showToast) window.showToast('Lỗi mạng', 'error');
            })
            .finally(() => {
                toggleConfirmBtn.innerText = originalText;
                toggleConfirmBtn.disabled = false;
            });
        });
    }

    // Cập nhật lại phần chỉnh sửa Nick
    const btnEditNicks = document.querySelectorAll('.btn-edit-nick');
    btnEditNicks.forEach((btn) => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if(id) {
                window.location.href = `/admin/sua-nick/${id}`;
            }
        });
    });
});
