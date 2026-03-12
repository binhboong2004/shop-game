document.addEventListener('DOMContentLoaded', function () {
    // 1. Tab Switching Logic
    const menuBtns = document.querySelectorAll('.menu-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    menuBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Remove active classes from all buttons
            menuBtns.forEach(b => {
                b.classList.remove('bg-primary', 'text-white', 'shadow-[0_4px_15px_rgba(231,8,20,0.4)]', 'active');
                b.classList.add('text-slate-400', 'hover:text-white', 'hover:bg-primary/10');
            });

            // Add active classes to clicked button
            this.classList.remove('text-slate-400', 'hover:text-white', 'hover:bg-primary/10');
            this.classList.add('bg-primary', 'text-white', 'shadow-[0_4px_15px_rgba(231,8,20,0.4)]', 'active');

            // Hide all tabs
            tabPanes.forEach(tab => {
                tab.classList.add('hidden');
            });

            // Show target tab
            const targetId = this.getAttribute('data-target');
            const targetTab = document.getElementById(targetId);
            if (targetTab) {
                targetTab.classList.remove('hidden');
            }
        });
    });

    // 2. Avatar Preview Logic
    const avatarInput = document.getElementById('avatar-upload');
    const avatarPreview = document.getElementById('avatar-preview');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                // Check if file is image
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        avatarPreview.src = e.target.result;
                        // You can also trigger an AJAX upload here...
                    }

                    reader.readAsDataURL(file);
                } else {
                    alert('Vui lòng chọn file hình ảnh hợp lệ (jpg, png, webp...)');
                }
            }
        });
    }

    // 3. Toggle Password Visibility Logic
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('.material-symbols-outlined');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        });
    });

    // 4. Form Submit Logic (Thông tin chung)
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span><span>Đang lưu...</span>';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            fetch('/thongtincanhan/update', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    window.showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showToast('Lỗi kết nối đến máy chủ', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            });
        });
    }

    // 5. Form Submit Logic (Đổi mật khẩu)
    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Client-side validation for password match
            const newPassword = this.querySelector('input[name="new_password"]').value;
            const confirmPassword = this.querySelector('input[name="new_password_confirmation"]').value;
            
            if (newPassword !== confirmPassword) {
                window.showToast('Mật khẩu mới không khớp!', 'error');
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalContent = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span><span>Đang xử lý...</span>';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            fetch('/thongtincanhan/password', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    window.showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.showToast('Lỗi kết nối đến máy chủ', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalContent;
                submitBtn.disabled = false;
            });
        });
    }
});
