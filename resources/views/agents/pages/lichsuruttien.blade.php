@extends('agents.layouts.master')

@section('title', 'Lịch Sử Rút Tiền')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/agents/css/lichsuruttien.css') }}">
@endpush

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6 animate-slide-up">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <p class="text-agent-muted text-sm group-hover:text-white transition-colors">Theo dõi và quản lý mọi yêu cầu rút tiền từ tài khoản đại lý của bạn.</p>
        </div>
        <a href="{{ route('agent.ruttien') ?? '#' }}" class="bg-agent-primary hover:bg-agent-hover text-white font-bold py-2.5 px-5 rounded-md transition-all shadow-[0_4px_16px_rgba(231,8,20,0.3)] hover:shadow-[0_6px_20px_rgba(231,8,20,0.5)] flex items-center justify-center gap-2 whitespace-nowrap">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            Tạo yêu cầu rút tiền mới
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg shadow-sm hover:border-[#404452] transition-colors relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-agent-primary/5 rounded-full blur-[40px] pointer-events-none -translate-y-1/2 translate-x-1/2 group-hover:bg-agent-primary/10 transition-colors"></div>
            <div class="flex items-start gap-4 mb-4 relative z-10">
                <div class="bg-agent-primary/10 p-3 rounded-md text-agent-primary">
                    <span class="material-symbols-outlined text-[24px]">payments</span>
                </div>
                <div>
                    <p class="text-agent-muted text-[13px] font-bold uppercase tracking-wide mb-1">Tổng số tiền rút</p>
                    <h3 class="text-white font-black text-[24px]">50.000.000đ</h3>
                </div>
            </div>
            <p class="text-[#10b981] text-[13px] font-semibold flex items-center gap-1 mt-1 relative z-10">
                <span class="material-symbols-outlined text-[16px]">trending_up</span>
                +12.5% so với tháng trước
            </p>
        </div>

        <!-- Card 2 -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg shadow-sm hover:border-[#404452] transition-colors relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-agent-warning/5 rounded-full blur-[40px] pointer-events-none -translate-y-1/2 translate-x-1/2 group-hover:bg-agent-warning/10 transition-colors"></div>
            <div class="flex items-start gap-4 mb-4 relative z-10">
                <div class="bg-agent-warning/10 p-3 rounded-md text-agent-warning">
                    <span class="material-symbols-outlined text-[24px]">pending_actions</span>
                </div>
                <div>
                    <p class="text-agent-muted text-[13px] font-bold uppercase tracking-wide mb-1">Đang xử lý</p>
                    <h3 class="text-white font-black text-[24px]">5.000.000đ</h3>
                </div>
            </div>
            <p class="text-agent-muted text-[13px] font-medium mt-1 relative z-10">
                2 yêu cầu đang chờ phê duyệt
            </p>
        </div>

        <!-- Card 3 -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg shadow-sm hover:border-[#404452] transition-colors relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-32 h-32 bg-[#10b981]/5 rounded-full blur-[40px] pointer-events-none -translate-y-1/2 translate-x-1/2 group-hover:bg-[#10b981]/10 transition-colors"></div>
            <div class="flex items-start gap-4 mb-4 relative z-10">
                <div class="bg-[#10b981]/10 p-3 rounded-md text-[#10b981]">
                    <span class="material-symbols-outlined text-[24px]">check_circle</span>
                </div>
                <div>
                    <p class="text-agent-muted text-[13px] font-bold uppercase tracking-wide mb-1">Thành công</p>
                    <h3 class="text-white font-black text-[24px]">45.000.000đ</h3>
                </div>
            </div>
            <p class="text-agent-muted text-[13px] font-medium mt-1 relative z-10">
                42 giao dịch hoàn tất
            </p>
        </div>
    </div>

    <!-- History Content Block -->
    <div class="bg-agent-card border border-agent-border rounded-lg overflow-hidden mt-8">
        <!-- Tabs -->
        <div class="flex border-b border-agent-border pt-2 px-6 overflow-x-auto hide-scrollbar">
            <button class="nav-tab active relative px-6 py-4 text-[14px] font-bold text-agent-primary whitespace-nowrap transition-colors" data-tab="all">
                Tất cả
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-agent-primary"></div>
            </button>
            <button class="nav-tab relative px-6 py-4 text-[14px] font-bold text-agent-muted hover:text-white whitespace-nowrap transition-colors" data-tab="success">
                Thành công
            </button>
            <button class="nav-tab relative px-6 py-4 text-[14px] font-bold text-agent-muted hover:text-white whitespace-nowrap transition-colors" data-tab="pending">
                Đang xử lý
            </button>
            <button class="nav-tab relative px-6 py-4 text-[14px] font-bold text-agent-muted hover:text-white whitespace-nowrap transition-colors" data-tab="failed">
                Thất bại
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="bg-[#1a1c23] border-b border-agent-border">
                        <th class="py-4 px-6 text-agent-muted text-[12px] font-bold uppercase tracking-wider">Mã GD</th>
                        <th class="py-4 px-6 text-agent-muted text-[12px] font-bold uppercase tracking-wider">Số tiền rút</th>
                        <th class="py-4 px-6 text-agent-muted text-[12px] font-bold uppercase tracking-wider">Hình thức nhận</th>
                        <th class="py-4 px-6 text-agent-muted text-[12px] font-bold uppercase tracking-wider">Thời gian</th>
                        <th class="py-4 px-6 text-agent-muted text-[12px] font-bold uppercase tracking-wider text-center">Trạng thái</th>
                        <th class="py-4 px-6 text-agent-muted text-[12px] font-bold uppercase tracking-wider text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-agent-border text-white text-[14px]" id="history-tbody">
                    <!-- Row 1 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors" data-status="success">
                        <td class="py-4 px-6 font-bold">WD-8921034</td>
                        <td class="py-4 px-6 font-bold">10.000.000đ</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-agent-muted">account_balance</span>
                                <span class="font-semibold">Vietcombank</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-agent-muted">14:20 22/05/2024</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#10b981]/15 text-[#10b981] text-[12px] font-bold border border-[#10b981]/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                Thành công
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Row 2 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors" data-status="pending">
                        <td class="py-4 px-6 font-bold">WD-8921035</td>
                        <td class="py-4 px-6 font-bold">5.000.000đ</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-agent-muted">account_balance_wallet</span>
                                <span class="font-semibold">VÍ USDT (BEP20)</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-agent-muted">09:15 22/05/2024</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-agent-warning/15 text-agent-warning text-[12px] font-bold border border-agent-warning/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-agent-warning"></span>
                                Đang xử lý
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors" data-status="success">
                        <td class="py-4 px-6 font-bold">WD-8921031</td>
                        <td class="py-4 px-6 font-bold">15.000.000đ</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-agent-muted">account_balance</span>
                                <span class="font-semibold">Techcombank</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-agent-muted">18:45 20/05/2024</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#10b981]/15 text-[#10b981] text-[12px] font-bold border border-[#10b981]/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                Thành công
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 4 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors" data-status="failed">
                        <td class="py-4 px-6 font-bold">WD-8921028</td>
                        <td class="py-4 px-6 font-bold">2.500.000đ</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-agent-muted">account_balance</span>
                                <span class="font-semibold">Momo</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-agent-muted">11:10 19/05/2024</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-agent-primary/15 text-agent-primary text-[12px] font-bold border border-agent-primary/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-agent-primary"></span>
                                Thất bại
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-agent-muted hover:text-white transition-colors" title="Xem lý do từ chối">
                                <span class="material-symbols-outlined">info</span>
                            </button>
                        </td>
                    </tr>

                    <!-- Row 5 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors" data-status="success">
                        <td class="py-4 px-6 font-bold">WD-8921025</td>
                        <td class="py-4 px-6 font-bold">20.000.000đ</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-[18px] text-agent-muted">account_balance</span>
                                <span class="font-semibold">Vietcombank</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-agent-muted">15:30 18/05/2024</td>
                        <td class="py-4 px-6 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#10b981]/15 text-[#10b981] text-[12px] font-bold border border-[#10b981]/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                Thành công
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined">visibility</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Empty State (Hidden via JS initially or server logic) -->
            <div id="empty-state" class="hidden flex flex-col items-center justify-center py-16 px-4">
                <span class="material-symbols-outlined text-[64px] text-agent-muted/50 mb-4">inbox</span>
                <p class="text-white font-bold text-[16px] mb-2">Không tìm thấy giao dịch</p>
                <p class="text-agent-muted text-[14px]">Chưa có giao dịch rút tiền nào trong mục này.</p>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between p-6 border-t border-agent-border bg-[#1a1c23] gap-4">
            <div class="text-agent-muted text-[13px] font-medium">
                Hiển thị <span class="text-white font-bold mx-1">1 - 5</span> trên <span class="text-white font-bold mx-1">42</span> giao dịch
            </div>
            
            <div class="flex items-center gap-1.5">
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#2a2d35] border border-agent-border text-agent-muted hover:text-white hover:border-agent-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-agent-primary text-white font-bold text-[13px] border border-agent-primary shadow-[0_2px_8px_rgba(231,8,20,0.4)]">
                    1
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#2a2d35] border border-agent-border text-white font-bold text-[13px] hover:border-agent-primary hover:text-agent-primary transition-colors">
                    2
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#2a2d35] border border-agent-border text-white font-bold text-[13px] hover:border-agent-primary hover:text-agent-primary transition-colors">
                    3
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-[#2a2d35] border border-agent-border text-agent-muted hover:text-white hover:border-agent-primary transition-colors">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/agents/js/lichsuruttien.js') }}"></script>
@endpush
