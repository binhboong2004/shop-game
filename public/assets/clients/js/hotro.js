document.addEventListener('DOMContentLoaded', () => {
    // Xử lý Accordion FAQ
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const btn = item.querySelector('.faq-btn');
        const content = item.querySelector('.faq-content');

        btn.addEventListener('click', () => {
            // Đóng các mục khác nếu muốn chỉ mở 1 cái 1 lúc
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-content').classList.add('hidden');
                }
            });

            // Toggle trạng thái của mục hiện tại
            item.classList.toggle('active');
            if (item.classList.contains('active')) {
                content.classList.remove('hidden');
            } else {
                content.classList.add('hidden');
            }
        });
    });

    // Xử lý Submit Form (Mô phỏng gửi tiến trình cho mượt)
    const supportForm = document.getElementById('support-form');
    if (supportForm) {
        supportForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const submitBtn = supportForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // UX : Đang gửi (Loading state)
            submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Đang gửi...';
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-70', 'cursor-not-allowed');

            setTimeout(() => {
                // UX : Thành công
                submitBtn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Đã gửi thành công';
                submitBtn.classList.remove('bg-primary');
                submitBtn.classList.add('bg-green-600');

                // Reset form
                supportForm.reset();

                // Trả về mặc định sau 3 giây
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-70', 'cursor-not-allowed', 'bg-green-600');
                    submitBtn.classList.add('bg-primary');
                }, 3000);

            }, 1000);
        });
    }
});
