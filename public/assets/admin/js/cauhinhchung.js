document.addEventListener('DOMContentLoaded', function () {
    const handleImagePreview = (inputId, previewId) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (input && preview) {
            input.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    };

    handleImagePreview('logo-upload', 'logo-preview');
    handleImagePreview('favicon-upload', 'favicon-preview');

    const titleInput = document.querySelector('input[placeholder="Nhập tiêu đề SEO"]');
    const descInput = document.querySelector('textarea[placeholder="Nhập mô tả SEO"]');
    const titleCounter = document.getElementById('title-counter');
    const descCounter = document.getElementById('desc-counter');

    const updateCounter = (input, counterEl, maxLength) => {
        if (!input || !counterEl) return;
        
        const count = input.value.length;
        counterEl.textContent = count;
        
        if (count > maxLength) {
            counterEl.classList.remove('text-green-500');
            counterEl.classList.add('text-[#E70814]');
        } else {
            counterEl.classList.add('text-green-500');
            counterEl.classList.remove('text-[#E70814]');
        }
    };

    if (titleInput && titleCounter) {
        titleInput.addEventListener('input', () => updateCounter(titleInput, titleCounter, 60));
    }

    if (descInput && descCounter) {
        descInput.addEventListener('input', () => updateCounter(descInput, descCounter, 160));
    }

    const formSettings = document.getElementById('form-settings');
    if (formSettings) {
        formSettings.addEventListener('submit', function (e) {
            e.preventDefault();
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Lưu cấu hình?',
                    text: "Bạn có chắc chắn muốn lưu lại các thay đổi này?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#E70814',
                    cancelButtonColor: '#2a2d35',
                    confirmButtonText: 'Lưu thay đổi',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Thành công!',
                            text: 'Đã lưu cấu hình mới.',
                            icon: 'success',
                            confirmButtonColor: '#E70814',
                        });
                    }
                });
            } else {
                if(confirm('Bạn có chắc chắn muốn lưu lại các thay đổi?')) {
                    alert('Lưu thành công!');
                }
            }
        });
    }
});
