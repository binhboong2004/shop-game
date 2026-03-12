@extends('clients.layouts.master')
@section('content')
            <section class="mt-6">
                <div class="@container">
                    <div class="flex min-h-[400px] flex-col gap-6 bg-cover bg-center bg-no-repeat rounded-xl items-center justify-center p-8 text-center relative overflow-hidden group"
                        data-alt="Epic gaming background with neon lights and characters"
                        style='background-image: linear-gradient(rgba(35, 15, 17, 0.7) 0%, rgba(35, 15, 17, 0.9) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuD-ZbZrPGAa4M3EzP_JtDiaUWE9J6ZkD8opeFK75QtFM0cGdKZwjSi7BTkZo1V59WwKsTAKDLvp9nE3Nj2WPzpsktzkLilZc9JWdSYPBluikOBE7Zxxx7pQ0w1efCP7zkNXWLIlTNQj_Tr2lEaUtcWg4i5q4kbmR4aciyrPSJbpIMe150MxXEU-pS2nuEQXYLjzGzwhMZ50QViRicvxZkNRgDI4FkJvtbiWtnj5adnkgVrlmDmwoTFwnbcULEN5D4Uncilcdp-IMb8");'>
                        <div class="z-10 flex flex-col gap-4">
                            <div
                                class="inline-block self-center bg-primary px-3 py-1 rounded text-xs font-bold uppercase tracking-widest text-white">
                                Sự kiện mới nhất</div>
                            <h1 class="text-white text-4xl font-black leading-tight tracking-tight md:text-6xl">
                                SIÊU SALE NICK GAME GIÁ RẺ
                            </h1>
                            <p class="text-slate-200 text-base md:text-lg max-w-2xl mx-auto">
                                Khuyến mãi nạp thẻ lên đến 50% - Hệ thống tự động 24/7. Hàng ngàn tài khoản VIP đang chờ
                                đón bạn.
                            </p>
                            <div class="flex flex-wrap gap-4 justify-center mt-4">
                                <a href="{{ route('dangkydaily') }}"
                                    class="flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-primary text-white text-base font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                                    Đăng ký làm đại lý
                                </a>
                                <button
                                    class="flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-primary text-white text-base font-bold shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                                    Mua Nick Ngay
                                </button>
                                <button
                                    class="flex min-w-[160px] cursor-pointer items-center justify-center rounded-lg h-12 px-6 bg-white/10 text-white text-base font-bold border border-white/20 hover:bg-white/20 transition-all">
                                    Nạp Thẻ Ngay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Danh mục game nổi bật -->
            <section class="py-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold leading-tight flex items-center gap-2">
                        <span class="w-2 h-8 bg-primary rounded-full"></span>
                        Danh Mục Game Nổi Bật
                    </h2>
                    <a class="text-primary text-sm font-bold hover:underline" href="{{ route('sanpham') }}">Xem tất cả</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($topGames as $game)
                    <a href="{{ route('sanpham', ['game' => $game->slug]) }}" class="group relative aspect-square overflow-hidden rounded-xl cursor-pointer block">
                        @php
                            $defaultBg = 'https://lh3.googleusercontent.com/aida-public/AB6AXuDQrdQ36NBnfKPWLiLPJf24pe6QD0DyjRvdE1BGJkVVyHrmFXjULBABMj16OwxxxJzVPBmmMDmqfTI7_jHKpg37EvDrzO_A50uxUCO29PizryUhQZYjUxEbzj4iv9vh0fiih62rmt8eknwFdUVZH9nlWCpjb_0_qVOo1uw88sDJQccW5TZli_9IBpKBHYwzUCqEhG0h72CHxnCfr7GjVQAICfIM6-GI0FcnfKpoVrdESMkG-ROb6LsICofcY8us6KrgXENi3qfdB3Q';
                            $gameBg = $game->image ?? $defaultBg;
                        @endphp
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                            style="background-image: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 50%), url('{{ $gameBg }}');">
                        </div>
                        <div class="absolute bottom-0 left-0 p-4 w-full">
                            <p class="text-white text-lg font-bold">{{ $game->name }}</p>
                            <p class="text-primary text-xs font-medium">{{ number_format($game->accounts_count ?? 0, 0, ',', '.') }} nick đang bán</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
            <!-- Các danh mục game và tài khoản đang bán -->
            @foreach($gamesWithAccounts as $game)
            <section class="py-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold leading-tight flex items-center gap-2 uppercase">
                        <span class="w-2 h-8 bg-primary rounded-full"></span>
                        {{ $game->name }}
                    </h2>
                    <a class="text-primary text-sm font-bold hover:underline" href="{{ route('sanpham', ['game' => $game->slug]) }}">Xem tất cả</a>
                </div>
                <!-- Cập nhật grid layout: 2 cột mobile, 3 tablet, 4 màn nhỏ, 5 màn to -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 lg:gap-6 mt-6">
                    @foreach($game->latest_accounts as $account)
                    <!-- Nick Card -->
                    <div class="bg-primary/5 border border-primary/10 rounded-xl overflow-hidden hover:shadow-xl hover:shadow-primary/5 transition-all group flex flex-col">
                        <div class="relative aspect-video overflow-hidden">
                            @if(!empty($account->badge) || !isset($account->badge))
                                <div class="absolute top-2 left-2 z-10 bg-primary text-white text-[10px] sm:text-[12px] font-bold px-2 py-1 rounded shadow-sm">{{ $account->badge ?: 'HOT' }}</div>
                            @endif
                            <button onclick="toggleWishlist('{{ $account->id }}', this)" class="absolute top-2 right-2 z-10 size-7 sm:size-8 bg-black/40 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-[16px] sm:text-lg {{ in_array($account->id, $wishlistedIds ?? []) ? 'text-primary' : '' }}">favorite</span>
                            </button>
                            <img alt="Nick Game Preview" class="w-full h-full object-cover transition-transform group-hover:scale-105" src="{{ (is_array($account->images) && count($account->images) > 0) ? $account->images[0] : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBSqSRYCFLWc6tXI5qSph2cTO9BCTJcAAm9Plhww61FUXY82_bqF-UXj27sEqpepYFNShZYjsFDPZ3VJ3NIxU2mGnxXWMJnih8J64166jLVAtqLsC-VAdFfFmiMIeOzFy-3i-hVBVpSFFJXPE7DntUTVnnKFbYeGszdf1BAtpfcLGOMgFzF3KN9KaDYkvYQxqhHh6_I28HB5N2uKK1Dr67IuI9yuQ-sKovMvr2csNOxnJyRu9omI0JNtFQ0uyHtCGFQnyliI9xHboo' }}" />
                        </div>
                        <div class="p-3 sm:p-4 flex flex-col gap-2 sm:gap-3 flex-1">
                            <h3 class="font-bold text-[13px] sm:text-base line-clamp-1 break-all" title="{{ $account->title }}">{{ $account->title }}</h3>
                            <div class="flex gap-2 items-center text-[10px] sm:text-xs text-slate-500 dark:text-slate-400">
                                <span class="bg-primary/10 text-primary px-1.5 sm:px-2 py-0.5 rounded truncate max-w-[80px] sm:max-w-[100px]">{{ $account->gameCategory->name ?? $game->name }}</span>
                                <span>ID: #{{ $account->id }}</span>
                            </div>
                            <div class="mt-auto pt-2 flex flex-col lg:flex-row lg:justify-between lg:items-center gap-2">
                                <span class="text-primary text-base sm:text-lg font-black">{{ number_format($account->price, 0, ',', '.') }}đ</span>
                                <a href="{{ route('sanphamchitiet', $account->id) }}" class="bg-primary text-white text-[10px] sm:text-xs font-bold px-3 py-1.5 sm:px-4 sm:py-2 rounded-lg hover:brightness-110 text-center w-full lg:w-max cursor-pointer">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endforeach

            <!-- Hoạt động gần đây -->
            <section class="py-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Đơn Hàng Gần Đây -->
                    <div class="flex flex-col gap-4">
                        <div
                            class="bg-primary/90 text-white font-bold px-4 py-3 rounded-lg shadow-md flex items-center gap-2">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            ĐƠN HÀNG GẦN ĐÂY
                        </div>
                        <div class="flex flex-col gap-3 h-[350px] overflow-y-auto pr-2" style="scrollbar-width: thin;">
                            @foreach($recentOrders as $order)
                            <!-- Item Order -->
                            <div class="bg-white dark:bg-white/5 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-3 flex justify-between items-center gap-2 shadow-sm transition-all hover:border-primary/50">
                                <p class="text-[14px] text-slate-700 dark:text-slate-300 line-clamp-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold">...{{ Str::substr($order->buyer->name ?? 'Guest', -10) }}</span> mua
                                    <span class="text-red-500 font-bold">1</span> {{ Str::limit($order->account->title ?? 'Nick Game', 25) }}... với
                                    giá <span class="text-blue-600 dark:text-blue-400 font-bold">{{ number_format($order->amount, 0, ',', '.') }}đ</span>
                                </p>
                                <span class="bg-[#007bff] text-white text-[10px] font-bold px-2 py-1.5 rounded whitespace-nowrap shadow-sm">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Nạp Tiền Gần Đây -->
                    <div class="flex flex-col gap-4">
                        <div
                            class="bg-primary/90 text-white font-bold px-4 py-3 rounded-lg shadow-md flex items-center gap-2">
                            <span class="material-symbols-outlined">credit_card</span>
                            NẠP TIỀN GẦN ĐÂY
                        </div>
                        <div class="flex flex-col gap-3 h-[350px] overflow-y-auto pr-2" style="scrollbar-width: thin;">
                            @foreach($recentDeposits as $deposit)
                            <!-- Item Deposit -->
                            <div class="bg-white dark:bg-white/5 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg p-3 flex justify-between items-center gap-2 shadow-sm transition-all hover:border-primary/50">
                                <p class="text-[14px] text-slate-700 dark:text-slate-300 line-clamp-1">
                                    <span class="text-green-600 dark:text-green-400 font-bold">...{{ Str::substr($deposit->user->name ?? 'Guest', -10) }}</span> thực
                                    hiện nạp <span class="text-blue-600 dark:text-blue-400 font-bold">{{ number_format($deposit->amount, 0, ',', '.') }}đ</span> bằng
                                    <span class="text-red-500 font-bold">{{ mb_strtoupper($deposit->category->name ?? 'ATM/MOMO') }}</span> thực nhận 
                                    <span class="text-blue-600 dark:text-blue-400 font-bold">{{ number_format($deposit->received_amount, 0, ',', '.') }}đ</span>
                                </p>
                                <span class="bg-[#007bff] text-white text-[10px] font-bold px-2 py-1.5 rounded whitespace-nowrap shadow-sm">{{ $deposit->created_at->diffForHumans() }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

@endsection
