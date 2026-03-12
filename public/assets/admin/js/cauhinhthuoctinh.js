document.addEventListener('DOMContentLoaded', function() {
    const addAttributeBtn = document.getElementById('addAttributeBtn');
    const attributeModal = document.getElementById('attributeModal');
    const deleteModal = document.getElementById('deleteModal');
    const attributeForm = document.getElementById('attributeForm');
    
    const attrTypeSelect = document.getElementById('attrType');
    const selectOptionsContainer = document.getElementById('selectOptionsContainer');

    const searchInput = document.getElementById('searchInput');
    const gameFilter = document.getElementById('gameFilter');
    const typeFilter = document.getElementById('typeFilter');
    const filterBtn = document.getElementById('filterBtn');
    const rows = document.querySelectorAll('.attribute-row');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    let currentEditId = null;
    let currentDeleteId = null;

    function applyFilters() {
        const searchTerm = searchInput.value.toLowerCase();
        const gameValue = gameFilter.value;
        const typeValue = typeFilter.value;

        rows.forEach(row => {
            const searchData = row.getAttribute('data-search').toLowerCase();
            const gamesData = JSON.parse(row.getAttribute('data-games') || '[]');
            const typeData = row.getAttribute('data-type');

            const matchSearch = searchData.includes(searchTerm);
            const matchGame = gameValue === 'all' || gamesData.includes(parseInt(gameValue));
            const matchType = typeValue === 'all' || typeData === typeValue;

            if (matchSearch && matchGame && matchType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (filterBtn) {
        filterBtn.addEventListener('click', applyFilters);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') applyFilters();
        });
    }

    if (attrTypeSelect) {
        attrTypeSelect.addEventListener('change', function() {
            if (this.value === 'select') {
                selectOptionsContainer.classList.remove('hidden');
                document.getElementById('attrOptions').setAttribute('required', 'required');
            } else {
                selectOptionsContainer.classList.add('hidden');
                document.getElementById('attrOptions').removeAttribute('required');
            }
        });
    }

    function openModal(modalId, title = 'Thêm Thuộc Tính Mới', isEdit = false) {
        const modal = document.getElementById(modalId);
        if(!modal) return;
        
        modal.classList.remove('hidden');
        
        if (modalId === 'attributeModal') {
            document.getElementById('modalTitle').textContent = title;
            if (!isEdit) {
                currentEditId = null;
                attributeForm.reset();
                if(attrTypeSelect) {
                    attrTypeSelect.dispatchEvent(new Event('change'));
                }
            }
        }
        
        setTimeout(() => {
            modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
            modal.classList.add('modal-active');
        }, 10);
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if(!modal) return;
        
        modal.classList.remove('modal-active');
        modal.querySelector('div').classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    if(addAttributeBtn) {
        addAttributeBtn.addEventListener('click', () => {
            openModal('attributeModal');
        });
    }

    // Handle Edit Button Client
    document.querySelectorAll('.btn-edit-attribute').forEach(btn => {
        btn.addEventListener('click', function() {
            const attrData = JSON.parse(this.getAttribute('data-attribute'));
            currentEditId = attrData.id;
            
            document.getElementById('attrName').value = attrData.name;
            document.getElementById('attrVariable').value = attrData.variable_name;
            
            // Set multiple games
            const attrGamesSelect = document.getElementById('attrGames');
            Array.from(attrGamesSelect.options).forEach(option => {
                option.selected = attrData.games.some(g => g.id == option.value);
            });

            document.getElementById('attrType').value = attrData.type;
            
            if (attrData.type === 'select' && attrData.options) {
                document.getElementById('attrOptions').value = attrData.options.join('\n');
            } else {
                document.getElementById('attrOptions').value = '';
            }
            
            document.getElementById('attrStatus').checked = (attrData.status === 'active');

            openModal('attributeModal', 'Sửa Thuộc Tính', true);
            attrTypeSelect.dispatchEvent(new Event('change'));
        });
    });

    // Handle Config Options Button
    document.querySelectorAll('.btn-config-options').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const dataStr = row.querySelector('.btn-edit-attribute').getAttribute('data-attribute');
            const attrData = JSON.parse(dataStr);
            currentEditId = attrData.id;
            
            document.getElementById('attrName').value = attrData.name;
            document.getElementById('attrVariable').value = attrData.variable_name;
            
            // Set multiple games
            const attrGamesSelect = document.getElementById('attrGames');
            Array.from(attrGamesSelect.options).forEach(option => {
                option.selected = attrData.games.some(g => g.id == option.value);
            });

            document.getElementById('attrType').value = 'select'; // forcefully setting
            
            if (attrData.options) {
                document.getElementById('attrOptions').value = attrData.options.join('\n');
            }
            
            document.getElementById('attrStatus').checked = (attrData.status === 'active');

            openModal('attributeModal', 'Cấu hình giá trị thuộc tính', true);
            attrTypeSelect.dispatchEvent(new Event('change'));
        });
    });

    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener('click', () => closeModal('attributeModal'));
    });

    document.querySelectorAll('.btn-cancel-delete').forEach(btn => {
        btn.addEventListener('click', () => closeModal('deleteModal'));
    });

    [attributeModal, deleteModal].forEach(modal => {
        if(modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal.id);
                }
            });
        }
    });

    // Delete Attribute Action
    document.querySelectorAll('.btn-delete-attribute').forEach(btn => {
        btn.addEventListener('click', function() {
            currentDeleteId = this.getAttribute('data-id');
            openModal('deleteModal');
        });
    });

    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function() {
            if(!currentDeleteId) return;
            
            closeModal('deleteModal');
            const originalText = confirmDeleteBtn.innerText;
            confirmDeleteBtn.innerText = 'Đang xóa...';
            confirmDeleteBtn.disabled = true;

            fetch(`/admin/cau-hinh-thuoc-tinh/${currentDeleteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showToast('Lỗi: ' + (data.message || 'Không thể xóa'), 'error');
                    confirmDeleteBtn.innerText = originalText;
                    confirmDeleteBtn.disabled = false;
                }
            })
            .catch(err => {
                window.showToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
                confirmDeleteBtn.innerText = originalText;
                confirmDeleteBtn.disabled = false;
            });
        });
    }

    // Toggle Status Action
    document.querySelectorAll('.status-switch').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            
            fetch(`/admin/cau-hinh-thuoc-tinh/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) {
                    // Revert UI on failure
                    this.checked = !this.checked;
                    window.showToast('Lỗi: ' + (data.message || 'Không thể thay đổi trạng thái'), 'error');
                } else {
                    window.showToast(data.message, 'success');
                }
            })
            .catch(err => {
                // Revert UI on failure
                this.checked = !this.checked;
                window.showToast('Có lỗi mạng xảy ra, không thể thay đổi trạng thái', 'error');
            });
        });
    });

    // Create / Update AJAX Submit
    if(attributeForm) {
        attributeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            closeModal('attributeModal');
            
            const btnSave = document.getElementById('btnSave');
            const originalText = btnSave.innerText;
            btnSave.innerText = 'Đang lưu...';
            btnSave.disabled = true;

            const selectedGameIds = Array.from(document.getElementById('attrGames').selectedOptions).map(opt => opt.value);

            const formData = {
                name: document.getElementById('attrName').value,
                variable_name: document.getElementById('attrVariable').value,
                game_ids: selectedGameIds,
                type: document.getElementById('attrType').value,
                status: document.getElementById('attrStatus').checked ? 'active' : 'inactive',
                options: document.getElementById('attrType').value === 'select' ? document.getElementById('attrOptions').value : ''
            };

            const url = currentEditId ? `/admin/cau-hinh-thuoc-tinh/${currentEditId}` : '/admin/cau-hinh-thuoc-tinh';
            const method = currentEditId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(async res => {
                const data = await res.json();
                if(!res.ok) {
                    // Validation errors
                    let errMsg = data.message || 'Lỗi khi lưu';
                    if(data.errors) {
                        errMsg += '\n' + Object.values(data.errors).map(e => e.join(', ')).join('\n');
                    }
                    throw new Error(errMsg);
                }
                return data;
            })
            .then(data => {
                if(data.success) {
                    window.showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 1000); // Reload to show new data
                } else {
                    throw new Error(data.message || 'Lỗi không xác định');
                }
            })
            .catch(err => {
                window.showToast(err.message, 'error');
            })
            .finally(() => {
                btnSave.innerText = originalText;
                btnSave.disabled = false;
            });
        });
    }
    
});
