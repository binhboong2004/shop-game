@extends('clients.layouts.master')

@section('title', 'Nạp thẻ - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/napnganhang.css') }}">
@endpush

@section('content')
    <div class="py-10">
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-slate-500 py-4 mt-2">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    Trang chủ
                </a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-slate-500">Nạp thẻ</span>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-primary font-medium">Nạp Ngân Hàng</span>
            </div>

            <div class="mb-6 border-l-4 border-primary pl-4">
                <h1 class="text-2xl md:text-3xl font-bold uppercase text-white">Chuyển Khoản Ngân Hàng / Ví Điện Tử</h1>
                <p class="text-slate-400 mt-1 text-sm">Hệ thống xử lý tự động tiện lợi, an toàn, nhanh chóng 24/7. Nhận
                    <span class="bg-primary/20 text-primary font-bold px-1.5 py-0.5 rounded">+15% khuyến mãi</span>
                </p>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-10">
                <!-- Cột trái: Lưu ý & Hướng dẫn -->
                <div class="xl:col-span-1 flex flex-col gap-6">
                    <div class="bg-primary/5 border border-primary/20 rounded-xl p-5">
                        <div
                            class="flex items-center gap-2 text-primary font-bold text-lg mb-4 border-b border-primary/10 pb-3">
                            <span class="material-symbols-outlined">warning</span>
                            Lưu ý quan trọng
                        </div>
                        <ul class="text-sm text-slate-300 space-y-3 list-disc pl-5">
                            <li>Vui lòng chuyển đúng <strong class="text-white">Nội dung chuyển khoản</strong> để hệ
                                thống duyệt tự động.</li>
                            <li>Hệ thống xử lý giao dịch tự động trong <strong class="text-green-400">1 - 3
                                    phút</strong>.</li>
                            <li>Nếu quá 10 phút chưa nhận được tiền, vui lòng liên hệ CSKH.</li>
                            <li>Không được thay đổi lời nhắn. Nếu ghi sai, liên hệ hỗ trợ để được cộng tay (có thể chậm
                                hơn).</li>
                            <li>Nạp tiền qua ngân hàng/Momo sẽ được ưu đãi <strong class="text-primary italic">+15% giá
                                    trị</strong> so với nạp thẻ cào.</li>
                        </ul>
                    </div>

                    <div
                        class="bg-primary/5 border border-primary/20 text-center rounded-xl p-5 hover:bg-primary/10 transition-colors">
                        <span class="material-symbols-outlined text-4xl text-primary mb-2">support_agent</span>
                        <h3 class="font-bold text-white text-lg mb-1">Cần hỗ trợ?</h3>
                        <p class="text-sm text-slate-400 mb-4">Chúng tôi luôn ở đây để giúp bạn!</p>
                        <a href="{{ route('hotro') }}"
                            class="inline-flex items-center justify-center bg-primary text-white font-bold py-2 px-6 rounded-lg text-sm hover:brightness-110 shadow-lg shadow-primary/20">Liên
                            hệ Fanpage</a>
                    </div>
                </div>

                <!-- Cột phải: Thông tin chuyển khoản -->
                <div class="xl:col-span-2">
                    <div class="bg-background-dark border border-slate-700 rounded-xl overflow-hidden shadow-xl">

                        <!-- Tabs chọn phương thức -->
                        <div class="flex border-b border-slate-700 bg-black/20 overflow-x-auto"
                            style="scrollbar-width: none;">
                            <button data-target="mbbank-info"
                                class="bank-tab active whitespace-nowrap flex-1 py-4 flex items-center justify-center gap-2 border-b-2 border-primary text-primary bg-primary/10 font-bold text-sm transition-all focus:outline-none">
                                <img src="https://iocrealty.com/wp-content/uploads/images/y-nghia-va-thong-diep-dang-sau-bieu-tuong-mb-bank-0.jpg"
                                    class="h-6 object-contain rounded-sm" alt="MBBank Logo"
                                    style="filter: brightness(1.2);"> MB BANK
                            </button>
                            <button data-target="momo-info"
                                class="bank-tab whitespace-nowrap flex-1 py-4 flex items-center justify-center gap-2 border-b-2 border-transparent text-slate-500 hover:text-slate-300 hover:border-slate-300 font-bold text-sm transition-all focus:outline-none">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQZcQPC-zWVyFOu9J2OGl0j2D220D49D0Z7BQ&s"
                                    class="h-6 object-contain" alt="Momo Logo"> VÍ MOMO
                            </button>
                        </div>

                        <!-- Nội dung MB Bank -->
                        <div id="mbbank-info" class="bank-content p-6 flex flex-col md:flex-row gap-6 items-start">
                            <div
                                class="w-full md:w-1/3 flex flex-col items-center gap-3 bg-white p-4 rounded-xl shadow-inner border border-slate-200">
                                <h3
                                    class="text-slate-800 font-bold text-center border-b border-dashed border-slate-300 pb-2 w-full uppercase text-sm">
                                    Quét mã QR để chuyển nhanh</h3>
                                <div class="qr-code-wrapper bg-white">
                                    <img src="https://img.vietqr.io/image/{{ $settings['mbbank_bank_code'] ?? 'MB' }}-{{ $settings['mbbank_number'] ?? '6802122004' }}-qr_only.png?amount=100000&addInfo={{ urlencode(($settings['transfer_prefix'] ?? 'NAP SHOPNICKVN ') . (Auth::check() ? Auth::id() : '12345')) }}&accountName={{ urlencode($settings['mbbank_owner'] ?? 'VU DUY BINH') }}"
                                        alt="QR Code MBBank">
                                </div>
                                <p class="text-[11px] text-slate-500 text-center italic">* Mở app ngân hàng để
                                    quét mã (Tự động nhập đúng Nội dung)</p>
                            </div>

                            <div class="w-full md:w-1/3 flex flex-col gap-3">
                                <h3 class="font-bold text-[15px] text-white border-l-4 border-primary pl-2 mb-1">Thông tin tài
                                    khoản</h3>

                                <div class="space-y-2">
                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-slate-700/50">
                                        <span class="text-[11px] text-slate-400">Ngân hàng:</span>
                                        <div class="font-bold text-white text-sm">MB Bank</div>
                                    </div>

                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-slate-700/50">
                                        <span class="text-[11px] text-slate-400">Chủ tài khoản:</span>
                                        <div class="font-bold text-white text-sm uppercase">{{ $settings['mbbank_owner'] ?? 'VU DUY BINH' }}</div>
                                    </div>

                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-primary/30 relative">
                                        <span class="text-[11px] text-slate-400">Số tài khoản:</span>
                                        <div class="flex justify-between items-center">
                                            <div class="font-bold text-primary text-base">{{ $settings['mbbank_number'] ?? '6802122004' }}</div>
                                            <button data-copy="{{ $settings['mbbank_number'] ?? '6802122004' }}"
                                                class="btn-copy bg-primary/20 text-primary p-1.5 rounded hover:bg-primary hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-green-500/30">
                                        <div class="flex justify-between items-center text-[11px] font-bold text-green-400 uppercase">
                                            <span>Nội dung CK (BẮT BUỘC):</span>
                                        </div>
                                        <div class="flex justify-between items-center mt-1">
                                            <div class="font-black text-green-400 text-[15px] bg-green-900/40 px-2 py-1 rounded">
                                                {{ ($settings['transfer_prefix'] ?? 'NAP SHOPNICKVN ') . (Auth::check() ? Auth::id() : '12345') }}</div>
                                            <button data-copy="{{ ($settings['transfer_prefix'] ?? 'NAP SHOPNICKVN ') . (Auth::check() ? Auth::id() : '12345') }}"
                                                class="btn-copy bg-green-500/20 text-green-400 p-1.5 rounded hover:bg-green-500 hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="w-full md:w-1/3 flex flex-col gap-4 border-l border-slate-700 md:pl-6">
                                <h3 class="font-bold text-[15px] text-white border-l-4 border-primary pl-2 mb-1">Xác nhận nạp tiền</h3>
                                <p class="text-xs text-slate-400 leading-relaxed mb-1">Sau khi chuyển khoản thành công, hãy nhập số tiền và bấm nút bên dưới để hệ thống đối soát.</p>
                                <form id="form-mbbank-deposit" class="flex flex-col gap-3">
                                    @csrf
                                    <input type="hidden" name="bank_type" value="mbbank">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Số tiền đã chuyển <span class="text-primary">*</span></label>
                                        <div class="relative">
                                            <input type="number" name="amount" required min="10000" step="1000"
                                                class="w-full bg-primary/5 border border-primary/20 rounded-lg px-3 py-2.5 text-white text-sm focus:outline-none focus:border-primary transition-colors"
                                                placeholder="VD: 50000" />
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs font-bold">VNĐ</span>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-primary text-white font-bold h-10 rounded-lg text-sm hover:brightness-110 transition-all flex items-center justify-center gap-2 mt-2">
                                        <span class="material-symbols-outlined text-[18px]">check_circle</span> Xác nhận đã chuyển
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Nội dung Momo -->
                        <div id="momo-info" class="bank-content p-6 flex flex-col md:flex-row gap-6 items-start hidden">
                            <!-- Cột trái: QR card trắng -->
                            <div
                                class="w-full md:w-1/3 flex flex-col items-center gap-3 bg-white p-4 rounded-xl shadow-inner border-2 border-[#a50064]">
                                <h3
                                    class="text-slate-800 font-bold text-center border-b border-dashed border-slate-300 pb-2 w-full uppercase text-sm">
                                    Quét mã QR để chuyển nhanh</h3>
                                <div class="qr-code-wrapper bg-white">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=2|99|{{ $settings['momo_number'] ?? '0889639655' }}|{{ urlencode($settings['momo_owner'] ?? 'VU DUY BINH') }}||0|0|0|{{ urlencode(($settings['transfer_prefix'] ?? 'NAP SHOPNICKVN ') . (Auth::check() ? Auth::id() : '12345')) }}"
                                        alt="QR Code Momo">
                                </div>
                                <p class="text-[11px] text-slate-500 text-center italic">* Mở app Momo → Quét mã (Tự động điền Lời nhắn)</p>
                            </div>

                            <!-- Cột giữa: Thông tin -->
                            <div class="w-full md:w-1/3 flex flex-col gap-3">
                                <h3 class="font-bold text-[15px] text-white border-l-4 border-[#a50064] pl-2 mb-1">Thông tin ví Momo</h3>

                                <div class="space-y-2">
                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-slate-700/50">
                                        <span class="text-[11px] text-slate-400">Ứng dụng:</span>
                                        <div class="font-bold text-white text-sm">Ví MoMo</div>
                                    </div>

                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-slate-700/50">
                                        <span class="text-[11px] text-slate-400">Chủ tài khoản:</span>
                                        <div class="font-bold text-white text-sm uppercase">{{ $settings['momo_owner'] ?? 'VU DUY BINH' }}</div>
                                    </div>

                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-[#a50064]/30 relative">
                                        <span class="text-[11px] text-slate-400">Số điện thoại:</span>
                                        <div class="flex justify-between items-center">
                                            <div class="font-bold text-[#a50064] text-base">{{ $settings['momo_number'] ?? '0889639655' }}</div>
                                            <button data-copy="{{ $settings['momo_number'] ?? '0889639655' }}"
                                                class="btn-copy bg-[#a50064]/20 text-[#a50064] p-1.5 rounded hover:bg-[#a50064] hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-1 p-2 bg-black/20 rounded-lg border border-green-500/30">
                                        <div class="flex justify-between items-center text-[11px] font-bold text-green-400 uppercase">
                                            <span>Lời nhắn (BẮT BUỘC):</span>
                                        </div>
                                        <div class="flex justify-between items-center mt-1">
                                            <div class="font-black text-green-400 text-[15px] bg-green-900/40 px-2 py-1 rounded">
                                                {{ ($settings['transfer_prefix'] ?? 'NAP SHOPNICKVN ') . (Auth::check() ? Auth::id() : '12345') }}</div>
                                            <button data-copy="{{ ($settings['transfer_prefix'] ?? 'NAP SHOPNICKVN ') . (Auth::check() ? Auth::id() : '12345') }}"
                                                class="btn-copy bg-green-500/20 text-green-400 p-1.5 rounded hover:bg-green-500 hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">content_copy</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-1/3 flex flex-col gap-4 border-l border-slate-700 md:pl-6">
                                <h3 class="font-bold text-[15px] text-white border-l-4 border-[#a50064] pl-2 mb-1">Xác nhận nạp tiền</h3>
                                <p class="text-xs text-slate-400 leading-relaxed mb-1">Hãy chuyển tiền trước, sau đó lưu lại số tiền và nhấn nút xác nhận bên dưới hệ thống duyệt!</p>
                                <form id="form-momo-deposit" class="flex flex-col gap-3">
                                    @csrf
                                    <input type="hidden" name="bank_type" value="momo">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400 mb-1">Số tiền đã chuyển <span class="text-primary">*</span></label>
                                        <div class="relative">
                                            <input type="number" name="amount" required min="10000" step="1000"
                                                class="w-full bg-primary/5 border border-primary/20 rounded-lg px-3 py-2.5 text-white text-sm focus:outline-none focus:border-primary transition-colors"
                                                placeholder="VD: 50000" />
                                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 text-xs font-bold">VNĐ</span>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-[#a50064] text-white font-bold h-10 rounded-lg text-sm hover:brightness-110 transition-all flex items-center justify-center gap-2 mt-2">
                                        <span class="material-symbols-outlined text-[18px]">check_circle</span> Xác nhận đã chuyển
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Bảng Lịch Sự -->
            <div class="bg-background-dark border border-slate-700/60 rounded-xl overflow-hidden mb-10 shadow-lg">
                <div class="px-6 py-4 border-b border-primary/20 bg-primary/5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">history</span>
                    <h2 class="font-bold text-lg text-white uppercase">Lịch sử chuyển khoản (Đang duyệt)</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[700px]">
                        <thead>
                            <tr class="bg-black/30 text-slate-400 text-sm border-b border-slate-700">
                                <th class="p-4 font-bold">Thời gian</th>
                                <th class="p-4 font-bold">Người nạp</th>
                                <th class="p-4 font-bold">Phương thức</th>
                                <th class="p-4 font-bold text-right">Số tiền CK</th>
                                <th class="p-4 font-bold text-right">Thực nhận (+15%)</th>
                                <th class="p-4 font-bold text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-800">
                            @forelse($recentBankDeposits as $deposit)
                            <tr class="history-row bg-white/5">
                                <td class="p-4 text-slate-300">{{ $deposit->created_at->diffForHumans() }}</td>
                                <td class="p-4 font-bold text-white">
                                    @php
                                        $name = $deposit->user->username ?? $deposit->user->name ?? 'Khách';
                                        $hiddenName = strlen($name) > 4 ? '...' . substr($name, -4) : $name;
                                    @endphp
                                    {{ $hiddenName }}
                                </td>
                                <td class="p-4">
                                    @if($deposit->deposit_category_id == 4)
                                    <span class="bg-blue-900/50 text-blue-300 text-[10px] font-bold px-2 py-1 rounded uppercase border border-blue-500/30">MB Bank</span>
                                    @elseif($deposit->deposit_category_id == 5)
                                    <span class="bg-[#a50064]/20 text-[#ff80cd] text-[10px] font-bold px-2 py-1 rounded uppercase border border-[#a50064]/50">Momo</span>
                                    @else
                                    <span class="bg-purple-900/50 text-purple-300 text-[10px] font-bold px-2 py-1 rounded uppercase border border-purple-500/30">{{ $deposit->category->name ?? 'Bank' }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-right font-bold text-slate-300">{{ number_format($deposit->amount, 0, ',', '.') }}đ</td>
                                <td class="p-4 text-right font-bold text-green-400">{{ number_format($deposit->received_amount ?? ($deposit->amount * 1.15), 0, ',', '.') }}đ</td>
                                <td class="p-4 text-center">
                                    @if($deposit->status == 'pending')
                                    <span class="inline-flex items-center gap-1 bg-yellow-500/20 text-yellow-400 text-[11px] font-bold px-2 py-1 rounded border border-yellow-500/30">
                                        <span class="material-symbols-outlined text-[14px]">pending</span> Chờ duyệt
                                    </span>
                                    @elseif($deposit->status == 'approved')
                                    <span class="inline-flex items-center gap-1 bg-green-500/20 text-green-400 text-[11px] font-bold px-2 py-1 rounded border border-green-500/30">
                                        <span class="material-symbols-outlined text-[14px]">check_circle</span> Hoàn thành
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 bg-red-500/20 text-red-400 text-[11px] font-bold px-2 py-1 rounded border border-red-500/30">
                                        <span class="material-symbols-outlined text-[14px]">error</span> Thất bại
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-4 text-center text-slate-500">Chưa có giao dịch chuyển khoản nào gần đây.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/napnganhang.js') }}"></script>
@endpush
