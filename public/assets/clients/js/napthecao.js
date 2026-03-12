/**
 * js/napthecao.js
 * Quản lý frontend logic của form Nạp thẻ cào
 */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-nap-the');
    const loadingOverlay = document.getElementById('loading-overlay');
    const btnSubmit = document.getElementById('btn-submit');
    const serialInput = document.getElementById('serial-input');
    const pinInput = document.getElementById('pin-input');
    const tbHstb = document.getElementById('history-table-body');

    // Validation
    function showError(inputId, errorId, show) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(errorId);
        if (show) {
            input.classList.add('border-red-500', 'focus:ring-red-500');
            input.classList.remove('border-primary/20', 'focus:ring-primary');
            error.classList.remove('hidden');
        } else {
            input.classList.remove('border-red-500', 'focus:ring-red-500');
            input.classList.add('border-primary/20', 'focus:ring-primary');
            error.classList.add('hidden');
        }
    }

    // Validate Input form
    serialInput.addEventListener('input', () => {
        showError('serial-input', 'err-serial', serialInput.value.trim().length > 0 && serialInput.value.trim().length < 5);
    });

    pinInput.addEventListener('input', () => {
        showError('pin-input', 'err-pin', pinInput.value.trim().length > 0 && pinInput.value.trim().length < 5);
    });

    // Form Submit
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // 1. Get values
        const network = form.querySelector('input[name="network"]:checked');
        const amount = form.querySelector('input[name="amount"]:checked');
        const serial = serialInput.value.trim();
        const pin = pinInput.value.trim();

        // 2. Validate
        let hasError = false;

        if (!network) {
            showToast('Lỗi', 'Vui lòng chọn nhà mạng', 'error');
            hasError = true;
        }
        else if (!amount) {
            showToast('Lỗi', 'Vui lòng chọn mệnh giá thẻ', 'error');
            hasError = true;
        }
        else if (serial.length < 5) {
            showError('serial-input', 'err-serial', true);
            hasError = true;
        }
        else if (pin.length < 5) {
            showError('pin-input', 'err-pin', true);
            hasError = true;
        }

        if (hasError) return;

        // 3. Show loading & simulate API call
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');

        // Disable form elements
        const formElements = form.elements;
        for (let i = 0; i < formElements.length; i++) {
            formElements[i].disabled = true;
        }

        setTimeout(() => {
            // Restore form
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');
            for (let i = 0; i < formElements.length; i++) {
                formElements[i].disabled = false;
            }

            // Fake success response
            showToast('Thành công', `Thẻ ${network.value.toUpperCase()} mệnh giá ${parseInt(amount.value).toLocaleString('vi-VN')} đang được xử lý.`, 'success');

            // Add to history
            addHistoryRow(network.value, amount.value);

            // Reset form (keep network and price selected if you want, but demo will full reset)
            form.reset();

        }, 2000);
    });

    // History builder 
    function addHistoryRow(net, amnt) {
        // Remove empty state if present
        if (tbHstb.querySelector('td[colspan="6"]')) {
            tbHstb.innerHTML = '';
        }

        const now = new Date();
        const timeStr = `${now.getHours().toString().padStart(2, '0')}:${now.getMinutes().toString().padStart(2, '0')} - ${now.getDate().toString().padStart(2, '0')}/${(now.getMonth() + 1).toString().padStart(2, '0')}`;

        let netColor = '';
        let netName = '';
        switch (net) {
            case 'viettel': netColor = 'text-green-500 bg-green-500/10 border-green-500/20'; netName = 'Viettel'; break;
            case 'vinaphone': netColor = 'text-blue-500 bg-blue-500/10 border-blue-500/20'; netName = 'Vinaphone'; break;
            case 'mobifone': netColor = 'text-red-500 bg-red-500/10 border-red-500/20'; netName = 'Mobifone'; break;
        }

        const txCode = 'GD' + Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
        const receiveAmount = (parseInt(amnt) * 0.9).toLocaleString('vi-VN') + 'đ'; // Fake 90%
        const formattedAmnt = parseInt(amnt).toLocaleString('vi-VN') + 'đ';

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-primary/5 transition-colors group';
        tr.innerHTML = `
            <td class="px-6 py-4 font-mono font-bold text-slate-700 dark:text-slate-300">#${txCode}</td>
            <td class="px-6 py-4">
                <span class="${netColor} px-3 py-1.5 rounded-full text-xs font-bold border flex items-center gap-1 w-fit">
                    ${netName}
                </span>
            </td>
            <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-medium">${formattedAmnt}</td>
            <td class="px-6 py-4">
                <span class="bg-yellow-500/10 text-yellow-500 px-3 py-1.5 rounded-full text-xs font-bold border border-yellow-500/20 inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] animate-spin">sync</span> Chờ xử lý...
                </span>
            </td>
            <td class="px-6 py-4 font-black text-slate-400">Đang tính...</td>
            <td class="px-6 py-4 text-right text-xs text-slate-500">${timeStr}</td>
        `;

        tbHstb.prepend(tr);

        // Fake update status after 5s
        setTimeout(() => {
            const statusTd = tr.querySelector('td:nth-child(4)');
            const receiveTd = tr.querySelector('td:nth-child(5)');

            statusTd.innerHTML = `
                <span class="bg-green-500/10 text-green-500 px-3 py-1.5 rounded-full text-xs font-bold border border-green-500/20 inline-flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px]">check_circle</span> Hoàn thành
                </span>
            `;
            receiveTd.className = 'px-6 py-4 font-black text-primary';
            receiveTd.innerText = receiveAmount;

            showToast('Cập nhật', `Giao dịch #${txCode} đã nạp thành công!`, 'success');
        }, 5000);
    }

    // Custom Toast Notification System
    function showToast(title, message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast-slide-in min-w-[300px] bg-white dark:bg-background-dark border rounded-xl shadow-2xl p-4 flex gap-3 items-start relative overflow-hidden';

        let iconClass = '';
        let iconName = '';
        let borderClass = '';
        let progressColor = '';

        switch (type) {
            case 'success':
                iconClass = 'text-green-500 bg-green-500/10';
                iconName = 'check_circle';
                borderClass = 'border-green-500/30';
                progressColor = 'bg-green-500';
                break;
            case 'error':
                iconClass = 'text-red-500 bg-red-500/10';
                iconName = 'error';
                borderClass = 'border-red-500/30';
                progressColor = 'bg-red-500';
                break;
            case 'warning':
                iconClass = 'text-yellow-500 bg-yellow-500/10';
                iconName = 'warning';
                borderClass = 'border-yellow-500/30';
                progressColor = 'bg-yellow-500';
                break;
        }

        toast.classList.add(borderClass.split('/')[0]); // Add border color class dynamically

        toast.innerHTML = `
            <div class="flex-shrink-0 size-8 rounded-full flex items-center justify-center ${iconClass}">
                <span class="material-symbols-outlined text-[20px]">${iconName}</span>
            </div>
            <div class="flex-1 pr-6">
                <h4 class="font-bold text-sm text-slate-800 dark:text-slate-100">${title}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">${message}</p>
            </div>
            <button class="absolute top-3 right-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors close-toast">
                <span class="material-symbols-outlined text-[16px]">close</span>
            </button>
            <div class="absolute bottom-0 left-0 h-1 ${progressColor} w-full" style="animation: toastProgress 3s linear forwards;"></div>
        `;

        // Add keyframe dynamically inside document
        if (!document.getElementById('toast-keyframes')) {
            const style = document.createElement('style');
            style.id = 'toast-keyframes';
            style.innerHTML = `@keyframes toastProgress { from { width: 100%; } to { width: 0%; } }`;
            document.head.appendChild(style);
        }

        container.appendChild(toast);

        // Close functions
        const removeToast = () => {
            toast.classList.remove('toast-slide-in');
            toast.classList.add('toast-fade-out');
            setTimeout(() => {
                if (container.contains(toast)) container.removeChild(toast);
            }, 300);
        };

        toast.querySelector('.close-toast').addEventListener('click', removeToast);
        setTimeout(removeToast, 3000); // Auto remove after 3s
    }
});
