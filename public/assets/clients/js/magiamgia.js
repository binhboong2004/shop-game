document.addEventListener('DOMContentLoaded', function () {
    // ========== Countdown Timers ==========
    function updateCountdowns() {
        document.querySelectorAll('.countdown').forEach(el => {
            const expire = new Date(el.dataset.expire).getTime();
            const now = Date.now();
            const diff = expire - now;
            if (diff <= 0) { el.textContent = 'Hết hạn'; el.classList.add('text-red-500'); return; }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            el.textContent = d > 0 ? `${d}d ${h}h ${m}p` : `${h}h ${m}p`;
        });
    }
    updateCountdowns();
    setInterval(updateCountdowns, 60000);

    // ========== Copy Coupon Code ==========
    let toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = '<span class="material-symbols-outlined text-[18px] text-green-400">check_circle</span> <span>Đã sao chép mã giảm giá!</span>';
    document.body.appendChild(toast);

    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const code = this.dataset.code;
            navigator.clipboard.writeText(code).then(() => {
                // Visual feedback
                this.classList.add('copied');
                this.innerHTML = '<span class="material-symbols-outlined text-[16px]">check</span> Đã chép';
                setTimeout(() => {
                    this.classList.remove('copied');
                    this.innerHTML = '<span class="material-symbols-outlined text-[16px]">content_copy</span> Sao chép';
                }, 2000);
                // Toast
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 2500);
            });
        });
    });

    // ========== Filter Tabs ==========
    const filterTabs = document.querySelectorAll('.filter-tab');
    const cards = document.querySelectorAll('.coupon-card');
    const countEl = document.getElementById('coupon-count');

    function filterCards(type) {
        let visible = 0;
        cards.forEach(card => {
            const cardType = card.dataset.type;
            const cardTag = card.dataset.tag;
            const match = type === 'all' || cardType === type || (type === 'hot' && cardTag === 'hot');
            card.style.display = match ? 'flex' : 'none';
            if (match) visible++;
        });
        if (countEl) countEl.textContent = `Hiển thị ${visible} mã`;
    }

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            filterCards(this.dataset.filter);
        });
    });

    // ========== Search ==========
    const searchInput = document.getElementById('search-coupon');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let visible = 0;
            cards.forEach(card => {
                const title = card.querySelector('.coupon-title')?.textContent.toLowerCase() || '';
                const code = card.querySelector('.coupon-code')?.textContent.toLowerCase() || '';
                const game = card.querySelector('.coupon-game')?.textContent.toLowerCase() || '';
                const match = !q || title.includes(q) || code.includes(q) || game.includes(q);
                card.style.display = match ? 'flex' : 'none';
                if (match) visible++;
            });
            if (countEl) countEl.textContent = `Hiển thị ${visible} mã`;
            // Reset filter tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            if (!q) filterTabs[0]?.classList.add('active');
        });
    }
});
