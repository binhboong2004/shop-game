@extends('admin.layouts.master')

@section('title', 'Vòng Quay May Mắn')

@section('content')
<!-- Header Page -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-[28px] font-bold text-white mb-2">Vòng Quay May Mắn</h1>
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E70814] transition-colors">Hệ thống</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-white">Vòng Quay May Mắn</span>
        </div>
    </div>
    <div class="flex items-center gap-3 relative z-10">
        <button onclick="openAddModal()" class="bg-[#E70814] hover:bg-[#c60711] text-white px-4 py-2 rounded-md font-medium transition-all shadow-[0_4px_12px_rgba(231,8,20,0.25)] flex items-center gap-2" id="btnAddWheel">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Thêm Vòng Quay Mới
        </button>
    </div>
</div>

<!-- Filter & Search -->
<div class="bg-[#1a1c23] border border-[#2a2d35] rounded-xl p-5 mb-6">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <input type="text" id="searchWheel" placeholder="Tìm kiếm vòng quay..." class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md pl-10 pr-4 py-2.5 focus:outline-none focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814]/50 transition-all font-medium placeholder-gray-500">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
        </div>
        <div class="w-full md:w-[200px]">
            <select id="filterStatus" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814]/50 transition-all font-medium cursor-pointer appearance-none custom-select">
                <option value="">Trạng thái: Tất cả</option>
                <option value="1">Đang hoạt động</option>
                <option value="0">Đã tạm dừng</option>
            </select>
        </div>
    </div>
</div>

<!-- List Vong Quay -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" id="wheelList">
    @forelse($wheels as $wheel)
    <div class="bg-[#1a1c23] border border-[#2a2d35] rounded-xl overflow-hidden hover:border-[#E70814]/50 transition-colors group relative wheel-item" data-name="{{ $wheel->name }}" data-status="{{ $wheel->status }}">
        <div class="h-[160px] bg-[#13131A] relative flex items-center justify-center p-4 border-b border-[#2a2d35]">
            <div class="absolute top-3 right-3 flex items-center gap-2 z-10">
                @if($wheel->status)
                    <span class="bg-green-500/20 text-green-500 px-2 py-1 rounded text-xs font-bold border border-green-500/20">Hoạt động</span>
                @else
                    <span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded text-xs font-bold border border-gray-500/20">Tạm dừng</span>
                @endif
            </div>
            
            <div class="w-[120px] h-[120px] rounded-full border-4 border-[#2a2d35] bg-[#20222a] flex items-center justify-center relative overflow-hidden group-hover:border-[#E70814] transition-colors duration-300 shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                @if($wheel->image)
                    <img src="{{ asset('storage/' . $wheel->image) }}" class="w-full h-full object-cover">
                @else
                    <span class="material-symbols-outlined text-[48px] text-[#E70814]">casino</span>
                @endif
                <!-- Decorative elements for wheel -->
                <div class="absolute inset-x-0 w-[4px] h-full bg-[#2a2d35] mx-auto opacity-50"></div>
                <div class="absolute inset-y-0 h-[4px] w-full bg-[#2a2d35] my-auto opacity-50"></div>
            </div>
        </div>
        
        <div class="p-5">
            <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] bg-[#E70814]/10 text-[#E70814] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider border border-[#E70814]/20">{{ $wheel->game->name ?? 'N/A' }}</span>
            </div>
            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-[#E70814] transition-colors leading-tight line-clamp-1">{{ $wheel->name }}</h3>
            <p class="text-sm text-gray-400 line-clamp-2 mb-4 h-10">{{ $wheel->description ?? 'Không có mô tả cho vòng quay này.' }}</p>
            
            <div class="flex items-center justify-between py-3 border-t border-[#2a2d35]/50 mb-4">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Giá/Lượt</p>
                    <p class="text-sm font-bold text-white">{{ number_format($wheel->price) }}đ</p>
                </div>
                <div class="w-px h-8 bg-[#2a2d35]"></div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Đã quay</p>
                    <p class="text-sm font-bold text-green-500">0</p>
                </div>
                <div class="w-px h-8 bg-[#2a2d35]"></div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Doanh thu</p>
                    <p class="text-sm font-bold text-[#E70814]">0đ</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button onclick="editWheel({{ $wheel->id }})" class="flex-1 bg-[#20222a] hover:bg-[#E70814] text-white hover:text-white border border-[#2a2d35] hover:border-[#E70814] py-2 rounded-md font-medium transition-all text-sm flex items-center justify-center gap-1.5 ">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Chỉnh sửa
                </button>
                <div class="relative group/menu">
                    <button class="w-10 h-10 flex items-center justify-center bg-[#20222a] hover:bg-gray-100/10 text-gray-400 hover:text-white border border-[#2a2d35] py-2 rounded-md font-medium transition-all text-sm">
                        <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                    </button>
                    <div class="absolute bottom-full right-0 mb-0 translate-y-[-8px] w-48 bg-[#1a1c23] border border-[#2a2d35] rounded-lg shadow-2xl py-2 hidden group-hover/menu:block z-20 after:content-[''] after:absolute after:top-full after:left-0 after:w-full after:h-4">
                        <a href="{{ route('admin.vongquaymayman.show', $wheel->id) }}" class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-[#E70814]/10 hover:text-white flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-primary">settings_suggest</span>
                            Thiết lập phần thưởng
                        </a>
                        <button onclick="toggleStatus({{ $wheel->id }})" class="w-full text-left px-4 py-2.5 text-sm text-gray-300 hover:bg-[#E70814]/10 hover:text-white flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-[18px] text-blue-500">{{ $wheel->status ? 'pause' : 'play_arrow' }}</span>
                            {{ $wheel->status ? 'Tạm dừng' : 'Kích hoạt' }}
                        </button>
                        <button onclick="deleteWheel({{ $wheel->id }})" class="w-full text-left px-4 py-2.5 text-sm text-red-500 hover:bg-red-500/10 flex items-center gap-2 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Xóa vòng quay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center">
        <div class="w-20 h-20 bg-[#1a1c23] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#2a2d35]">
            <span class="material-symbols-outlined text-[40px] text-gray-600">casino</span>
        </div>
        <p class="text-gray-500 font-medium">Chưa có vòng quay nào được tạo.</p>
    </div>
    @endforelse
</div>

<!-- Modal Add/Edit Wheel -->
<div id="modalWheel" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-[#1a1c23] border border-[#2a2d35] rounded-2xl w-full max-w-xl overflow-hidden shadow-2xl transform transition-all">
        <div class="p-6 border-b border-[#2a2d35] flex items-center justify-between bg-[#13131A]">
            <h2 class="text-xl font-bold text-white" id="modalTitle">Thêm Vòng Quay Mới</h2>
            <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-white transition-colors" id="btnCloseModal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="formWheel" class="p-6 space-y-5" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="wheelId">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Tên vòng quay <span class="text-[#E70814]">*</span></label>
                    <input type="text" name="name" id="wheelName" required placeholder="VD: Vòng Quay Liên Quân Siêu Cấp" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-[#E70814] transition-all font-medium">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Danh mục game <span class="text-[#E70814]">*</span></label>
                    <select name="game_id" id="wheelGame" required class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-[#E70814] font-medium appearance-none">
                        @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Giá/Lượt quay <span class="text-[#E70814]">*</span></label>
                    <input type="number" name="price" id="wheelPrice" required placeholder="20000" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-[#E70814] transition-all font-medium">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Ảnh minh họa</label>
                    <div class="flex items-center gap-4">
                        <div class="w-24 h-24 rounded-lg bg-[#13131A] border border-dashed border-[#2a2d35] flex items-center justify-center relative overflow-hidden group/img">
                            <span class="material-symbols-outlined text-gray-600 text-[32px]" id="imgPlaceholder">image</span>
                            <img id="imgPreview" class="w-full h-full object-cover hidden">
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover/img:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-[10px] text-white font-bold">Thay đổi</span>
                            </div>
                            <input type="file" name="image" id="wheelImage" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*">
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 leading-relaxed">Tải lên ảnh đẹp để thu hút người chơi. Định dạng hỗ trợ: JPG, PNG, WEBP. Kích thước đề xuất: 500x500px.</p>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Mô tả vòng quay</label>
                    <textarea name="description" id="wheelDesc" rows="3" placeholder="Nhập mô tả ngắn gọn về phần thưởng hoặc thể lệ..." class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-[#E70814] transition-all font-medium resize-none"></textarea>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-gray-400 mb-2 uppercase tracking-wider">Trạng thái ban đầu</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="status" value="1" checked class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-[#2a2d35] peer-checked:border-[#E70814] peer-checked:bg-[#E70814] transition-all relative after:content-[''] after:w-2 after:h-2 after:bg-white after:rounded-full after:absolute after:top-1/2 after:left-1/2 after:-translate-x-1/2 after:-translate-y-1/2 after:scale-0 peer-checked:after:scale-100 after:transition-transform"></div>
                            <span class="text-sm font-medium text-gray-400 group-hover:text-white transition-colors">Hoạt động ngay</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="radio" name="status" value="0" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-[#2a2d35] peer-checked:border-[#E70814] peer-checked:bg-[#E70814] transition-all relative after:content-[''] after:w-2 after:h-2 after:bg-white after:rounded-full after:absolute after:top-1/2 after:left-1/2 after:-translate-x-1/2 after:-translate-y-1/2 after:scale-0 peer-checked:after:scale-100 after:transition-transform"></div>
                            <span class="text-sm font-medium text-gray-400 group-hover:text-white transition-colors">Tạm dừng ẩn bài</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="pt-4 flex items-center justify-end gap-3">
                <button type="button" onclick="closeModal()" class="btn-cancel bg-[#20222a] hover:bg-[#2a2d35] text-white px-6 py-2.5 rounded-md font-bold transition-all" id="btnCancelModal">Hủy bỏ</button>
                <button type="submit" class="bg-[#E70814] hover:bg-[#c60711] text-white px-8 py-2.5 rounded-md font-bold transition-all shadow-[0_4px_12px_rgba(231,8,20,0.25)] flex items-center gap-2" id="btnSaveWheel">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    Lưu thông tin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ROUTES = {
        store: "{{ route('admin.vongquaymayman.store') }}",
        edit: "{{ url('admin/vong-quay-may-man') }}/:id/edit",
        update: "{{ url('admin/vong-quay-may-man') }}/:id/update",
        delete: "{{ url('admin/vong-quay-may-man') }}/:id",
        toggle: "{{ url('admin/vong-quay-may-man') }}/:id/toggle-status"
    }
</script>
<script src="{{ asset('assets/admin/js/vongquaymayman.js') }}"></script>
@endpush

@push('styles')
<style>
    .custom-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236B7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='激19 9l-7 7-7-7' /%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.25rem;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
</style>
@endpush
