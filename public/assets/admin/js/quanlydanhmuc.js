document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('categoryModal');
    const addBtn = document.getElementById('addCategoryBtn');
    const cancelBtns = modal.querySelectorAll('.btn-cancel');
    const form = document.getElementById('categoryForm');
    const modalTitle = document.getElementById('modalTitle');
    const catNameInput = document.getElementById('catName');
    const catImageInput = document.getElementById('catImage');
    const catImageFileInput = document.getElementById('catImageFile');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const catStatusInput = document.getElementById('catStatus');
    const btnSave = document.getElementById('btnSave');
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let currentEditId = null;

    if (catImageFileInput && fileNameDisplay) {
        catImageFileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.classList.remove('text-gray-400');
                fileNameDisplay.classList.add('text-white');
                if(catImageInput) catImageInput.value = '';
            } else {
                fileNameDisplay.textContent = '... Hoặc chọn ảnh tải lên từ máy tính';
                fileNameDisplay.classList.add('text-gray-400');
                fileNameDisplay.classList.remove('text-white');
            }
        });
    }

    function openModal(isEdit = false, data = null) {
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        const modalContent = modal.querySelector('div[class*="transform"]');
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');

        if (isEdit && data) {
            currentEditId = data.id;
            modalTitle.textContent = 'Chỉnh sửa Danh Mục (Game)';
            catNameInput.value = data.name || '';
            // Display URL if stored as URL
            if(data.image && data.image.startsWith('http')) {
                catImageInput.value = data.image;
            } else {
                catImageInput.value = '';
            }

            catStatusInput.checked = data.status == 1;
            
            if(catImageFileInput) catImageFileInput.value = '';
            if(fileNameDisplay) {
                // Determine display content
                let dispText = data.image ? 'Đã có file ảnh được tải lên' : '... Hoặc chọn ảnh tải lên từ máy tính';
                if(data.image && data.image.startsWith('http')) dispText = '... Hoặc chọn ảnh tải lên từ máy tính';
                
                fileNameDisplay.textContent = dispText;
                
                if(dispText !== '... Hoặc chọn ảnh tải lên từ máy tính') {
                    fileNameDisplay.classList.remove('text-gray-400');
                    fileNameDisplay.classList.add('text-white');
                } else {
                    fileNameDisplay.classList.add('text-gray-400');
                    fileNameDisplay.classList.remove('text-white');
                }
            }
        } else {
            currentEditId = null;
            modalTitle.textContent = 'Thêm Danh Mục (Game) Mới';
            form.reset();
            catStatusInput.checked = true;
            
            if(fileNameDisplay) {
                fileNameDisplay.textContent = '... Hoặc chọn ảnh tải lên từ máy tính';
                fileNameDisplay.classList.add('text-gray-400');
                fileNameDisplay.classList.remove('text-white');
            }
        }
    }

    function closeModal() {
        const modalContent = modal.querySelector('div[class*="transform"]');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    if (addBtn) {
        addBtn.addEventListener('click', () => openModal(false));
    }
    
    cancelBtns.forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    document.querySelectorAll('.btn-edit-category').forEach(btn => {
        btn.addEventListener('click', function() {
            const dataStr = this.getAttribute('data-game');
            const dataObj = JSON.parse(dataStr);
            openModal(true, dataObj);
        });
    });

    // Handle Form Submit using FormData API
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const originalText = btnSave.innerText;
            btnSave.innerText = 'Đang lưu...';
            btnSave.disabled = true;

            const formData = new FormData();
            formData.append('name', catNameInput.value);
            formData.append('status', catStatusInput.checked ? 'active' : 'hidden');
            
            if(catImageInput.value) {
                formData.append('image_url', catImageInput.value);
            }
            if(catImageFileInput.files.length > 0) {
                formData.append('image_file', catImageFileInput.files[0]);
            }

            let url = '/admin/quan-ly-danh-muc';
            if (currentEditId) {
                url += '/' + currentEditId;
                formData.append('_method', 'PUT'); // Laravel spoofing for FormData
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                    // Do not set Content-Type header when using FormData; fetch handles boundary
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json();
                if(!res.ok) {
                    let errMsg = data.message || 'Lỗi khi lưu';
                    if(data.errors) {
                        errMsg += '\n' + Object.values(data.errors).map(er => er.join(', ')).join('\n');
                    }
                    throw new Error(errMsg);
                }
                return data;
            })
            .then(data => {
                if(data.success) {
                    closeModal();
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    throw new Error(data.message || 'Lỗi không xác định');
                }
            })
            .catch(err => {
                window.showToast(err.message, 'error');
            })
            .finally(() => {
                btnSave.innerText = originalText;
                btnSave.disabled = false;
            });
        });
    }

    const deleteModal = document.getElementById('deleteModal');
    const cancelDeleteBtns = deleteModal.querySelectorAll('.btn-cancel-delete');
    let currentDeleteId = null;
    
    function openDeleteModal(id) {
        currentDeleteId = id;
        deleteModal.classList.remove('hidden');
        void deleteModal.offsetWidth;
        const modalContent = deleteModal.querySelector('div[class*="transform"]');
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }

    function closeDeleteModal() {
        const modalContent = deleteModal.querySelector('div[class*="transform"]');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
        }, 300);
    }

    document.querySelectorAll('.btn-delete-category').forEach(btn => {
        btn.addEventListener('click', function() {
            openDeleteModal(this.getAttribute('data-id'));
        });
    });

    cancelDeleteBtns.forEach(btn => {
        btn.addEventListener('click', closeDeleteModal);
    });
    
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if(!currentDeleteId) return;

            const originalText = confirmDeleteBtn.innerText;
            confirmDeleteBtn.innerText = 'Đang xóa...';
            confirmDeleteBtn.disabled = true;

            fetch(`/admin/quan-ly-danh-muc/${currentDeleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    closeDeleteModal();
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showToast('Lỗi: ' + (data.message || 'Không thể xóa'), 'error');
                    confirmDeleteBtn.innerText = originalText;
                    confirmDeleteBtn.disabled = false;
                }
            })
            .catch(err => {
                window.showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                confirmDeleteBtn.innerText = originalText;
                confirmDeleteBtn.disabled = false;
            });
        });
    }

    // Toggle Status
    document.querySelectorAll('.status-switch').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            
            fetch(`/admin/quan-ly-danh-muc/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) {
                    this.checked = !this.checked; // revert
                    window.showToast('Lỗi: ' + (data.message || 'Không thể thay đổi trạng thái'), 'error');
                } else {
                    window.showToast(data.message, 'success');
                }
            })
            .catch(err => {
                this.checked = !this.checked; // revert
                window.showToast('Có lỗi mạng xảy ra, không thể thay đổi trạng thái', 'error');
            });
        });
    });

    const filterBtn = document.getElementById('filterBtn');
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');

    if (filterBtn && searchInput && statusFilter) {
        filterBtn.addEventListener('click', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusVal = statusFilter.value;
            const rows = document.querySelectorAll('.category-row');

            rows.forEach(row => {
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
        });
    }
});
