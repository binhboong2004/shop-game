document.addEventListener('DOMContentLoaded', () => {
    const btnWithdrawAll = document.getElementById('btn-withdraw-all');
    const withdrawAmountInput = document.getElementById('withdraw-amount');
    const availableBalance = 15250000;

    if (btnWithdrawAll && withdrawAmountInput) {
        btnWithdrawAll.addEventListener('click', (e) => {
            e.preventDefault();
            withdrawAmountInput.value = new Intl.NumberFormat('vi-VN').format(availableBalance);
            document.querySelectorAll('.btn-fixed-amount').forEach(btn => {
                btn.classList.remove('active');
            });
        });
    }

    const fixedAmountBtns = document.querySelectorAll('.btn-fixed-amount');
    fixedAmountBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            
            fixedAmountBtns.forEach(b => b.classList.remove('active'));
            
            btn.classList.add('active');
            
            const amount = btn.getAttribute('data-amount');
            withdrawAmountInput.value = new Intl.NumberFormat('vi-VN').format(amount);
        });
    });

    const paymentMethodBtns = document.querySelectorAll('.btn-payment-method');
    paymentMethodBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            
            paymentMethodBtns.forEach(b => b.classList.remove('active'));
            
            btn.classList.add('active');
        });
    });

    const modal = document.getElementById('withdraw-detail-modal');
    const closeBtns = document.querySelectorAll('.btn-close-modal');
    const viewDetailBtns = document.querySelectorAll('.btn-view-detail');

    if (modal) {
        viewDetailBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr');
                if(row) {
                    const transId = row.querySelector('.col-trans-id').textContent.trim();
                    const amount = row.querySelector('.col-amount').innerText.trim();
                    const statusElem = row.querySelector('.col-status span');
                    
                    document.getElementById('modal-trans-id').textContent = transId;
                    document.getElementById('modal-amount').textContent = amount;
                    
                    const statusContainer = document.getElementById('modal-status');
                    statusContainer.innerHTML = '';
                    statusContainer.appendChild(statusElem.cloneNode(true));
                }

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('.modal-backdrop').classList.replace('opacity-0', 'opacity-100');
                    modal.querySelector('.modal-content').classList.replace('opacity-0', 'opacity-100');
                    modal.querySelector('.modal-content').classList.replace('scale-95', 'scale-100');
                }, 10);
            });
        });

        const closeModal = () => {
            modal.querySelector('.modal-backdrop').classList.replace('opacity-100', 'opacity-0');
            modal.querySelector('.modal-content').classList.replace('opacity-100', 'opacity-0');
            modal.querySelector('.modal-content').classList.replace('scale-100', 'scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        };

        closeBtns.forEach(btn => {
            btn.addEventListener('click', closeModal);
        });

        const backdrop = modal.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', closeModal);
        }
    }
});
