document.addEventListener('DOMContentLoaded', () => {
    // --- Dữ liệu vòng quay ---
    const prizes = [
        { label: '1,000 Robux', color: '#10b981', icon: 'redeem' },
        { label: 'Thêm 1 Lượt', color: '#3b82f6', icon: 'sync' },
        { label: 'Chúc bạn\nmay mắn\nlần sau', color: '#64748b', icon: 'sentiment_dissatisfied' },
        { label: '10,000 KC', color: '#f59e0b', icon: 'diamond' },
        { label: 'Acc VIP', color: '#E70814', icon: 'star' },
        { label: '500 Robux', color: '#10b981', icon: 'redeem' },
        { label: 'x2 Nạp Thẻ', color: '#8b5cf6', icon: 'bolt' },
        { label: '100 KC', color: '#f59e0b', icon: 'diamond' }
    ];

    const canvas = document.getElementById('wheelCanvas');
    const ctx = canvas.getContext('2d');
    const spinBtn = document.getElementById('spinBtn');
    
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

    // Khởi tạo vòng quay tự quay chậm
    canvas.classList.add('auto-rotating');

    // --- Xử lý Quay ---
    let currentRotation = 0;
    let isSpinning = false;

    spinBtn.addEventListener('click', () => {
        if (isSpinning) return;
        isSpinning = true;
        
        // Remove lớp tự động quay
        canvas.classList.remove('auto-rotating');
        
        // Disable nút
        spinBtn.disabled = true;
        spinBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-3xl">sync</span>';

        // Tính toán random phần thưởng
        const randomSliceIndex = Math.floor(Math.random() * numSlices);
        
        // Số vòng quay thêm (để tạo hiệu ứng) = min 5 vòng
        const extraSpins = 5; 
        
        // Góc để dừng lại (nằm giữa slice)
        // Lưu ý: CSS transform rotate đi theo chiều kim đồng hồ
        // Slice vẽ từ 0, pointer đang chĩa xuống (nếu không xoay canvas)
        // Nhưng pointer của chúng ta đè lên canvas ở góc -90deg (Top center)
        // Do đó cần bù trừ góc. Pointer ở Mũi nhọn hướng lên (Top)
        
        // 1 slice = 360 / 8 = 45deg
        // Chọn góc dừng vào giữa slice được chọn.
        // Góc quay = (số vòng * 360) + (360 - index * sliceAngleDeg) - (sliceAngleDeg / 2) - 90
        // Cách dễ nhất: Xoay 1 góc ngẫu nhiên đủ lớn, dừng lại, tính góc dư xem trúng vào khoảng nào
        
        // Thuật toán chuẩn:
        const sliceAngleDeg = 360 / numSlices;
        const targetDeg = randomSliceIndex * sliceAngleDeg + (sliceAngleDeg / 2); // Điểm giữa của slice
        
        // Do pointer nằm ở phía trên (270 độ hoặc -90 độ so với 0 là nằm ngang bên phải)
        const offsetDeg = 270; 
        
        // Tính góc xoay cần để mũi kim trúng target
        // Nếu canvas quay 0deg, mũi kim ở trên sẽ chỉ vào slice có góc 270deg.
        // Vậy nên ta cần quay slice mong muốn (targetDeg) về vị trí 270deg.
        // Rotation = 270 - targetDeg + 360 * extraSpins
        
        // Để vòng quay trông random hơn, thêm một góc ngẫu nhiên nhỏ trong slice (chếch đi chút khỏi chính giữa)
        const randomOffset = Math.random() * (sliceAngleDeg - 10) - (sliceAngleDeg / 2 - 5); 
        
        const finalRotation = offsetDeg - targetDeg + randomOffset + (360 * extraSpins);
        
        // Cộng dồn vào currentRotation để quay tiếp từ vị trí cũ, không bị giật lùi
        // Mẹo: tính toán góc delta so với currentRotation % 360
        const currentMod = currentRotation % 360;
        let delta = (offsetDeg - targetDeg + randomOffset) - currentMod;
        
        // Đảm bảo quay ít nhất extraSpins vòng
        if (delta <= 0) {
            delta += 360;
        }
        delta += 360 * extraSpins;
        
        currentRotation += delta;

        // Apply css transform
        canvas.style.transition = 'transform 5s cubic-bezier(0.2, 0.8, 0.2, 1)';
        canvas.style.transform = `rotate(${currentRotation}deg)`;

        // Kết thúc quay
        setTimeout(() => {
            isSpinning = false;
            spinBtn.disabled = false;
            spinBtn.innerHTML = '<span class="pb-1">QUAY</span>';
            
            showPrizeModal(prizes[randomSliceIndex]);
            
            // Nếu muốn, thêm lại class auto-rotating sau một lúc (cần reset rotation để ko bị lỗi css animation)
        }, 5000);
    });

    // --- Modal Logic ---
    const modal = document.getElementById('prizeModal');
    const closeBtn = document.getElementById('closeModalBtn');
    const backdrop = document.getElementById('prizeBackdrop');
    const playAgainBtn = document.getElementById('playAgainBtn');
    
    const prizeNameEl = document.getElementById('prizeName');
    const prizeIconEl = document.getElementById('prizeIcon');

    function showPrizeModal(prize) {
        prizeNameEl.innerText = prize.label.replace(/\n/g, ' ');
        prizeIconEl.innerText = prize.icon;
        
        // Đổi màu
        const textWrapperColor = prize.color === '#64748b' ? '#64748b' : '#E70814'; 
        prizeNameEl.style.color = textWrapperColor;
        
        modal.classList.remove('hidden');
        // Kích hoạt transition
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('.transform').classList.remove('scale-95');
            modal.querySelector('.transform').classList.add('scale-100');
        }, 10);

        // Bắn pháo hoa nếu trúng thưởng
        if (prize.color !== '#64748b') {
            fireConfetti();
        }
    }

    function hideModal() {
        modal.classList.add('opacity-0');
        modal.querySelector('.transform').classList.remove('scale-100');
        modal.querySelector('.transform').classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    closeBtn.addEventListener('click', hideModal);
    backdrop.addEventListener('click', hideModal);
    playAgainBtn.addEventListener('click', () => {
        hideModal();
        setTimeout(() => {
            spinBtn.click();
        }, 300);
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

    // --- Render Lịch sử trúng giả lập ---
    const recentWinnersEl = document.getElementById('recentWinners');
    const mockWinners = [
        { name: 'Nguyễn Văn A', prize: '10,000 Kim Cương', time: '1 phút trước', color: 'text-amber-500' },
        { name: 'Trần B', prize: '1,000 Robux', time: '3 phút trước', color: 'text-green-500' },
        { name: 'Hoàng C', prize: 'Acc VIP Liên Quân', time: '5 phút trước', color: 'text-[#E70814]' },
        { name: 'Lê D', prize: 'x2 Nạp Thẻ', time: '10 phút trước', color: 'text-purple-500' },
        { name: 'Phạm E', prize: '500 Robux', time: '15 phút trước', color: 'text-green-500' },
        { name: 'Vũ F', prize: '100 Kim Cương', time: '20 phút trước', color: 'text-amber-500' },
    ];

    function renderWinners() {
        let html = '';
        mockWinners.forEach(w => {
            html += `
                <div class="flex items-center justify-between p-4 border-b border-slate-100 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold">
                            ${w.name.charAt(0)}
                        </div>
                        <div>
                            <p class="font-medium text-slate-900 dark:text-white text-sm">${w.name}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">${w.time}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-sm ${w.color}">${w.prize}</span>
                    </div>
                </div>
            `;
        });
        recentWinnersEl.innerHTML = html;
    }

    renderWinners();
});
