document.addEventListener('DOMContentLoaded', () => {
    // --- Khởi tạo dữ liệu ---
    let subtotal = 0;
    
    // Tính tổng tiền động từ các item
    document.querySelectorAll('.cart-item').forEach(item => {
        const price = parseInt(item.getAttribute('data-price')) || 0;
        subtotal += price;
    });

    let discount = 0;
    let itemToDelete = null;

    const subtotalEl = document.getElementById('subtotal');
    const totalEl = document.getElementById('total-price');
    const discountRowEl = document.getElementById('discount-row');
    const discountAmountEl = document.getElementById('discount-amount');

    // Format tiền VNĐ
    const formatMoney = (amount) => {
        return amount.toLocaleString('vi-VN') + 'đ';
    };

    // Cập nhật tổng tiền
    const updateTotals = () => {
        subtotalEl.textContent = formatMoney(subtotal);
        if (discount > 0) {
            discountRowEl.classList.remove('hidden');
            discountAmountEl.textContent = '-' + formatMoney(discount);
        } else {
            discountRowEl.classList.add('hidden');
        }
        totalEl.textContent = formatMoney(subtotal - discount);
    };

    // --- Modal Xóa Sản Phẩm ---
    const deleteModal = document.getElementById('delete-modal');
    const deleteModalBackdrop = document.getElementById('delete-modal-backdrop');
    const btnCancelDelete = document.getElementById('cancel-delete');
    const btnConfirmDelete = document.getElementById('confirm-delete');

    const openModal = (item) => {
        itemToDelete = item;
        deleteModal.classList.add('modal-active');
        document.body.style.overflow = 'hidden'; // Ngăn cuộn trang
    };

    const closeModal = () => {
        deleteModal.classList.remove('modal-active');
        document.body.style.overflow = '';
        setTimeout(() => { itemToDelete = null; }, 300);
    };

    deleteModalBackdrop.addEventListener('click', closeModal);
    btnCancelDelete.addEventListener('click', closeModal);

    // Gắn sự kiện xóa cho các nút ban đầu
    const removeBtns = document.querySelectorAll('.remove-item');
    removeBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const row = e.target.closest('.cart-item');
            openModal(row);
        });
    });

    // Tìm token CSRF cho AJAX Laravel
    const csrfTokenElements = document.querySelectorAll('meta[name="csrf-token"]');
    const csrfToken = csrfTokenElements.length > 0 ? csrfTokenElements[0].getAttribute('content') : '';

    // Xác nhận xóa
    btnConfirmDelete.addEventListener('click', async () => {
        if (itemToDelete) {
            const accountId = itemToDelete.getAttribute('data-id');
            const price = parseInt(itemToDelete.getAttribute('data-price')) || 0;
            
            // Gửi AJAX xóa
            try {
                const response = await fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ account_id: accountId })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    alert(data.message || 'Lỗi khi xóa sản phẩm');
                    closeModal();
                    return;
                }
                
                // Hiệu ứng xóa
                itemToDelete.style.transform = 'scale(0.95)';
                itemToDelete.style.opacity = '0';

                setTimeout(() => {
                    itemToDelete.remove();
                    subtotal -= price;
                    if (subtotal < 0) subtotal = 0;

                    // Nếu mã giảm giá lớn hơn tổng tiền -> reset mã
                    if (discount > subtotal) {
                        discount = 0;
                        const msgEl = document.getElementById('coupon-message');
                        msgEl.textContent = 'Mã giảm giá không còn hiệu lực do tổng tiền thay đổi.';
                        msgEl.className = 'text-xs mt-2 font-medium text-orange-500 block';
                        document.getElementById('coupon-code').value = '';
                    }

                    updateTotals();
                    checkEmptyCart();
                    // Cập nhật số đếm trên header nếu có element
                    const headerCartCount = document.getElementById('cart-count');
                    if (headerCartCount) headerCartCount.textContent = data.cart_count;
                }, 300);

                closeModal();
            
            } catch (error) {
                console.error('Error:', error);
                alert('Có lỗi xảy ra, vui lòng thử lại.');
                closeModal();
            }
        }
    });

    // --- Mã giảm giá ---
    const btnApplyCoupon = document.getElementById('apply-coupon');
    const inputCoupon = document.getElementById('coupon-code');
    const msgCoupon = document.getElementById('coupon-message');

    btnApplyCoupon.addEventListener('click', async () => {
        const code = inputCoupon.value.trim().toUpperCase();

        msgCoupon.classList.add('hidden');

        if (subtotal === 0) {
            msgCoupon.textContent = 'Giỏ hàng đang trống.';
            msgCoupon.className = 'text-xs mt-2 font-medium text-red-500 block';
            msgCoupon.classList.remove('hidden');
            return;
        }

        if (code === '') {
            msgCoupon.textContent = 'Vui lòng nhập mã giảm giá.';
            msgCoupon.className = 'text-xs mt-2 font-medium text-red-500 block';
            msgCoupon.classList.remove('hidden');
            discount = 0;
            updateTotals();
            return;
        }

        btnApplyCoupon.disabled = true;
        btnApplyCoupon.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">refresh</span>';

        try {
            const response = await fetch('/coupon/apply', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    code: code,
                    subtotal: subtotal
                })
            });

            const data = await response.json();

            msgCoupon.classList.remove('hidden');
            
            if (data.success) {
                discount = data.data.discount_amount;
                msgCoupon.textContent = data.message;
                msgCoupon.className = 'text-xs mt-2 font-medium text-emerald-500 block';
            } else {
                discount = 0;
                msgCoupon.textContent = data.message;
                msgCoupon.className = 'text-xs mt-2 font-medium text-red-500 block';
            }
            updateTotals();

        } catch (error) {
            console.error('Coupon error:', error);
            msgCoupon.textContent = 'Có lỗi xảy ra, vui lòng thử lại.';
            msgCoupon.className = 'text-xs mt-2 font-medium text-red-500 block';
            msgCoupon.classList.remove('hidden');
        } finally {
            btnApplyCoupon.disabled = false;
            btnApplyCoupon.innerText = 'Áp dụng';
        }
    });

    // Nhấn Enter để áp dụng mã
    inputCoupon.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            btnApplyCoupon.click();
        }
    });

    // --- Kiểm tra giỏ hàng trống ---
    const checkEmptyCart = () => {
        const container = document.getElementById('cart-items-container');
        if (container.children.length === 0) {
            const emptyHtml = `
                <div class="bg-white dark:bg-[#1a1c23] rounded-xl p-8 sm:p-12 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col items-center justify-center text-center w-full">
                    <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-6 empty-cart-icon">
                        <span class="material-symbols-outlined text-[48px] text-slate-400">shopping_cart</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Giỏ hàng trống</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6 max-w-sm">Chưa có sản phẩm nào trong giỏ hàng của bạn. Hãy quay lại cửa hàng để chọn cho mình những tài khoản ưng ý nhé!</p>
                    <a href="/sanpham" class="bg-[#E70814] hover:bg-red-700 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg shadow-red-500/20 hover:-translate-y-0.5 inline-flex items-center gap-2">
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                        Tiếp tục mua sắm
                    </a>
                </div>
            `;
            container.innerHTML = emptyHtml;
            // Disable thanh toán
            const checkoutBtn = document.getElementById('btn-checkout');
            if (checkoutBtn) {
                checkoutBtn.disabled = true;
                checkoutBtn.className = "w-full bg-slate-200 dark:bg-slate-800 text-slate-400 rounded-xl py-3.5 sm:py-4 font-bold text-base sm:text-lg flex justify-center items-center gap-2 cursor-not-allowed transition-all shadow-none group";
            }
        }
    };

    // --- Tiến hành thanh toán ---
    const btnCheckout = document.getElementById('btn-checkout');
    if (btnCheckout) {
        btnCheckout.addEventListener('click', async () => {
            if (btnCheckout.disabled) return;

            // Optional: You could show a confirmation dialog here

            const orgHTML = btnCheckout.innerHTML;
            btnCheckout.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Đang xử lý...';
            btnCheckout.disabled = true;

            try {
                const response = await fetch('/cart/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        coupon_code: inputCoupon.value.trim().toUpperCase()
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    if (window.showToast) {
                        window.showToast(data.message, 'success');
                    } else {
                        alert(data.message);
                    }
                    
                    setTimeout(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            window.location.reload();
                        }
                    }, 1500);
                } else {
                    if (window.showToast) {
                        window.showToast(data.message || 'Lỗi khi thanh toán. Vui lòng thử lại sau.', 'error');
                    } else {
                        alert(data.message || 'Lỗi khi thanh toán. Vui lòng thử lại sau.');
                    }
                    btnCheckout.innerHTML = orgHTML;
                    btnCheckout.disabled = false;
                }
            } catch (error) {
                console.error('Checkout error:', error);
                if (window.showToast) {
                    window.showToast('Có lỗi xảy ra trong quá trình thanh toán, vui lòng kiểm tra kết nối mạng và thử lại.', 'error');
                } else {
                    alert('Có lỗi xảy ra trong quá trình thanh toán, vui lòng kiểm tra kết nối mạng và thử lại.');
                }
                btnCheckout.innerHTML = orgHTML;
                btnCheckout.disabled = false;
            }
        });
    }

    // Khởi tạo
    updateTotals();
});
