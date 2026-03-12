@extends('admin.layouts.master')

@section('title', 'Quản lý Danh mục con')

@push('styles')
<style>
    .glass-effect {
        background: rgba(32, 34, 42, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto flex flex-col gap-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-[#20222a] p-5 rounded-xl border border-[#2a2d35] shadow-lg">
        <div>
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-[#E70814]">folder_open</span>
                Quản lý Danh mục con
            </h2>
            <p class="text-sm text-gray-400 mt-1">Thêm, sửa, xóa và quản lý các danh mục thuộc loại game.</p>
        </div>
        <button onclick="openAddModal()" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-all shadow-[0_4px_12px_rgba(231,8,20,0.25)] hover:shadow-[0_6px_16px_rgba(231,8,20,0.4)] font-medium">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Thêm danh mục con
        </button>
    </div>

    <!-- Stats summary -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#20222a] p-4 rounded-xl border border-[#2a2d35] flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined">folder</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium tracking-wide mb-0.5">Tổng số</p>
                <p class="text-xl font-bold text-white">{{ $totalCategories ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-[#20222a] p-4 rounded-xl border border-[#2a2d35] flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined">visibility</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium tracking-wide mb-0.5">Đang hiển thị</p>
                <p class="text-xl font-bold text-white">{{ $activeCategories ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-[#20222a] p-4 rounded-xl border border-[#2a2d35] flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-gray-500/10 flex items-center justify-center text-gray-400">
                <span class="material-symbols-outlined">visibility_off</span>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-medium tracking-wide mb-0.5">Đã ẩn</p>
                <p class="text-xl font-bold text-white">{{ $hiddenCategories ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Filter & Search Box -->
    <div class="bg-[#20222a] rounded-xl border border-[#2a2d35] p-5">
        <form action="{{ route('admin.quanlydanhmuccon') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <!-- Search Keyword -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">search</span>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm tên danh mục..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 transition-colors outline-none placeholder-gray-500">
            </div>

            <!-- Filter Game -->
            <div class="md:w-64 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400 text-[20px]">sports_esports</span>
                </div>
                <select name="game" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-8 py-2.5 outline-none appearance-none cursor-pointer">
                    <option value="all">Tất cả Game</option>
                    @foreach($games as $gameOption)
                        <option value="{{ $gameOption->id }}" {{ request('game') == $gameOption->id ? 'selected' : '' }}>{{ $gameOption->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-500 hover:text-white transition-colors">expand_more</span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-2 shrink-0 border-l border-[#2a2d35] pl-4">
                <button type="submit" class="bg-[#2a2d35] hover:bg-[#363942] text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-colors font-medium border border-[#363942]">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                    Lọc KQ
                </button>
                @if(request()->hasAny(['search', 'game']))
                    <a href="{{ route('admin.quanlydanhmuccon') }}" class="bg-gray-500/10 hover:bg-gray-500/20 text-gray-300 hover:text-white px-4 py-2.5 rounded-lg flex items-center gap-2 transition-colors border border-[#2a2d35]" title="Xóa bộ lọc">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Main Table -->
    <div class="bg-[#20222a] rounded-xl border border-[#2a2d35] overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead class="bg-[#13131A] border-b border-[#2a2d35]">
                    <tr>
                        <th scope="col" class="px-5 py-3.5 font-bold uppercase tracking-wider text-xs text-gray-400">ID</th>
                        <th scope="col" class="px-5 py-3.5 font-bold uppercase tracking-wider text-xs text-gray-400">Hình & Tên Danh mục</th>
                        <th scope="col" class="px-5 py-3.5 font-bold uppercase tracking-wider text-xs text-gray-400">Game Cha</th>
                        <th scope="col" class="px-5 py-3.5 font-bold uppercase tracking-wider text-xs text-gray-400">Số Nick</th>
                        <th scope="col" class="px-5 py-3.5 font-bold uppercase tracking-wider text-xs text-gray-400 text-center">Trạng thái</th>
                        <th scope="col" class="px-5 py-3.5 font-bold uppercase tracking-wider text-xs text-gray-400 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2a2d35]">
                    @forelse($categories as $cat)
                    <tr class="hover:bg-[#2a2d35]/30 transition-colors group">
                        <td class="px-5 py-4 font-mono text-gray-400">{{ $cat->id }}</td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded overflow-hidden shrink-0 border border-[#2a2d35] bg-[#1a1c23]">
                                    @if($cat->image)
                                        <img src="{{ Str::startsWith($cat->image, 'http') ? $cat->image : asset($cat->image) }}" alt="{{ $cat->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-500 text-[10px] font-bold">NO IMG</div>
                                    @endif
                                </div>
                                <div class="max-w-[200px] sm:max-w-none">
                                    <h3 class="font-bold text-white text-[15px] group-hover:text-[#E70814] transition-colors truncate" title="{{ $cat->name }}">{{ $cat->name }}</h3>
                                    <p class="text-xs text-gray-500 truncate" title="{{ $cat->description }}">{{ Str::limit($cat->description ?? 'Không có mô tả', 30) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-blue-500/10 text-blue-400 text-xs font-bold border border-blue-500/20">
                                <span class="material-symbols-outlined text-[14px]">sports_esports</span>
                                {{ $cat->game->name ?? 'Không xác định' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 font-bold text-gray-300">
                            {{ $cat->accounts_count }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            @if($cat->status == 1)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-xs font-bold border border-emerald-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Đang hiện
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-500/10 text-gray-400 text-xs font-bold border border-gray-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Đang ẩn
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 flex-nowrap">
                                <button onclick="toggleCategoryStatus('{{ $cat->id }}', {{ $cat->status }})" class="p-2 w-9 h-9 flex items-center justify-center rounded-lg border {{ $cat->status == 1 ? 'border-amber-500/30 text-amber-500 hover:bg-amber-500 hover:text-white' : 'border-emerald-500/30 text-emerald-500 hover:bg-emerald-500 hover:text-white' }} transition-colors" title="{{ $cat->status == 1 ? 'Ẩn danh mục' : 'Hiện danh mục' }}">
                                    <span class="material-symbols-outlined text-[20px]">{{ $cat->status == 1 ? 'visibility_off' : 'visibility' }}</span>
                                </button>
                                
                                <button onclick="openEditModal('{{ $cat->id }}', '{{ htmlspecialchars($cat->name, ENT_QUOTES) }}', '{{ $cat->game_id }}', '{{ $cat->status }}', '{{ htmlspecialchars($cat->description ?? '', ENT_QUOTES) }}', '{{ $cat->image ? (Str::startsWith($cat->image, 'http') ? $cat->image : asset($cat->image)) : '' }}')" class="p-2 w-9 h-9 flex items-center justify-center rounded-lg border border-blue-500/30 text-blue-500 hover:bg-blue-500 hover:text-white transition-colors" title="Chỉnh sửa">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>

                                <button onclick="confirmDeleteCategory('{{ $cat->id }}')" class="p-2 w-9 h-9 flex items-center justify-center rounded-lg border border-red-500/30 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Xóa">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <span class="material-symbols-outlined text-5xl text-gray-600">folder_off</span>
                                <p>Không tìm thấy danh mục con nào hợp lệ.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($categories->hasPages())
        <div class="p-4 border-t border-[#2a2d35]">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-400">
                    Hiển thị từ <span class="font-bold text-white">{{ $categories->firstItem() }}</span> đến <span class="font-bold text-white">{{ $categories->lastItem() }}</span> trong <span class="font-bold text-white">{{ $categories->total() }}</span> danh mục con
                </div>
                <!-- Hiển thị liên kết phân trang chuẩn của Laravel tương tụ CSS trong Vendor  -->
                {{ $categories->links('vendor.pagination.tailwind') }}
            </div>
        </div>
        @endif
    </div>

</div>

<!-- Modal Thêm/Sửa Danh Mục Con -->
<div id="categoryModal" class="hidden fixed inset-0 glass-effect z-50 flex flex-col items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-lg shadow-2xl transform scale-95 transition-all duration-300 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="p-5 border-b border-[#2a2d35] flex justify-between items-center shrink-0">
            <h3 id="modalTitle" class="text-lg font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-[#E70814]" id="modalIcon">add_circle</span>
                <span id="modalTitleText">Thêm danh mục con</span>
            </h3>
            <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-white hover:bg-[#2a2d35] p-1.5 rounded-lg transition-colors border border-transparent">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-5 overflow-y-auto admin-scrollbar">
            <form id="categoryForm" class="space-y-4">
                <input type="hidden" id="categoryId">
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Game Cha <span class="text-[#E70814]">*</span></label>
                    <div class="relative">
                        <select id="gameSelect" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none cursor-pointer hover:border-gray-500 transition-colors" required>
                            <option value="">-- Chọn Game Cha --</option>
                            @foreach($games as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-500 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Tên danh mục con <span class="text-[#E70814]">*</span></label>
                    <input type="text" id="categoryName" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none hover:border-gray-500 transition-colors" placeholder="VD: Nick VIP, Acc Trắng Thông Tin..." required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Mô tả ngắn</label>
                    <input type="text" id="categoryDesc" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none hover:border-gray-500 transition-colors" placeholder="Mô tả danh mục này...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1.5">Trạng thái <span class="text-[#E70814]">*</span></label>
                    <div class="relative">
                        <select id="categoryStatus" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none cursor-pointer hover:border-gray-500 transition-colors" required>
                            <option value="active">Hiển thị (Active)</option>
                            <option value="hidden">Ẩn (Hidden)</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-500 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="border-t border-[#2a2d35] pt-4 mt-2">
                    <label class="block text-sm font-medium text-gray-300 mb-1.5 flex items-center justify-between">
                        <span>Hình Ảnh Đại Diện</span>
                        <span class="text-[11px] text-gray-500 bg-[#13131A] px-2 py-0.5 rounded border border-[#2a2d35]">Tùy chọn</span>
                    </label>
                    
                    <div class="flex gap-4 items-start">
                        <div class="w-20 h-20 rounded-lg border border-dashed border-gray-600 flex items-center justify-center shrink-0 bg-[#13131A] overflow-hidden relative" id="imagePreviewContainer">
                            <span class="material-symbols-outlined text-gray-500 text-[24px]" id="imagePlaceholderIcon">image</span>
                            <img id="imagePreview" alt="" class="hidden w-full h-full object-cover">
                        </div>
                        <div class="flex-1 space-y-3">
                            <div>
                                <input type="file" id="categoryImageFile" accept="image/*" class="w-full text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#2a2d35] file:text-white hover:file:bg-gray-600 transition-colors cursor-pointer border border-[#2a2d35] bg-[#13131A] rounded-lg">
                            </div>
                            <div class="relative flex items-center">
                                <span class="absolute bg-[#1a1c23] px-2 text-[10px] uppercase text-gray-500 font-bold left-2 -top-2">Hoặc dán Link Ảnh</span>
                                <input type="text" id="categoryImageUrl" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block px-3 py-2 outline-none" placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 border-t border-[#2a2d35] flex items-center justify-end gap-3 shrink-0 bg-[#1a1c23] cursor-pointer rounded-b-xl">
            <button class="px-5 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-[#2a2d35] transition-colors border border-transparent" onclick="closeCategoryModal()">
                Hủy bỏ
            </button>
            <button id="categorySubmitBtn" class="px-5 py-2.5 rounded-lg text-sm font-medium text-white bg-[#E70814] hover:bg-[#ff0f1e] shadow-[0_4px_10px_rgba(231,8,20,0.2)] transition-colors flex items-center gap-2 border border-transparent">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Lưu danh mục</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div id="deleteModal" class="hidden fixed inset-0 glass-effect z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-4 border border-red-500/20">
                <span class="material-symbols-outlined text-[32px] text-red-500">warning</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xóa danh mục con?</h3>
            <p class="text-sm text-gray-400 mb-6">Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác và chỉ có thể thực hiện khi không có Nick nào bên trong.</p>
            
            <div class="flex items-center justify-center gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 rounded-lg border border-[#2a2d35] text-gray-300 hover:bg-[#2a2d35] hover:text-white transition-colors font-medium">Hủy</button>
                <button id="confirmDeleteBtn" class="flex-1 px-4 py-2.5 rounded-lg bg-red-500 hover:bg-red-600 text-white transition-colors font-medium shadow-[0_4px_10px_rgba(239,68,68,0.2)] border border-transparent">Xóa</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
</script>
<script src="{{ asset('assets/admin/js/quanlydanhmuccon.js') }}"></script>
@endpush
