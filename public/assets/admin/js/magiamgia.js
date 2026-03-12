document.addEventListener('DOMContentLoaded', function() {
    const addCouponBtn = document.getElementById('addCouponBtn');
    const couponModal = document.getElementById('couponModal');
    const deleteModal = document.getElementById('deleteModal');
    const cancelBtns = document.querySelectorAll('.btn-cancel');
    const cancelDeleteBtns = document.querySelectorAll('.btn-cancel-delete');
    const editBtns = document.querySelectorAll('.btn-edit-coupon');
    const deleteBtns = document.querySelectorAll('.btn-delete-coupon');
    const couponForm = document.getElementById('couponForm');
    const modalTitle = document.getElementById('modalTitle');
    
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const filterBtn = document.getElementById('filterBtn');
    const couponRows = document.querySelectorAll('.coupon-row');

    let isEditing = false;
    let currentRow = null;
    let rowToDelete = null;

    function filterCoupons() {
        if (!filterBtn) return;
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusVal = statusFilter.value;

        couponRows.forEach(row => {
            const rowSearch = row.getAttribute('data-search').toLowerCase();
            const rowStatus = row.getAttribute('data-status');
            
            const matchSearch = rowSearch.includes(searchTerm);
            const matchStatus = statusVal === 'all' || rowStatus === statusVal;

            if (matchSearch && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (filterBtn) {
        filterBtn.addEventListener('click', filterCoupons);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') filterCoupons();
        });
    }

    function openModal(modal) {
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        modal.classList.add('show');
        modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
        modal.querySelector('div').classList.add('scale-100', 'opacity-100');
    }

    function closeModal(modal) {
        modal.querySelector('div').classList.remove('scale-100', 'opacity-100');
        modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.remove('show');
            modal.classList.add('hidden');
        }, 300);
    }

    if (addCouponBtn) {
        addCouponBtn.addEventListener('click', () => {
            isEditing = false;
            modalTitle.innerHTML = '<span class="material-symbols-outlined text-[#E70814]">local_activity</span> Thêm Mã Giảm Giá Mới';
            couponForm.reset();
            openModal(couponModal);
        });
    }

    editBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            isEditing = true;
            currentRow = this.closest('tr');
            modalTitle.innerHTML = '<span class="material-symbols-outlined text-[#E70814]">local_activity</span> Cập Nhật Mã Giảm Giá';
            
            const codeCell = currentRow.querySelector('td:nth-child(2)');
            document.getElementById('couponCode').value = codeCell ? codeCell.textContent.trim() : '';
            
            openModal(couponModal);
        });
    });

    cancelBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(couponModal);
        });
    });

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            rowToDelete = this.closest('tr');
            openModal(deleteModal);
        });
    });

    cancelDeleteBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(deleteModal);
            rowToDelete = null;
        });
    });

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', () => {
            if (rowToDelete) {
                rowToDelete.remove();
                closeModal(deleteModal);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    background: '#13131A',
                    color: '#fff',
                    iconColor: '#10b981'
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Đã xóa mã giảm giá thành công'
                });
            }
        });
    }

    if (couponForm) {
        couponForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            closeModal(couponModal);
            
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#13131A',
                color: '#fff',
                iconColor: '#10b981'
            });
            
            Toast.fire({
                icon: 'success',
                title: isEditing ? 'Cập nhật mã giảm giá thành công' : 'Thêm mã giảm giá thành công'
            });
        });
    }
});
