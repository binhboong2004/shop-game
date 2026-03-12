tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "primary": "#e70814",
                "background-light": "#f8f5f6",
                "background-dark": "#230f11",
            },
            fontFamily: {
                "display": ["Be Vietnam Pro"]
            },
            borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
        },
    },
}

// ========== Chat Widget ==========
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('chat-toggle-btn');
    const closeBtn = document.getElementById('chat-close-btn');
    const chatPanel = document.getElementById('chat-panel');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('chat-send-btn');
    const messages = document.getElementById('chat-messages');
    const badge = document.getElementById('chat-badge');
    const chatIcon = document.getElementById('chat-icon');
    const faqBtns = document.querySelectorAll('.faq-btn');
    let isOpen = false;

    // Mở / đóng panel
    function openChat() {
        chatPanel.classList.remove('hidden', 'chat-close');
        chatPanel.classList.add('chat-open');
        chatIcon.textContent = 'close';
        badge.style.display = 'none';
        isOpen = true;
        setTimeout(() => chatInput.focus(), 300);
        scrollToBottom();
    }

    function closeChat() {
        chatPanel.classList.remove('chat-open');
        chatPanel.classList.add('chat-close');
        chatIcon.textContent = 'chat';
        isOpen = false;
        setTimeout(() => {
            chatPanel.classList.add('hidden');
            chatPanel.classList.remove('chat-close');
        }, 200);
    }

    toggleBtn.addEventListener('click', () => isOpen ? closeChat() : openChat());
    closeBtn.addEventListener('click', closeChat);

    // Scroll xuống cuối messages
    function scrollToBottom() {
        setTimeout(() => { messages.scrollTop = messages.scrollHeight; }, 50);
    }

    // Thêm tin nhắn của user
    function addUserMessage(text) {
        const div = document.createElement('div');
        div.className = 'flex justify-end';
        div.innerHTML = `<div class="rounded-2xl rounded-br-none px-3 py-2 text-sm text-white max-w-[80%]" style="background:#e70814;">${escapeHtml(text)}</div>`;
        messages.appendChild(div);
        scrollToBottom();
    }

    // Thêm tin nhắn của bot
    function addBotMessage(text) {
        const div = document.createElement('div');
        div.className = 'flex items-end gap-2';
        div.innerHTML = `
            <div class="flex items-center justify-center size-7 rounded-full flex-shrink-0" style="background:#e70814;">
                <span class="material-symbols-outlined text-white text-[14px]">support_agent</span>
            </div>
            <div class="rounded-2xl rounded-bl-none px-3 py-2 text-sm text-slate-100 max-w-[80%]" style="background:#2d1215;">${text}</div>`;
        messages.appendChild(div);
        scrollToBottom();
    }

    // Escape HTML để tránh XSS
    function escapeHtml(str) {
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    }

    // Bot trả lời tự động theo từ khóa
    const botReplies = [
        { keys: ['mua nick', 'mua tài khoản', 'mua game'], reply: '🛒 Bạn muốn mua nick game nào? Chúng tôi có <strong>Liên Quân, Free Fire, PUBG, Roblox</strong> và nhiều game khác. Bạn có thể xem các sản phẩm ngay trên trang chủ nhé!' },
        { keys: ['bảo hành', 'bảo hành'], reply: '🛡️ Chính sách bảo hành: <strong>1-7 ngày</strong> kể từ ngày mua. Hoàn tiền hoặc đổi nick nếu lỗi từ phía shop. Vui lòng liên hệ qua SDT: <strong>0889.639.655</strong>.' },
        { keys: ['thanh toán', 'chuyển khoản', 'napas', 'momo'], reply: '💳 Chúng tôi hỗ trợ thanh toán qua: <strong>Chuyển khoản ngân hàng, MoMo, ZaloPay, thẻ cào</strong>. Hệ thống nạp tự động 24/7!' },
        { keys: ['liên hệ', 'admin', 'hotline', 'sđt'], reply: '📞 Liên hệ Admin: <strong>0889.639.655</strong><br>📧 Email: hotro@shopnickvn.vn<br>⏰ Hỗ trợ: 08:00 - 23:00 mọi ngày.' },
        { keys: ['giá', 'bao nhiêu'], reply: '💰 Giá nick dao động từ <strong>69.000đ</strong> đến hàng triệu đồng tuỳ theo loại. Bạn xem chi tiết từng sản phẩm để biết giá chính xác nhé!' },
        { keys: ['xin chào', 'hello', 'hi', 'chào'], reply: '😊 Xin chào bạn! Mình có thể giúp gì cho bạn hôm nay?' },
    ];

    function getBotReply(text) {
        const lower = text.toLowerCase();
        for (const item of botReplies) {
            if (item.keys.some(k => lower.includes(k))) return item.reply;
        }
        return 'Cảm ơn bạn đã liên hệ! 🙏 Nhân viên hỗ trợ sẽ phản hồi bạn sớm nhất. Hoặc gọi <strong>0889.639.655</strong> để được hỗ trợ ngay!';
    }

    // Gửi tin nhắn
    function sendMessage() {
        const text = chatInput.value.trim();
        if (!text) return;
        addUserMessage(text);
        chatInput.value = '';
        // Bot typing giả lập
        setTimeout(() => addBotMessage(getBotReply(text)), 700);
    }

    sendBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') sendMessage(); });

    // FAQ quick replies
    faqBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const msg = btn.dataset.msg;
            addUserMessage(msg);
            setTimeout(() => addBotMessage(getBotReply(msg)), 700);
        });
    });

    // ========== Mobile Menu & Mega Menu Logic ==========
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenu = document.getElementById('mobile-menu');
    const accordionBtns = document.querySelectorAll('.accordion-btn');
    const subAccordionBtns = document.querySelectorAll('.sub-accordion-btn');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', () => {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Ngăn scroll body
        });

        mobileMenuClose.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = '';
        });

        // Đóng menu khi click ra ngoài panel
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    }

    // Xử lý Accordion chính (Sản phẩm)
    accordionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.material-symbols-outlined');
            
            content.classList.toggle('hidden');
            content.classList.toggle('show');
            icon.classList.toggle('rotate-180');
        });
    });

    // Xử lý Sub-Accordion (Game con)
    subAccordionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.material-symbols-outlined');
            
            content.classList.toggle('hidden');
            content.classList.toggle('show');
            icon.textContent = content.classList.contains('hidden') ? 'add' : 'remove';
        });
    });

    // ========== Notifications / Toast Logic ==========
    window.showToast = function(message, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        if(!toastContainer) return;
        
        const toast = document.createElement('div');
        toast.className = `flex items-center w-full min-w-[300px] max-w-sm p-4 text-slate-500 bg-white rounded-xl shadow-[0_5px_20px_rgba(0,0,0,0.3)] dark:text-slate-400 dark:bg-background-dark/95 backdrop-blur border border-primary/20 transition-all duration-300 transform translate-x-full opacity-0 relative overflow-hidden`;
        
        // Progress bar effect
        const progressColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
        toast.innerHTML += `<div class="absolute bottom-0 left-0 h-1 w-full ${progressColor} animate-[toast-progress_1.5s_linear_forwards]"></div>`;

        const iconMap = {
            'success': '<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-500/10 rounded-lg dark:text-green-400"><span class="material-symbols-outlined text-[20px]">check_circle</span></div>',
            'error': '<div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-500/10 rounded-lg dark:text-red-400"><span class="material-symbols-outlined text-[20px]">error</span></div>',
        };
        
        toast.innerHTML += `
            ${iconMap[type] || iconMap['success']}
            <div class="ms-3 text-sm font-bold text-slate-800 dark:text-white">${message}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-slate-400 hover:text-slate-900 rounded-lg p-1.5 hover:bg-slate-100 inline-flex items-center justify-center h-8 w-8 dark:hover:text-white dark:hover:bg-slate-700 transition" onclick="this.parentElement.remove()">
                <span class="sr-only">Close</span>
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full', 'opacity-0');
        }, 10);
        
        // Auto remove after 1.5s matching progress bar
        setTimeout(() => {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 1500);
    }

    // ========== Logic Nút Đăng Xuất (Logout) ==========
    const logoutBtns = document.querySelectorAll('.logout-btn');
    if(logoutBtns.length > 0) {
        logoutBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const redirectUrl = this.getAttribute('href');
                
                // Show notification success
                window.showToast('Đăng xuất thành công!', 'success');
                
                // Trì hoãn 1.5s để xem notification trước khi chuyển trang
                setTimeout(() => {
                    if (redirectUrl && redirectUrl !== '#') {
                        window.location.href = redirectUrl;
                    } else {
                        window.location.href = '/dangnhap';
                    }
                }, 1500);
            });
        });
    }

});

// Tailwind CSS plugin format keyframes cho toast-progress, có thể thêm vào đây tạm hoặc load qua style.css
const style = document.createElement('style');
style.textContent = `
    @keyframes toast-progress {
        0% { width: 100%; }
        100% { width: 0%; }
    }
`;
document.head.appendChild(style);

// ========== Global Actions (Wishlist & Cart) ========== //
window.toggleWishlist = async function(accountId, btnElement) {
    if(btnElement) btnElement.classList.add('opacity-50', 'pointer-events-none');
    try {
        const response = await fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ account_id: accountId })
        });
        
        const data = await response.json();
        
        if (response.status === 401) {
            window.showToast('Vui lòng đăng nhập để sử dụng tính năng này!', 'error');
            setTimeout(() => window.location.href = '/dangnhap', 1500);
            return;
        }

        if (data.success) {
            window.showToast(data.message, 'success');
            const counter = document.getElementById('wishlist-count-badge');
            if (counter) counter.textContent = data.wishlist_count;
            
            if (btnElement) {
                const icon = btnElement.querySelector('span');
                if (icon) {
                    if (data.action === 'added') {
                        icon.classList.add('text-primary');
                    } else {
                        icon.classList.remove('text-primary');
                    }
                }
            }
        } else {
            window.showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    } catch (error) {
        console.error(error);
        window.showToast('Lỗi kết nối máy chủ!', 'error');
    } finally {
        if(btnElement) btnElement.classList.remove('opacity-50', 'pointer-events-none');
    }
};

window.addToCartGlobal = async function(accountId, btnElement) {
    let originalHtml = '';
    if (btnElement) {
        originalHtml = btnElement.innerHTML;
        btnElement.disabled = true;
        btnElement.innerHTML = '<span class="material-symbols-outlined animate-spin text-[16px]">refresh</span> Đang thêm...';
    }
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ account_id: accountId })
        });
        const data = await response.json();
        
        if (response.status === 401) {
            window.showToast('Vui lòng đăng nhập để múa sắm!', 'error');
            setTimeout(() => window.location.href = '/dangnhap', 1500);
            return;
        }

        if (data.success) {
            window.showToast(data.message, 'success');
            const counter = document.getElementById('cart-count');
            if (counter) counter.textContent = data.cart_count;
            
            if (btnElement) {
                btnElement.innerHTML = '<span class="material-symbols-outlined text-[16px]">check_circle</span> Đã thêm';
                btnElement.classList.remove('bg-surface', 'text-primary');
                btnElement.classList.add('bg-green-600', 'text-white', 'border-green-600');
                setTimeout(() => {
                    btnElement.innerHTML = originalHtml;
                    btnElement.classList.add('bg-surface', 'text-primary');
                    btnElement.classList.remove('bg-green-600', 'text-white', 'border-green-600');
                }, 2000);
            }
        } else {
            window.showToast(data.message || 'Không thể thêm vào giỏ', 'error');
            if(data.message.includes('đã có')) {
                 if (btnElement) btnElement.innerHTML = '<span class="material-symbols-outlined text-[16px]">check_circle</span> Đã có trong giỏ';
            }
        }
    } catch (error) {
        console.error(error);
        window.showToast('Lỗi kết nối máy chủ!', 'error');
        if (btnElement) btnElement.innerHTML = originalHtml;
    } finally {
        if (btnElement) {
            btnElement.disabled = false;
        }
    }
};

window.buyNowGlobal = async function(accountId) {
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify({ account_id: accountId })
        });
        
        if (response.status === 401) {
            window.showToast('Vui lòng đăng nhập trước khi mua!', 'error');
            setTimeout(() => window.location.href = '/dangnhap', 1500);
            return;
        }
        
        const data = await response.json();
        if (data.success || (data.message && data.message.includes('đã có'))) {
            window.location.href = '/giohang';
        } else {
            window.showToast(data.message || 'Có lỗi xảy ra', 'error');
        }
    } catch (error) {
        console.error(error);
        window.showToast('Lỗi kết nối máy chủ!', 'error');
    }
};
