@extends('admin.layouts.master')

@section('title', 'Cấu hình phần thưởng: ' . $wheel->name)

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E70814] transition-colors">Hệ thống</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a href="{{ route('admin.vongquaymayman') }}" class="hover:text-[#E70814] transition-colors">Vòng Quay May Mắn</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-[#E70814]">Cấu hình phần thưởng</span>
    </div>
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full border-4 border-[#2a2d35] bg-[#20222a] flex items-center justify-center overflow-hidden shadow-lg">
                @if($wheel->image)
                    <img src="{{ asset('storage/' . $wheel->image) }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined text-[32px] text-[#E70814]">casino</span>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $wheel->name }}</h1>
                <p class="text-gray-500 text-sm">Danh mục: <span class="text-primary font-bold">{{ $wheel->game->name }}</span> | Giá: <span class="text-white font-bold">{{ number_format($wheel->price) }}đ</span></p>
            </div>
        </div>
        
        <button onclick="openAddPrizeModal()" class="bg-[#E70814] hover:bg-[#c60711] text-white px-4 py-2.5 rounded-md font-bold transition-all shadow-lg flex items-center gap-2">
            <span class="material-symbols-outlined">add_circle</span>
            Thêm Phần Thưởng
        </button>
    </div>
</div>

<div class="grid grid-cols-1 gap-6">
    <!-- List Prizes -->
    <div class="bg-[#1a1c23] border border-[#2a2d35] rounded-xl overflow-hidden">
        <div class="p-5 border-b border-[#2a2d35] bg-[#13131A] flex items-center justify-between">
            <h3 class="font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">lists</span>
                Danh sách phần thưởng ({{ $wheel->prizes->count() }}/8)
            </h3>
            <span class="text-xs text-gray-500 italic">* Lưu ý: Một vòng quay nên có đúng 8 phần thưởng để hiển thị đẹp nhất.</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#13131A]/50 text-gray-400 text-[11px] uppercase tracking-wider font-bold">
                        <th class="px-6 py-4 border-b border-[#2a2d35]">Hình ảnh</th>
                        <th class="px-6 py-4 border-b border-[#2a2d35]">Tên phần thưởng</th>
                        <th class="px-6 py-4 border-b border-[#2a2d35]">Loại</th>
                        <th class="px-6 py-4 border-b border-[#2a2d35]">Giá trị</th>
                        <th class="px-6 py-4 border-b border-[#2a2d35]">Tỷ lệ (%)</th>
                        <th class="px-6 py-4 border-b border-[#2a2d35]">Trạng thái</th>
                        <th class="px-6 py-4 border-b border-[#2a2d35] text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2a2d35]">
                    @forelse($wheel->prizes as $prize)
                    <tr class="hover:bg-[#20222a] transition-colors group">
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded bg-[#13131A] border border-[#2a2d35] flex items-center justify-center p-1">
                                @if($prize->image)
                                    <img src="{{ asset('storage/' . $prize->image) }}" class="w-full h-full object-contain">
                                @else
                                    <span class="material-symbols-outlined text-gray-600">redeem</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-white">{{ $prize->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-[10px] font-bold uppercase border 
                                @if($prize->type == 'money') bg-green-500/10 text-green-500 border-green-500/20 
                                @elseif($prize->type == 'diamond') bg-blue-500/10 text-blue-500 border-blue-500/20
                                @else bg-purple-500/10 text-purple-500 border-purple-500/20 @endif">
                                {{ $prize->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-white">{{ number_format($prize->value) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 bg-[#13131A] rounded-full overflow-hidden w-24">
                                    <div class="h-full bg-primary" style="width: {{ $prize->probability }}%"></div>
                                </div>
                                <span class="text-sm font-bold text-white">{{ $prize->probability }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($prize->status)
                                <span class="flex items-center gap-1.5 text-green-500 text-xs font-bold">
                                    <span class="size-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                    Hiển thị
                                </span>
                            @else
                                <span class="flex items-center gap-1.5 text-gray-500 text-xs font-bold">
                                    <span class="size-1.5 bg-gray-500 rounded-full"></span>
                                    Ẩn
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editPrize({{ $prize->id }})" class="p-2 bg-[#20222a] hover:bg-primary text-gray-400 hover:text-white rounded transition-all border border-[#2a2d35] hover:border-primary">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button onclick="deletePrize({{ $prize->id }})" class="p-2 bg-[#20222a] hover:bg-red-500 text-gray-400 hover:text-white rounded transition-all border border-[#2a2d35] hover:border-red-500">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            Chưa có phần thưởng nào. Hãy thêm phần thưởng đầu tiên!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add/Edit Prize -->
<div id="modalPrize" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-[#1a1c23] border border-[#2a2d35] rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-[#2a2d35] flex items-center justify-between bg-[#13131A]">
            <h2 class="text-xl font-bold text-white" id="modalPrizeTitle">Thêm Phần Thưởng</h2>
            <button onclick="closePrizeModal()" class="text-gray-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="formPrize" class="p-6 space-y-4" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="lucky_wheel_id" value="{{ $wheel->id }}">
            <input type="hidden" name="id" id="prizeId">
            
            <div>
                <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Tên phần thưởng <span class="text-primary">*</span></label>
                <input type="text" name="name" id="prizeName" required placeholder="VD: 9.999 Kim Cương" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-primary transition-all font-medium">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Loại phần thưởng <span class="text-primary">*</span></label>
                    <select name="type" id="prizeType" required class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-primary font-medium">
                        <option value="diamond">Kim Cương / Quân Huy</option>
                        <option value="money">Cộng Tiền Shop</option>
                        <option value="item">Vật phẩm (Nick/Code)</option>
                        <option value="no_prize">Chúc may mắn lần sau</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Giá trị <span class="text-primary">*</span></label>
                    <input type="number" name="value" id="prizeValue" required placeholder="9999" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-primary transition-all font-medium">
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Tỷ lệ trúng (%) <span class="text-primary">*</span></label>
                    <input type="number" step="0.01" name="probability" id="prizeProb" required placeholder="10.5" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-primary transition-all font-medium">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Trạng thái</label>
                    <select name="status" id="prizeStatus" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-primary font-medium">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn đi</option>
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Ảnh phần thưởng</label>
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded bg-[#13131A] border border-dashed border-[#2a2d35] flex items-center justify-center relative overflow-hidden group">
                        <span class="material-symbols-outlined text-gray-600 @if(isset($prize) && $prize->image) hidden @endif" id="prizeImgPlaceholder">image</span>
                        <img id="prizeImgPreview" class="w-full h-full object-contain hidden">
                        <input type="file" name="image" id="prizeImage" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                    </div>
                    <p class="text-xs text-gray-500 italic flex-1">Nên dùng ảnh PNG không nền (transparent) để hiển thị tốt nhất trên vòng quay.</p>
                </div>
            </div>
            
            <div class="pt-4 flex items-center justify-end gap-3">
                <button type="button" onclick="closePrizeModal()" class="bg-[#20222a] hover:bg-[#2a2d35] text-white px-6 py-2.5 rounded-md font-bold transition-all">Hủy</button>
                <button type="submit" class="bg-[#E70814] hover:bg-[#c60711] text-white px-8 py-2.5 rounded-md font-bold transition-all flex items-center gap-2" id="btnSavePrize">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Lưu phần thưởng
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const PRIZE_ROUTES = {
        store: "{{ route('admin.wheelprizes.store') }}",
        edit: "{{ route('admin.wheelprizes.edit', ['id' => ':id']) }}",
        update: "{{ route('admin.wheelprizes.update', ['id' => ':id']) }}",
        delete: "{{ route('admin.wheelprizes.destroy', ['id' => ':id']) }}"
    };

    window.openAddPrizeModal = function() {
        document.getElementById('modalPrizeTitle').textContent = 'Thêm Phần Thưởng';
        document.getElementById('formPrize').reset();
        document.getElementById('prizeId').value = '';
        document.getElementById('prizeImgPreview').classList.add('hidden');
        document.getElementById('prizeImgPlaceholder').classList.remove('hidden');
        document.getElementById('modalPrize').classList.remove('hidden');
    };

    window.closePrizeModal = function() {
        document.getElementById('modalPrize').classList.add('hidden');
    };

    window.editPrize = function(id) {
        fetch(PRIZE_ROUTES.edit.replace(':id', id))
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalPrizeTitle').textContent = 'Chỉnh Sửa Phần Thưởng';
                document.getElementById('prizeId').value = data.id;
                document.getElementById('prizeName').value = data.name;
                document.getElementById('prizeType').value = data.type;
                document.getElementById('prizeValue').value = data.value;
                document.getElementById('prizeProb').value = data.probability;
                document.getElementById('prizeStatus').value = data.status;
                
                if (data.image) {
                    const preview = document.getElementById('prizeImgPreview');
                    preview.src = '/storage/' + data.image;
                    preview.classList.remove('hidden');
                    document.getElementById('prizeImgPlaceholder').classList.add('hidden');
                } else {
                    document.getElementById('prizeImgPreview').classList.add('hidden');
                    document.getElementById('prizeImgPlaceholder').classList.remove('hidden');
                }
                
                document.getElementById('modalPrize').classList.remove('hidden');
            }).catch(err => {
                console.error(err);
                if (window.showToast) window.showToast('Không thể tải dữ liệu!', 'error');
            });
    };

    window.deletePrize = function(id) {
        if (confirm('Bạn có chắc chắn muốn xóa phần thưởng này?')) {
            fetch(PRIZE_ROUTES.delete.replace(':id', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (window.showToast) window.showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 500);
                } else {
                    if (window.showToast) window.showToast(data.message || 'Lỗi xảy ra', 'error');
                }
            }).catch(err => {
                console.error(err);
                if (window.showToast) window.showToast('Lỗi kết nối!', 'error');
            });
        }
    };

    document.getElementById('prizeImage')?.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('prizeImgPreview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('prizeImgPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    document.getElementById('formPrize')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('prizeId').value;
        const url = id ? PRIZE_ROUTES.update.replace(':id', id) : PRIZE_ROUTES.store;
        const formData = new FormData(this);
        
        const btn = document.getElementById('btnSavePrize');
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-spin inline-block size-4 border-2 border-white border-t-transparent rounded-full mr-2"></span> Đang lưu...';

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok && data.success) {
                if (window.showToast) window.showToast(data.message, 'success');
                setTimeout(() => location.reload(), 800);
            } else {
                if (window.showToast) window.showToast(data.message || 'Lỗi xảy ra', 'error');
                btn.disabled = false;
                btn.textContent = 'Lưu phần thưởng';
            }
        })
        .catch(err => {
            console.error(err);
            if (window.showToast) window.showToast('Lỗi hệ thống hoặc kết nối!', 'error');
            btn.disabled = false;
            btn.textContent = 'Lưu phần thưởng';
        });
    });
</script>
@endpush
