document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-detail-btn');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('tr');
            
            const txnId = row.querySelector('td:nth-child(1)').innerText;
            const buyerCell = row.querySelector('td:nth-child(2)');
            const buyerName = buyerCell.querySelector('.font-medium').innerText;
            const buyerId = buyerCell.querySelector('.text-xs').innerText.replace('ID: ', '');
            
            const prodCell = row.querySelector('td:nth-child(3)');
            const prodName = prodCell.querySelector('.font-medium').innerText;
            const prodId = prodCell.querySelector('.text-xs').innerText.replace('ID: ', '');
            
            const amount = row.querySelector('td:nth-child(4)').innerText;
            const statusNode = row.querySelector('td:nth-child(5) .status-badge');
            const statusClass = statusNode.className;
            const statusText = statusNode.innerText;
            
            const timeRaw = row.querySelector('td:nth-child(6)').innerText;
            const timeFormatted = timeRaw.replace('\n', ' ');
            
            document.getElementById('modal-txn-id').innerText = txnId;
            document.getElementById('modal-buyer-id').innerText = buyerId;
            document.getElementById('modal-buyer-name').innerText = buyerName;
            document.getElementById('modal-prod-id').innerText = prodId;
            document.getElementById('modal-prod-name').innerText = prodName;
            document.getElementById('modal-txn-amount').innerText = amount;
            document.getElementById('modal-txn-time').innerText = timeFormatted;
            
            const modalStatus = document.getElementById('modal-txn-status');
            modalStatus.className = statusClass;
            modalStatus.innerText = statusText;
            
            openTransactionModal();
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
        if (!modal.classList.contains('hidden')) {
            closeTransactionModal();
        }
    }
});
