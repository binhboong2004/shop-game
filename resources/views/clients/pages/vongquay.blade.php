@extends('clients.layouts.master')

@section('title', 'Vòng Quay May Mắn - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/vongquay.css') }}">
@endpush

@section('content')
<div class="mb-12 mt-6">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-slate-700 hover:text-[#E70814] dark:text-slate-400 dark:hover:text-white transition-colors">
                    <span class="material-symbols-outlined mr-2 text-base">home</span>
                    Trang chủ
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    <span class="ml-1 text-sm font-medium text-slate-500 md:ml-2 dark:text-slate-400">Vòng quay may mắn</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl mb-4">
            VÒNG QUAY <span class="text-[#E70814]">MAY MẮN</span>
        </h1>
        <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
            Thử vận may ngay hôm nay với hàng ngàn phần quà cực chất đang chờ đón bạn. Lượt quay không giới hạn!
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Vòng quay Area (Left/Top) -->
        <div class="lg:col-span-7 xl:col-span-8 flex flex-col items-center">
            
            <!-- Wheel Container -->
            <div class="wheel-wrapper relative mb-8">
                <div class="wheel-border rounded-full p-2 bg-gradient-to-br from-yellow-400 via-yellow-600 to-yellow-800 shadow-[0_0_30px_rgba(231,8,20,0.5)]">
                    <div class="wheel-inner relative overflow-hidden rounded-full border-4 border-slate-900 shadow-inner bg-slate-800 w-[300px] h-[300px] sm:w-[400px] sm:h-[400px] md:w-[450px] md:h-[450px]">
                        <!-- SVG Wheel Canvas -->
                        <canvas id="wheelCanvas" class="w-full h-full" width="450" height="450"></canvas>
                    </div>
                </div>

                <!-- Center Pointer/Spin Button -->
                <div class="wheel-pointer absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center z-10">
                    <button id="spinBtn" class="spin-btn w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#E70814] text-white font-bold text-xl sm:text-2xl shadow-[0_0_20px_rgba(231,8,20,0.8)] border-4 border-white dark:border-slate-800 transition-transform hover:scale-105 uppercase tracking-wider disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 flex flex-col items-center justify-center">
                        <span class="pb-1">QUAY</span>
                    </button>
                    <!-- Pointer Arrow -->
                    <div class="absolute -top-6 sm:-top-8 left-1/2 -translate-x-1/2 w-0 h-0 border-l-[15px] sm:border-l-[20px] border-l-transparent border-r-[15px] sm:border-r-[20px] border-r-transparent border-t-[30px] sm:border-t-[40px] border-t-[#E70814] drop-shadow-lg z-20"></div>
                </div>
            </div>

            <!-- Stats & Action -->
            <div class="flex flex-col sm:flex-row items-center gap-4 bg-white dark:bg-slate-800 p-4 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 w-full max-w-md justify-between">
                <div class="text-center sm:text-left">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Số dư hiện tại</p>
                    <p class="text-xl font-bold text-[#E70814]">150,000 đ</p>
                </div>
                <div class="h-10 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>
                <div class="text-center sm:text-left">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Giá mỗi lượt quay</p>
                    <p class="text-xl font-bold text-green-500">19,000 đ</p>
                </div>
                <div class="h-10 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm whitespace-nowrap">
                    Nạp thẻ ngay
                </button>
            </div>
            
        </div>

        <!-- Sidebar (Right/Bottom) -->
        <div class="lg:col-span-5 xl:col-span-4 space-y-6">
            
            <!-- Leaderboard / Recent Winners -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="border-b border-slate-200 dark:border-slate-700 px-5 py-4 bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between">
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-yellow-500">trophy</span>
                        Lịch sử trúng thưởng
                    </h3>
                </div>
                <div class="p-0 max-h-[300px] overflow-y-auto no-scrollbar" id="recentWinners">
                    <!-- Danh sách người trúng code javascript sẽ render -->
                    <div class="w-full h-full flex items-center justify-center p-8 text-slate-400">
                        <span class="material-symbols-outlined animate-spin text-2xl mr-2">refresh</span>
                        Đang tải...
                    </div>
                </div>
            </div>

            <!-- Rules & Info -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="border-b border-slate-200 dark:border-slate-700 px-5 py-4 bg-slate-50 dark:bg-slate-800/50">
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#E70814]">info</span>
                        Thể lệ trò chơi
                    </h3>
                </div>
                <div class="p-5 text-sm text-slate-600 dark:text-slate-400 space-y-3">
                    <ul class="list-disc pl-5 space-y-2">
                        <li>Mỗi lượt quay trị giá <strong class="text-green-500">19,000đ</strong> và sẽ trừ trực tiếp vào số dư tài khoản.</li>
                        <li>Trúng <strong>Robux</strong>, <strong>Kim Cương</strong> sẽ được cộng trực tiếp vào ví sau 1-3 phút.</li>
                        <li>Trúng <strong>Tài khoản VIP</strong> sẽ nhận được thông tin đăng nhập trong phần "Lịch sử mua hàng".</li>
                        <li>Nếu trúng "Chúc bạn may mắn lần sau", bạn đừng nản chí nhé!</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Trúng Thưởng -->
<div id="prizeModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="prizeBackdrop"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white dark:bg-slate-800 rounded-2xl shadow-2xl w-full max-w-sm p-6 sm:p-8 transform scale-95 transition-transform duration-300 ease-out text-center border overflow-hidden border-[#E70814]">
        
        <!-- Confetti/Firework decoration absolute -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-yellow-400 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-[#E70814] rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>
        
        <!-- Close Button -->
        <button id="closeModalBtn" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors z-10">
            <span class="material-symbols-outlined">close</span>
        </button>

        <!-- Main Icon -->
        <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 relative z-10 shadow-lg border-2 border-yellow-400">
            <span class="material-symbols-outlined text-4xl" id="prizeIcon">redeem</span>
        </div>
        
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2 relative z-10">Chúc Mừng Bạn!</h2>
        <p class="text-slate-600 dark:text-slate-300 mb-6 relative z-10">
            Bạn đã quay trúng: <br/>
            <span class="text-lg font-bold text-[#E70814] mt-2 block" id="prizeName">1,000 Robux</span>
        </p>
        
        <div class="flex gap-3 relative z-10">
            <button id="playAgainBtn" class="flex-1 bg-[#E70814] hover:bg-red-700 text-white py-2.5 rounded-lg font-medium transition-colors">
                Quay tiếp
            </button>
            <a href="#" class="flex-1 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-800 dark:text-white py-2.5 rounded-lg font-medium transition-colors">
                Xem tủ đồ
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script src="{{ asset('assets/clients/js/vongquay.js') }}"></script>
@endpush
