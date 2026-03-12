@extends('admin.layouts.master')

@section('title', 'Kiểm duyệt Rút Tiền')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/kiemduyetruttien.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Kiểm duyệt Yêu cầu Rút Tiền</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Tài Chính</li>
                <li><span class="mx-2">/</span></li>
                <li>Kiểm duyệt Rút Tiền</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Số Yêu Cầu</p>
                <h3 class="text-2xl font-bold text-white">45</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">payments</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Chờ Duyệt</p>
                <h3 class="text-2xl font-bold text-yellow-500">8</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                <span class="material-symbols-outlined text-[28px]">pending_actions</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã Duyệt</p>
                <h3 class="text-2xl font-bold text-emerald-400">32</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">check_circle</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã Từ Chối</p>
                <h3 class="text-2xl font-bold text-[#E70814]">5</h3>
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
                <input type="text" id="searchInput" placeholder="Tên / ID Đại lý..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả trạng thái</option>
                <option value="pending" selected>Đang chờ duyệt</option>
                <option value="approved">Đã duyệt (Thành công)</option>
                <option value="rejected">Đã từ chối</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Thời gian</label>
            <select id="dateFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả thời gian</option>
                <option value="today">Hôm nay</option>
                <option value="week">Trong tuần</option>
                <option value="month">Trong tháng</option>
            </select>
        </div>
        <div class="flex items-end">
            <button id="filterBtn" class="w-full bg-[#E70814] hover:bg-[#ff0f1e] text-white font-medium py-2.5 rounded-md transition-colors">
                Lọc Báo Cáo
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
                    <th class="p-4 w-20 text-center">Mã YC</th>
                    <th class="p-4">Thông tin Đại lý</th>
                    <th class="p-4 text-emerald-400">Số Tiền Rút</th>
                    <th class="p-4">Tài Khoản Nhận</th>
                    <th class="p-4">Thời gian</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                <tr class="hover:bg-[#1a1c23] transition-colors group withdraw-row" data-search="Nguyễn Văn A AGENT001" data-status="pending" data-date="today">
                    <td class="p-4 text-center font-medium text-gray-400">#RT0125</td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 font-bold uppercase overflow-hidden">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white group-hover:text-[#E70814] transition-colors">Nguyễn Văn A</h4>
                                <span class="text-xs text-gray-500 uppercase tracking-widest font-bold">ID: AGENT001</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 font-bold text-lg text-white">
                        5,000,000đ
                    </td>
                    <td class="p-4">
                        <div class="text-white font-medium">10123456789</div>
                        <div class="text-gray-400 text-xs">Ngân hàng: <span class="text-blue-400 font-bold">VCB</span> | Tên: NGUYEN VAN A</div>
                    </td>
                    <td class="p-4 text-gray-400 text-sm">
                        Hôm nay 10:24<br>
                        <span class="text-xs text-gray-500">20/03/2026</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">Đang chờ</span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors flex items-center justify-center btn-approve" title="Duyệt yêu cầu" data-id="RT0125" data-agent="Nguyễn Văn A" data-amount="5,000,000đ">
                                <span class="material-symbols-outlined text-[18px]">check</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-yellow-500 hover:bg-yellow-500 hover:text-white transition-colors flex items-center justify-center btn-reject" title="Từ chối" data-id="RT0125" data-agent="Nguyễn Văn A" data-amount="5,000,000đ">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete" title="Xóa bản ghi" data-id="RT0125">
                                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-[#1a1c23] transition-colors group withdraw-row" data-search="Trần Thị B AGENT002" data-status="approved" data-date="today">
                    <td class="p-4 text-center font-medium text-gray-400">#RT0124</td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 font-bold uppercase overflow-hidden">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white group-hover:text-[#E70814] transition-colors">Trần Thị B</h4>
                                <span class="text-xs text-gray-500 uppercase tracking-widest font-bold">ID: AGENT002</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 font-bold text-lg text-white">
                        2,500,000đ
                    </td>
                    <td class="p-4">
                        <div class="text-white font-medium">987654321</div>
                        <div class="text-gray-400 text-xs">Ngân hàng: <span class="text-green-500 font-bold">MB Bank</span> | Tên: TRAN THI B</div>
                    </td>
                    <td class="p-4 text-gray-400 text-sm">
                        Hôm nay 08:15<br>
                        <span class="text-xs text-gray-500">20/03/2026</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">Thành công</span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete" title="Xóa bản ghi" data-id="RT0124">
                                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                            </button>
                        </div>
                    </td>
                </tr>

                 <tr class="hover:bg-[#1a1c23] transition-colors group withdraw-row" data-search="Lê Văn C AGENT003" data-status="rejected" data-date="week">
                    <td class="p-4 text-center font-medium text-gray-400">#RT0123</td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 font-bold uppercase overflow-hidden">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white group-hover:text-[#E70814] transition-colors">Lê Văn C</h4>
                                <span class="text-xs text-gray-500 uppercase tracking-widest font-bold">ID: AGENT003</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 font-bold text-lg text-white">
                        10,000,000đ
                    </td>
                    <td class="p-4">
                        <div class="text-white font-medium">654321098</div>
                        <div class="text-gray-400 text-xs">Ngân hàng: <span class="text-purple-400 font-bold">TPBank</span> | Tên: LE VAN C</div>
                    </td>
                    <td class="p-4 text-gray-400 text-sm">
                        Hôm qua 15:30<br>
                        <span class="text-xs text-gray-500">19/03/2026</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-[#E70814]/10 text-[#E70814] border border-[#E70814]/20">Từ chối</span>
                        <div class="text-[10px] text-gray-500 mt-1" title="Lý do: Sai tên tài khoản">Xem lý do</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete" title="Xóa bản ghi" data-id="RT0123">
                                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 border-t border-[#2a2d35] flex items-center justify-between">
        <span class="text-sm text-gray-400">Hiển thị <span class="font-bold text-white">1</span> đến <span class="font-bold text-white">3</span> của <span class="font-bold text-white">45</span> yêu cầu</span>
        <div class="flex gap-1">
            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#2a2d35] flex items-center justify-center transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-[20px]">chevron_left</span>
            </button>
            <button class="w-8 h-8 rounded bg-[#E70814] text-white flex items-center justify-center font-medium shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors">1</button>
            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#2a2d35] flex items-center justify-center font-medium transition-colors">2</button>
            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#2a2d35] flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined text-[20px]">chevron_right</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Duyệt Yêu Cầu -->
<div id="approveModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Duyệt Rút Tiền</h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                    <span class="material-symbols-outlined text-[32px]">task_alt</span>
                </div>
                <h4 class="text-lg font-bold text-white mb-2">Xác nhận chuyển khoản</h4>
                <p class="text-sm text-gray-400">Bạn chuẩn bị duyệt yêu cầu <span id="approveAmount" class="text-white font-bold"></span> cho <span id="approveAgent" class="text-emerald-400 font-bold"></span>.</p>
                <p class="text-sm text-yellow-500 mt-2">Lưu ý: Chỉ duyệt khi bạn ĐÃ chuyển khoản thành công!</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-emerald-500 text-white font-medium hover:bg-emerald-600 shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-colors" id="btnConfirmApprove">Xác nhận Đã Chuyển</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Từ Chối -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Từ chối Rút Tiền</h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <p class="text-sm text-gray-400 mb-2">Từ chối yêu cầu <span id="rejectAmount" class="font-bold text-white"></span> của <span id="rejectAgent" class="font-bold text-white"></span></p>
            </div>
            <form id="rejectForm">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Lý do từ chối <span class="text-[#E70814]">*</span></label>
                    <textarea id="rejectReason" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-yellow-500 focus:border-yellow-500 block p-3 outline-none min-h-[100px]" placeholder="Nhập lý do chi tiết để đại lý biết (VD: Sai tên người hưởng, Tài khoản không tồn tại...)" required></textarea>
                </div>
                
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-yellow-500 text-white font-medium hover:bg-yellow-600 shadow-[0_2px_10px_rgba(234,179,8,0.3)] transition-colors" id="btnConfirmReject">Xác nhận Từ chối</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-[#E70814]/10 text-[#E70814] flex items-center justify-center mx-auto mb-4 border border-[#E70814]/20">
                <span class="material-symbols-outlined text-[32px]">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Xóa lịch sử rút tiền này? Hành động này không thể hoàn tác.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="btnConfirmDelete">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/kiemduyetruttien.js') }}"></script>
@endpush
