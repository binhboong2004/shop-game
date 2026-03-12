@extends('clients.layouts.master')

@section('title', 'Hỗ trợ - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/hotro.css') }}">
@endpush

@section('content')
    <div class="py-10">

            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-slate-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-lg mr-1">home</span>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-sm mx-1">chevron_right</span>
                            <span class="text-slate-300">Hỗ trợ</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="mb-10 text-center">
                <h1 class="text-3xl md:text-4xl font-black mb-4 uppercase text-white tracking-tight">Trung Tâm Hỗ Trợ
                </h1>
                <p class="text-slate-400 max-w-2xl mx-auto">Chúng tôi luôn ở đây để giúp đỡ bạn. Vui lòng tham khảo các
                    câu hỏi thường gặp hoặc gửi yêu cầu hỗ trợ nếu bạn cần giải quyết vấn đề.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cột trái: Form & Liên hệ -->
                <div class="lg:col-span-1 flex flex-col gap-6">
                    <!-- Liên hệ trực tiếp -->
                    <div class="bg-primary/5 border border-primary/20 rounded-xl p-6">
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">contact_support</span>
                            Liên Hệ Trực Tiếp
                        </h2>
                        <ul class="flex flex-col gap-4">
                            <li class="flex items-start gap-4">
                                <div
                                    class="size-10 bg-primary/10 rounded-full flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined">call</span>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">Hotline</p>
                                    <p class="text-lg font-bold text-white">{{ $settings['hotline'] ?? '0889.639.655' }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div
                                    class="size-10 bg-primary/10 rounded-full flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined">mail</span>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">Email</p>
                                    <p class="text-base font-bold text-white">{{ $settings['email'] ?? 'hotro@shopnickvn.vn' }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div
                                    class="size-10 bg-primary/10 rounded-full flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined">schedule</span>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 font-bold uppercase mb-1">Thời gian làm việc</p>
                                    <p class="text-base font-bold text-white">{{ $settings['work_time'] ?? '08:00 - 23:00 hàng ngày' }}</p>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-6 pt-6 border-t border-primary/20 flex gap-4">
                            <a href="{{ $settings['zalo_link'] ?? '#' }}" target="_blank"
                                class="flex-1 bg-[#0068FF] text-white flex items-center justify-center gap-2 py-2 rounded-lg font-bold hover:brightness-110 transition-all">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a1/Zalo_Logo.svg/512px-Zalo_Logo.svg.png"
                                    class="size-5" alt="Zalo" /> Zalo
                            </a>
                            <a href="{{ $settings['facebook_link'] ?? '#' }}" target="_blank"
                                class="flex-1 bg-[#0866FF] text-white flex items-center justify-center gap-2 py-2 rounded-lg font-bold hover:brightness-110 transition-all">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b8/2021_Facebook_icon.svg/2048px-2021_Facebook_icon.svg.png"
                                    class="size-5" alt="Facebook" /> Messenger
                            </a>
                        </div>
                    </div>

                    <!-- Form gửi yêu cầu -->
                    <div class="bg-background-dark border border-primary/20 rounded-xl p-6 shadow-xl">
                        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">mail</span>
                            Gửi Yêu Cầu Hỗ Trợ
                        </h2>
                        <form id="support-form" class="flex flex-col gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Chủ đề hỗ trợ</label>
                                <select
                                    class="w-full bg-primary/5 border border-primary/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition-colors">
                                    <option value="" disabled selected>Chọn chủ đề...</option>
                                    <option value="buy">Lỗi mua nick</option>
                                    <option value="deposit">Lỗi nạp tiền</option>
                                    <option value="account">Lỗi đăng nhập/mật khẩu</option>
                                    <option value="other">Báo lỗi hệ thống / Khác</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Mã đơn hàng / ID (Nếu
                                    có)</label>
                                <input type="text"
                                    class="w-full bg-primary/5 border border-primary/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition-colors"
                                    placeholder="Ví dụ: #55291" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-400 mb-1">Nội dung chi tiết</label>
                                <textarea rows="4" required
                                    class="w-full bg-primary/5 border border-primary/20 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-primary transition-colors"
                                    placeholder="Vui lòng mô tả chi tiết vấn đề bạn đang gặp phải..."></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-primary text-white font-bold h-12 rounded-lg hover:brightness-110 transition-all flex items-center justify-center gap-2 mt-2">
                                <span class="material-symbols-outlined">send</span> Gửi Yêu Cầu
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Cột phải: FAQ -->
                <div class="lg:col-span-2">
                    <div class="bg-primary/5 border border-primary/20 rounded-xl p-6 h-full">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">help</span>
                            Câu Hỏi Thường Gặp (FAQ)
                        </h2>

                        <div class="flex flex-col gap-3" id="faq-accordion">
                            <!-- FAQ Item 1 -->
                            <div
                                class="faq-item bg-background-dark border border-primary/10 rounded-lg overflow-hidden transition-all duration-300">
                                <button
                                    class="faq-btn flex w-full items-center justify-between p-4 text-left font-bold text-white hover:text-primary transition-colors">
                                    <span>Làm thế nào để mua nick trên ShopNickVN?</span>
                                    <span
                                        class="material-symbols-outlined transition-transform duration-300 faq-icon shrink-0">expand_more</span>
                                </button>
                                <div
                                    class="faq-content hidden px-4 pb-4 text-sm text-slate-400 border-t border-primary/10 pt-3">
                                    <p>Bước 1: Đăng nhập hoặc tạo tài khoản mới.<br>
                                        Bước 2: Nạp tiền vào tài khoản thông qua Thẻ cào, Momo hoặc Ngân hàng.<br>
                                        Bước 3: Chọn game, tìm nick ưng ý và bấm "Mua ngay".<br>
                                        Bước 4: Vào mục "Lịch sử mua nick" để lấy tài khoản và mật khẩu.</p>
                                </div>
                            </div>

                            <!-- FAQ Item 2 -->
                            <div
                                class="faq-item bg-background-dark border border-primary/10 rounded-lg overflow-hidden transition-all duration-300">
                                <button
                                    class="faq-btn flex w-full items-center justify-between p-4 text-left font-bold text-white hover:text-primary transition-colors">
                                    <span>Nạp tiền bị lỗi/chưa cộng tiền phải làm sao?</span>
                                    <span
                                        class="material-symbols-outlined transition-transform duration-300 faq-icon shrink-0">expand_more</span>
                                </button>
                                <div
                                    class="faq-content hidden px-4 pb-4 text-sm text-slate-400 border-t border-primary/10 pt-3">
                                    <p>Nếu bạn nạp thẻ cào, vui lòng chờ hệ thống duyệt (thường từ 1-5 phút). Đối với
                                        nạp qua ngân hàng/Momo, nếu sau 10 phút chưa thấy cộng tiền, vui lòng cung cấp
                                        hình ảnh gửi vào mục "Gửi Yêu Cầu Hỗ Trợ" hoặc nhắn qua Fanpage/Zalo để admin
                                        kiểm tra và cộng tay.</p>
                                </div>
                            </div>

                            <!-- FAQ Item 3 -->
                            <div
                                class="faq-item bg-background-dark border border-primary/10 rounded-lg overflow-hidden transition-all duration-300">
                                <button
                                    class="faq-btn flex w-full items-center justify-between p-4 text-left font-bold text-white hover:text-primary transition-colors">
                                    <span>Mua nick về có được đổi mật khẩu không?</span>
                                    <span
                                        class="material-symbols-outlined transition-transform duration-300 faq-icon shrink-0">expand_more</span>
                                </button>
                                <div
                                    class="faq-content hidden px-4 pb-4 text-sm text-slate-400 border-t border-primary/10 pt-3">
                                    <p>Tất cả các tài khoản trên ShopNickVN đều được kèm thông tin bảo mật. Bạn CẦN PHẢI
                                        đổi lại mật khẩu và cập nhật thông tin bảo mật của cá nhân bạn ngay lập tức.</p>
                                </div>
                            </div>

                            <!-- FAQ Item 4 -->
                            <div
                                class="faq-item bg-background-dark border border-primary/10 rounded-lg overflow-hidden transition-all duration-300">
                                <button
                                    class="faq-btn flex w-full items-center justify-between p-4 text-left font-bold text-white hover:text-primary transition-colors">
                                    <span>Chính sách bảo hành như thế nào?</span>
                                    <span
                                        class="material-symbols-outlined transition-transform duration-300 faq-icon shrink-0">expand_more</span>
                                </button>
                                <div
                                    class="faq-content hidden px-4 pb-4 text-sm text-slate-400 border-t border-primary/10 pt-3">
                                    <p>Shop cam kết bảo hành 100% trong vòng 24h đầu nếu nick bị lỗi đăng nhập không
                                        phải do người mua thay đổi. Nếu nick bị ban hoặc lỗi xác minh, bạn sẽ được hoàn
                                        tiền hoặc đổi nick khác.</p>
                                </div>
                            </div>

                            <!-- FAQ Item 5 -->
                            <div
                                class="faq-item bg-background-dark border border-primary/10 rounded-lg overflow-hidden transition-all duration-300">
                                <button
                                    class="faq-btn flex w-full items-center justify-between p-4 text-left font-bold text-white hover:text-primary transition-colors">
                                    <span>Vòng quay may mắn có chắc chắn trúng nick không?</span>
                                    <span
                                        class="material-symbols-outlined transition-transform duration-300 faq-icon shrink-0">expand_more</span>
                                </button>
                                <div
                                    class="faq-content hidden px-4 pb-4 text-sm text-slate-400 border-t border-primary/10 pt-3">
                                    <p>Tùy thuộc vào loại vòng quay bạn chọn. Một số vòng quay cam kết 100% trúng tài
                                        khoản. Xin vui lòng đọc kỹ thể lệ ở từng vòng quay trước khi tiến hành quay.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Banner dưới FAQ -->
                        <div
                            class="mt-8 rounded-xl bg-gradient-to-r from-primary/20 to-transparent p-6 border border-primary/20 flex flex-col sm:flex-row items-center justify-between gap-6">
                            <div>
                                <h3 class="text-lg font-bold text-white mb-2">Vẫn chưa tìm thấy câu trả lời?</h3>
                                <p class="text-sm text-slate-400">Đội ngũ của chúng tôi đang trực tuyến. Đừng ngần ngại
                                    nhắn tin ngay!</p>
                            </div>
                            <button
                                class="shrink-0 bg-primary text-white font-bold h-10 px-6 rounded-lg hover:brightness-110 transition-all flex items-center gap-2"
                                onclick="document.getElementById('chat-toggle-btn').click()">
                                <span class="material-symbols-outlined">chat</span> Chat Với Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/hotro.js') }}"></script>
@endpush
