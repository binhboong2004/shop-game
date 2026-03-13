<!-- Admin Sidebar -->
<aside id="admin-sidebar" class="admin-sidebar fixed inset-y-0 left-0 w-[280px] bg-[#1a1c23] shadow-[4px_0_24px_rgba(0,0,0,0.4)] border-r z-50 border-[#2a2d35] flex flex-col h-full lg:static lg:transform-none">
    
    <!-- Logo area -->
    <div class="h-[88px] flex items-center justify-between px-6 border-b border-[#2a2d35] shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-11 h-11 bg-[#E70814] rounded-md flex items-center justify-center text-white border border-red-500/30 shadow-[0_4px_12px_rgba(231,8,20,0.3)]">
                <span class="material-symbols-outlined text-[24px]">shield_person</span>
            </div>
            <div>
                <h1 class="font-bold text-[17px] leading-tight text-white">Quản trị viên</h1>
                <p class="text-[#E70814] text-[13px] font-bold tracking-wide uppercase mt-0.5">ID: AGENT888</p>
            </div>
        </div>
        <!-- Close button mobile -->
        <button id="sidebar-close" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-md text-gray-400 hover:text-white hover:bg-[#2a2d35] transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 py-6 px-4 space-y-1.5 overflow-y-auto admin-scrollbar">
        <!-- 1. Tổng quan -->
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">Hệ Thống</p>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-md transition-all font-medium group {{ request()->routeIs('admin.dashboard') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }}">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">dashboard</span>
                Tổng quan
            </a>
        </div>

        <!-- 2. Quản lý Tài khoản (Dropdown) -->
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">Tài khoản</p>
            <div>
                @php
                    $isAccountActive = request()->routeIs('admin.taikhoandaily') || request()->routeIs('admin.taikhoanthanhvien') || request()->routeIs('admin.taikhoanadmin');
                @endphp
                <button type="button" class="w-full flex items-center justify-between px-4 py-3 {{ $isAccountActive ? 'text-white bg-[#20222a]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group" data-toggle="dropdown" data-target="user-menu">
                    <div class="flex items-center gap-3.5">
                        <span class="material-symbols-outlined text-[22px] {{ $isAccountActive ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">groups</span>
                        Quản lý Người dùng
                    </div>
                    <span class="material-symbols-outlined text-[20px] transition-transform duration-200 {{ $isAccountActive ? 'rotate-180' : '' }}">expand_more</span>
                </button>
                <div id="user-menu" class="{{ $isAccountActive ? 'block' : 'hidden' }} mt-1 bg-[#13131A] rounded-md border border-[#2a2d35] overflow-hidden dropdown-menu">
                    <a href="{{ route('admin.taikhoanadmin') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.taikhoanadmin') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Tài khoản Admin</a>
                    <a href="{{ route('admin.taikhoandaily') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.taikhoandaily') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Tài khoản Đại lý</a>
                    <a href="{{ route('admin.taikhoanthanhvien') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.taikhoanthanhvien') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Tài khoản Thành viên</a>
                </div>
            </div>
        </div>

        <!-- 3. Quản lý Sản phẩm (Dropdown) -->
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">Sản phẩm & Game</p>
            <div>
                @php
                    $isProductActive = request()->routeIs('admin.quanlydanhmuc') || request()->routeIs('admin.quanlydanhmuccon') || request()->routeIs('admin.cauhinhthuoctinh') || request()->routeIs('admin.danhsachnick') || request()->routeIs('admin.kiemduyetnick');
                @endphp
                <button type="button" class="w-full flex items-center justify-between px-4 py-3 {{ $isProductActive ? 'text-white bg-[#20222a]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group" data-toggle="dropdown" data-target="product-menu">
                    <div class="flex items-center gap-3.5">
                        <!-- Notification badge if needed -->
                        <div class="relative">
                            <span class="material-symbols-outlined text-[22px] {{ $isProductActive ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">inventory_2</span>
                            @if(isset($pendingAccountsCount) && $pendingAccountsCount > 0)
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-yellow-500 rounded-full border border-[#1a1c23]"></span>
                            @endif
                        </div>
                        Kho Nick Hệ Thống
                    </div>
                    <span class="material-symbols-outlined text-[20px] transition-transform duration-200 {{ $isProductActive ? 'rotate-180' : '' }}">expand_more</span>
                </button>
                <div id="product-menu" class="{{ $isProductActive ? 'block' : 'hidden' }} mt-1 bg-[#13131A] rounded-md border border-[#2a2d35] overflow-hidden dropdown-menu">
                    <a href="{{ route('admin.kiemduyetnick') }}" class="flex items-center justify-between px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.kiemduyetnick') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">
                        Kiểm duyệt Nick Đại lý
                        @if(isset($pendingAccountsCount) && $pendingAccountsCount > 0)
                        <span class="bg-yellow-500/10 text-yellow-500 text-[10px] px-1.5 py-0.5 rounded font-bold">{{ $pendingAccountsCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.danhsachnick') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.danhsachnick') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Danh sách Nick có sẵn</a>
                    <a href="{{ route('admin.quanlydanhmuc') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.quanlydanhmuc') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Quản lý Danh mục Game</a>
                    <a href="{{ route('admin.quanlydanhmuccon') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.quanlydanhmuccon') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Quản lý Danh mục con</a>
                    <a href="{{ route('admin.cauhinhthuoctinh') }}" class="block px-12 py-2.5 text-sm font-medium {{ request()->routeIs('admin.cauhinhthuoctinh') ? 'text-white bg-[#20222a] border-l-2 border-[#E70814]' : 'text-gray-400 hover:text-white hover:bg-[#20222a] border-l-2 border-transparent' }} transition-colors">Cấu hình Thuộc tính</a>
                </div>
            </div>
        </div>

        <!-- 4. Tài chính -->
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">Tài Chính</p>
            
            <a href="{{ route('admin.quanlynaptien') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.quanlynaptien') ? 'text-white bg-[#E70814] shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group mb-1">
                <div class="flex items-center gap-3.5">
                    <div class="relative">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.quanlynaptien') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">account_balance_wallet</span>
                        @if(isset($pendingDepositsCount) && $pendingDepositsCount > 0)
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border border-[#1a1c23]"></span>
                        @endif
                    </div>
                    Quản lý Nạp Tiền
                </div>
                @if(isset($pendingDepositsCount) && $pendingDepositsCount > 0)
                <span class="bg-red-500/10 text-red-500 text-[10px] px-1.5 py-0.5 rounded font-bold border border-red-500/20">{{ $pendingDepositsCount }} Mới</span>
                @endif
            </a>
            
            <a href="{{ route('admin.kiemduyetruttien') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.kiemduyetruttien') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group mb-1">
                <div class="flex items-center gap-3.5">
                    <div class="relative">
                        <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.kiemduyetruttien') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">payments</span>
                        @if(isset($pendingWithdrawalsCount) && $pendingWithdrawalsCount > 0)
                        <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full border border-[#1a1c23]"></span>
                        @endif
                    </div>
                    Kiểm duyệt Rút Tiền
                </div>
                @if(isset($pendingWithdrawalsCount) && $pendingWithdrawalsCount > 0)
                <span class="bg-red-500/10 text-red-500 text-[10px] px-1.5 py-0.5 rounded font-bold border border-red-500/20">{{ $pendingWithdrawalsCount }} Mới</span>
                @endif
            </a>

            <a href="{{ route('admin.lichsubanhang') }}" class="flex items-center gap-3.5 px-4 py-3 {{ request()->routeIs('admin.lichsubanhang') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.lichsubanhang') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">receipt_long</span>
                Lịch sử Bán hàng
            </a>
        </div>

        <!-- 5. Khuyến Mãi -->
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">Marketing</p>
            <a href="{{ route('admin.magiamgia') }}" class="flex items-center gap-3.5 px-4 py-3 {{ request()->routeIs('admin.magiamgia') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group mb-1">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.magiamgia') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">local_activity</span>
                Mã Giảm Giá
            </a>
            <a href="{{ route('admin.vongquaymayman') }}" class="flex items-center gap-3.5 px-4 py-3 {{ request()->routeIs('admin.vongquaymayman') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.vongquaymayman') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">casino</span>
                Vòng Quay May Mắn
            </a>
        </div>

        <!-- 6. Cấu hình -->
        <div class="mb-4">
            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest px-4 mb-2">CMS & Cài Đặt</p>
            <a href="{{ route('admin.tintucsukien') }}" class="flex items-center gap-3.5 px-4 py-3 {{ request()->routeIs('admin.tintucsukien') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group mb-1">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.tintucsukien') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">newspaper</span>
                Tin tức & Sự kiện
            </a>
            <a href="{{ route('admin.hotrophongve') }}" class="flex items-center justify-between px-4 py-3 {{ request()->routeIs('admin.hotrophongve') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group mb-1">
                <div class="flex items-center gap-3.5">
                    <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.hotrophongve') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">support_agent</span>
                    Hỗ trợ Phòng vé
                </div>
            </a>
            <a href="{{ route('admin.cauhinhchung') }}" class="flex items-center gap-3.5 px-4 py-3 {{ request()->routeIs('admin.cauhinhchung') ? 'bg-[#E70814] text-white shadow-[0_4px_12px_rgba(231,8,20,0.25)]' : 'text-gray-400 hover:text-white hover:bg-[#20222a]' }} rounded-md transition-all font-medium group">
                <span class="material-symbols-outlined text-[22px] {{ request()->routeIs('admin.cauhinhchung') ? 'text-white' : 'text-gray-400 group-hover:text-white transition-colors' }}">settings</span>
                Cấu hình Chung
            </a>
        </div>

    </nav>

    <!-- Bottom Action -->
    <div class="p-4 border-t border-[#2a2d35] bg-[#1a1c23] shrink-0">
        <a href="{{ url('/') }}" target="_blank" class="w-full bg-[#20222a] hover:bg-[#2a2d35] text-white font-medium py-2.5 px-4 rounded-md transition-all flex justify-center items-center gap-2 border border-[#2a2d35]">
            <span class="material-symbols-outlined text-[18px]">public</span>
            Xem Website chính
        </a>
    </div>
</aside>
