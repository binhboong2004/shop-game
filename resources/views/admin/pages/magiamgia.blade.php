@extends('admin.layouts.master')

@section('title', 'Quản lý Mã Giảm Giá')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/magiamgia.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Quản lý Mã Giảm Giá</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Mã Giảm Giá</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button id="addCouponBtn" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Mã Giảm Giá
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Mã Giảm Giá</p>
                <h3 class="text-2xl font-bold text-white">24</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">local_activity</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Hoạt Động</p>
                <h3 class="text-2xl font-bold text-emerald-400">18</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">check_circle</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã Hết Hạn / Hết Lượt</p>
                <h3 class="text-2xl font-bold text-[#E70814]">6</h3>
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
                <input type="text" id="searchInput" placeholder="Nhập mã code..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả</option>
                <option value="active">Đang hoạt động</option>
                <option value="expired">Đã hết hạn/Hết lượt</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Loại Giảm</label>
            <select id="typeFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả</option>
                <option value="percent">Phần trăm (%)</option>
                <option value="money">Số tiền (VNĐ)</option>
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
                    <th class="p-4 w-16 text-center">ID</th>
                    <th class="p-4">Mã Code</th>
                    <th class="p-4 text-center">Loại Giảm</th>
                    <th class="p-4 text-center">Mức Giảm</th>
                    <th class="p-4 text-center">Đã Dùng / Tổng</th>
                    <th class="p-4 text-center">Thời Gian Hết Hạn</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                <tr class="hover:bg-[#1a1c23] transition-colors group coupon-row" data-search="TET2026" data-status="active">
                    <td class="p-4 text-center font-medium text-gray-400">#1</td>
                    <td class="p-4 font-bold text-emerald-400 tracking-wider">
                        TET2026
                    </td>
                    <td class="p-4 text-center text-gray-300">
                        <span class="px-2 py-1 bg-blue-500/10 text-blue-400 text-xs rounded border border-blue-500/20">Phần trăm</span>
                    </td>
                    <td class="p-4 text-center text-[#E70814] font-bold">
                        15%
                    </td>
                    <td class="p-4 text-center text-gray-300">
                        <span class="text-white font-medium">120</span> / 500
                        <div class="w-full bg-[#13131A] rounded-full h-1.5 mt-2 overflow-hidden border border-[#2a2d35]">
                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 24%"></div>
                        </div>
                    </td>
                    <td class="p-4 text-center text-gray-400">
                        28/02/2026 23:59
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-500 text-xs rounded-full font-medium border border-emerald-500/20 flex w-max mx-auto items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Hoạt động
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit-coupon" title="Sửa">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete-coupon" title="Xóa">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-[#1a1c23] transition-colors group coupon-row" data-search="GIAM50K" data-status="expired">
                    <td class="p-4 text-center font-medium text-gray-400">#2</td>
                    <td class="p-4 font-bold text-gray-400 tracking-wider line-through">
                        GIAM50K
                    </td>
                    <td class="p-4 text-center text-gray-300">
                        <span class="px-2 py-1 bg-purple-500/10 text-purple-400 text-xs rounded border border-purple-500/20">Số tiền</span>
                    </td>
                    <td class="p-4 text-center text-gray-400 font-bold">
                        50.000đ
                    </td>
                    <td class="p-4 text-center text-gray-300">
                        <span class="text-[#E70814] font-medium">100</span> / 100
                        <div class="w-full bg-[#13131A] rounded-full h-1.5 mt-2 overflow-hidden border border-[#2a2d35]">
                            <div class="bg-[#E70814] h-1.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </td>
                    <td class="p-4 text-center text-gray-500">
                        15/01/2026 23:59
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-3 py-1 bg-gray-500/10 text-gray-400 text-xs rounded-full font-medium border border-gray-500/20 flex w-max mx-auto items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                            Hết lượt
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit-coupon" title="Sửa">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete-coupon" title="Xóa">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm/Sửa Mã Giảm Giá -->
<div id="couponModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-lg shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center bg-[#1a1c23] rounded-t-xl">
            <h3 class="text-xl font-bold text-white flex items-center gap-2" id="modalTitle">
                <span class="material-symbols-outlined text-[#E70814]">local_activity</span>
                Thêm Mã Giảm Giá Mới
            </h3>
            <button type="button" class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 max-h-[75vh] overflow-y-auto admin-scrollbar">
            <form id="couponForm">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Mã Code <span class="text-[#E70814]">*</span></label>
                        <div class="flex gap-2">
                            <input type="text" id="couponCode" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none font-bold tracking-wider uppercase" placeholder="VD: TET2026" required>
                            <button type="button" class="bg-[#2a2d35] hover:bg-gray-600 text-white px-3 py-2.5 rounded-md transition-colors whitespace-nowrap text-sm font-medium" onclick="document.getElementById('couponCode').value = Math.random().toString(36).substring(2, 10).toUpperCase()">
                                Gẫu nhiên
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Loại Giảm Giá <span class="text-[#E70814]">*</span></label>
                        <select class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                            <option value="percent">Giảm theo %</option>
                            <option value="fixed">Giảm số tiền cố định</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Mức Giảm <span class="text-[#E70814]">*</span></label>
                        <input type="number" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="VD: 10 hoặc 50000" min="1" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Số lượng tối đa <span class="text-gray-500 font-normal">(0 = Vô hạn)</span></label>
                    <input type="number" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="100" min="0" value="100">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Ngày Bắt Đầu</label>
                        <input type="datetime-local" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" style="color-scheme: dark;">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Ngày Kết Thúc</label>
                        <input type="datetime-local" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" style="color-scheme: dark;">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Áp dụng cho <span class="text-xs text-gray-500 font-normal">(Mặc định: Tất cả thành viên)</span></label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 rounded bg-[#13131A] border-[#2a2d35] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                            <span class="text-sm text-gray-300">Chỉ dành cho Đại lý</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" class="w-4 h-4 rounded bg-[#13131A] border-[#2a2d35] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                            <span class="text-sm text-gray-300">Yêu cầu đăng nhập để sử dụng</span>
                        </label>
                    </div>
                </div>

                <div class="mb-6 border-t border-[#2a2d35] pt-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" id="couponStatus" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-300">Kích hoạt mã chạy ngay lập tức</span>
                    </label>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy Bỏ</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors flex justify-center items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Lưu Mã Giảm Giá
                    </button>
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
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa mã giảm giá này? Hành động này không thể hoàn tác và user sẽ không thể dùng code này nữa.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel-delete w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="confirmDeleteBtn">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include SweetAlert2 if not already in master -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/admin/js/magiamgia.js') }}"></script>
@endpush
