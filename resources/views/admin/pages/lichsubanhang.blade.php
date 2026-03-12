@extends('admin.layouts.master')

@section('title', 'Lịch sử Bán hàng - Admin Panel')

@section('content_header')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white mb-2">Lịch sử Bán hàng</h1>
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E70814] transition-colors">Trang chủ</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-[#E70814]">Tài chính</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-white">Lịch sử Bán hàng</span>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="admin-container">
    <!-- Filters -->
    <div class="glass-panel p-6 rounded-xl mb-6">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Mã Giao Dịch</label>
                <input type="text" class="w-full bg-[#13131A] border border-[#2a2d35] rounded-lg px-4 py-2.5 text-white focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-all" placeholder="Nhập mã GD...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Từ Ngày</label>
                <input type="date" class="w-full bg-[#13131A] border border-[#2a2d35] rounded-lg px-4 py-2.5 text-white focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Đến Ngày</label>
                <input type="date" class="w-full bg-[#13131A] border border-[#2a2d35] rounded-lg px-4 py-2.5 text-white focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-all">
            </div>
            <div class="flex gap-2">
                <button type="button" class="flex-1 bg-[#E70814] hover:bg-red-600 text-white px-4 py-2.5 rounded-lg flex items-center justify-center gap-2 transition-all shadow-[0_4px_12px_rgba(231,8,20,0.2)]">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                    Tìm kiếm
                </button>
                <button type="reset" class="px-4 py-2.5 bg-[#20222a] hover:bg-[#2a2d35] text-gray-400 hover:text-white rounded-lg transition-colors border border-[#2a2d35]">
                    <span class="material-symbols-outlined px-1">refresh</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="glass-panel rounded-xl overflow-hidden">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-[#E70814]">list_alt</span>
                Danh sách Giao dịch
            </h2>
            <button class="bg-[#20222a] hover:bg-[#2a2d35] text-green-500 px-4 py-2 rounded-lg text-sm font-medium transition-colors border border-[#2a2d35] flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Xuất Excel
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="salesHistoryTable">
                <thead>
                    <tr class="bg-[#13131A] text-gray-400 text-sm font-medium border-b border-[#2a2d35]">
                        <th class="py-4 px-6">Mã GD</th>
                        <th class="py-4 px-6">Người Mua</th>
                        <th class="py-4 px-6">Sản Phẩm</th>
                        <th class="py-4 px-6 text-right">Giá Trị</th>
                        <th class="py-4 px-6">Trạng Thái</th>
                        <th class="py-4 px-6">Thời Gian</th>
                        <th class="py-4 px-6 text-center">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="text-sm border-b border-[#2a2d35]">
                    <!-- Sample Row 1 -->
                    <tr class="border-b border-[#2a2d35]/50 hover:bg-[#20222a]/50 transition-colors">
                        <td class="py-4 px-6 font-mono text-[#E70814]">#TXN-998811</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#1a1c23] flex items-center justify-center text-gray-400 font-bold border border-[#2a2d35]">
                                    N
                                </div>
                                <div>
                                    <div class="font-medium text-white">Nguyen Van A</div>
                                    <div class="text-xs text-gray-500">ID: USER-1029</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-white mb-0.5">Nick Liên Quân VIP</div>
                            <div class="text-xs text-gray-500 bg-[#13131A] inline-block px-2 py-0.5 rounded border border-[#2a2d35]">ID: NICK-5541</div>
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-green-500">
                            500.000đ
                        </td>
                        <td class="py-4 px-6">
                            <span class="status-badge status-success">Thành công</span>
                        </td>
                        <td class="py-4 px-6 text-gray-400 text-sm">
                            14:30<br>20/10/2023
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button title="Chi tiết" class="view-detail-btn w-8 h-8 rounded-lg bg-[#20222a] hover:bg-[#2a2d35] text-blue-500 flex items-center justify-center transition-colors border border-[#2a2d35] mx-auto">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <!-- Sample Row 2 -->
                    <tr class="border-b border-[#2a2d35]/50 hover:bg-[#20222a]/50 transition-colors">
                        <td class="py-4 px-6 font-mono text-[#E70814]">#TXN-998810</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#1a1c23] flex items-center justify-center text-gray-400 font-bold border border-[#2a2d35]">
                                    T
                                </div>
                                <div>
                                    <div class="font-medium text-white">Tran Thi B</div>
                                    <div class="text-xs text-gray-500">ID: USER-8832</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-white mb-0.5">Nick Free Fire Siêu Rẻ</div>
                            <div class="text-xs text-gray-500 bg-[#13131A] inline-block px-2 py-0.5 rounded border border-[#2a2d35]">ID: NICK-1123</div>
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-green-500">
                            150.000đ
                        </td>
                        <td class="py-4 px-6">
                            <span class="status-badge status-failed">Thất bại</span>
                        </td>
                        <td class="py-4 px-6 text-gray-400 text-sm">
                            09:15<br>20/10/2023
                        </td>
                        <td class="py-4 px-6 text-center">
                            <button title="Chi tiết" class="view-detail-btn w-8 h-8 rounded-lg bg-[#20222a] hover:bg-[#2a2d35] text-blue-500 flex items-center justify-center transition-colors border border-[#2a2d35] mx-auto">
                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-[#2a2d35] flex items-center justify-between">
            <div class="text-sm text-gray-400">
                Hiển thị <span class="text-white font-medium">1</span> - <span class="text-white font-medium">10</span> trong <span class="text-white font-medium">256</span> giao dịch
            </div>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#13131A] border border-[#2a2d35] text-gray-500 cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#E70814] text-white font-medium">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#20222a] transition-colors">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#20222a] transition-colors">3</button>
                <span class="text-gray-500 px-1">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#20222a] transition-colors">26</button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#20222a] transition-colors">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Detail Modal -->
<div id="transactionModal" class="fixed inset-0 z-50 hidden">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeTransactionModal()"></div>
    
    <!-- Modal Content -->
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-2xl bg-[#1a1c23] rounded-2xl border border-[#2a2d35] shadow-2xl">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-[#2a2d35]">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-[#E70814]">receipt</span>
                Chi tiết Giao dịch
            </h3>
            <button onclick="closeTransactionModal()" class="text-gray-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-6 space-y-6">
            <!-- Summary Info -->
            <div class="flex justify-between items-center bg-[#13131A] p-4 rounded-xl border border-[#2a2d35]">
                <div>
                    <div class="text-sm text-gray-400 mb-1">Mã Giao Dịch</div>
                    <div class="font-mono text-lg text-[#E70814] font-bold" id="modal-txn-id">#TXN-998811</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-400 mb-1">Trạng Thái</div>
                    <span class="status-badge status-success inline-flex" id="modal-txn-status">Thành công</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <!-- Buyer Info -->
                <div>
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">person</span>
                        Thông tin Người mua
                    </h4>
                    <div class="bg-[#13131A] p-4 rounded-xl border border-[#2a2d35] space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Tài khoản ID:</span>
                            <span class="text-white font-medium" id="modal-buyer-id">USER-1029</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Họ và tên:</span>
                            <span class="text-white font-medium" id="modal-buyer-name">Nguyen Van A</span>
                        </div>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div>
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">sports_esports</span>
                        Thông tin Sản phẩm
                    </h4>
                    <div class="bg-[#13131A] p-4 rounded-xl border border-[#2a2d35] space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">ID Nick:</span>
                            <span class="text-white font-medium font-mono" id="modal-prod-id">NICK-5541</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400 text-sm">Tên Game:</span>
                            <span class="text-white font-medium line-clamp-1 text-right" id="modal-prod-name">Nick Liên Quân VIP...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financials -->
            <div>
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">payments</span>
                    Chi tiết Thanh toán
                </h4>
                <div class="bg-[#13131A] p-4 rounded-xl border border-[#2a2d35] space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Thời gian:</span>
                        <span class="text-white" id="modal-txn-time">14:30 20/10/2023</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400 text-sm">Phương thức:</span>
                        <span class="text-white">Trừ tiền tài khoản</span>
                    </div>
                    <div class="h-px w-full bg-[#2a2d35] my-2"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300 font-medium">Tổng tiền thanh toán:</span>
                        <span class="text-xl font-bold text-green-500" id="modal-txn-amount">500.000đ</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="p-6 border-t border-[#2a2d35] flex justify-end gap-3 bg-[#13131A] rounded-b-2xl">
            <button onclick="closeTransactionModal()" class="px-5 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-[#20222a] border border-transparent hover:border-[#2a2d35] transition-all font-medium">
                Đóng
            </button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/lichsubanhang.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('assets/admin/js/lichsubanhang.js') }}"></script>
@endpush
