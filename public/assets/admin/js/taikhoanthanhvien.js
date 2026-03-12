document.addEventListener('DOMContentLoaded', function() {
    const deleteBtns = document.querySelectorAll('.btn-delete-user');
    const confirmModal = document.getElementById('confirmModal');
    const btnCancel = confirmModal?.querySelector('.btn-cancel');

    const unlockModal = document.getElementById('unlockModal');
    const unlockBtnCancel = unlockModal?.querySelector('.btn-cancel');
    if(deleteBtns && confirmModal) {
        deleteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('lockForm');
                if (form) form.action = `/admin/thanh-vien/${id}/lock`;
                confirmModal.classList.remove('hidden');
                setTimeout(() => {
                    confirmModal.children[0].classList.remove('scale-95', 'opacity-0');
                    confirmModal.children[0].classList.add('scale-100', 'opacity-100');
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
    
    const statusToggles = document.querySelectorAll('.btn-status-toggle');
    statusToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const id = this.dataset.id;
            
            if (action === 'lock') {
                const form = document.getElementById('lockForm');
                if (form) form.action = `/admin/thanh-vien/${id}/lock`;
                confirmModal.classList.remove('hidden');
                setTimeout(() => {
                    confirmModal.children[0].classList.remove('scale-95', 'opacity-0');
                    confirmModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            } else if (action === 'unlock') {
                const form = document.getElementById('unlockForm');
                if (form) form.action = `/admin/thanh-vien/${id}/unlock`;
                unlockModal.classList.remove('hidden');
                setTimeout(() => {
                    unlockModal.children[0].classList.remove('scale-95', 'opacity-0');
                    unlockModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            }
        });
    });

    // Remove hacky edit button listener, we will use direct href

    const unlockBtns = document.querySelectorAll('.btn-unlock-user');
    if(unlockBtns && unlockModal) {
        unlockBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('unlockForm');
                if (form) form.action = `/admin/thanh-vien/${id}/unlock`;
                unlockModal.classList.remove('hidden');
                setTimeout(() => {
                    unlockModal.children[0].classList.remove('scale-95', 'opacity-0');
                    unlockModal.children[0].classList.add('scale-100', 'opacity-100');
                }, 10);
            });
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

    const removeBtns = document.querySelectorAll('.btn-remove-user');
    const removeModal = document.getElementById('removeModal');
    const removeBtnCancel = removeModal?.querySelector('.btn-cancel');

    if(removeBtns && removeModal) {
        removeBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('removeForm');
                if (form) form.action = `/admin/thanh-vien/${id}`;
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

    const promoteBtns = document.querySelectorAll('.btn-promote-user');
    const promoteModal = document.getElementById('promoteModal');
    const promoteBtnCancel = promoteModal?.querySelector('.btn-cancel');

    if(promoteBtns && promoteModal) {
        promoteBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('promoteForm');
                if (form) form.action = `/admin/thanh-vien/${id}/promote`;
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

    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    const filterBtn = document.getElementById('filterBtn');
    const tableBody = document.querySelector('tbody');
    let rows = Array.from(document.querySelectorAll('.user-row'));

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

        if (sortBy === 'balance') {
            visibleRows.sort((a, b) => {
                const balA = parseInt(a.dataset.balance);
                const balB = parseInt(b.dataset.balance);
                return balB - balA;
            });
        } else if (sortBy === 'new') {
            visibleRows.sort((a, b) => {
                const dateA = new Date(a.dataset.date).getTime();
                const dateB = new Date(b.dataset.date).getTime();
                return dateB - dateA;
            });
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

    if (editId && pageTitleAdd && breadcrumbCurrentAdd && submitBtnTextAdd) {
        pageTitleAdd.textContent = 'Chỉnh sửa Thành viên';
        breadcrumbCurrentAdd.textContent = 'Chỉnh sửa';
        submitBtnTextAdd.textContent = 'Cập nhật Thành viên';

        const name = urlParams.get('name') || '';
        const email = urlParams.get('email') || '';
        const phone = urlParams.get('phone') || '';
        const bal = urlParams.get('balance') || '0';
        const status = urlParams.get('status') || '';

        const nameInput = document.querySelector('input[name="name"]');
        const emailInput = document.querySelector('input[name="email"]');
        const phoneInput = document.querySelector('input[name="phone"]');
        const balanceInput = document.querySelector('input[name="balance"]');
        const activeCheckbox = document.getElementById('isActiveCheckbox');

        const pwInput = document.querySelector('input[name="password"]');
        const pwConfirmInput = document.querySelector('input[name="password_confirmation"]');

        if (nameInput) nameInput.value = name;
        if (emailInput) emailInput.value = email;
        if (phoneInput) phoneInput.value = phone;
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
