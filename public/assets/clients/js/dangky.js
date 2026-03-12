document.addEventListener('DOMContentLoaded', function() {
    // 1. Logic Hiện/Ẩn Mật khẩu
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('.material-symbols-outlined');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
                icon.classList.add('text-primary');
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
                icon.classList.remove('text-primary');
            }
        });
    });

    // 2. Validate Password Match
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    const errorText = document.getElementById('password-match-error');

    function validatePassword() {
        if(confirmPassword.value && password.value !== confirmPassword.value) {
            confirmPassword.classList.add('border-red-500', 'focus:ring-red-500');
            confirmPassword.classList.remove('border-primary/20', 'focus:ring-primary');
            errorText.classList.remove('hidden');
            return false;
        } else {
            confirmPassword.classList.remove('border-red-500', 'focus:ring-red-500');
            confirmPassword.classList.add('border-primary/20', 'focus:ring-primary');
            errorText.classList.add('hidden');
            return true;
        }
    }

    if(password && confirmPassword) {
        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
    }

    // 3. Xử lý Đăng ký qua AJAX
    const registerForm = document.getElementById('registerForm');
    if(registerForm) {
        registerForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if(!validatePassword()) {
                showToast('Mật khẩu xác nhận không khớp!', 'error');
                confirmPassword.focus();
                return;
            }

            // Xử lý loading state
            const btn = document.getElementById('btnSubmit');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[20px]">refresh</span> <span>Đang xử lý...</span>`;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            btn.disabled = true;

            try {
                const formData = new FormData(this);
                
                const response = await fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    showToast(result.message || 'Đăng ký thành công!', 'success');
                    setTimeout(() => {
                        localStorage.setItem('auth_sync_event', Date.now());
                        window.location.href = result.redirect || '/';
                    }, 1000);
                } else {
                    let errorMessage = result.message || 'Có lỗi xảy ra';
                    if (result.errors) {
                        errorMessage = result.errors[Object.keys(result.errors)[0]][0];
                    }
                    showToast(errorMessage, 'error');
                    btn.innerHTML = originalText;
                    btn.classList.remove('opacity-80', 'cursor-not-allowed');
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                showToast('Lỗi kết nối đến máy chủ!', 'error');
                btn.innerHTML = originalText;
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
                btn.disabled = false;
            }
        });
    }

    // Hàm hiển thị Toast Notification
    function showToast(message, type = 'success') {
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed top-4 right-4 z-[9999] flex flex-col items-end pointer-events-none';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-[#0f2e1a] border-green-500/30 text-green-400' : 'bg-[#2a0e0e] border-red-500/30 text-red-400';
        const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
        const icon = type === 'success' ? 'check_circle' : 'error';

        toast.className = `flex items-center gap-3 px-4 py-3 rounded-xl border backdrop-blur-md shadow-2xl mb-3 transform transition-all duration-300 translate-x-full opacity-0 ${bgColor}`;
        toast.innerHTML = `
            <span class="material-symbols-outlined ${iconColor}">${icon}</span>
            <span class="text-sm font-medium">${message}</span>
        `;
        
        toastContainer.appendChild(toast);
        
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
});
