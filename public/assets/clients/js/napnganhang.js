const CopyUtils = {
    copyText: function (text) {
        if (!navigator.clipboard) {
            this.fallbackCopyTextToClipboard(text);
            return;
        }
        navigator.clipboard.writeText(text).then(() => {
            this.showToast('Đã copy: ' + text);
        }).catch(err => {
            console.error('Không thể copy: ', err);
            this.showToast('Lỗi copy, vui lòng thao tác thủ công!', 'error');
        });
    },

    fallbackCopyTextToClipboard: function (text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;

        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";

        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            if (successful) {
                this.showToast('Đã copy: ' + text);
            } else {
                this.showToast('Lỗi copy, vui lòng thao tác thủ công!', 'error');
            }
        } catch (err) {
            console.error('Fallback: Lỗi khi xử lý copy', err);
            this.showToast('Lỗi copy, vui lòng thao tác thủ công!', 'error');
        }

        document.body.removeChild(textArea);
    },

    showToast: function (message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-20 right-4 px-4 py-3 rounded shadow-lg z-50 flex items-center gap-2 transform transition-all duration-300 translate-x-full opacity-0 text-white font-medium ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;

        const icon = document.createElement('span');
        icon.className = 'material-symbols-outlined text-[20px]';
        icon.textContent = type === 'success' ? 'check_circle' : 'error';

        const textObj = document.createElement('span');
        textObj.textContent = message;

        toast.appendChild(icon);
        toast.appendChild(textObj);
        document.body.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        });

        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Xử lý sự kiện click trên các nút copy
    const copyBtns = document.querySelectorAll('.btn-copy');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const textToCopy = btn.getAttribute('data-copy');
            if (textToCopy) {
                CopyUtils.copyText(textToCopy);
            }
        });
    });

    // Handle tab switching if there are multiple banks
    const bankTabs = document.querySelectorAll('.bank-tab');
    const bankContents = document.querySelectorAll('.bank-content');

    bankTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active from all tabs
            bankTabs.forEach(t => {
                t.classList.remove('border-primary', 'text-primary', 'bg-primary/10');
                t.classList.add('border-transparent', 'text-slate-500', 'hover:text-slate-300', 'hover:border-slate-300');
            });
            // Add active to clicked tab
            tab.classList.remove('border-transparent', 'text-slate-500', 'hover:text-slate-300', 'hover:border-slate-300');
            tab.classList.add('border-primary', 'text-primary', 'bg-primary/10');

            // Hide all contents
            const targetId = tab.getAttribute('data-target');
            bankContents.forEach(content => {
                if (content.id === targetId) {
                    content.classList.remove('hidden');
                } else {
                    content.classList.add('hidden');
                }
            });
        });
    });

    // Handle Form Submission for Bank/Momo
    const mbbankForm = document.getElementById('form-mbbank-deposit');
    const momoForm = document.getElementById('form-momo-deposit');

    function handleDepositSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span> Đang xử lý...';
        submitBtn.disabled = true;

        const formData = new FormData(form);

        fetch('/nap-ngan-hang/submit', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                CopyUtils.showToast(data.message, 'success');
                form.reset();
                setTimeout(() => window.location.reload(), 2000);
            } else {
                CopyUtils.showToast(data.message || 'Có lỗi xảy ra', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            CopyUtils.showToast('Lỗi kết nối đến máy chủ', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }

    if (mbbankForm) mbbankForm.addEventListener('submit', handleDepositSubmit);
    if (momoForm) momoForm.addEventListener('submit', handleDepositSubmit);
});
