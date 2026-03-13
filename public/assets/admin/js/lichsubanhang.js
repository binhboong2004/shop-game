document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-detail-btn');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const orderId = this.dataset.id;
            
            // Show loading or just open modal with skeleton if needed
            // For now, let's fetch first
            try {
                const response = await fetch(`/admin/lich-su-ban-hang/${orderId}`);
                const result = await response.json();
                
                if (result.success) {
                    const data = result.data;
                    
                    document.getElementById('modal-txn-id').innerText = data.txn_id;
                    document.getElementById('modal-buyer-id').innerText = data.buyer_id;
                    document.getElementById('modal-buyer-name').innerText = data.buyer_name;
                    document.getElementById('modal-prod-id').innerText = data.product_id;
                    document.getElementById('modal-prod-name').innerText = data.product_name;
                    document.getElementById('modal-txn-amount').innerText = data.amount;
                    document.getElementById('modal-txn-time').innerText = data.time;
                    
                    const modalStatus = document.getElementById('modal-txn-status');
                    modalStatus.innerText = data.status === 'success' || data.status === 'completed' ? 'Thành công' : data.status;
                    modalStatus.className = `status-badge ${data.status === 'success' || data.status === 'completed' ? 'status-success' : 'status-failed'}`;
                    
                    openTransactionModal();
                }
            } catch (error) {
                console.error('Error fetching order details:', error);
                if (window.showToast) window.showToast('Lỗi khi lấy thông tin chi tiết!', 'error');
            }
        });
    });
});

function openTransactionModal() {
    const modal = document.getElementById('transactionModal');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeTransactionModal() {
    const modal = document.getElementById('transactionModal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('transactionModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeTransactionModal();
        }
    }
});
