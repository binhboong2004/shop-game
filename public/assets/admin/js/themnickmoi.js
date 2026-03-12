document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatarInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    
    if (avatarInput && fileNameDisplay) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
                fileNameDisplay.classList.remove('text-gray-400');
                fileNameDisplay.classList.add('text-white');
            } else {
                fileNameDisplay.textContent = 'Chọn ảnh tải lên...';
                fileNameDisplay.classList.add('text-gray-400');
                fileNameDisplay.classList.remove('text-white');
            }
        });
    }

    // Multiple Images Preview
    const multipleImagesInput = document.getElementById('multipleImagesInput');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');

    if(multipleImagesInput && imagePreviewContainer) {
        multipleImagesInput.addEventListener('change', function() {
            imagePreviewContainer.innerHTML = '';
            if(this.files && this.files.length > 0) {
                imagePreviewContainer.classList.remove('hidden');
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'w-16 h-16 rounded overflow-hidden border border-[#2a2d35] relative group shrink-0';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover" />
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                <span class="material-symbols-outlined text-white text-[16px]">visibility</span>
                            </div>
                        `;
                        imagePreviewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                imagePreviewContainer.classList.add('hidden');
            }
        });
    }

    // Dynamic Game Attributes
    const gameSelectEl = document.getElementById('gameSelect');
    const gameAttributesContainer = document.getElementById('gameAttributesContainer');
    const attributesList = document.getElementById('attributesList');

    function loadGameAttributes(gameId) {
        if(!gameId) {
            if(gameAttributesContainer) gameAttributesContainer.classList.add('hidden');
            if(attributesList) attributesList.innerHTML = '';
            return;
        }

        const existingAttrs = window.existingAttributes || {};

        fetch(`/admin/game/${gameId}/attributes`)
            .then(res => res.json())
            .then(attributes => {
                if(attributesList) attributesList.innerHTML = '';
                if(attributes.length > 0) {
                    if(gameAttributesContainer) gameAttributesContainer.classList.remove('hidden');
                    attributes.forEach(attr => {
                        const div = document.createElement('div');
                        
                        const label = document.createElement('label');
                        label.className = 'block text-sm font-medium text-gray-300 mb-2';
                        label.textContent = attr.name;
                        div.appendChild(label);

                        const existingVal = existingAttrs[attr.id] || '';

                        if(attr.type === 'select') {
                            const wrapper = document.createElement('div');
                            wrapper.className = 'relative';

                            const select = document.createElement('select');
                            select.name = `attributes[${attr.id}]`;
                            select.className = 'w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none appearance-none cursor-pointer';

                            const defaultOpt = document.createElement('option');
                            defaultOpt.value = '';
                            defaultOpt.textContent = `-- Chọn ${attr.name} --`;
                            select.appendChild(defaultOpt);

                            if(Array.isArray(attr.options)) {
                                attr.options.forEach(opt => {
                                    const option = document.createElement('option');
                                    option.value = opt;
                                    option.textContent = opt;
                                    if(existingVal === opt) option.selected = true;
                                    select.appendChild(option);
                                });
                            }
                            
                            wrapper.appendChild(select);
                            wrapper.innerHTML += `<span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-500 pointer-events-none">expand_more</span>`;
                            div.appendChild(wrapper);

                        } else {
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.name = `attributes[${attr.id}]`;
                            input.value = existingVal;
                            input.className = 'w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none';
                            input.placeholder = `Nhập ${attr.name}...`;
                            div.appendChild(input);
                        }

                        if(attributesList) attributesList.appendChild(div);
                    });
                } else {
                    if(gameAttributesContainer) gameAttributesContainer.classList.add('hidden');
                }
            })
            .catch(err => {
                console.error("Lỗi khi tải cấu hình thuộc tính:", err);
            });
    }

    if(gameSelectEl) {
        gameSelectEl.addEventListener('change', function() {
            loadGameAttributes(this.value);
            loadGameCategories(this.value);
        });
        
        // Initial load for edit mode
        if(gameSelectEl.value) {
            loadGameAttributes(gameSelectEl.value);
            loadGameCategories(gameSelectEl.value);
        }
    }

    // Dynamic Game Categories
    const categorySelectEl = document.getElementById('categorySelect');

    function loadGameCategories(gameId) {
        if(!categorySelectEl) return;
        
        if(!gameId) {
            categorySelectEl.innerHTML = '<option value="">-- Chọn Game cha trước --</option>';
            categorySelectEl.disabled = true;
            return;
        }

        categorySelectEl.innerHTML = '<option value="">Đang tải...</option>';
        categorySelectEl.disabled = true;

        fetch(`/admin/game/${gameId}/categories`)
            .then(res => res.json())
            .then(categories => {
                categorySelectEl.innerHTML = '<option value="">-- Chọn Danh mục con --</option>';
                
                if(categories.length > 0) {
                    categorySelectEl.disabled = false;
                    categories.forEach(cat => {
                        const option = document.createElement('option');
                        option.value = cat.id;
                        option.textContent = cat.name;
                        
                        // Select existing category if editing
                        if (window.existingCategory && window.existingCategory == cat.id) {
                            option.selected = true;
                        }
                        
                        categorySelectEl.appendChild(option);
                    });
                } else {
                    categorySelectEl.innerHTML = '<option value="">-- Game này chưa có danh mục con --</option>';
                    if (window.showToast) {
                        window.showToast('Game này chưa có danh mục con. Hãy tạo danh mục con trong phần "Quản lý danh mục con" trước.', 'error');
                    }
                }
            })
            .catch(err => {
                console.error("Lỗi khi tải danh mục con:", err);
                categorySelectEl.innerHTML = '<option value="">Lỗi tải danh mục</option>';
            });
    }

});
