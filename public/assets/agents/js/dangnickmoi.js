document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatarInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    if (avatarInput && fileNameDisplay) {
        avatarInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "Chọn ảnh tải lên...";
            fileNameDisplay.textContent = fileName;
            if (e.target.files[0]) {
                fileNameDisplay.classList.remove('text-agent-muted', 'opacity-70');
                fileNameDisplay.classList.add('text-white', 'font-medium');
            } else {
                fileNameDisplay.classList.add('text-agent-muted');
                fileNameDisplay.classList.remove('text-white', 'font-medium');
            }
        });
    }

    const isActiveCheckbox = document.getElementById('isActiveCheckbox');
    const statusDescription = document.getElementById('statusDescription');

    if (isActiveCheckbox && statusDescription) {
        isActiveCheckbox.addEventListener('change', function() {
            if (this.checked) {
                statusDescription.textContent = "Bật: Nick sẽ được hiển thị công khai trên Shop";
                statusDescription.classList.remove('text-agent-muted', 'opacity-70');
                statusDescription.classList.add('text-emerald-500');
            } else {
                statusDescription.textContent = "Tắt: Sẽ Ẩn nick này (Khách không thể mua)";
                statusDescription.classList.add('text-agent-muted', 'opacity-70');
                statusDescription.classList.remove('text-emerald-500');
            }
        });
        isActiveCheckbox.dispatchEvent(new Event('change'));
    }
});
