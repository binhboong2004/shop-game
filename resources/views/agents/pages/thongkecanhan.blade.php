@extends('agents.layouts.master')

@section('title', 'Thống Kê Cá Nhân')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/agents/css/thongkecanhan.css') }}">
@endpush

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6 animate-slide-up">
    <!-- Top Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Stat: Tổng doanh thu -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[100px] text-agent-primary">payments</span>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-md bg-agent-primary/10 flex items-center justify-center text-agent-primary">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <p class="text-agent-muted text-[14px] font-bold uppercase tracking-wide">Tổng doanh thu</p>
            </div>
            <h3 class="text-[28px] font-black text-white relative z-10 tracking-tight">125.400.000đ</h3>
        </div>

        <!-- Stat: Số dư khả dụng -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all delay-100">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[100px] text-[#10b981]">account_balance_wallet</span>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-md bg-[#10b981]/10 flex items-center justify-center text-[#10b981]">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
                <p class="text-agent-muted text-[14px] font-bold uppercase tracking-wide">Số dư khả dụng</p>
            </div>
            <h3 class="text-[28px] font-black text-white relative z-10 tracking-tight">15.250.000đ</h3>
        </div>

        <!-- Stat: Số nick đang bán -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all delay-200">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[100px] text-[#3b82f6]">storefront</span>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-md bg-[#3b82f6]/10 flex items-center justify-center text-[#3b82f6]">
                    <span class="material-symbols-outlined">storefront</span>
                </div>
                <p class="text-agent-muted text-[14px] font-bold uppercase tracking-wide">Nick đang bán</p>
            </div>
            <h3 class="text-[28px] font-black text-white relative z-10 tracking-tight">142<span class="text-[16px] text-agent-muted font-medium ml-1.5">nick</span></h3>
        </div>

        <!-- Stat: Số nick đã bán -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all delay-300">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[100px] text-[#f59e0b]">shopping_bag</span>
            </div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-md bg-[#f59e0b]/10 flex items-center justify-center text-[#f59e0b]">
                    <span class="material-symbols-outlined">shopping_bag</span>
                </div>
                <p class="text-agent-muted text-[14px] font-bold uppercase tracking-wide">Nick đã bán</p>
            </div>
            <h3 class="text-[28px] font-black text-white relative z-10 tracking-tight">856<span class="text-[16px] text-agent-muted font-medium ml-1.5">nick</span></h3>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 bg-agent-card border border-agent-border rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="font-bold text-lg text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-agent-primary">bar_chart</span>
                        Biểu đồ doanh thu
                    </h3>
                    <p class="text-agent-muted text-[13px] mt-1">Thống kê doanh thu theo tuần gần nhất</p>
                </div>
                <div class="relative">
                    <select class="appearance-none bg-[#1a1c23] border border-agent-border text-white text-[13px] font-bold rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary block pl-4 pr-10 py-2 outline-none cursor-pointer hover:bg-[#2a2d35] transition-colors">
                        <option>Tuần này</option>
                        <option>Tuần trước</option>
                        <option>Tháng này</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-agent-muted pointer-events-none text-[20px]">expand_more</span>
                </div>
            </div>
            
            <div class="relative h-[300px] w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Top Categories Table -->
        <div class="bg-agent-card border border-agent-border rounded-lg flex flex-col">
            <div class="p-6 border-b border-agent-border">
                <h3 class="font-bold text-lg text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-agent-primary">emoji_events</span>
                    Top Danh mục bán chạy
                </h3>
            </div>
            
            <div class="p-6 flex-1 overflow-y-auto custom-scrollbar">
                <div class="space-y-5">
                    <!-- Top 1 -->
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded shrink-0 bg-gradient-to-br from-[#fbbf24] to-[#d97706] text-white flex items-center justify-center font-black text-[14px] shadow-[0_0_10px_rgba(251,191,36,0.5)]">
                            1
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-bold text-[14px] truncate">Liên Minh Huyền Thoại</p>
                            <p class="text-agent-muted text-[12px] mt-0.5">342 sản phẩm</p>
                        </div>
                        <div class="text-right shrink-0 min-w-[30%]">
                            <p class="text-white font-bold text-[14px]">35.4m</p>
                            <div class="w-full bg-[#1a1c23] rounded-full h-1.5 mt-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#fbbf24] to-[#d97706] h-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top 2 -->
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded shrink-0 bg-gradient-to-br from-[#94a3b8] to-[#475569] text-white flex items-center justify-center font-black text-[14px]">
                            2
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-bold text-[14px] truncate">Liên Quân Mobile</p>
                            <p class="text-agent-muted text-[12px] mt-0.5">256 sản phẩm</p>
                        </div>
                        <div class="text-right shrink-0 min-w-[30%]">
                            <p class="text-white font-bold text-[14px]">22.1m</p>
                            <div class="w-full bg-[#1a1c23] rounded-full h-1.5 mt-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#94a3b8] to-[#475569] h-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top 3 -->
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded shrink-0 bg-gradient-to-br from-[#b45309] to-[#78350f] text-white flex items-center justify-center font-black text-[14px]">
                            3
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-bold text-[14px] truncate">Free Fire</p>
                            <p class="text-agent-muted text-[12px] mt-0.5">189 sản phẩm</p>
                        </div>
                        <div class="text-right shrink-0 min-w-[30%]">
                            <p class="text-white font-bold text-[14px]">15.8m</p>
                            <div class="w-full bg-[#1a1c23] rounded-full h-1.5 mt-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-[#b45309] to-[#78350f] h-full" style="width: 55%"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top 4 -->
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded shrink-0 bg-[#1a1c23] border border-agent-border text-agent-muted flex items-center justify-center font-black text-[14px]">
                            4
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-bold text-[14px] truncate">PUBG Mobile</p>
                            <p class="text-agent-muted text-[12px] mt-0.5">90 sản phẩm</p>
                        </div>
                        <div class="text-right shrink-0 min-w-[30%]">
                            <p class="text-white font-bold text-[14px]">8.2m</p>
                            <div class="w-full bg-[#1a1c23] rounded-full h-1.5 mt-1.5 overflow-hidden">
                                <div class="bg-agent-primary h-full" style="width: 30%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Top 5 -->
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded shrink-0 bg-[#1a1c23] border border-agent-border text-agent-muted flex items-center justify-center font-black text-[14px]">
                            5
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-white font-bold text-[14px] truncate">Valorant</p>
                            <p class="text-agent-muted text-[12px] mt-0.5">45 sản phẩm</p>
                        </div>
                        <div class="text-right shrink-0 min-w-[30%]">
                            <p class="text-white font-bold text-[14px]">5.1m</p>
                            <div class="w-full bg-[#1a1c23] rounded-full h-1.5 mt-1.5 overflow-hidden">
                                <div class="bg-agent-primary/60 h-full" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('assets/agents/js/thongkecanhan.js') }}"></script>
@endpush
