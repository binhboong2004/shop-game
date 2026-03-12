let currentDeleteId = null;

// Modal Elements
const categoryModal = document.getElementById('categoryModal');
const deleteModal = document.getElementById('deleteModal');
const modalOverlay = categoryModal?.querySelector('.glass-effect');

// Form Elements
const form = document.getElementById('categoryForm');
const categoryIdInput = document.getElementById('categoryId');
const gameSelect = document.getElementById('gameSelect');
const nameInput = document.getElementById('categoryName');
const descInput = document.getElementById('categoryDesc');
const statusSelect = document.getElementById('categoryStatus');
const imageFileInput = document.getElementById('categoryImageFile');
const imageUrlInput = document.getElementById('categoryImageUrl');
const imagePreview = document.getElementById('imagePreview');
const placeholderIcon = document.getElementById('imagePlaceholderIcon');
const submitBtnText = document.querySelector('#categorySubmitBtn span:last-child');
const modalTitleText = document.getElementById('modalTitleText');
const modalIcon = document.getElementById('modalIcon');

function animateFadeIn(element) {
    element.classList.remove('hidden');
    // small delay to allow display:block to apply before animating opacity
    setTimeout(() => {
        element.classList.remove('opacity-0');
        element.querySelector('.transform').classList.remove('scale-95');
        element.querySelector('.transform').classList.add('scale-100');
    }, 10);
}

function animateFadeOut(element) {
    element.classList.add('opacity-0');
    element.querySelector('.transform').classList.remove('scale-100');
    element.querySelector('.transform').classList.add('scale-95');
    setTimeout(() => {
        element.classList.add('hidden');
    }, 300);
}

/**
 * Open Modal - Add Mode
 */
function openAddModal() {
    form.reset();
    categoryIdInput.value = '';
    
    // Reset images preview
    imagePreview.src = '';
    imagePreview.classList.add('hidden');
    placeholderIcon.classList.remove('hidden');

    submitBtnText.textContent = 'Thêm danh mục';
    modalTitleText.textContent = 'Thêm danh mục con';
    modalIcon.textContent = 'add_circle';

    animateFadeIn(categoryModal);
}

/**
 * Open Modal - Edit Mode
 */
window.openEditModal = function(id, name, gameId, status, desc, imageUrl) {
    form.reset();
    categoryIdInput.value = id;
    nameInput.value = name;
    gameSelect.value = gameId;
    statusSelect.value = status == 1 ? 'active' : 'hidden';
    descInput.value = desc;
    
    // Process image preview
    if (imageUrl) {
        imagePreview.src = imageUrl;
        imagePreview.classList.remove('hidden');
        placeholderIcon.classList.add('hidden');
    } else {
        imagePreview.src = '';
        imagePreview.classList.add('hidden');
        placeholderIcon.classList.remove('hidden');
    }

    submitBtnText.textContent = 'Lưu thay đổi';
    modalTitleText.textContent = 'Chỉnh sửa danh mục con';
    modalIcon.textContent = 'edit_square';

    animateFadeIn(categoryModal);
};

function closeCategoryModal() {
    animateFadeOut(categoryModal);
}

/**
 * Handle form submission
 */
document.getElementById('categorySubmitBtn')?.addEventListener('click', async (e) => {
    e.preventDefault();
    
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const id = categoryIdInput.value;
    const isEdit = id !== '';
    const url = isEdit ? `/admin/quan-ly-danh-muc-con/${id}` : '/admin/quan-ly-danh-muc-con';
    const method = isEdit ? 'POST' : 'POST'; // Keep POST for both, use _method=PUT for update mapped by Laravel
    
    const formData = new FormData();
    formData.append('name', nameInput.value);
    formData.append('game_id', gameSelect.value);
    formData.append('status', statusSelect.value);
    if(descInput.value) formData.append('description', descInput.value);

    if (imageFileInput.files.length > 0) {
        formData.append('image_file', imageFileInput.files[0]);
    } else if (imageUrlInput.value) {
        formData.append('image_url', imageUrlInput.value);
    }

    if (isEdit) {
        formData.append('_method', 'PUT'); // Laravel trick
    }

    try {
        // Disable button
        const btn = document.getElementById('categorySubmitBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> <span class="ml-2">Đang xử lý...</span>';
        btn.disabled = true;

        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok && data.success) {
            window.showToast?.(data.message, 'success');
            closeCategoryModal();
            setTimeout(() => window.location.reload(), 800);
        } else {
            console.error(data);
             // handle errors logic mapped in Controller validation
            const errorMsg = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Đã có lỗi xảy ra.');
            window.showToast?.(errorMsg, 'error');
            btn.innerHTML = originalText;
            btn.disabled = false;
        }

    } catch (error) {
        console.error('Error:', error);
        window.showToast?.('Lỗi kết nối máy chủ!', 'error');
        const btn = document.getElementById('categorySubmitBtn');
        btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">save</span> <span class="ml-2">Lưu lại</span>';
        btn.disabled = false;
    }
});

/**
 * Handle image file selection preview
 */
imageFileInput?.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
            placeholderIcon.classList.add('hidden');
            imageUrlInput.value = ''; // clear url if file selected
        }
        reader.readAsDataURL(this.files[0]);
    }
});

/**
 * Handle URL input preview
 */
imageUrlInput?.addEventListener('input', function() {
    if (this.value) {
        imagePreview.src = this.value;
        imagePreview.classList.remove('hidden');
        placeholderIcon.classList.add('hidden');
        imageFileInput.value = ''; // clear file if url typed
    } else {
        // If url cleared and no file, hide preview
        if(!imageFileInput.files[0]){
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            placeholderIcon.classList.remove('hidden');
        }
    }
});


/**
 * Toggle Status logic
 */
window.toggleCategoryStatus = async function(id, currentStatus) {
    try {
        const response = await fetch(`/admin/quan-ly-danh-muc-con/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            window.showToast?.(data.message, 'success');
            setTimeout(() => window.location.reload(), 800);
        } else {
            window.showToast?.(data.message || 'Có lỗi xảy ra', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        window.showToast?.('Lỗi kết nối máy chủ!', 'error');
    }
}


/**
 * Handle Delete
 */
window.confirmDeleteCategory = function(id) {
    currentDeleteId = id;
    animateFadeIn(deleteModal);
}

window.closeDeleteModal = function() {
    currentDeleteId = null;
    animateFadeOut(deleteModal);
}

document.getElementById('confirmDeleteBtn')?.addEventListener('click', async () => {
    if (!currentDeleteId) return;

    try {
        const btn = document.getElementById('confirmDeleteBtn');
        const oldHtml = btn.innerHTML;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin align-middle mr-1">progress_activity</span> Xóa...';
        btn.disabled = true;

        const response = await fetch(`/admin/quan-ly-danh-muc-con/${currentDeleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (response.ok && data.success) {
            window.showToast?.(data.message, 'success');
            closeDeleteModal();
            setTimeout(() => window.location.reload(), 800);
        } else {
            window.showToast?.(data.message || 'Không thể xóa', 'error');
            btn.innerHTML = oldHtml;
            btn.disabled = false;
        }
    } catch (error) {
        console.error('Error:', error);
        window.showToast?.('Lỗi kết nối máy chủ!', 'error');
        const btn = document.getElementById('confirmDeleteBtn');
        btn.innerHTML = 'Xóa';
        btn.disabled = false;
    }
});

// Close modals when clicking outside
[categoryModal, deleteModal].forEach(modal => {
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) {
            if(modal === categoryModal) closeCategoryModal();
            if(modal === deleteModal) closeDeleteModal();
        }
    });
});
