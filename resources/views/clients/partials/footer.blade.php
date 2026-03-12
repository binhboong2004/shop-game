        <!-- Footer -->
        <footer class="bg-primary/5 border-t border-primary/10 mt-20 pt-16 pb-8">
            <div class="max-w-[1280px] mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 text-primary mb-4">
                        <span class="material-symbols-outlined text-3xl">sports_esports</span>
                        <h1 class="text-xl font-bold tracking-tighter text-slate-100">SHOPNICKVN</h1>
                    </div>
                    <p class="text-slate-400 text-sm">Hệ thống mua bán tài khoản game uy tín hàng đầu Việt Nam. Hỗ trợ
                        24/7, giao dịch tự động.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6">Chính sách</h3>
                    <ul class="flex flex-col gap-3 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#">Điều khoản dịch vụ</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Chính sách bảo mật</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Chính sách bảo hành</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Cơ chế giải quyết tranh chấp</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6">Liên hệ</h3>
                    <ul class="flex flex-col gap-3 text-sm text-slate-500 dark:text-slate-400">
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-[18px] text-primary">call</span> 0889.639.655</li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-[18px] text-primary">mail</span>
                            hotro@shopnickvn.vn</li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-[18px] text-primary">location_on</span> Hà Đông,
                            Hà Nội</li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-[18px] text-primary">schedule</span> 08:00 - 23:00
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg mb-6">Hỗ trợ</h3>
                    <ul class="flex flex-col gap-3 text-sm text-slate-500 dark:text-slate-400">
                        <li><a class="hover:text-primary transition-colors" href="#">Hướng dẫn mua nick</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Khiếu nại - Phản hồi</a></li>
                        <li><a class="hover:text-primary transition-colors" href="#">Liên hệ Admin</a></li>
                    </ul>
                </div>
            </div>
            <div
                class="max-w-[1280px] mx-auto px-6 mt-16 pt-8 border-t border-primary/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>© 2026 ShopNickVN. Tất cả quyền được bảo lưu.</p>
                <div class="flex gap-6">
                    <span class="flex items-center gap-1"><span
                            class="material-symbols-outlined text-[14px]">bolt</span> Tự động 100%</span>
                    <span class="flex items-center gap-1"><span
                            class="material-symbols-outlined text-[14px]">verified_user</span> Bảo mật SSL</span>
                </div>
            </div>
        </footer>

    <!-- Floating Chat Button -->
    <div id="chat-wrapper" class="fixed bottom-6 right-6 z-[100] flex flex-col items-end gap-3">

        <!-- Chat Panel -->
        <div id="chat-panel"
            class="chat-panel hidden flex-col w-[340px] max-h-[520px] rounded-2xl overflow-hidden shadow-2xl shadow-primary/30 border border-primary/20"
            style="background:#1a0a0c;">
            <!-- Header -->
            <div class="flex items-center gap-3 px-4 py-3"
                style="background:linear-gradient(135deg,#e70814 0%,#9b0510 100%);">
                <div class="flex items-center justify-center size-9 rounded-full bg-white/20">
                    <span class="material-symbols-outlined text-white text-[22px]">support_agent</span>
                </div>
                <div class="flex-1">
                    <p class="text-white font-bold text-sm leading-tight">Hỗ Trợ ShopNickVN</p>
                    <p class="text-white/70 text-xs flex items-center gap-1"><span
                            class="inline-block size-2 rounded-full bg-green-400 animate-pulse"></span> Đang trực tuyến
                    </p>
                </div>
                <button id="chat-close-btn" class="text-white/70 hover:text-white transition-colors" title="Đóng">
                    <span class="material-symbols-outlined text-[22px]">close</span>
                </button>
            </div>

            <!-- Messages -->
            <div id="chat-messages" class="flex flex-col gap-3 p-4 overflow-y-auto flex-1"
                style="min-height:200px;max-height:300px;">
                <!-- Bot greeting -->
                <div class="flex items-end gap-2">
                    <div class="flex items-center justify-center size-7 rounded-full flex-shrink-0"
                        style="background:#e70814;">
                        <span class="material-symbols-outlined text-white text-[14px]">support_agent</span>
                    </div>
                    <div class="chat-bubble-bot rounded-2xl rounded-bl-none px-3 py-2 text-sm text-slate-100 max-w-[80%]"
                        style="background:#2d1215;">
                        Xin chào! Mình là trợ lý của <strong>ShopNickVN</strong>. Bạn cần hỗ trợ gì ạ? 😊
                    </div>
                </div>
            </div>

            <!-- Quick FAQ -->
            <div id="chat-faqs" class="flex flex-wrap gap-2 px-4 pb-2">
                <button
                    class="faq-btn text-[11px] px-3 py-1.5 rounded-full border border-primary/40 text-primary hover:bg-primary hover:text-white transition-all"
                    data-msg="Tôi muốn mua nick game">🛒 Mua nick</button>
                <button
                    class="faq-btn text-[11px] px-3 py-1.5 rounded-full border border-primary/40 text-primary hover:bg-primary hover:text-white transition-all"
                    data-msg="Bảo hành nick như thế nào?">🛡️ Bảo hành</button>
                <button
                    class="faq-btn text-[11px] px-3 py-1.5 rounded-full border border-primary/40 text-primary hover:bg-primary hover:text-white transition-all"
                    data-msg="Phương thức thanh toán?">💳 Thanh toán</button>
                <button
                    class="faq-btn text-[11px] px-3 py-1.5 rounded-full border border-primary/40 text-primary hover:bg-primary hover:text-white transition-all"
                    data-msg="Liên hệ Admin">📞 Liên hệ</button>
            </div>

            <!-- Input -->
            <div class="flex items-center gap-2 px-3 py-3 border-t border-primary/10">
                <input id="chat-input" type="text" placeholder="Nhập tin nhắn..."
                    class="flex-1 bg-primary/5 border border-primary/20 rounded-full px-4 py-2 text-sm text-slate-100 placeholder:text-slate-500 focus:outline-none focus:border-primary transition-colors" />
                <button id="chat-send-btn"
                    class="flex items-center justify-center size-9 rounded-full bg-primary text-white hover:brightness-110 transition-all flex-shrink-0">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </div>
        </div>

        <!-- Toggle Button -->
        <button id="chat-toggle-btn"
            class="flex size-14 items-center justify-center rounded-full bg-primary text-white shadow-lg shadow-primary/40 hover:scale-110 hover:brightness-110 transition-all cursor-pointer group"
            title="Chat với chúng tôi">
            <span id="chat-icon"
                class="material-symbols-outlined text-[32px] group-hover:rotate-12 transition-transform">chat</span>
            <span id="chat-badge" class="absolute -top-1 -right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span
                    class="relative inline-flex rounded-full h-4 w-4 bg-white text-[10px] text-primary font-bold items-center justify-center border border-primary">1</span>
            </span>
        </button>
    </div>
