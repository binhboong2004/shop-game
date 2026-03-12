@extends('admin.layouts.master')

@section('title', 'Cấu hình Thuộc tính')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/cauhinhthuoctinh.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Cấu hình Thuộc tính Sản phẩm</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Sản phẩm & Game</li>
                <li><span class="mx-2">/</span></li>
                <li>Cấu hình Thuộc tính</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button id="addAttributeBtn" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Thuộc Tính
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Thuộc Tính</p>
                <h3 class="text-2xl font-bold text-white">{{ $totalAttributes }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">tune</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Sử Dụng</p>
                <h3 class="text-2xl font-bold text-emerald-400">{{ $activeAttributes }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">check_circle</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Dừng Áp Dụng</p>
                <h3 class="text-2xl font-bold text-[#E70814]">{{ $inactiveAttributes }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">cancel</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tìm Kiếm</label>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Tên thuộc tính..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Danh mục Game</label>
            <select id="gameFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả Game</option>
                @foreach($games as $game)
                <option value="{{ $game->id }}">{{ $game->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Loại Dữ Liệu</label>
            <select id="typeFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả Data Type</option>
                <option value="number">Số nguyên (Number)</option>
                <option value="text">Văn bản (Text)</option>
                <option value="select">Lựa chọn (Select)</option>
            </select>
        </div>
        <div class="flex items-end">
            <button id="filterBtn" class="w-full bg-[#E70814] hover:bg-[#ff0f1e] text-white font-medium py-2.5 rounded-md transition-colors">
                Lọc Kết Quả
            </button>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
            <thead>
                <tr class="bg-[#1a1c23] border-b border-[#2a2d35] text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    <th class="p-4 w-16 text-center">ID</th>
                    <th class="p-4">Tên Thuộc Tính</th>
                    <th class="p-4">Game Áp Dụng</th>
                    <th class="p-4 text-center">Định Dạng</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @forelse($attributes as $attribute)
                <tr class="hover:bg-[#1a1c23] transition-colors group attribute-row" data-search="{{ $attribute->name }}" data-games="{{ json_encode($attribute->games->pluck('id')) }}" data-type="{{ $attribute->type }}" data-status="{{ $attribute->status }}">
                    <td class="p-4 text-center font-medium text-gray-400">#{{ $attribute->id }}</td>
                    <td class="p-4 font-bold text-white group-hover:text-[#E70814] transition-colors">
                        {{ $attribute->name }}
                        <div class="text-xs text-gray-500 font-normal mt-0.5">Biến: <code>{{ $attribute->variable_name }}</code></div>
                    </td>
                    <td class="p-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($attribute->games as $game)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#13131A] border border-[#2a2d35] text-[10px] font-medium text-gray-300">
                                @if($game->image)
                                <img src="{{ asset($game->image) }}" class="w-3 h-3 rounded-sm" alt="">
                                @endif
                                {{ $game->name }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        @if($attribute->type === 'number')
                        <span class="px-2 py-1 bg-blue-500/10 text-blue-400 text-xs rounded border border-blue-500/20">Số nguyên</span>
                        @elseif($attribute->type === 'text')
                        <span class="px-2 py-1 bg-green-500/10 text-green-400 text-xs rounded border border-green-500/20">Văn bản</span>
                        @elseif($attribute->type === 'select')
                        <span class="px-2 py-1 bg-purple-500/10 text-purple-400 text-xs rounded border border-purple-500/20">Lựa chọn (Select)</span>
                        @elseif($attribute->type === 'checkbox')
                         <span class="px-2 py-1 bg-orange-500/10 text-orange-400 text-xs rounded border border-orange-500/20">Checkbox</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer status-switch" data-id="{{ $attribute->id }}" {{ $attribute->status === 'active' ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </label>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($attribute->type === 'select')
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors flex items-center justify-center btn-config-options" data-id="{{ $attribute->id }}" data-options="{{ json_encode($attribute->options ?? []) }}" title="Cấu hình lựa chọn">
                                <span class="material-symbols-outlined text-[18px]">format_list_bulleted</span>
                            </button>
                            @endif
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit-attribute" data-attribute="{{ json_encode($attribute) }}" title="Sửa">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete-attribute" data-id="{{ $attribute->id }}" title="Xóa">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">Chưa có thuộc tính nào được cấu hình.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm/Sửa Thuộc Tính -->
<div id="attributeModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-lg shadow-2xl transform scale-95 opacity-0 transition-all duration-300 my-8">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center sticky top-0 bg-[#20222a] z-10 rounded-t-xl">
            <h3 class="text-xl font-bold text-white" id="modalTitle">Thêm Thuộc Tính Mới</h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <form id="attributeForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Tên Thuộc Tính <span class="text-[#E70814]">*</span></label>
                        <input type="text" id="attrName" name="name" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="VD: Rank, Số Tướng..." required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Tên Biến (Tiếng Anh, không dấu) <span class="text-[#E70814]">*</span></label>
                        <input type="text" id="attrVariable" name="variable_name" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="VD: rank_ff, so_tuong..." required>
                    </div>
                </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2 font-bold">Các Game được áp dụng <span class="text-[#E70814]">*</span> <span class="text-[10px] text-gray-500 font-normal normal-case">(Giữ Ctrl để chọn nhiều)</span></label>
                        <select id="attrGames" name="game_ids[]" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2 outline-none cursor-pointer min-h-[120px]" multiple required>
                            @foreach($games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                            @endforeach
                        </select>
                    </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Loại Dữ Liệu <span class="text-[#E70814]">*</span></label>
                    <select id="attrType" name="type" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none" required>
                        <option value="number">Số (Dùng cho đếm số lượng: skin, tướng...)</option>
                        <option value="text">Văn bản ngắn (Tên, mã...)</option>
                        <option value="select">Dropdown Choice (Rank, loại acc...)</option>
                        <option value="checkbox">Checkbox (Có/Không)</option>
                    </select>
                </div>

                <div class="mb-4 hidden" id="selectOptionsContainer">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Các giá trị lựa chọn (Mỗi dòng 1 giá trị)</label>
                    <textarea id="attrOptions" name="options" rows="4" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none resize-none" placeholder="VD:&#10;Đồng&#10;Bạc&#10;Vàng&#10;Bạch Kim"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Chỉ áp dụng cho loại dữ liệu: Dropdown Choice.</p>
                </div>

                <div class="mb-6 border-t border-[#2a2d35] pt-4">
                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-sm font-medium text-gray-300">Hoạt động (Cho phép sử dụng thuộc tính này)</span>
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" id="attrStatus" name="status" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </div>
                    </label>
                </div>
                
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="btnSave">Lưu Cấu Hình</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Delete Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-[#E70814]/10 text-[#E70814] flex items-center justify-center mx-auto mb-4 border border-[#E70814]/20">
                <span class="material-symbols-outlined text-[32px]">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa thuộc tính này? Toàn bộ dữ liệu gắn với nick game của thuộc tính này cũng sẽ bị xóa.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel-delete w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="confirmDeleteBtn">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/cauhinhthuoctinh.js') }}"></script>
@endpush
