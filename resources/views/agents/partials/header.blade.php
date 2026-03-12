<header class="h-[88px] bg-[#1a1c23]/95 backdrop-blur-xl border-b border-agent-border flex items-center justify-between px-8 sticky top-0 z-30 shrink-0">
    <div class="flex items-center gap-4">
        <button class="lg:hidden text-white hover:text-agent-primary transition-colors">
            <span class="material-symbols-outlined text-3xl">menu</span>
        </button>
        <h2 class="text-[22px] font-bold text-white tracking-wide">@yield('title')</h2>
    </div>

    <div class="flex items-center gap-8">
        <!-- Search -->
        <div class="relative hidden sm:block">
            <input type="text" placeholder="Tìm kiếm nick, mã số..." class="bg-[#2a2d35] border border-[#404452] py-2.5 pl-11 pr-4 rounded-md focus:outline-none focus:border-agent-primary focus:ring-1 focus:ring-agent-primary focus:bg-[#2a1617] text-[14px] w-[300px] text-white placeholder-agent-muted transition-all shadow-inner">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-agent-muted text-[20px]">search</span>
        </div>

        <!-- Notification -->
        <button class="relative text-agent-muted hover:text-white transition-colors p-2 rounded-md hover:bg-agent-card">
            <span class="material-symbols-outlined text-[26px]">notifications</span>
            <span class="absolute top-2 right-2 w-3 h-3 bg-agent-primary border-2 border-[#1a1c23] rounded-full"></span>
        </button>

        <!-- Profile -->
        <div class="flex items-center gap-4 pl-8 border-l border-agent-border cursor-pointer group">
            <div class="text-right hidden sm:block">
                <p class="font-bold text-[15px] text-white group-hover:text-agent-primary transition-colors">Vũ Duy Bình</p>
                <p class="text-agent-muted text-[13px] font-medium mt-0.5">Đại lý</p>
            </div>
            <div class="relative">
                <img src="https://i.pravatar.cc/150?img=11" alt="Avatar" class="w-12 h-12 rounded-full border-2 border-agent-primary/50 object-cover p-0.5 group-hover:border-agent-primary transition-colors">
                <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-agent-success border-2 border-[#1a1c23] rounded-full"></div>
            </div>
        </div>
    </div>
</header>
