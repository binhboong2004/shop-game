document.addEventListener('DOMContentLoaded', () => {
    // --- Dữ liệu vòng quay ---
    let prizes = [];

    // Lấy dữ liệu thực từ window.wheelPrizes (truyền từ Blade)
    if (window.wheelPrizes && window.wheelPrizes.length > 0) {
        const colors = ['#10b981', '#3b82f6', '#64748b', '#f59e0b', '#E70814', '#a855f7', '#ec4899', '#06b6d4'];
        const icons = ['redeem', 'sync', 'sentiment_dissatisfied', 'diamond', 'star', 'bolt', 'card_giftcard', 'auto_awesome'];
        
        prizes = window.wheelPrizes.map((p, index) => ({
            label: p.name,
            color: p.color || colors[index % colors.length],
            icon: p.icon || icons[index % icons.length],
            value: p.value,
            type: p.type
        }));
    }

    const canvas = document.getElementById('wheelCanvas');
    const ctx = canvas.getContext('2d');
    const spinBtn = document.getElementById('spinBtn');
    
    // Nếu không có phần thưởng, hiển thị thông báo và dừng vẽ
    if (prizes.length === 0) {
        ctx.fillStyle = "#ffffff";
        ctx.font = "bold 16px sans-serif";
        ctx.textAlign = "center";
        ctx.fillText("Vòng quay này chưa được", canvas.width / 2, canvas.height / 2 - 10);
        ctx.fillText("cấu hình phần thưởng!", canvas.width / 2, canvas.height / 2 + 15);
        if (spinBtn) spinBtn.disabled = true;
        return;
    }

    const numSlices = prizes.length;
    const sliceAngle = (2 * Math.PI) / numSlices;
    let startAngle = 0;
    
    // Config hiển thị
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const radius = centerX - 10; // Padding

    // --- Vẽ vòng quay ---
    function drawWheel() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        for (let i = 0; i < numSlices; i++) {
            const angle = startAngle + i * sliceAngle;
            
            // Vẽ hình quạt
            ctx.beginPath();
            ctx.moveTo(centerX, centerY);
            ctx.arc(centerX, centerY, radius, angle, angle + sliceAngle);
            ctx.closePath();
            
            // Fill màu
            ctx.fillStyle = prizes[i].color;
            ctx.fill();
            
            // Viền
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#1e293b'; // Màu viền
            ctx.stroke();

            // Vẽ text
            ctx.save();
            ctx.translate(centerX, centerY);
            ctx.rotate(angle + sliceAngle / 2);
            ctx.textAlign = 'right';
            ctx.fillStyle = '#ffffff';
            ctx.font = 'bold 18px "Be Vietnam Pro", sans-serif';
            
            // Xử lý text xuống dòng
            const lines = prizes[i].label.split('\n');
            const lineHeight = 22;
            const textYOffset = (lines.length * lineHeight) / 2;
            
            for (let j = 0; j < lines.length; j++) {
                // Đẩy text ra xa tâm
                ctx.fillText(lines[j], radius - 20, (j * lineHeight) - textYOffset + 10);
            }
            
            ctx.restore();
        }
    }

    drawWheel();

    // --- Modals Xác nhận ---
    const confirmModal = document.getElementById('confirmSpinModal');
    const confirmBtn = document.getElementById('confirmBtn');
    const cancelSpinBtn = document.getElementById('cancelSpinBtn');
    const confirmBackdrop = document.getElementById('confirmBackdrop');

    function showConfirm() {
        if (!confirmModal) return;
        confirmModal.classList.remove('hidden');
        setTimeout(() => {
            confirmModal.classList.remove('opacity-0');
            confirmModal.querySelector('.transform').classList.remove('scale-95');
            confirmModal.querySelector('.transform').classList.add('scale-100');
        }, 10);
    }

    function hideConfirm() {
        if (!confirmModal) return;
        confirmModal.classList.add('opacity-0');
        confirmModal.querySelector('.transform').classList.remove('scale-100');
        confirmModal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => confirmModal.classList.add('hidden'), 300);
    }

    cancelSpinBtn?.addEventListener('click', hideConfirm);
    confirmBackdrop?.addEventListener('click', hideConfirm);

    // --- Xử lý Quay ---
    let isSpinning = false;
    let rotationSpeed = 0.005; // Tốc độ quay tự động ban đầu

    // Animation Loop
    function animationLoop() {
        if (!isSpinning) {
            startAngle += rotationSpeed;
            drawWheel();
        }
        requestAnimationFrame(animationLoop);
    }
    
    // Start the loop
    requestAnimationFrame(animationLoop);

    spinBtn.addEventListener('click', () => {
        if (isSpinning) return;
        showConfirm();
    });

    confirmBtn.addEventListener('click', async () => {
        hideConfirm();
        if (isSpinning) return;

        isSpinning = true;
        spinBtn.disabled = true;
        const originalContent = spinBtn.innerHTML;
        spinBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-3xl">sync</span>';

        try {
            const response = await fetch(window.spinUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (!data.success) {
                if (window.showToast) window.showToast(data.message, 'error');
                else alert(data.message);
                
                isSpinning = false;
                spinBtn.disabled = false;
                spinBtn.innerHTML = originalContent;
                return;
            }

            // Bắt đầu quay nhanh
            const prizeIndex = data.prize_index;
            const extraSpins = 5; 
            
            // Tính toán góc đích
            // Kim ở trên (3*PI/2), Slice index i nằm ở [startAngle + i*sliceAngle, startAngle + (i+1)*sliceAngle]
            // Ta muốn stopAngle sao cho (stopAngle + prizeIndex*sliceAngle + sliceAngle/2) % 2PI = 3PI/2
            // => stopAngle = 3PI/2 - (prizeIndex*sliceAngle + sliceAngle/2)
            
            const targetRotation = (extraSpins * 2 * Math.PI) + 
                                  (1.5 * Math.PI - (prizeIndex * sliceAngle + sliceAngle / 2));
            
            const startTime = performance.now();
            const duration = 5000;
            const initialAngle = startAngle % (2 * Math.PI);

            function animate(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Ease Out Cubic
                const easing = 1 - Math.pow(1 - progress, 3);
                
                startAngle = initialAngle + easing * targetRotation;
                drawWheel();

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    isSpinning = false;
                    spinBtn.disabled = false;
                    spinBtn.innerHTML = originalContent;
                    
                    showPrizeModal(data.prize);
                    
                    // Cập nhật số dư
                    const balanceEls = document.querySelectorAll('.user-balance-text, #userBalance');
                    balanceEls.forEach(el => {
                        if (data.new_balance) el.innerText = data.new_balance;
                    });
                    
                    fireConfetti();
                }
            }

            requestAnimationFrame(animate);

        } catch (error) {
            console.error(error);
            alert('Lỗi kết nối máy chủ!');
            isSpinning = false;
            spinBtn.disabled = false;
            spinBtn.innerHTML = originalContent;
        }
    });

    // --- Modal Kết Quả ---
    const modal = document.getElementById('prizeModal');
    const closeBtn = document.getElementById('closeModalBtn');
    const backdrop = document.getElementById('prizeBackdrop');
    const playAgainBtn = document.getElementById('playAgainBtn');
    
    const prizeNameEl = document.getElementById('prizeResultName');
    const prizeIconEl = document.getElementById('prizeIcon');

    function showPrizeModal(prize) {
        prizeNameEl.innerText = prize.name;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10);
    }

    function hideModal() {
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.remove('scale-100');
        modal.querySelector('.transform').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            location.reload(); // Reload để cập nhật số dư và lịch sử thật từ server
        }, 300);
    }

    closeBtn.addEventListener('click', hideModal);
    backdrop.addEventListener('click', hideModal);
    playAgainBtn.addEventListener('click', () => {
        hideModal();
        setTimeout(() => spinBtn.click(), 300);
    });

    // Pháo hoa effect bằng canvas-confetti
    function fireConfetti() {
        if (typeof confetti === 'function') {
            const duration = 3000;
            const animationEnd = Date.now() + duration;
            const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 60 };

            const interval = setInterval(function() {
                const timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                const particleCount = 50 * (timeLeft / duration);
                
                // since particles fall down, start a bit higher than random
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        }
    }

    function randomInRange(min, max) {
      return Math.random() * (max - min) + min;
    }

    // --- Render Lịch sử trúng thưởng thật ---
    const recentWinnersEl = document.getElementById('recentWinners');

    function formatTime(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);
        
        if (diffInSeconds < 60) return 'Vừa xong';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' phút trước';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' giờ trước';
        return date.toLocaleDateString('vi-VN');
    }

    function renderWinners() {
        if (!window.recentHistories || window.recentHistories.length === 0) {
            recentWinnersEl.innerHTML = `
                <div class="flex flex-col items-center justify-center p-12 text-slate-400">
                    <span class="material-symbols-outlined text-4xl mb-2 opacity-20">history</span>
                    <p class="text-sm">Chưa có lịch sử quay</p>
                </div>
            `;
            return;
        }

        let html = '';
        window.recentHistories.forEach(h => {
            const userName = h.user ? h.user.name : 'Người dùng';
            const prizeName = h.prize ? h.prize.name : 'Phần thưởng';
            const timeAgo = formatTime(h.created_at);
            
            // Ẩn bớt tên người dùng để bảo mật (VD: Nguyễn *** A)
            const nameParts = userName.split(' ');
            let hiddenName = userName;
            if (nameParts.length > 1) {
                hiddenName = `${nameParts[0]} *** ${nameParts[nameParts.length - 1]}`;
            } else if (userName.length > 3) {
                hiddenName = userName.substring(0, 2) + '***';
            }

            html += `
                <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold">
                            ${userName.charAt(0)}
                        </div>
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white text-sm">${hiddenName}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">${timeAgo}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-sm text-[#E70814]">${prizeName}</span>
                    </div>
                </div>
            `;
        });
        recentWinnersEl.innerHTML = html;
    }

    renderWinners();
});
