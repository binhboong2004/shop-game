document.addEventListener('DOMContentLoaded', () => {
    let itemToDelete = null;

    // --- Cập nhật số lượng danh sách yêu thích ---
    const updateCount = () => {
        const container = document.getElementById('wishlist-items-container');
        const countSpan = document.getElementById('wishlist-count');
        if(countSpan && container) {
            countSpan.textContent = container.children.length;
        }
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

    if(deleteModalBackdrop) deleteModalBackdrop.addEventListener('click', closeModal);
    if(btnCancelDelete) btnCancelDelete.addEventListener('click', closeModal);

    // Gắn sự kiện xóa
    const bindDeleteEvents = () => {
        const removeBtns = document.querySelectorAll('.remove-item');
        removeBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation(); // Ngăn click lan ra ngoài thẻ card
                const row = e.target.closest('.wishlist-item');
                openModal(row);
            });
        });
    };

    bindDeleteEvents();

    // Xác nhận xóa
    if(btnConfirmDelete) {
        btnConfirmDelete.addEventListener('click', async () => {
            if (itemToDelete) {
                const accountId = itemToDelete.getAttribute('data-id');

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
                        updateCount();
                        checkEmptyWishlist();
                        
                        // Cập nhật số đếm header
                        const headerWishlistCount = document.getElementById('wishlist-count-badge');
                        if (headerWishlistCount) headerWishlistCount.textContent = data.wishlist_count;
                    }, 300);

                    closeModal();
                } catch (error) {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                    closeModal();
                }
            }
        });
    }

    // --- Chức năng Thêm vào giỏ hàng ---
    const toast = document.getElementById('toast');
    let toastTimeout;

    const showToast = () => {
        if(!toast) return;
        // Reset animation
        toast.classList.remove('translate-y-20', 'opacity-0');
        
        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    };

    const bindAddToCartEvents = () => {
        const addBtns = document.querySelectorAll('.add-to-cart');
        addBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Hiển thị toast thông báo
                const toastMsg = document.getElementById('toast-msg');
                
                const accountId = btn.closest('.wishlist-item').getAttribute('data-id');
                btn.innerHTML = `<span class="material-symbols-outlined text-[16px]">hourglass_empty</span>Đang thêm`;

                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({ account_id: accountId })
                }).then(res => res.json()).then(data => {
                    if(data.success) {
                        if(toastMsg) toastMsg.textContent = data.message;
                        showToast();

                        const originalText = `<span class="material-symbols-outlined text-[18px]">shopping_cart</span> Thêm vào giỏ`;
                        btn.innerHTML = `<span class="material-symbols-outlined text-[16px]">check</span>Đã thêm`;
                        btn.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                        btn.classList.remove('bg-[#E70814]', 'hover:bg-red-700');
                        
                        // Cập nhật header cart count
                        const headerCartCount = document.getElementById('cart-count');
                        if (headerCartCount) headerCartCount.textContent = data.cart_count;

                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                            btn.classList.add('bg-[#E70814]', 'hover:bg-red-700');
                        }, 2000);
                    } else {
                        alert(data.message);
                        btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">shopping_cart</span> Thêm vào giỏ`;
                    }
                }).catch(err => {
                    console.error(err);
                    alert('Lỗi kết nối.');
                    btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">shopping_cart</span> Thêm vào giỏ`;
                });
            });
        });
    };

    bindAddToCartEvents();

    // --- Kiểm tra yêu thích trống ---
    const checkEmptyWishlist = () => {
        const container = document.getElementById('wishlist-items-container');
        if (container.children.length === 0) {
            
            // Ẩn tabs và header nếu muốn
            const tabs = document.querySelector('.border-b.border-red-900\\/30');
            if(tabs) tabs.style.display = 'none';

            const emptyHtml = `
                <div class="col-span-full bg-[#15171c] dark:bg-[#15171c] rounded-xl p-8 sm:p-12 border border-slate-800 shadow-sm flex flex-col items-center justify-center text-center w-full min-h-[400px]">
                    <div class="w-24 h-24 bg-red-500/10 rounded-full flex items-center justify-center mb-6 empty-wishlist-icon">
                        <span class="material-symbols-outlined text-[48px] text-red-500/50">favorite</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-white">Chưa có tài khoản yêu thích</h3>
                    <p class="text-slate-400 mb-6 max-w-sm">Bạn chưa lưu bất kỳ tài khoản nào. Hãy dạo quanh cửa hàng và lưu lại những tài khoản ưng ý nhé!</p>
                    <a href="/sanpham" class="bg-[#E70814] hover:bg-red-700 text-white px-6 py-3.5 rounded-xl font-bold transition-all shadow-lg shadow-red-500/20 hover:-translate-y-0.5 hover:shadow-red-500/40 inline-flex items-center gap-2">
                        <span class="material-symbols-outlined">explore</span>
                        Khám phá tài khoản ngay
                    </a>
                </div>
            `;
            container.innerHTML = emptyHtml;
            container.className = "flex flex-col w-full"; // Đổi grid lại thành flex cho box trống
        }
    };

});
