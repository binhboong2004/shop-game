// Global functions to be accessible from onclick attributes
window.openAddModal = function() {
    const modal = document.getElementById('modalWheel');
    const form = document.getElementById('formWheel');
    const imgPreview = document.getElementById('imgPreview');
    const imgPlaceholder = document.getElementById('imgPlaceholder');
    const title = document.getElementById('modalTitle');
    
    if (modal && form) {
        title.textContent = 'Thêm Vòng Quay Mới';
        form.reset();
        document.getElementById('wheelId').value = '';
        
        if (imgPreview) imgPreview.classList.add('hidden');
        if (imgPlaceholder) imgPlaceholder.classList.remove('hidden');
        
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Lock scroll
    }
};

window.closeModal = function() {
    const modal = document.getElementById('modalWheel');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Unlock scroll
    }
};

window.editWheel = function(id) {
    fetch(ROUTES.edit.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            const modal = document.getElementById('modalWheel');
            const imgPreview = document.getElementById('imgPreview');
            const imgPlaceholder = document.getElementById('imgPlaceholder');
            
            document.getElementById('modalTitle').textContent = 'Chỉnh Sửa Vòng Quay';
            document.getElementById('wheelId').value = data.id;
            document.getElementById('wheelName').value = data.name;
            document.getElementById('wheelGame').value = data.game_id;
            document.getElementById('wheelPrice').value = data.price;
            document.getElementById('wheelDesc').value = data.description || '';
            
            const statusRadios = document.getElementsByName('status');
            statusRadios.forEach(radio => {
                if (radio.value == data.status) radio.checked = true;
            });

            if (data.image) {
                if (imgPreview) {
                    imgPreview.src = '/storage/' + data.image;
                    imgPreview.classList.remove('hidden');
                }
                if (imgPlaceholder) imgPlaceholder.classList.add('hidden');
            } else {
                if (imgPreview) imgPreview.classList.add('hidden');
                if (imgPlaceholder) imgPlaceholder.classList.remove('hidden');
            }

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
};

window.toggleStatus = function(id) {
    fetch(ROUTES.toggle.replace(':id', id), {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (window.showToast) window.showToast(data.message, 'success');
            setTimeout(() => location.reload(), 500);
        }
    });
};

window.deleteWheel = function(id) {
    if (confirm('Bạn có chắc chắn muốn xóa vòng quay này không?')) {
        fetch(ROUTES.delete.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.showToast) window.showToast(data.message, 'success');
                setTimeout(() => location.reload(), 500);
            }
        });
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const formWheel = document.getElementById('formWheel');
    const wheelImage = document.getElementById('wheelImage');
    const searchWheel = document.getElementById('searchWheel');
    const filterStatus = document.getElementById('filterStatus');
    const wheelItems = document.querySelectorAll('.wheel-item');

    // Image Preview
    wheelImage?.addEventListener('change', function(e) {
        const imgPreview = document.getElementById('imgPreview');
        const imgPlaceholder = document.getElementById('imgPlaceholder');
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (imgPreview) {
                    imgPreview.src = e.target.result;
                    imgPreview.classList.remove('hidden');
                }
                if (imgPlaceholder) imgPlaceholder.classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Search and Filter
    const filterWheels = () => {
        const searchText = searchWheel.value.toLowerCase();
        const statusValue = filterStatus.value;

        wheelItems.forEach(item => {
            const name = item.dataset.name.toLowerCase();
            const status = item.dataset.status;

            const matchesSearch = name.includes(searchText);
            const matchesStatus = statusValue === "" || status === statusValue;

            if (matchesSearch && matchesStatus) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    };

    searchWheel?.addEventListener('input', filterWheels);
    filterStatus?.addEventListener('change', filterWheels);

    // Form Submit
    formWheel?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = document.getElementById('wheelId').value;
        const url = id ? ROUTES.update.replace(':id', id) : ROUTES.store;
        const formData = new FormData(this);

        const btnSave = document.getElementById('btnSaveWheel');
        btnSave.disabled = true;
        const originalText = btnSave.textContent;
        btnSave.innerHTML = '<span class="animate-spin inline-block size-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Đang lưu...';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (window.showToast) window.showToast(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                if (window.showToast) window.showToast(data.message || 'Có lỗi xảy ra', 'error');
                btnSave.disabled = false;
                btnSave.textContent = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (window.showToast) window.showToast('Lỗi hệ thống!', 'error');
            btnSave.disabled = false;
            btnSave.textContent = originalText;
        });
    });
});
