@extends('admin.layouts.master')

@section('title', 'Hỗ trợ Phòng vé')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/hotrophongve.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Hỗ trợ Phòng vé</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>CMS & Cài Đặt</li>
                <li><span class="mx-2">/</span></li>
                <li>Hỗ trợ Phòng vé</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Số Vé</p>
                <h3 class="text-2xl font-bold text-white">128</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">receipt_long</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Chờ Phản Hồi</p>
                <h3 class="text-2xl font-bold text-[#E70814]">12</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">mark_email_unread</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Xử Lý</p>
                <h3 class="text-2xl font-bold text-yellow-500">5</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                <span class="material-symbols-outlined text-[28px]">hourglass_top</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã Đóng</p>
                <h3 class="text-2xl font-bold text-emerald-400">111</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">check_circle</span>
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
                <input type="text" id="searchInput" placeholder="Mã vé / Khách hàng..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả trạng thái</option>
                <option value="pending" selected>Chờ phản hồi</option>
                <option value="processing">Đang xử lý</option>
                <option value="closed">Đã đóng</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Chủ Đề</label>
            <select id="topicFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả chủ đề</option>
                <option value="payment">Nạp tiền / Thanh toán</option>
                <option value="account">Tài khoản</option>
                <option value="bug">Lỗi Game / Hệ thống</option>
                <option value="other">Khác</option>
            </select>
        </div>
        <div class="flex items-end">
            <button id="filterBtn" class="w-full bg-[#E70814] hover:bg-[#ff0f1e] text-white font-medium py-2.5 rounded-md transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">filter_list</span>
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
                    <th class="p-4 w-20 text-center">Mã Vé</th>
                    <th class="p-4">Khách Hàng</th>
                    <th class="p-4">Chủ Đề & Tiêu Đề</th>
                    <th class="p-4">Cập Nhật Gần Nhất</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]" id="ticketTableBody">
                <tr class="hover:bg-[#1a1c23] transition-colors group ticket-row" data-search="Nguyễn Văn A TK0125" data-status="pending" data-topic="payment">
                    <td class="p-4 text-center font-medium text-gray-400">#TK0125</td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 font-bold uppercase overflow-hidden">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white group-hover:text-[#E70814] transition-colors">Nguyễn Văn A</h4>
                                <span class="text-xs text-gray-500 font-bold">Thành viên</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-white font-medium mb-1">Nạp tiền bị lỗi không lên số dư</div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-blue-400 border border-blue-400/20 bg-blue-400/10 px-2 py-0.5 rounded">Nạp tiền</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-400 text-sm">
                        Hôm nay 10:24<br>
                        <span class="text-xs text-gray-500">20/03/2026</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-[#E70814]/10 text-[#E70814] border border-[#E70814]/20">Chờ phản hồi</span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-reply" title="Phản hồi vé" data-id="TK0125" data-title="Nạp tiền bị lỗi không lên số dư" data-customer="Nguyễn Văn A">
                                <span class="material-symbols-outlined text-[18px]">reply</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors flex items-center justify-center btn-close-ticket" title="Đóng vé" data-id="TK0125">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete" title="Xóa vé" data-id="TK0125">
                                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                            </button>
                        </div>
                    </td>
                </tr>

                <tr class="hover:bg-[#1a1c23] transition-colors group ticket-row" data-search="Trần Thị B TK0124" data-status="processing" data-topic="account">
                    <td class="p-4 text-center font-medium text-gray-400">#TK0124</td>
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
                    <td class="p-4">
                        <div class="text-white font-medium mb-1">Quên mật khẩu cấp 2 tài khoản đại lý</div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-purple-400 border border-purple-400/20 bg-purple-400/10 px-2 py-0.5 rounded">Tài khoản</span>
                        </div>
                    </td>
                    <td class="p-4 text-gray-400 text-sm">
                        Hôm nay 08:15<br>
                        <span class="text-xs text-gray-500">20/03/2026</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">Đang xử lý</span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-reply" title="Phản hồi vé" data-id="TK0124" data-title="Quên mật khẩu cấp 2 tài khoản đại lý" data-customer="Trần Thị B">
                                <span class="material-symbols-outlined text-[18px]">reply</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-emerald-400 hover:bg-emerald-500 hover:text-white transition-colors flex items-center justify-center btn-close-ticket" title="Đóng vé" data-id="TK0124">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            </button>
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete" title="Xóa vé" data-id="TK0124">
                                <span class="material-symbols-outlined text-[18px]">delete_forever</span>
                            </button>
                        </div>
                    </td>
                </tr>

                 <tr class="hover:bg-[#1a1c23] transition-colors group ticket-row" data-search="Lê Văn C TK0123" data-status="closed" data-topic="bug">
                    <td class="p-4 text-center font-medium text-gray-400">#TK0123</td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 font-bold uppercase overflow-hidden">
                                <span class="material-symbols-outlined">person</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white group-hover:text-[#E70814] transition-colors">Lê Văn C</h4>
                                <span class="text-xs text-gray-500 font-bold">Thành viên</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-400 font-medium line-through mb-1">Mua nick báo lỗi không kết nối</div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-orange-400 border border-orange-400/20 bg-orange-400/10 px-2 py-0.5 rounded">Lỗi Game</span>
                        </div>
                    </td>
                     <td class="p-4 text-gray-400 text-sm">
                        Hôm qua 15:30<br>
                        <span class="text-xs text-gray-500">19/03/2026</span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-md bg-emerald-500/10 text-emerald-500 border border-emerald-500/20">Đã đóng</span>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                             <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete" title="Xóa vé" data-id="TK0123">
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
        <span class="text-sm text-gray-400">Hiển thị <span class="font-bold text-white">1</span> đến <span class="font-bold text-white">3</span> của <span class="font-bold text-white">128</span> vé</span>
        <div class="flex gap-1" id="pagination">
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

<!-- Modal Phản Hồi Vé -->
<div id="replyModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-2xl shadow-2xl transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center shrink-0">
            <div>
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E70814]">forum</span>
                    Chi tiết vé <span id="replyTicketId" class="text-blue-400"></span>
                </h3>
                <p class="text-sm text-gray-400 mt-1" id="replyCustomerName"></p>
            </div>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Nội dung vé -->
        <div class="p-6 overflow-y-auto flex-1 admin-scrollbar space-y-4">
            <h4 class="text-lg font-bold text-white mb-4" id="replyTicketTitle"></h4>
            
            <!-- Message from customer -->
            <div class="flex gap-4">
                 <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 shrink-0">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div class="bg-[#13131A] border border-[#2a2d35] rounded-lg rounded-tl-none p-4 flex-1">
                    <p class="text-gray-300 text-sm leading-relaxed">Admin xem giúp em tài khoản này nạp tiền từ hôm qua mà chưa thấy lên điểm, em chuyển khoản VCB stk 101010101.</p>
                    <span class="text-xs text-gray-500 mt-2 block">10:24 AM - 20/03/2026</span>
                </div>
            </div>

            <!-- Message from Admin -->
            <div class="flex gap-4 flex-row-reverse mt-4">
                <div class="w-10 h-10 rounded-full bg-[#E70814]/10 border border-[#E70814]/20 flex items-center justify-center text-[#E70814] shrink-0">
                    <span class="material-symbols-outlined">admin_panel_settings</span>
                </div>
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg rounded-tr-none p-4 flex-1">
                    <p class="text-blue-100 text-sm leading-relaxed">Chào bạn, hệ thống đã kiểm tra. Vui lòng cung cấp thêm hình ảnh biên lai để admin hỗ trợ nhanh nhất nhé.</p>
                     <span class="text-xs text-blue-300/50 mt-2 block text-right">11:00 AM - 20/03/2026</span>
                </div>
            </div>
             <!-- Message from customer -->
             <div class="flex gap-4 mt-4">
                 <div class="w-10 h-10 rounded-full bg-[#13131A] border border-[#2a2d35] flex items-center justify-center text-gray-400 shrink-0">
                    <span class="material-symbols-outlined">person</span>
                </div>
                <div class="bg-[#13131A] border border-[#2a2d35] rounded-lg rounded-tl-none p-4 flex-1">
                    <p class="text-gray-300 text-sm leading-relaxed">Dạ em gửi ảnh rồi ạ.</p>
                    <div class="mt-2 text-[#E70814] text-xs font-bold">[Đính kèm: image_123.jpg]</div>
                    <span class="text-xs text-gray-500 mt-2 block">11:15 AM - 20/03/2026</span>
                </div>
            </div>
            
        </div>
        
        <!-- From Reply -->
        <div class="p-6 border-t border-[#2a2d35] shrink-0">
             <form id="replyForm">
                <div class="mb-4">
                    <textarea id="replyContent" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 block p-3 outline-none min-h-[100px]" placeholder="Nhập câu trả lời của bạn..." required></textarea>
                </div>
                
                <div class="flex justify-between items-center">
                     <button type="button" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium transition-colors border border-emerald-400/20 bg-emerald-400/10 px-3 py-2 rounded-md" id="btnQuickClose">Đánh dấu Đã xử lý</button>
                    <div class="flex items-center gap-3">
                         <button type="button" class="btn-cancel px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                        <button type="submit" class="px-6 py-2.5 rounded-lg bg-blue-500 text-white font-medium hover:bg-blue-600 shadow-[0_2px_10px_rgba(59,130,246,0.3)] transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">send</span>
                            Gửi Trả Lời
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xóa Vé -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-[#E70814]/10 text-[#E70814] flex items-center justify-center mx-auto mb-4 border border-[#E70814]/20">
                <span class="material-symbols-outlined text-[32px]">delete_forever</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Xóa vé hỗ trợ này? Hành động này không thể hoàn tác.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="btnConfirmDelete">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đóng Vé -->
<div id="closeTicketModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                <span class="material-symbols-outlined text-[32px]">check_circle</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Đóng Vé</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn xác nhận sự cố này đã được giải quyết?</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-emerald-500 text-white font-medium hover:bg-emerald-600 shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-colors" id="btnConfirmCloseTicket">Đóng Vé</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/hotrophongve.js') }}"></script>
@endpush
