        <!-- Header -->
        <header
            class="flex items-center justify-between whitespace-nowrap border-b border-solid border-primary/20 px-6 py-3 bg-background-light dark:bg-background-dark sticky top-0 z-50">
            <div class="flex items-center gap-8">
                <div class="flex items-center gap-3 text-primary">
                    <a class="flex items-center gap-3 text-primary" href="{{ url('/') }}">
                        <span class="material-symbols-outlined text-3xl">sports_esports</span>
                        <h2 class="text-xl font-bold leading-tight tracking-tight">SHOPNICKVN</h2>
                    </a>
                </div>
                <nav class="hidden lg:flex items-center gap-6">
                    <a class="text-sm font-bold hover:text-primary transition-colors" href="{{ url('/') }}">Trang chủ</a>

                    <!-- Mega Menu Sản Phẩm -->
                    <div class="group relative flex items-center h-full">
                        <a class="text-sm font-medium hover:text-primary transition-colors flex items-center gap-1 py-4"
                            href="#">
                            Sản phẩm
                            <span class="material-symbols-outlined text-xs">keyboard_arrow_down</span>
                        </a>

                        <!-- Mega Menu Panel -->
                        <div
                            class="absolute top-full left-0 w-[800px] bg-background-dark border border-primary/10 rounded-b-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 translate-y-2 transition-all duration-300 z-[100] p-6">
                            <div class="grid grid-cols-4 gap-8">
                                @foreach($games as $game)
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-2 border-b border-primary/10 pb-2">
                                        <img src="{{ $game->image }}"
                                            class="size-6 object-contain" alt="{{ $game->name }}">
                                        <span class="font-bold text-sm text-primary uppercase">{{ $game->name }}</span>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        @foreach($game->gameCategories as $category)
                                        <a href="{{ url('sanpham') }}?category={{ $category->slug }}"
                                            class="text-sm text-slate-400 hover:text-white flex items-center gap-2 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">sell</span> {{ $category->name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ url('magiamgia') }}">Mã giảm
                        giá</a>

                    <!-- Mega Menu Vòng Quay May Mắn-->
                    <div class="group relative flex items-center h-full">
                        <a class="text-sm font-medium hover:text-primary transition-colors flex items-center gap-1 py-4"
                            href="#">
                            Vòng quay may mắn
                            <span class="material-symbols-outlined text-xs">keyboard_arrow_down</span>
                        </a>

                        <!-- Mega Menu Panel -->
                        <div
                            class="absolute top-full left-0 w-[800px] bg-background-dark border border-primary/10 rounded-b-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 translate-y-2 transition-all duration-300 z-[100] p-6">
                            <div class="grid grid-cols-4 gap-8">
                                @foreach($games as $game)
                                @if($game->luckyWheels->count() > 0)
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-2 border-b border-primary/10 pb-2">
                                        <img src="{{ $game->image }}"
                                            class="size-6 object-contain" alt="{{ $game->name }}">
                                        <span class="font-bold text-sm text-primary uppercase">{{ $game->name }}</span>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        @foreach($game->luckyWheels as $wheel)
                                        <a href="{{ url('vongquay/' . $wheel->id) }}"
                                            class="text-sm text-slate-400 hover:text-white flex flex-col gap-1 transition-colors">
                                            <span class="text-slate-300 flex items-center gap-1 group/wheel">
                                                <span class="material-symbols-outlined text-[16px] text-primary transition-transform group-hover/wheel:rotate-180">casino</span>
                                                <span class="line-clamp-1">{{ $wheel->name }}</span>
                                            </span>
                                            <span class="text-primary font-bold text-xs pl-5">{{ number_format($wheel->price) }}đ / lượt</span>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Mega Menu Nạp Thẻ-->
                    <div class="group relative flex items-center h-full">
                        <a class="text-sm font-medium hover:text-primary transition-colors flex items-center gap-1 py-4"
                            href="#">
                            Nạp thẻ
                            <span class="material-symbols-outlined text-xs">keyboard_arrow_down</span>
                        </a>

                        <!-- Mega Menu Panel -->
                        <div
                            class="absolute top-full left-0 w-[200px] bg-background-dark border border-primary/10 rounded-b-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 translate-y-2 transition-all duration-300 z-[100] p-6">
                            <div class="grid grid-cols-4 gap-8">
                                <!-- Column 1: Thẻ Cào -->
                                <div class="flex flex-col gap-4">
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ url('napthecao') }}"
                                            class="text-sm text-slate-400 hover:text-white flex items-center gap-2 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">credit_card</span> Thẻ
                                            cào
                                        </a>
                                        <a href="{{ url('napnganhang') }}"
                                            class="text-sm text-slate-400 hover:text-white flex items-center gap-2 transition-colors">
                                            <span class="material-symbols-outlined text-[18px]">account_balance</span>
                                            Ngân hàng
                                            <span
                                                class="text-[10px] bg-primary text-white px-1.5 rounded-full">+15%</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ url('tintuc') }}">Tin tức</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ url('hotro') }}">Hỗ trợ</a>
                </nav>
            </div>
            <div class="flex flex-1 justify-end gap-4 items-center">
                <label class="hidden md:flex flex-col min-w-40 h-10 max-w-64">
                    <div
                        class="flex w-full flex-1 items-stretch rounded-lg h-full overflow-hidden border border-primary/20">
                        <div class="text-primary/60 flex bg-primary/5 items-center justify-center px-3">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </div>
                        <input
                            class="form-input flex w-full min-w-0 flex-1 border-none bg-primary/5 focus:ring-0 text-sm placeholder:text-primary/40"
                            placeholder="Tìm kiếm nick game..." value="" />
                    </div>
                </label>
                <div class="flex gap-2">
                    <button
                        class="flex items-center justify-center rounded-lg size-10 bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all">
                        <a href="{{ url('yeuthich') }}"><span class="material-symbols-outlined text-[20px]">favorite</span></a>
                    </button>
                    <button
                        class="flex items-center justify-center rounded-lg size-10 bg-primary/10 text-primary hover:bg-primary hover:text-white transition-all">
                        <a href="{{ url('giohang') }}"><span class="material-symbols-outlined text-[20px]">shopping_cart</span></a>
                    </button>
                    <button
                        class="flex lg:hidden items-center justify-center rounded-lg size-10 bg-primary text-white transition-all"
                        id="mobile-menu-toggle">
                        <span class="material-symbols-outlined text-[20px]">menu</span>
                    </button>
                    @guest
                    <a href="{{ route('dangnhap') }}"
                        class="flex items-center justify-center rounded-lg px-4 h-10 bg-primary text-white font-bold text-sm gap-2 hover:brightness-110 transition-all"
                        id="btn-login-header">
                        <span class="material-symbols-outlined text-[20px]">account_circle</span>
                        <span class="hidden sm:inline">Đăng nhập</span>
                    </a>
                    @endguest

                    @auth
                    <!-- User Profile Dropdown (Logged in state) -->
                    <div class="flex items-center gap-3 group relative cursor-pointer ml-2">
                        <!-- Text Info -->
                        <div class="hidden sm:flex flex-col items-end justify-center">
                            <span class="font-bold text-white text-base leading-none mb-1">{{ Auth::user()->name }}</span>
                            <span class="text-slate-400 text-sm font-medium leading-none">{{ number_format(Auth::user()->balance) }}đ</span>
                        </div>
                        <!-- Avatar -->
                        <div
                            class="size-11 rounded-full border-[2px] border-primary p-0.5 shadow-[0_0_10px_rgba(231,8,20,0.5)] transition-transform group-hover:scale-105 bg-background-dark">
                            <img src="{{ Auth::user()->avatar ?? 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}" alt="Avatar"
                                class="w-full h-full object-cover rounded-full bg-teal-600/20">
                        </div>

                        <!-- Dropdown Menu -->
                        <div
                            class="absolute top-full right-0 pt-4 w-60 opacity-0 invisible group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 translate-y-2 transition-all duration-300 z-[100]">
                            <div
                                class="bg-background-dark border border-primary/20 rounded-xl shadow-2xl overflow-hidden flex flex-col">
                                <!-- User Info Mobile Only -->
                                <div
                                    class="sm:hidden flex flex-col items-center justify-center p-4 border-b border-primary/10 bg-primary/5">
                                    <span class="font-bold text-white text-base">{{ Auth::user()->name }}</span>
                                    <span
                                        class="text-primary text-xs font-bold mt-1 bg-primary/10 px-2 py-0.5 rounded-full">{{ number_format(Auth::user()->balance) }}đ</span>
                                </div>
                                <a href="{{ route('thongtincanhan') }}"
                                    class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors">
                                    <span class="material-symbols-outlined text-[20px] text-primary">person</span>
                                    Thông tin cá nhân
                                </a>
                                <a href="{{ route('lichsunaptien') }}"
                                    class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                                    <span
                                        class="material-symbols-outlined text-[20px] text-primary">account_balance_wallet</span>
                                    Lịch sử nạp tiền
                                </a>
                                <a href="{{ route('lichsumuahang') }}"
                                    class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                                    <span class="material-symbols-outlined text-[20px] text-primary">history</span>
                                    Lịch sử mua hàng
                                </a>

                                <a href="#"
                                    class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                                    <span class="material-symbols-outlined text-[20px] text-primary">history</span>
                                    Lịch sử quay
                                </a>

                                <a href="#"
                                    class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                                    <span class="material-symbols-outlined text-[20px] text-primary">payment_arrow_down</span>
                                    Rút vật phẩm
                                </a>

                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                                        <span class="material-symbols-outlined text-[20px] text-primary">admin_panel_settings</span>
                                        Trang quản trị (Admin)
                                    </a>
                                @elseif(Auth::user()->role === 'agent')
                                    <a href="{{ route('agent.dashboard') }}"
                                        class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                                        <span class="material-symbols-outlined text-[20px] text-primary">real_estate_agent</span>
                                        Trang quản trị (Đại lý)
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                                    @csrf
                                </form>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="logout-btn px-4 py-3 text-sm text-red-500 hover:text-red-400 hover:bg-red-500/10 flex items-center gap-3 transition-colors border-t border-primary/10 font-bold">
                                    <span class="material-symbols-outlined text-[20px]">logout</span>
                                    Đăng xuất
                                </a>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Mobile Menu Overlay -->
            <div id="mobile-menu" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden lg:hidden">
                <div
                    class="absolute right-0 top-0 h-full w-[280px] bg-background-dark shadow-2xl flex flex-col p-6 animate-slide-left">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center gap-2 text-primary">
                            <span class="material-symbols-outlined text-2xl">sports_esports</span>
                            <span class="font-bold text-lg">SHOPNICKVN</span>
                        </div>
                        <button id="mobile-menu-close" class="text-slate-400">
                            <span class="material-symbols-outlined text-2xl">close</span>
                        </button>
                    </div>
                    <nav class="flex flex-col gap-1">
                        <a href="{{ url('/') }}"
                            class="px-4 py-3 rounded-lg text-sm font-medium hover:bg-primary/10 hover:text-primary transition-all">Trang
                            chủ</a>

                        <!-- Mobile Accordion Item -->
                        <div class="mobile-accordion">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium hover:bg-primary/10 hover:text-primary transition-all accordion-btn">
                                Sản phẩm
                                <span
                                    class="material-symbols-outlined text-xl transition-transform duration-300">expand_more</span>
                            </button>
                            <div class="accordion-content hidden pl-4 flex flex-col gap-1 mt-1">
                                @foreach($games as $game)
                                <div class="sub-accordion">
                                    <button
                                        class="w-full flex items-center justify-between px-4 py-2 text-xs font-bold text-slate-500 uppercase flex-shrink-0 sub-accordion-btn">
                                        {{ $game->name }}
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                    <div class="sub-accordion-content hidden flex flex-col gap-1 pl-4 pb-2">
                                        @foreach($game->gameCategories as $category)
                                        <a href="{{ url('sanpham') }}?category={{ $category->slug }}"
                                            class="px-4 py-2 text-sm text-slate-400 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px]">sell</span> {{ $category->name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>


                        <a href="{{ url('nickrandom') }}"
                            class="px-4 py-3 rounded-lg text-sm font-medium hover:bg-primary/10 hover:text-primary transition-all">Nick
                            Random</a>

                        <!-- Mobile Accordion Item: Vòng Quay -->
                        <div class="mobile-accordion">
                            <button
                                class="w-full flex items-center justify-between px-4 py-3 rounded-lg text-sm font-medium hover:bg-primary/10 hover:text-primary transition-all accordion-btn">
                                Vòng quay may mắn
                                <span
                                    class="material-symbols-outlined text-xl transition-transform duration-300">expand_more</span>
                            </button>
                            <div class="accordion-content hidden pl-4 flex flex-col gap-1 mt-1">
                                @foreach($games as $game)
                                @if($game->luckyWheels->count() > 0)
                                <div class="sub-accordion">
                                    <button
                                        class="w-full flex items-center justify-between px-4 py-2 text-xs font-bold text-slate-500 uppercase flex-shrink-0 sub-accordion-btn">
                                        {{ $game->name }}
                                        <span class="material-symbols-outlined text-[16px]">add</span>
                                    </button>
                                    <div class="sub-accordion-content hidden flex flex-col gap-1 pl-4 pb-2">
                                        @foreach($game->luckyWheels as $wheel)
                                        <a href="{{ url('vongquay/' . $wheel->id) }}"
                                            class="px-4 py-2 text-sm text-slate-400 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[18px]">casino</span> <span class="line-clamp-1">{{ $wheel->name }}</span>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <a href="{{ url('napthe') }}"
                            class="px-4 py-3 rounded-lg text-sm font-medium hover:bg-primary/10 hover:text-primary transition-all">Nạp
                            thẻ</a>
                    </nav>
                </div>
            </div>
        </header>