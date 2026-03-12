@extends('admin.layouts.master')

@section('title', 'Tổng quan hệ thống')

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white mb-1">Tổng quan hệ thống</h1>
            <p class="text-admin-muted text-sm">Báo cáo hoạt động và doanh thu toàn sàn ShopNickVN.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <button class="bg-[#20222a] border border-[#2a2d35] hover:bg-[#2a2d35] text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                Hôm nay
            </button>
            <button class="bg-admin-primary hover:bg-admin-hover text-white px-4 py-2 rounded-md font-bold transition-all shadow-[0_4px_12px_rgba(231,8,20,0.25)] flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Xuất Báo Cáo
            </button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <!-- Doanh thu -->
        <div class="bg-admin-card border border-admin-border rounded-xl p-5 relative overflow-hidden group hover:border-[#E70814]/30 transition-all">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-[#E70814]/5 rounded-full transition-transform group-hover:scale-150"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-10 h-10 rounded-lg bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                    <span class="material-symbols-outlined">payments</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-admin-muted text-sm mb-1 font-medium">Tổng doanh thu</p>
                <h3 class="text-2xl font-black text-white">{{ number_format($totalRevenue) }}đ</h3>
            </div>
        </div>

        <!-- Người dùng -->
        <div class="bg-admin-card border border-admin-border rounded-xl p-5 relative overflow-hidden group hover:border-blue-500/30 transition-all">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full transition-transform group-hover:scale-150"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-10 h-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-admin-muted text-sm mb-1 font-medium">Thành viên mới (30 ngày)</p>
                <h3 class="text-2xl font-black text-white">{{ number_format($newMembers) }}</h3>
            </div>
        </div>

        <!-- Đại lý -->
        <div class="bg-admin-card border border-admin-border rounded-xl p-5 relative overflow-hidden group hover:border-purple-500/30 transition-all">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/5 rounded-full transition-transform group-hover:scale-150"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-10 h-10 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-500">
                    <span class="material-symbols-outlined">shield_person</span>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-admin-muted text-sm mb-1 font-medium">Tổng Đại lý</p>
                <h3 class="text-2xl font-black text-white">{{ number_format($totalAgents) }}</h3>
            </div>
        </div>

        <!-- Chờ duyệt -->
        <div class="bg-admin-card border border-admin-border rounded-xl p-5 relative overflow-hidden group hover:border-yellow-500/30 transition-all">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/5 rounded-full transition-transform group-hover:scale-150"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div class="w-10 h-10 rounded-lg bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <div class="text-yellow-500 flex items-center gap-1 text-sm font-bold bg-yellow-500/10 px-2 py-1 rounded border border-yellow-500/20">
                    Cần xử lý
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-admin-muted text-sm mb-1 font-medium">Nick đang chờ duyệt</p>
                <h3 class="text-2xl font-black text-white">{{ number_format($pendingAccounts) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders (Phần chính) -->
        <div class="lg:col-span-2 bg-admin-card rounded-xl border border-admin-border">
            <div class="p-5 border-b border-admin-border flex justify-between items-center">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E70814]">receipt_long</span> 
                    Giao dịch gần đây
                </h2>
                <a href="#" class="text-sm text-admin-primary hover:underline">Xem tất cả</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-admin-border text-xs text-admin-muted uppercase tracking-wider bg-[#13131A]/30">
                            <th class="p-4 font-semibold">Khách Hàng</th>
                            <th class="p-4 font-semibold">Tài Khoản Game</th>
                            <th class="p-4 font-semibold">Giá Trị</th>
                            <th class="p-4 font-semibold">Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-admin-border/50 text-sm">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-admin-border/20 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-white mb-0.5">{{ $order->buyer ? $order->buyer->name : 'Khách vãng lai' }}</div>
                                <div class="text-xs text-admin-muted">ID: #Cus{{ $order->buyer_id ?? 'N/A' }}</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-gray-200 mb-0.5">{{ $order->account ? $order->account->title : 'N/A' }}</div>
                                <div class="text-xs text-admin-muted">Game: {{ $order->account && $order->account->gameCategory ? $order->account->gameCategory->name : 'N/A' }}</div>
                            </td>
                            <td class="p-4 font-bold overflow-hidden text-[#E70814]">{{ number_format($order->amount) }}đ</td>
                            <td class="p-4">
                                @if($order->status == 'completed')
                                    <span class="bg-green-500/10 text-green-500 px-2.5 py-1 rounded-full text-xs font-semibold border border-green-500/20">Hoàn thành</span>
                                @elseif($order->status == 'refunded')
                                    <span class="bg-red-500/10 text-red-500 px-2.5 py-1 rounded-full text-xs font-semibold border border-red-500/20">Hoàn tiền</span>
                                @else
                                    <span class="bg-yellow-500/10 text-yellow-500 px-2.5 py-1 rounded-full text-xs font-semibold border border-yellow-500/20">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($recentOrders->isEmpty())
                        <tr>
                            <td colspan="4" class="p-4 text-center text-admin-muted">Chưa có giao dịch nào</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cần Chú Ý (Sidebar Analytics) -->
        <div class="bg-admin-card rounded-xl border border-admin-border flex flex-col">
            <div class="p-5 border-b border-admin-border">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-yellow-500">warning</span> 
                    Cần chú ý
                </h2>
            </div>
            <div class="p-5 flex-1 space-y-4">
                <a href="#" class="block bg-admin-bg border border-admin-border rounded-lg p-3 hover:border-admin-primary/50 transition-colors group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-white text-sm mb-1 group-hover:text-admin-primary transition-colors">Yêu cầu rút tiền mới</p>
                            <p class="text-xs text-admin-muted">{{ $pendingWithdrawals }} yêu cầu chưa xử lý từ Đại lý</p>
                        </div>
                        <span class="bg-[#E70814] text-white text-[10px] font-bold px-2 py-0.5 rounded">{{ $pendingWithdrawals }}</span>
                    </div>
                </a>
                
                <a href="#" class="block bg-admin-bg border border-admin-border rounded-lg p-3 hover:border-yellow-500/50 transition-colors group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-white text-sm mb-1 group-hover:text-yellow-500 transition-colors">Nick chờ duyệt</p>
                            <p class="text-xs text-admin-muted">Hệ thống có {{ $pendingAccounts }} nick mới cần duyệt</p>
                        </div>
                        <span class="bg-yellow-500 text-black text-[10px] font-bold px-2 py-0.5 rounded">{{ $pendingAccounts }}</span>
                    </div>
                </a>

                <a href="#" class="block bg-admin-bg border border-admin-border rounded-lg p-3 hover:border-red-500/50 transition-colors group">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-white text-sm mb-1 group-hover:text-red-500 transition-colors">Nạp tiền sai cú pháp</p>
                            <p class="text-xs text-admin-muted">{{ $failedDeposits }} lệnh nạp tự động bị lỗi</p>
                        </div>
                        <span class="bg-red-500/20 border border-red-500 text-red-500 text-[10px] font-bold px-2 py-0.5 rounded">{{ $failedDeposits }}</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
