/* Script for Agent Registration Page */
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('agentRegistrationForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate (simple)
            const name = this.querySelector('input[name="name"]').value.trim();
            const phone = this.querySelector('input[name="phone"]').value.trim();
            const email = this.querySelector('input[name="email"]').value.trim();

            if (!name || !phone || !email) {
                if(typeof showToast === 'function') {
                    showToast('Vui lòng điền đầy đủ thông tin bắt buộc!', 'error');
                } else {
                    alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                }
                return;
            }

            // Mock submission
            const btn = this.querySelector('button[type="submit"]');
            const btnText = btn.querySelector('.btn-text');
            const btnIcon = btn.querySelector('.btn-icon');
            
            const originalText = btnText.innerHTML;
            const originalIcon = btnIcon.innerHTML;

            btnText.innerHTML = 'Đang xử lý...';
            btnIcon.innerHTML = 'sync';
            btnIcon.classList.add('animate-spin');
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');

            setTimeout(() => {
                btnText.innerHTML = 'Đăng ký thành công';
                btnIcon.innerHTML = 'check_circle';
                btnIcon.classList.remove('animate-spin');
                btn.classList.remove('bg-primary', 'hover:bg-primary/90', 'opacity-80', 'cursor-not-allowed');
                btn.classList.add('bg-green-600', 'hover:bg-green-700');
                
                if(typeof showToast === 'function') {
                    showToast('Yêu cầu đăng ký đại lý đã được gửi. Chúng tôi sẽ liên hệ lại sớm nhất!', 'success');
                } else {
                    alert('Yêu cầu đăng ký đại lý đã được gửi thành công!');
                }
                
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            }, 1000);
        });
    }
});
