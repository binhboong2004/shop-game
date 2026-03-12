document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('main-product-image');
    const thumbBtns = document.querySelectorAll('.thumb-btn');

    const nextBtn = document.getElementById('next-img-btn');
    const prevBtn = document.getElementById('prev-img-btn');

    let currentIndex = 0;
    // Lọc các nút có chứa ảnh
    const validThumbBtns = Array.from(thumbBtns).filter(btn => btn.querySelector('img'));

    function updateMainImage(index) {
        if (index >= 0 && index < validThumbBtns.length) {
            const img = validThumbBtns[index].querySelector('img');
            if (img && mainImage) {
                mainImage.src = img.src;

                // Update active state
                validThumbBtns.forEach(b => {
                    b.classList.remove('border-primary', 'opacity-100');
                    b.classList.add('border-transparent', 'opacity-70');
                });

                validThumbBtns[index].classList.remove('border-transparent', 'opacity-70');
                validThumbBtns[index].classList.add('border-primary', 'opacity-100');
            }
        }
    }

    if (validThumbBtns.length > 0) {
        // Init state
        updateMainImage(0);

        validThumbBtns.forEach((btn, index) => {
            btn.addEventListener('click', function () {
                currentIndex = index;
                updateMainImage(currentIndex);
            });
        });

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % validThumbBtns.length;
                updateMainImage(currentIndex);
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + validThumbBtns.length) % validThumbBtns.length;
                updateMainImage(currentIndex);
            });
        }
    }

    // Copy ID functionality
    const copyIcons = document.querySelectorAll('.copy-icon');
    copyIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const textToCopy = this.textContent.trim();
            navigator.clipboard.writeText(textToCopy).then(() => {
                // Optional: Show a small tooltip or toast here
                const originalTitle = this.getAttribute('title');
                this.setAttribute('title', 'Đã copy!');

                // Visual feedback
                const span = this.querySelector('span');
                if (span) {
                    const originalColor = span.className;
                    span.className = 'text-green-500 font-bold transition-colors';
                    setTimeout(() => {
                        span.className = originalColor;
                        this.setAttribute('title', originalTitle);
                    }, 1000);
                }
            });
        });
    });
});
