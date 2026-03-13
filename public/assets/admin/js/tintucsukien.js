document.addEventListener('DOMContentLoaded', function() {
    const newsModal = document.getElementById('newsModal');
    const deleteModal = document.getElementById('deleteModal');
    const newsForm = document.getElementById('newsForm');
    const btnSave = document.getElementById('btn-save-news');
    const btnConfirmDelete = document.getElementById('btn-confirm-delete');
    const thumbnailUpload = document.getElementById('thumbnail-upload');
    const thumbnailPreview = document.getElementById('thumbnail-preview');
    const thumbnailIcon = document.getElementById('thumbnail-icon');
    
    let deleteId = null;

    // Open Add Modal
    document.getElementById('btn-add-news')?.addEventListener('click', () => {
        document.getElementById('modalTitle').textContent = 'Thêm Bài Viết Mới';
        newsForm.reset();
        document.getElementById('newsId').value = '';
        resetThumbnail();
        openModal(newsModal);
    });

    // Close Modals
    document.querySelectorAll('.btn-close-modal').forEach(btn => {
        btn.addEventListener('click', () => closeModal(newsModal));
    });

    document.querySelectorAll('.btn-close-delete').forEach(btn => {
        btn.addEventListener('click', () => closeModal(deleteModal));
    });

    // Thumbnail Preview
    thumbnailUpload?.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnailPreview.src = e.target.result;
                thumbnailPreview.classList.remove('hidden');
                thumbnailIcon.classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Save News
    btnSave?.addEventListener('click', function() {
        const id = document.getElementById('newsId').value;
        const url = id ? ARTICLE_ROUTES.update.replace(':id', id) : ARTICLE_ROUTES.store;
        const formData = new FormData(newsForm);
        
        // Cập nhật nội dung từ CKEditor
        if (editor) {
            formData.set('content', editor.getData());
        }

        btnSave.disabled = true;
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
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'Có lỗi xảy ra', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Lỗi hệ thống!', 'error');
        })
        .finally(() => {
            btnSave.disabled = false;
            btnSave.textContent = 'Lưu Bài Viết';
        });
    });

    // Delete News
    btnConfirmDelete?.addEventListener('click', function() {
        if (!deleteId) return;

        fetch(ARTICLE_ROUTES.delete.replace(':id', deleteId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            }
        })
        .catch(() => showToast('Lỗi hệ thống!', 'error'));
    });

    // Global Functions for buttons in HTML
    window.editNews = function(id) {
        fetch(ARTICLE_ROUTES.edit.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Chỉnh Sửa Bài Viết';
            document.getElementById('newsId').value = data.id;
            document.getElementById('newsTitle').value = data.title;
            document.getElementById('newsCategory').value = data.type;
            document.getElementById('newsStatus').value = data.status;
            document.getElementById('newsExcerpt').value = data.excerpt || '';
            
            // Set data cho CKEditor
            if (editor) {
                editor.setData(data.content);
            } else {
                document.getElementById('newsContent').value = data.content;
            }

            if (data.thumbnail) {
                thumbnailPreview.src = '/storage/' + data.thumbnail;
                thumbnailPreview.classList.remove('hidden');
                thumbnailIcon.classList.add('hidden');
            } else {
                resetThumbnail();
            }

            openModal(newsModal);
        });
    };

    window.confirmDelete = function(id) {
        deleteId = id;
        openModal(deleteModal);
    };

    window.toggleStatus = function(id) {
        fetch(ARTICLE_ROUTES.toggle.replace(':id', id), {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                const btn = document.querySelector(`tr[data-id="${id}"] .btn-status-toggle`);
                const isPublished = btn.textContent.trim() === 'Hiển thị';
                
                if (isPublished) {
                    btn.textContent = 'Đang ẩn';
                    btn.classList.replace('bg-emerald-500/10', 'bg-gray-500/10');
                    btn.classList.replace('text-emerald-400', 'text-gray-400');
                    btn.classList.replace('border-emerald-500/20', 'border-gray-500/20');
                } else {
                    btn.textContent = 'Hiển thị';
                    btn.classList.replace('bg-gray-500/10', 'bg-emerald-500/10');
                    btn.classList.replace('text-gray-400', 'text-emerald-400');
                    btn.classList.replace('border-gray-500/20', 'border-emerald-500/20');
                }
            }
        });
    };

    function resetThumbnail() {
        thumbnailPreview.src = '';
        thumbnailPreview.classList.add('hidden');
        thumbnailIcon.classList.remove('hidden');
        thumbnailUpload.value = '';
    }

    function openModal(modal) {
        modal.classList.remove('hidden');
    }

    function closeModal(modal) {
        modal.classList.add('hidden');
        if (editor) editor.setData('');
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-5 right-5 z-[100] px-6 py-3 rounded-lg shadow-xl text-white font-bold transform translate-y-20 transition-all duration-300 ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        setTimeout(() => toast.classList.replace('translate-y-20', 'translate-y-0'), 10);
        setTimeout(() => {
            toast.classList.replace('translate-y-0', 'translate-y-20');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});
