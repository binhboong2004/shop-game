<!-- Admin Header -->
<header class="bg-[#1a1c23] border-b border-[#2a2d35] h-[88px] flex items-center justify-between px-4 md:px-6 lg:px-8 z-30 sticky top-0 shadow-[0_4px_24px_rgba(0,0,0,0.2)]">
    <!-- Left side: Mobile Toggle & Search -->
    <div class="flex items-center gap-4 flex-1">
        <button id="sidebar-toggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-md bg-[#20222a] border border-[#2a2d35] text-gray-400 hover:text-white transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <div class="hidden md:flex relative max-w-md w-full">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-[20px]">search</span>
            <input type="text" placeholder="Tìm ID giao dịch, Mã nick, Email người dùng..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-lg pl-10 pr-4 py-2.5 focus:outline-none focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-all placeholder-gray-600">
            <!-- Mac hotkey hint -->
            <div class="absolute right-3 top-1/2 -translate-y-1/2 flex gap-1">
                <kbd class="hidden xl:inline-block bg-[#20222a] border border-[#2a2d35] text-gray-500 text-xs px-1.5 py-0.5 rounded">⌘</kbd>
                <kbd class="hidden xl:inline-block bg-[#20222a] border border-[#2a2d35] text-gray-500 text-xs px-1.5 py-0.5 rounded">K</kbd>
            </div>
        </div>
    </div>

    <!-- Right side: Notifications & Profile -->
    <div class="flex items-center gap-3 sm:gap-5">
        
        <!-- Notifications -->
        <div class="relative">
            <button class="w-10 h-10 flex items-center justify-center rounded-full bg-[#20222a] border border-[#2a2d35] text-gray-400 hover:text-white hover:bg-[#2a2d35] transition-all relative">
                <span class="material-symbols-outlined text-[22px]">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-[#E70814] rounded-full shadow-[0_0_6px_#E70814]"></span>
            </button>
        </div>

        <!-- Divider -->
        <div class="w-px h-8 bg-[#2a2d35] hidden sm:block"></div>

        <!-- User Profile Dropdown -->
        <div class="relative group cursor-pointer">
            <div class="flex items-center gap-3">
                <div class="hidden md:block text-right">
                    <p class="text-sm font-bold text-white leading-tight">Vũ Duy Bình</p>
                    <p class="text-xs text-[#E70814] font-medium">Admin</p>
                </div>
                <div class="relative">
                    <img src="https://placehold.co/100x100/1a0f0f/e70814?text=AD" alt="Avatar" class="w-10 h-10 rounded-full border border-[#2a2d35] group-hover:border-[#E70814] transition-colors object-cover ring-2 ring-transparent group-hover:ring-[#E70814]/20">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[#1a1c23] rounded-full"></span>
                </div>
                <span class="material-symbols-outlined text-gray-400 group-hover:text-white transition-colors hidden sm:block">expand_more</span>
            </div>
            
            <!-- Dropdown Menu -->
            <div class="absolute right-0 top-full mt-2 w-48 bg-[#1a1c23] border border-[#2a2d35] shadow-2xl rounded-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right group-hover:translate-y-0 translate-y-2 z-50">
                <div class="px-4 py-2 border-b border-[#2a2d35] mb-2 md:hidden">
                    <p class="text-sm font-bold text-white">Admin System</p>
                    <p class="text-xs text-[#E70814]">Admin</p>
                </div>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#20222a] transition-colors">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                    Hồ sơ cá nhân
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-300 hover:text-white hover:bg-[#20222a] transition-colors">
                    <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                    Cài đặt tài khoản
                </a>
                <div class="h-px bg-[#2a2d35] my-2"></div>
                <!-- Dùng form post cho bảo mật thật sự, ở đây mock up -->
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-[#E70814] hover:bg-red-500/10 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    Đăng xuất
                </a>
            </div>
        </div>

    </div>
</header>
