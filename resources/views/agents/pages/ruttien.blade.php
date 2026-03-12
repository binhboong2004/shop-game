@extends('agents.layouts.master')

@section('title', 'Rút Tiền Khỏi Hệ Thống')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/agents/css/ruttien.css') }}">
@endpush

@section('content')
<div class="max-w-[1400px] mx-auto space-y-6 animate-slide-up">
    <!-- Top Stats & Rules -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Balance Card -->
        <div class="lg:col-span-2 bg-gradient-to-br from-agent-primary via-[#b90610] to-[#7a0007] p-8 rounded-lg relative overflow-hidden shadow-[0_8px_32px_rgba(231,8,20,0.25)] text-white">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white/10 rounded-full blur-[60px] pointer-events-none -translate-y-1/2 translate-x-1/4"></div>
            
            <div class="relative z-10">
                <p class="text-[13px] font-bold uppercase tracking-widest text-white/90 mb-2">Số dư khả dụng</p>
                <h3 class="font-black text-[40px] tracking-wide drop-shadow-md mb-8">15.250.000 đ</h3>
                
                <div class="flex flex-wrap gap-4">
                    <div class="bg-black/20 backdrop-blur-sm border border-white/10 px-6 py-3 rounded-md">
                        <p class="text-[12px] text-white/80 font-semibold mb-1 uppercase">Chờ xử lý</p>
                        <p class="font-bold text-[18px]">1.200.000 đ</p>
                    </div>
                    <div class="bg-black/20 backdrop-blur-sm border border-white/10 px-6 py-3 rounded-md">
                        <p class="text-[12px] text-white/80 font-semibold mb-1 uppercase">Đã rút tháng này</p>
                        <p class="font-bold text-[18px]">45.000.000 đ</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rules Card -->
        <div class="bg-agent-card border border-agent-border p-8 rounded-lg">
            <h3 class="font-bold flex items-center gap-2.5 text-lg text-agent-primary mb-6">
                <span class="material-symbols-outlined rounded-md">info</span>
                Lưu ý & Quy định
            </h3>
            
            <ul class="space-y-5">
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-agent-muted text-[20px] mt-0.5">schedule</span>
                    <div>
                        <p class="text-white font-bold text-[14px] mb-0.5">Thời gian xử lý</p>
                        <p class="text-agent-muted text-[13px]">Tối đa 30 phút (trừ Lễ, Tết)</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-agent-muted text-[20px] mt-0.5">payments</span>
                    <div>
                        <p class="text-white font-bold text-[14px] mb-0.5">Hạn mức & Phí</p>
                        <p class="text-agent-muted text-[13px]">Rút tối thiểu 100k - Phí: 0đ</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-agent-muted text-[20px] mt-0.5">verified_user</span>
                    <div>
                        <p class="text-agent-muted text-[13px] leading-relaxed">Vui lòng kiểm tra kỹ thông tin tài khoản trước khi xác nhận.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Withdraw Form Section -->
    <div class="bg-agent-card border border-agent-border rounded-lg">
        <div class="p-6 border-b border-agent-border bg-[#20222a]">
            <h3 class="font-bold flex items-center gap-2.5 text-lg text-white">
                <span class="material-symbols-outlined text-agent-primary bg-agent-primary/10 p-1.5 rounded-md">account_balance</span>
                Tạo yêu cầu rút tiền
            </h3>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Left Column -->
                <div class="space-y-8 pl-2">
                    <!-- Amount Input -->
                    <div>
                        <h4 class="text-white font-bold text-[15px] mb-4">1. Số tiền muốn rút</h4>
                        <div class="relative mb-4">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-agent-muted">payments</span>
                            </div>
                            <input type="text" id="withdraw-amount" placeholder="Tối thiểu 100.000" class="w-full bg-[#1a1c23] border border-agent-border text-white text-[16px] font-bold rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary block pl-12 pr-24 py-4 outline-none transition-colors placeholder-agent-muted/50">
                            <button id="btn-withdraw-all" class="absolute inset-y-2 right-2 px-4 bg-[#2a2d35] hover:bg-agent-primary text-agent-primary hover:text-white text-[13px] font-bold rounded uppercase tracking-wider transition-all border border-[#404452] hover:border-agent-primary">Rút hết</button>
                        </div>
                        
                        <div class="grid grid-cols-4 gap-3">
                            <button class="btn-fixed-amount bg-[#1a1c23] border border-agent-border hover:border-agent-primary text-white font-bold py-2.5 rounded-md text-[13px] transition-colors" data-amount="500000">500.000</button>
                            <button class="btn-fixed-amount active bg-[#1a1c23] border border-agent-border hover:border-agent-primary text-white font-bold py-2.5 rounded-md text-[13px] transition-colors relative" data-amount="1000000">1.000.000</button>
                            <button class="btn-fixed-amount bg-[#1a1c23] border border-agent-border hover:border-agent-primary text-white font-bold py-2.5 rounded-md text-[13px] transition-colors" data-amount="5000000">5.000.000</button>
                            <button class="btn-fixed-amount bg-[#1a1c23] border border-agent-border hover:border-agent-primary text-white font-bold py-2.5 rounded-md text-[13px] transition-colors" data-amount="10000000">10.000.000</button>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <h4 class="text-white font-bold text-[15px] mb-4">2. Phương thức thanh toán</h4>
                        <div class="grid grid-cols-3 gap-4">
                            <button class="btn-payment-method active bg-[#1a1c23] border border-agent-border rounded-md p-4 flex flex-col items-center justify-center gap-2 group transition-all hover:border-[#404452]">
                                <span class="material-symbols-outlined text-agent-muted group-hover:text-white text-[28px] transition-colors">account_balance</span>
                                <span class="text-agent-muted group-hover:text-white text-[13px] font-bold transition-colors">Ngân hàng</span>
                            </button>
                            
                            <button class="btn-payment-method bg-[#1a1c23] border border-agent-border rounded-md p-4 flex flex-col items-center justify-center gap-2 group transition-all hover:border-[#404452]">
                                <span class="material-symbols-outlined text-agent-muted group-hover:text-white text-[28px] transition-colors">account_balance_wallet</span>
                                <span class="text-agent-muted group-hover:text-white text-[13px] font-bold transition-colors">Ví Momo</span>
                            </button>
                            
                            <button class="btn-payment-method bg-[#1a1c23] border border-agent-border rounded-md p-4 flex flex-col items-center justify-center gap-2 group transition-all hover:border-[#404452]">
                                <span class="material-symbols-outlined text-agent-muted group-hover:text-white text-[28px] transition-colors">phone_iphone</span>
                                <span class="text-agent-muted group-hover:text-white text-[13px] font-bold transition-colors">Viettel Money</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Beneficiary Info) -->
                <div>
                    <h4 class="text-white font-bold text-[15px] mb-4">3. Thông tin thụ hưởng</h4>
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-agent-muted text-[12px] font-bold mb-2 uppercase tracking-wide">Tên ngân hàng / ví</label>
                            <select class="appearance-none w-full bg-[#1a1c23] border border-agent-border text-white text-[15px] font-semibold rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary block pl-4 pr-10 py-3.5 outline-none cursor-pointer hover:bg-[#20222a] transition-colors">
                                <option>Vietcombank (VCB)</option>
                                <option>Techcombank (TCB)</option>
                                <option>MB Bank</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-[38px] text-agent-muted pointer-events-none text-[22px]">expand_more</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label class="block text-agent-muted text-[12px] font-bold mb-2 uppercase tracking-wide">Số tài khoản</label>
                                <input type="text" placeholder="Ví dụ: 038312xxxx" class="w-full bg-[#1a1c23] border border-agent-border text-white text-[15px] rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary block px-4 py-3.5 outline-none transition-colors placeholder-agent-muted/40 font-medium">
                            </div>
                            <div>
                                <label class="block text-agent-muted text-[12px] font-bold mb-2 uppercase tracking-wide">Chủ tài khoản</label>
                                <input type="text" placeholder="Viết hoa không dấu" class="w-full bg-[#1a1c23] border border-agent-border text-white text-[15px] rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary block px-4 py-3.5 outline-none transition-colors placeholder-agent-muted/40 uppercase font-medium">
                            </div>
                        </div>

                        <div class="pt-6">
                            <button class="w-full bg-agent-primary hover:bg-agent-hover text-white font-bold py-4 px-4 rounded-md transition-all shadow-[0_4px_16px_rgba(231,8,20,0.3)] hover:shadow-[0_6px_20px_rgba(231,8,20,0.5)] text-lg">
                                Xác nhận rút tiền
                            </button>
                            <p class="text-center text-agent-muted text-[12px] mt-4 leading-relaxed px-4">Bằng cách bấm xác nhận, bạn đồng ý với các <a href="#" class="text-agent-primary hover:underline font-semibold">điều khoản giao dịch</a> của hệ thống.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Withdrawals Table -->
    <div class="bg-agent-card border border-agent-border rounded-lg overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-agent-border bg-[#20222a]">
            <h3 class="font-bold flex items-center gap-2.5 text-lg text-white">
                <span class="material-symbols-outlined text-agent-primary">history</span>
                Yêu cầu rút tiền gần đây
            </h3>
            <a href="#" class="text-agent-primary text-[14px] font-semibold hover:text-white transition-colors">Xem tất cả</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-agent-border bg-[#1a1c23] text-agent-muted text-[12px] uppercase tracking-wider font-bold">
                        <th class="py-4 px-6 whitespace-nowrap">Mã giao dịch</th>
                        <th class="py-4 px-6 whitespace-nowrap">Thời gian</th>
                        <th class="py-4 px-6 whitespace-nowrap">Phương thức</th>
                        <th class="py-4 px-6 whitespace-nowrap">Số tiền</th>
                        <th class="py-4 px-6 whitespace-nowrap">Trạng thái</th>
                        <th class="py-4 px-6 text-right whitespace-nowrap">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-agent-border">
                    <tr class="hover:bg-[#2a2d35] transition-colors">
                        <td class="col-trans-id p-6 text-[15px] font-bold text-white">#RT129938</td>
                        <td class="p-6 text-[14px] text-agent-muted">14:20 25/10/2023</td>
                        <td class="p-6 flex items-center gap-2">
                            <span class="bg-[#005eab] text-white text-[10px] font-bold px-1.5 py-0.5 rounded">VCB</span>
                            <span class="text-[14px] font-semibold text-white">Vietcombank</span>
                        </td>
                        <td class="col-amount p-6 font-bold text-white text-[15px]">2.500.000 đ</td>
                        <td class="col-status p-6">
                            <span class="inline-block px-2.5 py-1 rounded text-[11px] font-bold bg-agent-warning/10 text-agent-warning border border-agent-warning/30 uppercase tracking-wide">Đang chờ</span>
                        </td>
                        <td class="p-6 text-right">
                            <button class="btn-view-detail text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-[#2a2d35] transition-colors">
                        <td class="col-trans-id p-6 text-[15px] font-bold text-white">#RT129912</td>
                        <td class="p-6 text-[14px] text-agent-muted">09:15 24/10/2023</td>
                        <td class="p-6 flex items-center gap-2">
                            <span class="bg-[#a50064] text-white text-[10px] font-bold px-1.5 py-0.5 rounded">MM</span>
                            <span class="text-[14px] font-semibold text-white">Ví MoMo</span>
                        </td>
                        <td class="col-amount p-6 font-bold text-white text-[15px]">500.000 đ</td>
                        <td class="col-status p-6">
                            <span class="inline-block px-2.5 py-1 rounded text-[11px] font-bold bg-[#10b981]/10 text-[#10b981] border border-[#10b981]/30 uppercase tracking-wide">Thành công</span>
                        </td>
                        <td class="p-6 text-right">
                            <button class="btn-view-detail text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                    <tr class="hover:bg-[#2a2d35] transition-colors">
                        <td class="col-trans-id p-6 text-[15px] font-bold text-white">#RT129850</td>
                        <td class="p-6 text-[14px] text-agent-muted">18:45 22/10/2023</td>
                        <td class="p-6 flex items-center gap-2">
                            <span class="bg-agent-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded">MB</span>
                            <span class="text-[14px] font-semibold text-white">MB Bank</span>
                        </td>
                        <td class="col-amount p-6 font-bold text-white text-[15px]">10.000.000 đ</td>
                        <td class="col-status p-6">
                            <span class="inline-block px-2.5 py-1 rounded text-[11px] font-bold bg-agent-primary/10 text-agent-primary border border-agent-primary/30 uppercase tracking-wide">Từ chối</span>
                        </td>
                        <td class="p-6 text-right">
                            <button class="btn-view-detail text-agent-muted hover:text-white transition-colors" title="Xem chi tiết">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Chi tiết Rút Tiền -->
<div id="withdraw-detail-modal" class="fixed inset-0 z-[100] flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm modal-backdrop opacity-0" style="transition: opacity 0.3s ease-out;"></div>
    
    <!-- Modal Content -->
    <div class="bg-agent-card border border-agent-border w-[90%] max-w-md rounded-lg shadow-[0_10px_40px_rgba(0,0,0,0.5)] relative z-10 modal-content opacity-0 scale-95 flex flex-col" style="transition: all 0.3s ease-out;">
        <div class="flex justify-between items-center p-6 border-b border-agent-border bg-[#20222a] rounded-t-lg">
            <h3 class="font-bold text-lg text-white">Chi tiết giao dịch</h3>
            <button class="text-agent-muted hover:text-white transition-colors btn-close-modal">
                <span class="material-symbols-outlined text-[24px]">close</span>
            </button>
        </div>
        
        <div class="p-6 space-y-4">
            <div class="flex justify-between items-center pb-4 border-b border-agent-border/50">
                <span class="text-agent-muted text-[14px] font-semibold uppercase tracking-wide">Mã giao dịch</span>
                <span id="modal-trans-id" class="text-white font-bold text-[15px]">...</span>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-agent-border/50">
                <span class="text-agent-muted text-[14px] font-semibold uppercase tracking-wide">Số tiền</span>
                <span id="modal-amount" class="text-agent-primary font-bold text-[18px]">...</span>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-agent-border/50">
                <span class="text-agent-muted text-[14px] font-semibold uppercase tracking-wide">Trạng thái</span>
                <div id="modal-status"></div>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-agent-border/50">
                <span class="text-agent-muted text-[14px] font-semibold uppercase tracking-wide">Người nhận</span>
                <div class="text-right">
                    <p class="text-white font-bold text-[15px]">Nguyễn Văn A</p>
                    <p class="text-agent-muted text-[12px] mt-0.5">Vietcombank</p>
                </div>
            </div>
            <div class="flex justify-between items-center pb-2">
                <span class="text-agent-muted text-[14px] font-semibold uppercase tracking-wide">Thời gian</span>
                <span class="text-white font-medium text-[14px]">14:20 25/10/2023</span>
            </div>
        </div>
        
        <div class="p-6 border-t border-agent-border bg-[#1a1c23] rounded-b-lg flex justify-end">
            <button class="bg-[#2a2d35] hover:bg-agent-primary text-white font-bold py-2.5 px-6 rounded-md transition-all border border-agent-border hover:border-agent-primary btn-close-modal shadow-sm">
                Đóng
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/agents/js/ruttien.js') }}"></script>
@endpush
