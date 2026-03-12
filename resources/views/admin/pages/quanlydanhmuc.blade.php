@extends('admin.layouts.master')

@section('title', 'Quản lý Danh mục Game')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/quanlydanhmuc.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Quản lý Danh mục Game</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Danh mục Game</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button id="addCategoryBtn" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Danh mục
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Danh Mục</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($totalGames) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">category</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Hiển Thị</p>
                <h3 class="text-2xl font-bold text-emerald-400">{{ number_format($activeGames) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">visibility</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã Ẩn</p>
                <h3 class="text-2xl font-bold text-[#E70814]">{{ number_format($hiddenGames) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">visibility_off</span>
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
                <input type="text" id="searchInput" placeholder="Tên danh mục..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả</option>
                <option value="active">Hiển thị</option>
                <option value="hidden">Đã ẩn</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Sắp Xếp</label>
            <select id="sortFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="new">Mới nhất</option>
                <option value="old">Cũ nhất</option>
                <option value="name_asc">Tên A-Z</option>
                <option value="name_desc">Tên Z-A</option>
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
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-[#1a1c23] border-b border-[#2a2d35] text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    <th class="p-4 w-16 text-center">ID</th>
                    <th class="p-4">Hình Ảnh</th>
                    <th class="p-4">Tên Game</th>
                    <th class="p-4 text-center">Số Lượng Nick</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @forelse($games as $game)
                <tr class="hover:bg-[#1a1c23] transition-colors group category-row" data-search="{{ $game->name }}" data-status="{{ $game->status ? 'active' : 'hidden' }}">
                    <td class="p-4 text-center font-medium text-gray-400">#{{ $game->id }}</td>
                    <td class="p-4">
                        <img src="{{ Str::startsWith($game->image, 'http') ? $game->image : asset($game->image) }}" alt="{{ $game->name }}" class="w-12 h-12 rounded object-cover border border-[#2a2d35] bg-white">
                    </td>
                    <td class="p-4 font-bold text-white group-hover:text-[#E70814] transition-colors">
                        {{ $game->name }}
                    </td>
                    <td class="p-4 text-center text-gray-300">
                        {{ number_format($game->accounts_count) }}
                    </td>
                    <td class="p-4 text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer status-switch" data-id="{{ $game->id }}" {{ $game->status ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </label>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit-category" title="Sửa" data-game="{{ json_encode($game) }}">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete-category" title="Xóa" data-id="{{ $game->id }}">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-400">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-symbols-outlined text-4xl mb-2 opacity-50">videogame_asset_off</span>
                            <p>Chưa có danh mục game nào trong hệ thống.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm/Sửa Danh Mục -->
<div id="categoryModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-xl font-bold text-white" id="modalTitle">Thêm Danh Mục Mới</h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <form id="categoryForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Tên Game <span class="text-[#E70814]">*</span></label>
                    <input type="text" id="catName" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="VD: Liên Quân Mobile" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Hình Ảnh URL hoặc Tải Ảnh Lên</label>
                    <div class="mb-2">
                        <input type="text" id="catImage" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="Nhập đường dẫn ảnh (URL)...">
                    </div>
                    <div class="relative w-full h-11 bg-[#13131A] border border-[#2a2d35] rounded-md hover:border-gray-500 transition-colors flex items-center px-3 cursor-pointer overflow-hidden group">
                        <input type="file" id="catImageFile" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-[#E70814] transition-colors mr-2">cloud_upload</span>
                        <span id="fileNameDisplay" class="text-sm text-gray-400 truncate flex-1">... Hoặc chọn ảnh tải lên từ máy tính</span>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" id="catStatus" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-300">Hiển thị ra trang chủ</span>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="btnSave">Lưu Danh Mục</button>
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
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác và có thể ảnh hưởng đến các Nick thuộc danh mục.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel-delete w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="confirmDeleteBtn">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/quanlydanhmuc.js') }}"></script>
@endpush
