document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let currentAccountId = null;

    // --- Approve Modal Logic ---
    const approveBtns = document.querySelectorAll('.btn-approve');
    const approveModal = document.getElementById('approveModal');
    const approveBtnCancel = approveModal?.querySelector('.btn-cancel');
    const approveNickId = document.getElementById('approveNickId');
    const confirmApproveBtn = document.getElementById('confirmApproveBtn');

    if (approveBtns && approveModal) {
        approveBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                currentAccountId = this.getAttribute('data-id');
                if(approveNickId) approveNickId.textContent = '#SC-' + currentAccountId;

                approveModal.classList.remove('hidden');
                setTimeout(() => {
                    approveModal.children[0].classList.remove('scale-95', 'opacity-0');
                    approveModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closeApproveModal() {
        if (!approveModal) return;
        approveModal.children[0].classList.remove('scale-100', 'opacity-100');
        approveModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            approveModal.classList.add('hidden');
            currentAccountId = null;
        }, 300);
    }

    if (approveBtnCancel) {
        approveBtnCancel.addEventListener('click', closeApproveModal);
    }
    
    if (approveModal) {
        approveModal.addEventListener('click', function(e) {
            if (e.target === approveModal) {
                closeApproveModal();
            }
        });
    }

    if (confirmApproveBtn) {
        confirmApproveBtn.addEventListener('click', function() {
            if (!currentAccountId) return;
            
            const originalText = confirmApproveBtn.innerText;
            confirmApproveBtn.innerText = 'Đang xử lý...';
            confirmApproveBtn.disabled = true;

            fetch(`/admin/kiem-duyet-nick/${currentAccountId}/approve`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showToast('Lỗi: ' + (data.message || 'Không thể duyệt'), 'error');
                    confirmApproveBtn.innerText = originalText;
                    confirmApproveBtn.disabled = false;
                }
            })
            .catch(err => {
                window.showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                confirmApproveBtn.innerText = originalText;
                confirmApproveBtn.disabled = false;
            });
        });
    }

    // --- Reject Modal Logic ---
    const rejectBtns = document.querySelectorAll('.btn-reject');
    const rejectModal = document.getElementById('rejectModal');
    const rejectBtnCancel = rejectModal?.querySelector('.btn-cancel');
    const rejectNickIdDisplay = document.getElementById('rejectNickIdDisplay');
    const confirmRejectBtn = document.getElementById('confirmRejectBtn');
    const rejectReasonInput = rejectModal?.querySelector('textarea');

    if (rejectBtns && rejectModal) {
        rejectBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                currentAccountId = this.getAttribute('data-id');
                if(rejectNickIdDisplay) rejectNickIdDisplay.textContent = 'Mã SC: #SC-' + currentAccountId;
                if(rejectReasonInput) rejectReasonInput.value = ''; // Reset reason

                rejectModal.classList.remove('hidden');
                setTimeout(() => {
                    rejectModal.children[0].classList.remove('scale-95', 'opacity-0');
                    rejectModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closeRejectModal() {
        if (!rejectModal) return;
        rejectModal.children[0].classList.remove('scale-100', 'opacity-100');
        rejectModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            rejectModal.classList.add('hidden');
            currentAccountId = null;
        }, 300);
    }

    if (rejectBtnCancel) {
        rejectBtnCancel.addEventListener('click', closeRejectModal);
    }
    
    if (rejectModal) {
        rejectModal.addEventListener('click', function(e) {
            if (e.target === rejectModal) {
                closeRejectModal();
            }
        });
    }

    if (confirmRejectBtn) {
        confirmRejectBtn.addEventListener('click', function() {
            if (!currentAccountId) return;

            const reason = rejectReasonInput.value.trim();
            if (!reason) {
                window.showToast('Vui lòng nhập lý do từ chối!', 'warning');
                rejectReasonInput.focus();
                return;
            }
            
            const originalText = confirmRejectBtn.innerText;
            confirmRejectBtn.innerText = 'Đang xử lý...';
            confirmRejectBtn.disabled = true;

            fetch(`/admin/kiem-duyet-nick/${currentAccountId}/reject`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ reason: reason })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showToast('Lỗi: ' + (data.message || 'Không thể từ chối'), 'error');
                    confirmRejectBtn.innerText = originalText;
                    confirmRejectBtn.disabled = false;
                }
            })
            .catch(err => {
                window.showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                confirmRejectBtn.innerText = originalText;
                confirmRejectBtn.disabled = false;
            });
        });
    }
});
