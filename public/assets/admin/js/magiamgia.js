document.addEventListener('DOMContentLoaded', function() {
    const couponModal = document.getElementById('couponModal');
    const deleteModal = document.getElementById('deleteModal');
    const couponForm = document.getElementById('couponForm');
    const modalTitle = document.getElementById('modalTitle');
    const couponIdInput = document.getElementById('couponId');
    const statusCheckbox = document.getElementById('couponStatusCheckbox');
    const statusValue = document.getElementById('couponStatusValue');

    // SweetAlert Toast Mixin
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        background: '#13131A',
        color: '#fff'
    });

    function openModal(modal) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            const inner = modal.querySelector('div');
            inner.classList.remove('scale-95', 'opacity-0');
            inner.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(modal) {
        const inner = modal.querySelector('div');
        inner.classList.remove('scale-100', 'opacity-100');
        inner.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Sync checkbox with hidden status input
    if (statusCheckbox) {
        statusCheckbox.addEventListener('change', function() {
            statusValue.value = this.checked ? 'active' : 'inactive';
        });
    }

    // Add button
    document.getElementById('addCouponBtn')?.addEventListener('click', () => {
        modalTitle.innerHTML = '<span class="material-symbols-outlined text-[#E70814]">local_activity</span> Thêm Mã Giảm Giá Mới';
        couponForm.reset();
        couponIdInput.value = '';
        statusCheckbox.checked = true;
        statusValue.value = 'active';
        openModal(couponModal);
    });

    // Edit button
    document.querySelectorAll('.btn-edit-coupon').forEach(btn => {
        btn.addEventListener('click', async function() {
            const id = this.dataset.id;
            try {
                const response = await fetch(`/admin/ma-giam-gia/${id}`);
                const res = await response.json();
                if (res.success) {
                    const data = res.data;
                    modalTitle.innerHTML = '<span class="material-symbols-outlined text-[#E70814]">local_activity</span> Cập Nhật Mã Giảm Giá';
                    couponIdInput.value = data.id;
                    document.getElementById('couponCode').value = data.code;
                    document.getElementById('couponType').value = data.type;
                    document.getElementById('couponValue').value = data.value;
                    document.getElementById('couponMaxUses').value = data.max_uses;
                    document.getElementById('couponMinOrder').value = data.min_order_amount || 0;
                    document.getElementById('couponMaxDiscount').value = data.max_discount_amount || 0;
                    
                    if (data.start_date) {
                        document.getElementById('couponStartDate').value = data.start_date.substring(0, 16);
                    }
                    if (data.end_date) {
                        document.getElementById('couponEndDate').value = data.end_date.substring(0, 16);
                    }
                    
                    statusCheckbox.checked = (data.status == 1);
                    statusValue.value = data.status == 1 ? 'active' : 'inactive';
                    
                    openModal(couponModal);
                }
            } catch (e) {
                Toast.fire({ icon: 'error', title: 'Lỗi khi lấy dữ liệu!' });
            }
        });
    });

    // Submit form
    couponForm?.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = couponIdInput.value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `/admin/ma-giam-gia/${id}` : '/admin/ma-giam-gia';
        
        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => jsonData[key] = value);

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(jsonData)
            });
            const res = await response.json();
            if (res.success) {
                Toast.fire({ icon: 'success', title: res.message });
                setTimeout(() => window.location.reload(), 1000);
            } else {
                Toast.fire({ icon: 'error', title: res.message || 'Có lỗi xảy ra!' });
            }
        } catch (e) {
            Toast.fire({ icon: 'error', title: 'Lỗi hệ thống!' });
        }
    });

    // Delete
    let deleteId = null;
    document.querySelectorAll('.btn-delete-coupon').forEach(btn => {
        btn.addEventListener('click', function() {
            deleteId = this.dataset.id;
            openModal(deleteModal);
        });
    });

    document.getElementById('confirmDeleteBtn')?.addEventListener('click', async function() {
        if (!deleteId) return;
        try {
            const response = await fetch(`/admin/ma-giam-gia/${deleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            const res = await response.json();
            if (res.success) {
                Toast.fire({ icon: 'success', title: res.message });
                setTimeout(() => window.location.reload(), 1000);
            }
        } catch (e) {
            Toast.fire({ icon: 'error', title: 'Lỗi hệ thống!' });
        }
    });

    // Cancel buttons
    document.querySelectorAll('.btn-cancel, .btn-cancel-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(couponModal);
            closeModal(deleteModal);
        });
    });
});
