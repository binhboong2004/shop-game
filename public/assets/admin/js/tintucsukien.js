document.addEventListener('DOMContentLoaded', function() {
    const btnAdd = document.getElementById('btn-add-news');
    const newsModal = document.getElementById('newsModal');
    const deleteModal = document.getElementById('deleteModal');
    const btnCancels = document.querySelectorAll('.btn-cancel');
    const btnEdits = document.querySelectorAll('.btn-edit');
    const btnDeletes = document.querySelectorAll('.btn-delete');
    const btnStatusToggles = document.querySelectorAll('.btn-status-toggle');
    const modalTitle = document.getElementById('modalTitle');
    
    const thumbnailUpload = document.getElementById('thumbnail-upload');
    const thumbnailPreview = document.getElementById('thumbnail-preview');
    const thumbnailIcon = document.getElementById('thumbnail-icon');
    if (btnAdd) {
        btnAdd.addEventListener('click', () => {
            modalTitle.textContent = 'Thêm Bài Viết Mới';
            document.getElementById('newsForm').reset();
            resetThumbnail();
            openModal(newsModal);
        });
    }

    btnEdits.forEach(btn => {
        btn.addEventListener('click', () => {
            modalTitle.textContent = 'Chỉnh Sửa Bài Viết';
            openModal(newsModal);
        });
    });

    btnDeletes.forEach(btn => {
        btn.addEventListener('click', () => {
            openModal(deleteModal);
        });
    });

    btnStatusToggles.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.textContent.trim() === 'Hiển thị') {
                this.className = "inline-block w-20 px-2 py-1 bg-[#E70814]/10 text-[#E70814] text-xs font-bold border border-[#E70814]/20 rounded btn-status-toggle";
                this.textContent = 'Đang ẩn';
            } else {
                this.className = "inline-block w-20 px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20 rounded btn-status-toggle";
                this.textContent = 'Hiển thị';
            }
        });
    });

    btnCancels.forEach(btn => {
        btn.addEventListener('click', () => {
            closeAllModals();
        });
    });

    if (thumbnailUpload) {
        thumbnailUpload.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    thumbnailPreview.src = e.target.result;
                    thumbnailPreview.classList.remove('hidden');
                    if (thumbnailIcon) thumbnailIcon.classList.add('hidden');
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    function resetThumbnail() {
        if (thumbnailPreview) {
            thumbnailPreview.src = '';
            thumbnailPreview.classList.add('hidden');
        }
        if (thumbnailIcon) thumbnailIcon.classList.remove('hidden');
    }

    function openModal(modal) {
        if (!modal) return;
        modal.classList.remove('hidden');
        void modal.offsetWidth;
        const modalContent = modal.querySelector('div.transform');
        if (modalContent) {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }
    }

    function closeAllModals() {
        const modals = [newsModal, deleteModal];
        modals.forEach(modal => {
            if (!modal || modal.classList.contains('hidden')) return;
            const modalContent = modal.querySelector('div.transform');
            if (modalContent) {
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
            closeAllModals();
        }
    });
});
