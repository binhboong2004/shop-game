<aside class="w-[280px] bg-agent-sidebar shadow-[4px_0_24px_rgba(0,0,0,0.4)] border-r z-40 border-agent-border flex flex-col h-full hidden lg:flex">
    <!-- Logo area -->
    <div class="h-[88px] flex items-center px-6 border-b border-agent-border shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-agent-primary rounded-md flex items-center justify-center text-white border border-red-500/30 shadow-[0_4px_12px_rgba(231,8,20,0.3)]">
                <span class="material-symbols-outlined text-[24px]">verified_user</span>
            </div>
            <div>
                <h1 class="font-bold text-[17px] leading-tight text-white">Đại lý</h1>
                <p class="text-agent-primary text-[13px] font-bold tracking-wide uppercase mt-0.5">ID: AGENT888</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-6 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
        <a href="{{ route('agent.dashboard') ?? '#' }}" class="flex items-center gap-3.5 px-4 py-3 bg-agent-primary text-white rounded-md transition-all font-semibold shadow-[0_4px_12px_rgba(231,8,20,0.25)]">
            <span class="material-symbols-outlined text-[22px]">grid_view</span>
            Tổng quan
        </a>
        <a href="{{ route('agent.dangnickmoi') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-md transition-all font-medium group {{ request()->routeIs('agent.dangnickmoi') ? 'bg-agent-primary/10 text-agent-primary font-bold shadow-inner' : 'text-agent-muted hover:text-white hover:bg-agent-card' }}">
            <span class="material-symbols-outlined text-[22px] transition-colors {{ request()->routeIs('agent.dangnickmoi') ? 'text-agent-primary' : 'text-agent-muted group-hover:text-white' }}">add_box</span>
            Đăng Nick Mới
        </a>
        <a href="{{ route('agent.khonickcuatoi') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-md transition-all font-medium group {{ request()->routeIs('agent.khonickcuatoi') ? 'bg-agent-primary/10 text-agent-primary font-bold shadow-inner' : 'text-agent-muted hover:text-white hover:bg-agent-card' }}">
            <span class="material-symbols-outlined text-[22px] transition-colors {{ request()->routeIs('agent.khonickcuatoi') ? 'text-agent-primary' : 'text-agent-muted group-hover:text-white' }}">inventory_2</span>
            Kho Nick Của Tôi
        </a>
        <a href="{{ route('agent.lichsuruttien') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-md transition-all font-medium group {{ request()->routeIs('agent.lichsuruttien') ? 'bg-agent-primary/10 text-agent-primary font-bold shadow-inner' : 'text-agent-muted hover:text-white hover:bg-agent-card' }}">
            <span class="material-symbols-outlined text-[22px] transition-colors {{ request()->routeIs('agent.lichsuruttien') ? 'text-agent-primary' : 'text-agent-muted group-hover:text-white' }}">history</span>
            Lịch sử Rút tiền
        </a>
        <!-- Thống kê cá nhân -->
        <a href="{{ route('agent.thongke') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-md transition-all font-medium group {{ request()->routeIs('agent.thongke') ? 'bg-agent-primary/10 text-agent-primary font-bold shadow-inner' : 'text-agent-muted hover:text-white hover:bg-agent-card' }}">
            <span class="material-symbols-outlined text-[22px] transition-colors {{ request()->routeIs('agent.thongke') ? 'text-agent-primary' : 'text-agent-muted group-hover:text-white' }}">bar_chart</span>
            Thống kê cá nhân
        </a>
    </nav>

    <!-- Bottom area -->
    <div class="p-6 border-t border-agent-border bg-agent-sidebar/50 shrink-0">
        <div class="bg-[#2a2d35] rounded-md p-5 mb-4 border border-[#404452]">
            <p class="text-agent-muted text-[13px] mb-1 font-medium">Hỗ trợ 24/7</p>
            <p class="text-agent-primary font-bold text-base">Hotline: 0889 639 655</p>
        </div>
        <a href="{{ route('agent.ruttien') }}" class="w-full bg-agent-primary hover:bg-agent-hover text-white font-bold py-3 px-4 rounded-md transition-all flex justify-center items-center gap-2 shadow-[0_4px_12px_rgba(231,8,20,0.25)] hover:shadow-[0_6px_16px_rgba(231,8,20,0.4)] mb-3">
            <span class="material-symbols-outlined text-[20px]">payments</span>
            Rút tiền mặt
        </a>
        <a href="{{ url('/') }}" target="_blank" class="w-full bg-[#20222a] hover:bg-agent-card text-white font-medium py-3 px-4 rounded-md transition-all flex justify-center items-center gap-2 border border-agent-border">
            <span class="material-symbols-outlined text-[20px]">public</span>
            Xem Website chính
        </a>
    </div>
</aside>
