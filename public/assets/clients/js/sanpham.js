// Handle attribute button clicks
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.toggle('bg-primary/10');
            this.classList.toggle('border-primary');
            this.classList.toggle('text-primary');
        });
    });

    // Handle range inputs
    const rangeInputs = document.querySelectorAll('.range-input');
    rangeInputs.forEach(input => {
        input.addEventListener('input', function() {
            const labelId = this.getAttribute('data-target');
            const label = document.getElementById(labelId);
            if (label) {
                label.textContent = this.value;
            }

            // Prevent min > max
            const parent = this.closest('.relative');
            const minInput = parent.querySelector('.range-min');
            const maxInput = parent.querySelector('.range-max');
            
            if (parseInt(minInput.value) > parseInt(maxInput.value)) {
                if (this.classList.contains('range-min')) {
                    maxInput.value = this.value;
                    document.getElementById(maxInput.getAttribute('data-target')).textContent = this.value;
                } else {
                    minInput.value = this.value;
                    document.getElementById(minInput.getAttribute('data-target')).textContent = this.value;
                }
            }
        });
    });
});

function applyFilters() {
    const url = new URL(window.location.href);
    
    // Price filters
    const selectedPrices = Array.from(document.querySelectorAll('input[name="price"]:checked')).map(el => el.value);
    url.searchParams.delete('price');
    if (selectedPrices.length > 0) {
        url.searchParams.set('price', selectedPrices.join(','));
    }

    // Attribute filters (Dynamic)
    const attrValues = {};
    
    // Checkbox inputs
    document.querySelectorAll('.filter-input:not([name="price"])').forEach(input => {
        if (input.checked) {
            if (!attrValues[input.name]) attrValues[input.name] = [];
            attrValues[input.name].push(input.value);
        }
    });

    // Attribute buttons (select type)
    document.querySelectorAll('.filter-btn.bg-primary\\/10').forEach(btn => {
        const name = btn.getAttribute('data-name');
        const value = btn.getAttribute('data-value');
        if (!attrValues[name]) attrValues[name] = [];
        attrValues[name].push(value);
    });

    // Range inputs
    document.querySelectorAll('.range-input').forEach(input => {
        url.searchParams.set(input.name, input.value);
    });

    // Update URL with attributes
    const knownParams = ['game', 'category', 'price', 'sort', 'page'];
    // Clear dynamic params that are not in current selections (this is complex, let's just clear attributes we know exist)
    // For simplicity, we keep original logic but handle ranges separately
    Array.from(url.searchParams.keys()).forEach(key => {
        if (!knownParams.includes(key) && !key.endsWith('_min') && !key.endsWith('_max')) {
             url.searchParams.delete(key);
        }
    });

    Object.keys(attrValues).forEach(key => {
        url.searchParams.set(key, attrValues[key].join(','));
    });

    // Sorting
    const sort = document.getElementById('sort-select').value;
    url.searchParams.set('sort', sort);

    // Reset to page 1 when filtering
    url.searchParams.delete('page');

    window.location.href = url.toString();
}

async function toggleWishlist(accountId) {
    try {
        const response = await fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ account_id: accountId })
        });

        const data = await response.json();
        if (data.success) {
            const icons = document.querySelectorAll('.wishlist-icon-' + accountId);
            icons.forEach(icon => {
                if (data.status === 'added') {
                    icon.classList.add('fill-1', 'text-primary');
                } else {
                    icon.classList.remove('fill-1', 'text-primary');
                }
            });
            showToast(data.message, 'success');
        } else if (response.status === 401) {
            window.location.href = '/dangnhap';
        }
    } catch (error) {
        console.error('Error toggling wishlist:', error);
    }
}
