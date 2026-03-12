document.addEventListener('DOMContentLoaded', function () {
    // 1. Logic Copy Tài khoản
    const copyBtns = document.querySelectorAll('.copy-btn');
    
    copyBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const textToCopy = this.getAttribute('data-copy');
            if(textToCopy) {
                // Sử dụng Clipboard API (Bắt buộc HTTPS hoặc Localhost)
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        const icon = this.querySelector('.material-symbols-outlined');
                        const originalIcon = icon.textContent;
                        
                        // Đổi icon sang Check
                        icon.textContent = 'check';
                        icon.classList.remove('text-primary');
                        icon.classList.add('text-green-500');
                        
                        setTimeout(() => {
                            icon.textContent = originalIcon;
                            icon.classList.add('text-primary');
                            icon.classList.remove('text-green-500');
                        }, 2000);
                    }).catch(err => {
                        console.error('Không thể copy text: ', err);
                    });
                } else {
                    // Fallback cho trình duyệt không hỗ trợ Clipboard API
                    const textArea = document.createElement("textarea");
                    textArea.value = textToCopy;
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        const icon = this.querySelector('.material-symbols-outlined');
                        const originalIcon = icon.textContent;
                        
                        icon.textContent = 'check';
                        icon.classList.remove('text-primary');
                        icon.classList.add('text-green-500');
                        
                        setTimeout(() => {
                            icon.textContent = originalIcon;
                            icon.classList.add('text-primary');
                            icon.classList.remove('text-green-500');
                        }, 2000);
                    } catch (err) {
                        console.error('Lỗi fallback copy', err);
                    }
                    document.body.removeChild(textArea);
                }
            }
        });
    });

    // 2. Logic Hiện/Ẩn Mật khẩu
    const viewPassBtns = document.querySelectorAll('.view-pass-btn');
    
    viewPassBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const passwordSpan = this.parentElement.querySelector('.password-text');
            const actualPassword = this.getAttribute('data-password');
            const icon = this.querySelector('.material-symbols-outlined');
            
            if(passwordSpan.textContent === '**********') {
                // Show password
                passwordSpan.textContent = actualPassword;
                passwordSpan.classList.add('text-green-400', 'font-bold');
                passwordSpan.classList.remove('text-slate-200');
                icon.textContent = 'visibility_off';
            } else {
                // Hide password
                passwordSpan.textContent = '**********';
                passwordSpan.classList.remove('text-green-400', 'font-bold');
                passwordSpan.classList.add('text-slate-200');
                icon.textContent = 'visibility';
            }
        });
    });
});
