document.addEventListener('DOMContentLoaded', function() {
    const deleteBtns = document.querySelectorAll('.btn-delete-agent');
    const confirmModal = document.getElementById('confirmModal');
    const btnCancel = confirmModal?.querySelector('.btn-cancel');

    const unlockModal = document.getElementById('unlockModal');
    const unlockBtnCancel = unlockModal?.querySelector('.btn-cancel');
    if(deleteBtns && confirmModal) {
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('lockForm').action = `/admin/dai-ly/${id}/lock`;
                confirmModal.classList.remove('hidden');
                setTimeout(() => {
                    confirmModal.children[0].classList.remove('scale-95', 'opacity-0');
                    confirmModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    const unlockBtns = document.querySelectorAll('.btn-unlock-agent');
    if(unlockBtns && unlockModal) {
        unlockBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('unlockForm').action = `/admin/dai-ly/${id}/unlock`;
                unlockModal.classList.remove('hidden');
                setTimeout(() => {
                    unlockModal.children[0].classList.remove('scale-95', 'opacity-0');
                    unlockModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closeModal() {
        if(!confirmModal) return;
        confirmModal.children[0].classList.remove('scale-100', 'opacity-100');
        confirmModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            confirmModal.classList.add('hidden');
        }, 300);
    }

    if(btnCancel) {
        btnCancel.addEventListener('click', closeModal);
    }
    
    if(confirmModal) {
        confirmModal.addEventListener('click', function(e) {
            if(e.target === confirmModal) {
                closeModal();
            }
        });
    }

    function closeUnlockModal() {
        if(!unlockModal) return;
        unlockModal.children[0].classList.remove('scale-100', 'opacity-100');
        unlockModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            unlockModal.classList.add('hidden');
        }, 300);
    }

    if(unlockBtnCancel) {
        unlockBtnCancel.addEventListener('click', closeUnlockModal);
    }
    
    if(unlockModal) {
        unlockModal.addEventListener('click', function(e) {
            if(e.target === unlockModal) {
                closeUnlockModal();
            }
        });
    }

    const statusToggles = document.querySelectorAll('.btn-status-toggle');
    statusToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const id = this.dataset.id;
            
            if (action === 'lock' && confirmModal) {
                document.getElementById('lockForm').action = `/admin/dai-ly/${id}/lock`;
                confirmModal.classList.remove('hidden');
                setTimeout(() => {
                    confirmModal.children[0].classList.remove('scale-95', 'opacity-0');
                    confirmModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            } else if (action === 'unlock' && unlockModal) {
                document.getElementById('unlockForm').action = `/admin/dai-ly/${id}/unlock`;
                unlockModal.classList.remove('hidden');
                setTimeout(() => {
                    unlockModal.children[0].classList.remove('scale-95', 'opacity-0');
                    unlockModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        });
    });

    const approveBtns = document.querySelectorAll('.btn-approve-agent');
    const approveModal = document.getElementById('approveModal');
    const approveBtnCancel = approveModal?.querySelector('.btn-cancel');

    if(approveBtns && approveModal) {
        approveBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('approveForm').action = `/admin/dai-ly/${id}/approve`;
                approveModal.classList.remove('hidden');
                setTimeout(() => {
                    approveModal.children[0].classList.remove('scale-95', 'opacity-0');
                    approveModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closeApproveModal() {
        if(!approveModal) return;
        approveModal.children[0].classList.remove('scale-100', 'opacity-100');
        approveModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            approveModal.classList.add('hidden');
        }, 300);
    }

    if(approveBtnCancel) {
        approveBtnCancel.addEventListener('click', closeApproveModal);
    }
    
    if(approveModal) {
        approveModal.addEventListener('click', function(e) {
            if(e.target === approveModal) {
                closeApproveModal();
            }
        });
    }

    const rejectBtns = document.querySelectorAll('.btn-reject-agent');
    const rejectModal = document.getElementById('rejectModal');
    const rejectBtnCancel = rejectModal?.querySelector('.btn-cancel');

    if(rejectBtns && rejectModal) {
        rejectBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('rejectForm').action = `/admin/dai-ly/${id}/reject`;
                rejectModal.classList.remove('hidden');
                setTimeout(() => {
                    rejectModal.children[0].classList.remove('scale-95', 'opacity-0');
                    rejectModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closeRejectModal() {
        if(!rejectModal) return;
        rejectModal.children[0].classList.remove('scale-100', 'opacity-100');
        rejectModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            rejectModal.classList.add('hidden');
        }, 300);
    }

    if(rejectBtnCancel) {
        rejectBtnCancel.addEventListener('click', closeRejectModal);
    }
    
    if(rejectModal) {
        rejectModal.addEventListener('click', function(e) {
            if(e.target === rejectModal) {
                closeRejectModal();
            }
        });
    }

    const promoteBtns = document.querySelectorAll('.btn-role-agent');
    const promoteModal = document.getElementById('promoteModal');
    const promoteBtnCancel = promoteModal?.querySelector('.btn-cancel');

    if(promoteBtns && promoteModal) {
        promoteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('promoteForm').action = `/admin/dai-ly/${id}/promote`;
                promoteModal.classList.remove('hidden');
                setTimeout(() => {
                    promoteModal.children[0].classList.remove('scale-95', 'opacity-0');
                    promoteModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closePromoteModal() {
        if(!promoteModal) return;
        promoteModal.children[0].classList.remove('scale-100', 'opacity-100');
        promoteModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            promoteModal.classList.add('hidden');
        }, 300);
    }

    if(promoteBtnCancel) {
        promoteBtnCancel.addEventListener('click', closePromoteModal);
    }
    
    if(promoteModal) {
        promoteModal.addEventListener('click', function(e) {
            if(e.target === promoteModal) {
                closePromoteModal();
            }
        });
    }

    const removeBtns = document.querySelectorAll('.btn-remove-agent');
    const removeModal = document.getElementById('removeModal');
    const removeBtnCancel = removeModal?.querySelector('.btn-cancel');

    if(removeBtns && removeModal) {
        removeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('removeForm').action = `/admin/dai-ly/${id}`;
                removeModal.classList.remove('hidden');
                setTimeout(() => {
                    removeModal.children[0].classList.remove('scale-95', 'opacity-0');
                    removeModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
        });
    }

    function closeRemoveModal() {
        if(!removeModal) return;
        removeModal.children[0].classList.remove('scale-100', 'opacity-100');
        removeModal.children[0].classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            removeModal.classList.add('hidden');
        }, 300);
    }

    if(removeBtnCancel) {
        removeBtnCancel.addEventListener('click', closeRemoveModal);
    }
    
    if(removeModal) {
        removeModal.addEventListener('click', function(e) {
            if(e.target === removeModal) {
                closeRemoveModal();
            }
        });
    }

    const searchInput = document.getElementById('agentSearchInput');
    const statusFilter = document.getElementById('agentStatusFilter');
    const sortFilter = document.getElementById('agentSortFilter');
    const filterBtn = document.getElementById('agentFilterBtn');
    const tableBody = document.querySelector('tbody');
    let rows = Array.from(document.querySelectorAll('.agent-row'));

    function applyFilters() {
        if (!searchInput || !statusFilter || !sortFilter) return;

        const searchTerm = searchInput.value.toLowerCase().trim();
        const status = statusFilter.value;
        const sortBy = sortFilter.value;

        rows.forEach(row => {
            const searchData = row.dataset.search.toLowerCase();
            const rowStatus = row.dataset.status;

            const matchSearch = searchData.includes(searchTerm);
            const matchStatus = (status === 'all' || status === rowStatus);

            if (matchSearch && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        let visibleRows = rows.filter(row => row.style.display !== 'none');

        if (sortBy === 'balance' || sortBy === 'revenue') {
            visibleRows.sort((a, b) => parseInt(b.dataset.balance) - parseInt(a.dataset.balance));
        } else if (sortBy === 'new') {
            visibleRows.sort((a, b) => new Date(b.dataset.date).getTime() - new Date(a.dataset.date).getTime());
        }

        visibleRows.forEach(row => tableBody.appendChild(row));
    }

    if (filterBtn) {
        filterBtn.addEventListener('click', applyFilters);
    }

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', applyFilters);
    }
    if (sortFilter) {
        sortFilter.addEventListener('change', applyFilters);
    }

    const avatarInput = document.getElementById('avatarInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const pageTitleAdd = document.querySelector('h2');
    const submitBtnTextAdd = document.getElementById('submitBtnText');
    const breadcrumbCurrentAdd = document.querySelector('ol.list-reset li:last-child');

    if (avatarInput && fileNameDisplay) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.classList.remove('text-gray-400');
                fileNameDisplay.classList.add('text-white');
            } else {
                fileNameDisplay.textContent = 'Chọn ảnh tải lên...';
                fileNameDisplay.classList.add('text-gray-400');
                fileNameDisplay.classList.remove('text-white');
            }
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    const editId = urlParams.get('edit_id');

    if (editId && pageTitleAdd && breadcrumbCurrentAdd) {
        pageTitleAdd.textContent = 'Chỉnh sửa Đại lý';
        breadcrumbCurrentAdd.textContent = 'Chỉnh sửa';
        if (submitBtnTextAdd) submitBtnTextAdd.textContent = 'Cập nhật Đại lý';

        const name = urlParams.get('name') || '';
        const email = urlParams.get('email') || '';
        const phone = urlParams.get('phone') || '';
        const level = urlParams.get('level') || '1';
        const discount = urlParams.get('discount') || '15';
        const status = urlParams.get('status') || '';
        const bal = urlParams.get('balance') || '0';

        const nameInput = document.querySelector('input[name="name"]');
        const emailInput = document.querySelector('input[name="email"]');
        const phoneInput = document.querySelector('input[name="phone"]');
        const levelInput = document.querySelector('input[name="level"]');
        const discountInput = document.querySelector('input[name="discount"]');
        const balanceInput = document.querySelector('input[name="balance"]');
        const activeCheckbox = document.getElementById('isActiveCheckbox');
        
        const pwInput = document.querySelector('input[name="password"]');
        const pwConfirmInput = document.querySelector('input[name="password_confirmation"]');

        if (nameInput) nameInput.value = name;
        if (emailInput) emailInput.value = email;
        if (phoneInput) phoneInput.value = phone;
        if (levelInput) levelInput.value = level;
        if (discountInput) discountInput.value = discount;
        if (balanceInput) balanceInput.value = bal;
        if (activeCheckbox) activeCheckbox.checked = (status === 'active');
        
        if (pwInput) {
            pwInput.required = false;
            pwInput.placeholder = "Bỏ trống nếu không đổi mật khẩu";
        }
        if (pwConfirmInput) {
            pwConfirmInput.required = false;
            pwConfirmInput.placeholder = "Bỏ trống nếu không đổi mật khẩu";
        }
    }
});
