@extends('clients.layouts.master')

@section('title', 'Nạp Thẻ Cào - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/napthecao.css') }}">
@endpush

@section('content')
    <main class="flex flex-col flex-1 max-w-[1280px] mx-auto w-full px-4 sm:px-6 py-10">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    Trang chủ
                </a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-slate-500">Nạp thẻ</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-medium">Nạp Thẻ Cào Tự Động</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Khu vực Biểu mẫu nạp thẻ (Bên trái, chiếm 2 phần) -->
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <div class="flex flex-col gap-2 relative">
                        <div class="absolute -top-6 -left-6 text-primary/10 pointer-events-none z-0">
                            <span class="material-symbols-outlined text-9xl">phone_iphone</span>
                        </div>
                        <h1 class="text-3xl font-black uppercase text-primary tracking-tight relative z-10">Nạp Thẻ Cào
                            Tự Động</h1>
                        <p class="text-slate-500 dark:text-slate-400 relative z-10">Hỗ trợ các loại thẻ Viettel,
                            Vinaphone, Mobifone. Nạp nhanh 24/7, chiết khấu cực tốt.</p>
                    </div>

                    <div
                        class="bg-primary/5 border border-primary/20 rounded-2xl p-6 md:p-8 shadow-lg relative overflow-hidden">
                        <form id="form-nap-the">
                            <!-- Chọn nhà mạng -->
                            <div class="mb-8">
                                <label
                                    class="block text-base font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                                    <span
                                        class="flex items-center justify-center size-6 bg-primary text-white rounded-full text-xs">1</span>
                                    Chọn loại thẻ cào <span class="text-primary">*</span>
                                </label>
                                <div class="grid grid-cols-3 gap-4 custom-radio-group network-selection">
                                    <label class="custom-radio">
                                        <input type="radio" name="network" value="viettel" class="peer sr-only">
                                        <div
                                            class="radio-card p-4 text-center rounded-xl border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/5 shadow-sm group">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Viettel_logo_2021.svg/1200px-Viettel_logo_2021.svg.png"
                                                class="h-8 mx-auto object-contain opacity-70 group-hover:opacity-100 peer-checked:opacity-100 transition-opacity"
                                                alt="Viettel">
                                        </div>
                                    </label>
                                    <label class="custom-radio">
                                        <input type="radio" name="network" value="vinaphone" class="peer sr-only">
                                        <div
                                            class="radio-card p-4 text-center rounded-xl border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/5 shadow-sm group">
                                            <img src="https://inkythuatso.com/uploads/images/2021/09/logo-vinaphone-inkythuatso-1-13-14-38-16.jpg"
                                                class="h-8 mx-auto object-contain opacity-70 group-hover:opacity-100 peer-checked:opacity-100 transition-opacity"
                                                alt="Vinaphone">
                                        </div>
                                    </label>
                                    <label class="custom-radio">
                                        <input type="radio" name="network" value="mobifone" class="peer sr-only">
                                        <div
                                            class="radio-card p-4 text-center rounded-xl border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/5 shadow-sm group">
                                            <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/01/Logo-Mobifone-V.png"
                                                class="h-8 mx-auto object-contain opacity-70 group-hover:opacity-100 peer-checked:opacity-100 transition-opacity"
                                                alt="Mobifone">
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Chọn mệnh giá -->
                            <div class="mb-8">
                                <label
                                    class="block text-base font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="flex items-center justify-center size-6 bg-primary text-white rounded-full text-xs">2</span>
                                        Chọn mệnh giá tiền <span class="text-primary">*</span>
                                    </div>
                                    <span
                                        class="text-xs text-primary bg-primary/10 px-2 py-1 rounded font-medium animate-pulse">Lưu
                                        ý: Mất thẻ nếu sai mệnh giá</span>
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 custom-radio-group price-selection">
                                    <label class="custom-radio price-item">
                                        <input type="radio" name="amount" value="10000" class="peer sr-only">
                                        <div
                                            class="radio-card py-3 text-center rounded-lg border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary font-bold text-sm shadow-sm hover:border-primary/50 text-slate-700 dark:text-slate-300">
                                            10.000 VNĐ
                                        </div>
                                    </label>
                                    <label class="custom-radio price-item">
                                        <input type="radio" name="amount" value="20000" class="peer sr-only">
                                        <div
                                            class="radio-card py-3 text-center rounded-lg border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary font-bold text-sm shadow-sm hover:border-primary/50 text-slate-700 dark:text-slate-300">
                                            20.000 VNĐ
                                        </div>
                                    </label>
                                    <label class="custom-radio price-item">
                                        <input type="radio" name="amount" value="50000" class="peer sr-only">
                                        <div
                                            class="radio-card py-3 text-center rounded-lg border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary font-bold text-sm shadow-sm hover:border-primary/50 text-slate-700 dark:text-slate-300">
                                            50.000 VNĐ<br><span class="text-[10px] text-green-500 font-medium">+10%
                                                nhận</span>
                                        </div>
                                    </label>
                                    <label class="custom-radio price-item">
                                        <input type="radio" name="amount" value="100000" class="peer sr-only">
                                        <div
                                            class="radio-card py-3 text-center rounded-lg border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary font-bold text-sm shadow-sm hover:border-primary/50 text-slate-700 dark:text-slate-300">
                                            100.000 VNĐ
                                        </div>
                                    </label>
                                    <label class="custom-radio price-item">
                                        <input type="radio" name="amount" value="200000" class="peer sr-only">
                                        <div
                                            class="radio-card py-3 text-center rounded-lg border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary font-bold text-sm shadow-sm hover:border-primary/50 text-slate-700 dark:text-slate-300">
                                            200.000 VNĐ
                                        </div>
                                    </label>
                                    <label class="custom-radio price-item">
                                        <input type="radio" name="amount" value="500000" class="peer sr-only">
                                        <div
                                            class="radio-card py-3 text-center rounded-lg border border-primary/20 transition-all cursor-pointer bg-white dark:bg-background-dark peer-checked:border-primary peer-checked:bg-primary/10 peer-checked:text-primary font-bold text-sm shadow-sm hover:border-primary/50 text-slate-700 dark:text-slate-300">
                                            500.000 VNĐ
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Nhập thông tin seri mã thẻ -->
                            <div class="mb-8">
                                <label
                                    class="block text-base font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                                    <span
                                        class="flex items-center justify-center size-6 bg-primary text-white rounded-full text-xs">3</span>
                                    Nhập Seri và Mã thẻ <span class="text-primary">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="input-group">
                                        <label
                                            class="block text-sm text-slate-600 dark:text-slate-400 font-medium mb-1">Số
                                            Seri <span class="text-primary">*</span></label>
                                        <div class="relative group">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">qr_code</span>
                                            </div>
                                            <input type="text" id="serial-input"
                                                class="w-full bg-white dark:bg-black/20 border border-primary/20 rounded-lg pl-10 pr-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none shadow-sm dark:text-slate-100 placeholder:text-slate-400"
                                                placeholder="Nhập chuỗi số seri trên thẻ">
                                        </div>
                                        <span class="text-xs text-red-500 mt-1 hidden" id="err-serial">Vui lòng nhập số
                                            seri hợp lệ</span>
                                    </div>
                                    <div class="input-group">
                                        <label
                                            class="block text-sm text-slate-600 dark:text-slate-400 font-medium mb-1">Mã
                                            thẻ <span class="text-primary">*</span></label>
                                        <div class="relative group">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                                <span class="material-symbols-outlined text-[20px]">pin</span>
                                            </div>
                                            <input type="text" id="pin-input"
                                                class="w-full bg-white dark:bg-black/20 border border-primary/20 rounded-lg pl-10 pr-4 py-3 text-sm focus:border-primary focus:ring-1 focus:ring-primary transition-all outline-none shadow-sm dark:text-slate-100 placeholder:text-slate-400"
                                                placeholder="Nhập mã thẻ cào">
                                        </div>
                                        <span class="text-xs text-red-500 mt-1 hidden" id="err-pin">Vui lòng nhập mã thẻ
                                            hợp lệ</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-primary/10 mb-6">

                            <button type="submit" id="btn-submit"
                                class="w-full h-14 bg-gradient-to-r from-primary to-orange-500 text-white font-black text-lg rounded-xl hover:brightness-110 hover:shadow-primary/30 shadow-lg transition-all flex items-center justify-center gap-2 group relative overflow-hidden">
                                <span
                                    class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                                <span
                                    class="material-symbols-outlined relative z-10 group-hover:rotate-12 transition-transform">bolt</span>
                                <span class="relative z-10 tracking-wide">NẠP THẺ NGAY</span>
                            </button>
                        </form>

                        <!-- Lớp phủ Loading -->
                        <div id="loading-overlay"
                            class="absolute inset-0 bg-background-dark/80 backdrop-blur-sm z-50 flex-col items-center justify-center hidden">
                            <div
                                class="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent mb-4">
                            </div>
                            <p class="text-primary font-bold text-lg animate-pulse">Đang xử lý thẻ...</p>
                            <p class="text-slate-400 text-sm mt-1">Vui lòng không tắt trình duyệt</p>
                        </div>
                    </div>
                </div>

                <!-- Khu vực Sidebar (Bên phải, chiếm 1 phần) -->
                <div class="flex flex-col gap-6">
                    <!-- Info Box -->
                    <div
                        class="bg-gradient-to-br from-indigo-900 to-purple-900 rounded-2xl p-6 text-white shadow-lg border border-purple-500/30 relative overflow-hidden h-max">
                        <div class="absolute -right-4 -top-4 opacity-10 pointer-events-none">
                            <span class="material-symbols-outlined text-8xl">verified_user</span>
                        </div>
                        <h3 class="font-bold text-lg text-purple-200 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined">gpp_maybe</span> Thông báo quan trọng
                        </h3>
                        <ul class="space-y-3 text-sm text-indigo-100">
                            <li class="flex items-start gap-2">
                                <span
                                    class="material-symbols-outlined text-purple-400 text-[18px] flex-shrink-0 mt-0.5">check_circle</span>
                                <span>Thẻ cào xử lý nhanh <b class="text-white">tự động 100%</b> trong 5s.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span
                                    class="material-symbols-outlined text-red-400 text-[18px] flex-shrink-0 mt-0.5">warning</span>
                                <span><b class="text-red-300">ĐẶC BIỆT CHÚ Ý:</b> Sai mệnh giá sẽ bị trừ 50% thực nhận
                                    hoặc mất thẻ, vui lòng kiểm tra kỹ trước khi bấm nạp.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span
                                    class="material-symbols-outlined text-purple-400 text-[18px] flex-shrink-0 mt-0.5">check_circle</span>
                                <span>Nếu nạp thẻ bị lỗi liên tục, vui lòng liên hệ Admin.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Bảng Giá Chiết Khấu -->
                    <div
                        class="bg-primary/5 border border-primary/20 rounded-2xl p-5 shadow-lg max-h-[400px] overflow-hidden flex flex-col">
                        <h3 class="font-bold text-lg mb-4 flex items-center gap-2 border-b border-primary/10 pb-3">
                            <span class="material-symbols-outlined text-primary">percent</span> Bảng giá nạp thẻ
                        </h3>
                        <div class="overflow-y-auto pr-1 flex-1 custom-scrollbar">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-slate-500 dark:text-slate-400 bg-primary/10 sticky top-0">
                                    <tr>
                                        <th class="px-3 py-2 rounded-l-lg">Nhà mạng</th>
                                        <th class="px-3 py-2 text-center">Chiết khấu</th>
                                        <th class="px-3 py-2 rounded-r-lg text-right">Nhận</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-primary/5">
                                    <tr class="hover:bg-white/5">
                                        <td class="px-3 py-2.5 font-bold text-viettel">Viettel</td>
                                        <td class="px-3 py-2.5 text-center text-red-500 font-medium">10%</td>
                                        <td class="px-3 py-2.5 text-right font-medium text-green-500">90%</td>
                                    </tr>
                                    <tr class="hover:bg-white/5">
                                        <td class="px-3 py-2.5 font-bold text-blue-500">Vinaphone</td>
                                        <td class="px-3 py-2.5 text-center text-red-500 font-medium">12%</td>
                                        <td class="px-3 py-2.5 text-right font-medium text-green-500">88%</td>
                                    </tr>
                                    <tr class="hover:bg-white/5">
                                        <td class="px-3 py-2.5 font-bold text-red-600">Mobifone</td>
                                        <td class="px-3 py-2.5 text-center text-red-500 font-medium">15%</td>
                                        <td class="px-3 py-2.5 text-right font-medium text-green-500">85%</td>
                                    </tr>
                                    <tr class="hover:bg-white/5">
                                        <td class="px-3 py-2.5 font-bold text-green-600">Zing</td>
                                        <td class="px-3 py-2.5 text-center text-red-500 font-medium">10%</td>
                                        <td class="px-3 py-2.5 text-right font-medium text-green-500">90%</td>
                                    </tr>
                                    <tr class="hover:bg-white/5 text-slate-400 italic">
                                        <td class="px-3 py-2.5" colspan="3">* Chiết khấu có thể dao động tùy khung giờ.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lịch sử nạp thẻ cào của tui -->
            <div class="mt-10 bg-primary/5 border border-primary/10 rounded-2xl shadow-lg overflow-hidden">
                <div
                    class="px-6 py-5 border-b border-primary/10 bg-white/5 dark:bg-white/5 flex items-center justify-between">
                    <h2 class="text-xl font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history_toggle_off</span>
                        Lịch Sử Nạp Thẻ Cào
                    </h2>
                    <button class="text-sm font-bold text-primary hover:underline" id="refresh-history">
                        <span class="material-symbols-outlined text-[18px] align-middle"
                            id="refresh-icon">refresh</span> Làm mới
                    </button>
                </div>

                <div class="overflow-x-auto min-h-[150px]">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-slate-500 dark:text-slate-400 uppercase bg-primary/5">
                            <tr>
                                <th scope="col" class="px-6 py-4 border-b border-primary/10">Mã giao dịch</th>
                                <th scope="col" class="px-6 py-4 border-b border-primary/10">Nhà mạng</th>
                                <th scope="col" class="px-6 py-4 border-b border-primary/10">Mệnh giá gửi</th>
                                <th scope="col" class="px-6 py-4 border-b border-primary/10">Trạng thái</th>
                                <th scope="col" class="px-6 py-4 border-b border-primary/10">Thực nhận</th>
                                <th scope="col" class="px-6 py-4 border-b border-primary/10 text-right">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary/5" id="history-table-body">
                            @auth
                                @forelse($deposits as $deposit)
                                    <tr class="hover:bg-primary/5 transition-colors group">
                                        <td class="px-6 py-4 font-mono font-bold text-slate-700 dark:text-slate-300">#{{ $deposit->transaction_id ?? $deposit->id }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $netColor = '';
                                                switch (strtolower($deposit->card_network)) {
                                                    case 'viettel': $netColor = 'text-green-500 bg-green-500/10 border-green-500/20'; break;
                                                    case 'vinaphone': $netColor = 'text-blue-500 bg-blue-500/10 border-blue-500/20'; break;
                                                    case 'mobifone': $netColor = 'text-red-500 bg-red-500/10 border-red-500/20'; break;
                                                    default: $netColor = 'text-slate-500 bg-slate-500/10 border-slate-500/20'; break;
                                                }
                                            @endphp
                                            <span class="{{ $netColor }} px-3 py-1.5 rounded-full text-xs font-bold border flex items-center gap-1 w-fit">
                                                {{ ucfirst($deposit->card_network ?? 'Unknown') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-medium">{{ number_format($deposit->amount, 0, ',', '.') }}đ</td>
                                        <td class="px-6 py-4">
                                            @if($deposit->status == 'pending')
                                                <span class="bg-yellow-500/10 text-yellow-500 px-3 py-1.5 rounded-full text-xs font-bold border border-yellow-500/20 inline-flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px] animate-spin">sync</span> Chờ xử lý...
                                                </span>
                                            @elseif($deposit->status == 'approved')
                                                <span class="bg-green-500/10 text-green-500 px-3 py-1.5 rounded-full text-xs font-bold border border-green-500/20 inline-flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">check_circle</span> Hoàn thành
                                                </span>
                                            @else
                                                <span class="bg-red-500/10 text-red-500 px-3 py-1.5 rounded-full text-xs font-bold border border-red-500/20 inline-flex items-center gap-1">
                                                    <span class="material-symbols-outlined text-[14px]">error</span> Thất bại
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 font-black {{ $deposit->status == 'approved' ? 'text-primary' : 'text-slate-400' }}">
                                            {{ $deposit->status == 'approved' ? number_format($deposit->received_amount ?? ($deposit->amount * 0.9), 0, ',', '.') . 'đ' : 'Đang tính...' }}
                                        </td>
                                        <td class="px-6 py-4 text-right text-xs text-slate-500">{{ $deposit->created_at->format('H:i - d/m') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                            Bạn chưa có giao dịch nạp thẻ cào nào.
                                        </td>
                                    </tr>
                                @endforelse
                            @else
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-slate-500">
                                        Vui lòng <a href="{{ route('dangnhap') }}" class="text-primary hover:underline">đăng nhập</a> để xem lịch sử nạp thẻ cào.
                                    </td>
                                </tr>
                            @endauth
                        </tbody>
                    </table>
                </div>
            </div>
        
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/napthecao.js') }}"></script>
@endpush
