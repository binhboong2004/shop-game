@extends('agents.layouts.master')

@section('title', 'Bảng Điều Khiển Đại Lý')

@section('content')
<div class="max-w-[1400px] mx-auto space-y-8 animate-slide-up">
    <!-- Welcome -->
    <div>
        <h1 class="text-[28px] font-bold mb-1.5 text-white">Chào mừng trở lại, Agent888! 👋</h1>
        <p class="text-agent-muted text-[15px]">Dưới đây là báo cáo hiệu suất kinh doanh của bạn trong tháng này.</p>
    </div>

    <!-- Stats grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat 1 -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[120px] text-agent-primary">account_balance_wallet</span>
            </div>
            <p class="text-agent-muted text-[15px] font-medium mb-2.5 relative z-10">Số dư khả dụng</p>
            <h3 class="text-[32px] font-bold mb-3.5 text-white relative z-10 tracking-tight">25.500.000đ</h3>
            <p class="text-agent-success text-sm flex items-center gap-1.5 font-semibold relative z-10">
                <span class="material-symbols-outlined text-[18px]">trending_up</span>
                +12.5% so với tháng trước
            </p>
        </div>

        <!-- Stat 2 -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all delay-100">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[120px] text-agent-primary">sports_esports</span>
            </div>
            <p class="text-agent-muted text-[15px] font-medium mb-2.5 relative z-10">Nick đang bán</p>
            <h3 class="text-[32px] font-bold mb-3.5 text-white relative z-10 tracking-tight">142 Nick</h3>
            <p class="text-agent-primary text-sm flex items-center gap-1.5 font-semibold relative z-10">
                <span class="material-symbols-outlined text-[18px]">new_releases</span>
                8 nick mới hôm nay
            </p>
        </div>

        <!-- Stat 3 -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg relative overflow-hidden group hover:border-[#404452] hover:bg-[#2a2d35] transition-all delay-200">
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity">
                <span class="material-symbols-outlined text-[120px] text-agent-primary">payments</span>
            </div>
            <p class="text-agent-muted text-[15px] font-medium mb-2.5 relative z-10">Doanh thu tháng này</p>
            <h3 class="text-[32px] font-bold mb-3.5 text-white relative z-10 tracking-tight">8.200.000đ</h3>
            <p class="text-agent-success text-sm flex items-center gap-1.5 font-semibold relative z-10">
                <span class="material-symbols-outlined text-[18px]">trending_up</span>
                +15.2% mục tiêu đề ra
            </p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-agent-card border border-agent-border rounded-lg overflow-hidden delay-300">
        <div class="flex items-center justify-between p-6 border-b border-agent-border bg-[#20222a]">
            <h3 class="font-bold flex items-center gap-2.5 text-lg text-white">
                <span class="material-symbols-outlined text-agent-primary bg-agent-primary/10 p-1.5 rounded-md">list_alt</span>
                Danh sách nick vừa đăng
            </h3>
            <a href="#" class="text-agent-primary text-[15px] font-semibold hover:text-white transition-colors">Xem tất cả</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-agent-border bg-[#1a1c23] text-agent-muted text-[13px] uppercase tracking-wider font-semibold">
                        <th class="py-5 px-6">Thông tin nick</th>
                        <th class="py-5 px-6">Mã số</th>
                        <th class="py-5 px-6">Ngày đăng</th>
                        <th class="py-5 px-6">Giá bán</th>
                        <th class="py-5 px-6">Trạng thái</th>
                        <th class="py-5 px-6 text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-agent-border">
                    <tr class="hover:bg-[#2a2d35] transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-md bg-[#2a1617] border border-[#404452] p-2 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-3xl opacity-50">sports_esports</span>
                                </div>
                                <div>
                                    <p class="font-bold text-[15px] text-white group-hover:text-agent-primary transition-colors">Rank Cao Thủ - 120 Skin</p>
                                    <p class="text-agent-muted text-[13px] mt-1 font-medium">Liên Minh Huyền Thoại</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-[15px] font-bold text-white tracking-wide">#LMHT-8892</td>
                        <td class="p-6 text-[14px] text-agent-muted font-medium">14:20,<br>24/05</td>
                        <td class="p-6 font-bold text-agent-primary text-[15px]">1.250.000đ</td>
                        <td class="p-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[13px] font-bold bg-[#10b981]/10 text-[#10b981] border border-[#10b981]/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981] shadow-[0_0_8px_#10b981]"></span>
                                Đã duyệt
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-agent-muted hover:text-white bg-[#1a1c23] rounded-md hover:bg-agent-primary transition-colors border border-agent-border hover:border-agent-primary" title="Chỉnh sửa">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button class="p-2 text-agent-muted hover:text-white bg-[#1a1c23] rounded-md hover:bg-agent-primary transition-colors border border-agent-border hover:border-agent-primary" title="Xem chi tiết">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-md bg-[#2a1617] border border-[#404452] p-2 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-3xl opacity-50">sports_esports</span>
                                </div>
                                <div>
                                    <p class="font-bold text-[15px] text-white group-hover:text-agent-primary transition-colors">Full Skin Súng - Level 70</p>
                                    <p class="text-agent-muted text-[13px] mt-1 font-medium">PUBG Mobile</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-[15px] font-bold text-white tracking-wide">#PUBG-1102</td>
                        <td class="p-6 text-[14px] text-agent-muted font-medium">12:05,<br>24/05</td>
                        <td class="p-6 font-bold text-agent-primary text-[15px]">850.000đ</td>
                        <td class="p-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[13px] font-bold bg-agent-warning/10 text-agent-warning border border-agent-warning/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-agent-warning shadow-[0_0_8px_#f59e0b]"></span>
                                Chờ duyệt
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-agent-muted hover:text-white bg-[#1a1c23] rounded-md hover:bg-agent-primary transition-colors border border-agent-border hover:border-agent-primary" title="Chỉnh sửa">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button class="p-2 text-agent-muted hover:text-white bg-[#1a1c23] rounded-md hover:bg-agent-primary transition-colors border border-agent-border hover:border-agent-primary" title="Xem chi tiết">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 3 -->
                    <tr class="hover:bg-[#2a2d35] transition-colors group">
                        <td class="p-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-md bg-[#2a1617] border border-[#404452] p-2 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white text-3xl opacity-50">sports_esports</span>
                                </div>
                                <div>
                                    <p class="font-bold text-[15px] text-white group-hover:text-agent-primary transition-colors">Nick Trắng Thông Tin - Radiant</p>
                                    <p class="text-agent-muted text-[13px] mt-1 font-medium">Valorant</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-[15px] font-bold text-white tracking-wide">#VAL-5562</td>
                        <td class="p-6 text-[14px] text-agent-muted font-medium">09:45,<br>24/05</td>
                        <td class="p-6 font-bold text-agent-primary text-[15px]">2.100.000đ</td>
                        <td class="p-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-[13px] font-bold bg-agent-warning/10 text-agent-warning border border-agent-warning/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-agent-warning shadow-[0_0_8px_#f59e0b]"></span>
                                Chờ duyệt
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="p-2 text-agent-muted hover:text-white bg-[#1a1c23] rounded-md hover:bg-agent-primary transition-colors border border-agent-border hover:border-agent-primary" title="Chỉnh sửa">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button class="p-2 text-agent-muted hover:text-white bg-[#1a1c23] rounded-md hover:bg-agent-primary transition-colors border border-agent-border hover:border-agent-primary" title="Xem chi tiết">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom Widgets -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-8">
        <!-- Chart mockup -->
        <div class="bg-agent-card border border-agent-border p-6 rounded-lg flex flex-col h-[320px]">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-bold text-lg text-white">Thống kê giao dịch</h3>
                <div class="relative">
                    <select class="appearance-none bg-[#2a1617] border border-[#404452] text-white text-sm font-medium rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary block pl-4 pr-10 py-2 outline-none cursor-pointer hover:bg-[#321a1b] transition-colors">
                        <option>7 ngày qua</option>
                        <option>30 ngày qua</option>
                        <option>Tháng này</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-agent-muted pointer-events-none text-[20px]">expand_more</span>
                </div>
            </div>
            <!-- Mock Bar Chart -->
            <div class="flex-1 flex items-end justify-between gap-3 pt-4">
                <div class="w-full bg-[#404452] rounded-t-sm h-[40%] hover:bg-agent-primary/60 transition-colors cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#1a1c23] text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-agent-border">T2: 1.2M</div>
                </div>
                <div class="w-full bg-[#404452] rounded-t-sm h-[65%] hover:bg-agent-primary/60 transition-colors cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#1a1c23] text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-agent-border">T3: 2.5M</div>
                </div>
                <div class="w-full bg-[#404452] rounded-t-sm h-[45%] hover:bg-agent-primary/60 transition-colors cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#1a1c23] text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-agent-border">T4: 1.5M</div>
                </div>
                <div class="w-full bg-agent-primary rounded-t-sm h-[90%] shadow-[0_0_20px_rgba(231,8,20,0.5)] cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-agent-primary text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap font-bold">Hôm nay: 3.8M</div>
                </div>
                <div class="w-full bg-[#404452] rounded-t-sm h-[35%] hover:bg-agent-primary/60 transition-colors cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#1a1c23] text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-agent-border">T6: 1.1M</div>
                </div>
                <div class="w-full bg-[#404452] rounded-t-sm h-[55%] hover:bg-agent-primary/60 transition-colors cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#1a1c23] text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-agent-border">T7: 2.1M</div>
                </div>
                <div class="w-full bg-[#404452] rounded-t-sm h-[25%] hover:bg-agent-primary/60 transition-colors cursor-pointer relative group">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-[#1a1c23] text-white text-xs py-1 px-2 rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap border border-agent-border">CN: 800k</div>
                </div>
            </div>
        </div>

        <!-- Target widget -->
        <div class="bg-gradient-to-br from-agent-primary via-[#b90610] to-[#7a0007] border border-agent-primary/40 p-8 rounded-lg flex flex-col justify-between relative overflow-hidden text-white shadow-[0_8px_32px_rgba(231,8,20,0.25)] h-[320px]">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-[60px] pointer-events-none -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute left-0 bottom-0 w-48 h-48 bg-black/20 rounded-full blur-[40px] pointer-events-none translate-y-1/2 -translate-x-1/4"></div>
            
            <div class="relative z-10">
                <h3 class="font-black text-[28px] mb-3 tracking-wide text-white drop-shadow-md">Trở thành Đại lý TOP 1</h3>
                <p class="text-white/90 text-[15px] leading-relaxed max-w-[85%] font-medium">Tiếp tục đăng thêm <span class="font-bold text-white bg-black/20 px-1.5 py-0.5 rounded-sm">15 nick chất lượng</span> để đạt mốc thưởng tháng 2.000.000đ.</p>
            </div>
            
            <div class="relative z-10 mt-8">
                <div class="flex justify-between items-end mb-3 text-white">
                    <span class="text-[13px] font-bold uppercase tracking-widest text-white/80">Tiến trình mục tiêu</span>
                    <span class="text-3xl font-black drop-shadow-md">85%</span>
                </div>
                <div class="w-full bg-black/40 rounded-full h-4 backdrop-blur-sm p-0.5 shadow-inner">
                    <div class="bg-gradient-to-r from-white/80 to-white h-full rounded-full w-[85%] shadow-[0_0_15px_rgba(255,255,255,0.8)] relative">
                        <div class="absolute right-0 top-1/2 -translate-y-1/2 w-5 h-5 bg-white rounded-full shadow-[0_0_12px_rgba(255,255,255,1)] flex items-center justify-center">
                            <div class="w-2 h-2 bg-agent-primary rounded-full"></div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between mt-3 text-xs font-semibold text-white/70">
                    <span>0đ</span>
                    <span>2.000.000đ</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
