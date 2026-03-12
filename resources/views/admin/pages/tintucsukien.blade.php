@extends('admin.layouts.master')

@section('title', 'Tin tức & Sự kiện')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/tintucsukien.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Tin tức & Sự kiện</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">CMS & Cài Đặt</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Tin tức & Sự kiện</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium" id="btn-add-news">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Bài Viết Mới
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Bài Viết</p>
                <h3 class="text-2xl font-bold text-white">125</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">article</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tin Tức</p>
                <h3 class="text-2xl font-bold text-white">85</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">newspaper</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Sự Kiện</p>
                <h3 class="text-2xl font-bold text-white">40</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500">
                <span class="material-symbols-outlined text-[28px]">event</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Ẩn/Chờ</p>
                <h3 class="text-2xl font-bold text-white">12</h3>
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
                <input type="text" id="searchInput" placeholder="Nhập tiêu đề bài viết..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Chuyên Mục</label>
            <select id="categoryFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả chuyên mục</option>
                <option value="news">Tin tức</option>
                <option value="event">Sự kiện</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả trạng thái</option>
                <option value="active">Hiển thị</option>
                <option value="hidden">Đang ẩn</option>
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
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
                <tr class="bg-[#1a1c23] border-b border-[#2a2d35] text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    <th class="p-4 w-12 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814]">
                    </th>
                    <th class="p-4">Bài Viết</th>
                    <th class="p-4">Chuyên Mục</th>
                    <th class="p-4 text-center">Lượt Xem</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4">Ngày Đăng</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                <tr class="hover:bg-[#1a1c23] transition-colors group">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814]">
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-12 rounded bg-[#13131A] border border-[#2a2d35] overflow-hidden shrink-0">
                                <img src="https://lienquan.garena.vn/files/skin/7efaf8d745585b59cedaddacbde6ec0b6348efc6.jpg" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="Thumb">
                            </div>
                            <div>
                                <p class="font-bold text-white group-hover:text-[#E70814] transition-colors line-clamp-1">Sự kiện nạp quân huy nhận trang phục VIP</p>
                                <p class="text-xs text-gray-500 mt-0.5 max-w-[300px] line-clamp-1">Cơ hội sở hữu trang phục Ngộ Không Nhóc Tì Bá Đạo...</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <span class="inline-block px-2 py-1 bg-purple-500/10 text-purple-400 text-xs font-bold border border-purple-500/20 rounded">Sự Kiện</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="text-gray-300 font-medium">1,245</span>
                    </td>
                    <td class="p-4 text-center">
                        <button class="inline-block w-20 px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20 rounded btn-status-toggle">
                            Hiển thị
                        </button>
                    </td>
                    <td class="p-4 text-gray-400">
                        <div class="text-xs">12/10/2023 14:30</div>
                        <div class="text-[11px] mt-0.5 text-blue-400">Bởi: Admin</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 border-t border-[#2a2d35] flex items-center justify-between text-sm text-gray-400">
        <div>Hiển thị 1 - 10 trong tổng 125 bài viết</div>
        <div class="flex items-center gap-1">
            <button class="px-3 py-1 bg-[#13131A] border border-[#2a2d35] rounded hover:text-white transition-colors">Trước</button>
            <button class="px-3 py-1 bg-[#E70814] text-white border border-[#E70814] rounded font-medium">1</button>
            <button class="px-3 py-1 bg-[#13131A] border border-[#2a2d35] rounded hover:text-white transition-colors">Tiếp</button>
        </div>
    </div>
</div>

<!-- Modal Thêm/Sửa Bài Viết -->
<div id="newsModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-5 border-b border-[#2a2d35] flex items-center justify-between shrink-0">
            <h3 class="text-xl font-bold text-white" id="modalTitle">Thêm Bài Viết Mới</h3>
            <button type="button" class="btn-cancel text-gray-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto admin-scrollbar flex-1">
            <form id="newsForm" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tiêu đề bài viết <span class="text-[#E70814]">*</span></label>
                        <input type="text" id="newsTitle" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] outline-none" required placeholder="Nhập tiêu đề...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Chuyên mục <span class="text-[#E70814]">*</span></label>
                        <select id="newsCategory" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] outline-none appearance-none" required>
                            <option value="news">Tin tức</option>
                            <option value="event">Sự kiện</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Trạng thái hiển thị</label>
                        <select id="newsStatus" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] outline-none appearance-none">
                            <option value="active">Hiển thị ngay</option>
                            <option value="hidden">Lưu nháp (Ẩn)</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Ảnh đại diện (Thumbnail)</label>
                        <div class="flex items-center gap-4">
                            <div class="w-32 h-20 rounded-lg border border-dashed border-[#2a2d35] bg-[#13131A] flex items-center justify-center p-1 relative overflow-hidden group">
                                <img src="" alt="" class="w-full h-full object-cover hidden z-0" id="thumbnail-preview">
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10" id="upload-overlay">
                                    <span class="material-symbols-outlined text-white text-[20px]">upload</span>
                                </div>
                                <span class="material-symbols-outlined text-gray-500 text-[32px] absolute" id="thumbnail-icon">image</span>
                                <input type="file" id="thumbnail-upload" class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*">
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-400 mb-2">Định dạng: JPG, PNG, WEBP. Tỷ lệ 16:9.</p>
                                <button type="button" class="btn-upload text-xs px-3 py-1.5 bg-[#20222a] hover:bg-[#2a2d35] text-white border border-[#2a2d35] rounded-md transition-colors" onclick="document.getElementById('thumbnail-upload').click()">Tải ảnh lên</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Mô tả ngắn</label>
                        <textarea id="newsExcerpt" rows="2" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2 focus:border-[#E70814] outline-none resize-none text-sm" placeholder="Mô tả ngắn gọn về bài viết..."></textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nội dung chi tiết <span class="text-[#E70814]">*</span></label>
                        <!-- Giả lập CKEditor / Trình soạn thảo -->
                        <div class="border border-[#2a2d35] rounded-lg overflow-hidden flex flex-col">
                            <div class="bg-[#13131A] border-b border-[#2a2d35] p-2 flex gap-1 items-center flex-wrap">
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="font-serif font-bold">B</span></button>
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="font-serif italic">I</span></button>
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="font-serif underline">U</span></button>
                                <div class="w-px h-5 bg-[#2a2d35] mx-1"></div>
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="material-symbols-outlined text-[18px]">format_align_left</span></button>
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="material-symbols-outlined text-[18px]">format_align_center</span></button>
                                <div class="w-px h-5 bg-[#2a2d35] mx-1"></div>
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="material-symbols-outlined text-[18px]">image</span></button>
                                <button type="button" class="w-8 h-8 flex justify-center items-center text-gray-400 hover:text-white hover:bg-[#2a2d35] rounded"><span class="material-symbols-outlined text-[18px]">link</span></button>
                            </div>
                            <textarea id="newsContent" rows="8" class="w-full bg-[#13131A] text-white p-4 focus:outline-none resize-none text-sm" placeholder="Nhập nội dung bài viết vào đây..."></textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-5 border-t border-[#2a2d35] flex items-center justify-end gap-3 shrink-0 bg-[#20222a] rounded-b-xl">
            <button type="button" class="btn-cancel px-5 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
            <button type="button" id="btn-save-news" class="px-5 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors">Lưu Bài Viết</button>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-500/10 text-gray-400 flex items-center justify-center mx-auto mb-4 border border-gray-500/20">
                <span class="material-symbols-outlined text-[32px]">delete</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa bài viết này không? Hành động này không thể hoàn tác.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-gray-600 text-white font-medium hover:bg-gray-700 shadow-[0_2px_10px_rgba(75,85,99,0.3)] transition-colors">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/tintucsukien.js') }}"></script>
@endpush
