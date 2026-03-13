@extends('clients.layouts.master')

@section('title', 'Mã Giảm Giá - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/magiamgia.css') }}">
@endpush

@section('content')
    <div class="py-10">
            <!-- Hero -->
            <section class="mt-6">
                <div
                    class="coupon-hero flex flex-col items-center justify-center text-center rounded-xl p-8 md:p-12 relative overflow-hidden min-h-[260px]">
                    <div class="coupon-hero-bg"></div>
                    <div class="z-10 flex flex-col gap-3 items-center">
                        <div
                            class="inline-flex items-center gap-2 bg-primary px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest text-white">
                            <span class="material-symbols-outlined text-[16px]">local_fire_department</span> Ưu đãi có
                            hạn
                        </div>
                        <h1 class="text-white text-3xl md:text-5xl font-black leading-tight tracking-tight">KHO MÃ GIẢM
                            GIÁ KHỦNG</h1>
                        <p class="text-slate-300 text-sm md:text-base max-w-xl">Săn ngay voucher giảm giá lên đến <span
                                class="text-primary font-bold">50%</span> khi mua nick game. Số lượng có hạn!</p>
                    </div>
                </div>
            </section>

            <!-- Stats -->
            <section class="py-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="stat-card flex flex-col items-center gap-1 p-4 rounded-xl">
                        <span class="material-symbols-outlined text-3xl text-primary">confirmation_number</span>
                        <span class="text-2xl font-black text-white">{{ $discountCodes->count() }}</span><span class="text-xs text-slate-400">Mã
                            đang có</span>
                    </div>
                    <div class="stat-card flex flex-col items-center gap-1 p-4 rounded-xl">
                        <span class="material-symbols-outlined text-3xl text-green-400">trending_up</span>
                        <span class="text-2xl font-black text-white">{{ rtrim(rtrim((string)$discountCodes->where('type', 'percent')->max('value'), '0'), '.') }}%</span><span class="text-xs text-slate-400">Giảm
                            cao nhất</span>
                    </div>
                    <div class="stat-card flex flex-col items-center gap-1 p-4 rounded-xl">
                        <span class="material-symbols-outlined text-3xl text-yellow-400">group</span>
                        <span class="text-2xl font-black text-white">{{ $discountCodes->sum('used_count') }}</span><span
                            class="text-xs text-slate-400">Lượt sử dụng</span>
                    </div>
                    <div class="stat-card flex flex-col items-center gap-1 p-4 rounded-xl">
                        <span class="material-symbols-outlined text-3xl text-blue-400">update</span>
                        <span class="text-2xl font-black text-white">24/7</span><span class="text-xs text-slate-400">Cập
                            nhật liên tục</span>
                    </div>
                </div>
            </section>

            <!-- Filter -->
            <section class="pb-6">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-2" id="filter-tabs">
                        <button class="filter-tab active" data-filter="all"><span
                                class="material-symbols-outlined text-[16px]">grid_view</span> Tất cả</button>
                        <button class="filter-tab" data-filter="percent"><span
                                class="material-symbols-outlined text-[16px]"></span> Giảm %</button>
                        <button class="filter-tab" data-filter="fixed"><span
                                class="material-symbols-outlined text-[16px]">payments</span> Giảm tiền</button>
                    </div>
                    <div class="search-input-wrapper w-full md:w-[280px]">
                        <span class="material-symbols-outlined text-[18px] text-primary/50">search</span>
                        <input type="text" id="search-coupon" placeholder="Tìm mã giảm giá..." class="search-input">
                    </div>
                </div>
            </section>

            <!-- Coupon Grid -->
            <section class="pb-10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2"><span
                            class="w-2 h-8 bg-primary rounded-full"></span>Mã Giảm Giá Đang Có</h2>
                    <span class="text-sm text-slate-400" id="coupon-count">Hiển thị {{ $discountCodes->count() }} mã</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="coupon-grid">
                    @forelse($discountCodes as $coupon)
                        @php
                            $percentageUsed = $coupon->max_uses > 0 ? min(round(($coupon->used_count / $coupon->max_uses) * 100), 100) : 0;
                            $isHot = $percentageUsed >= 80;
                            $isFreeship = $coupon->type === 'freeship';
                            $typeLabel = $isFreeship ? 'freeship' : $coupon->type;
                        @endphp
                        <div class="coupon-card" data-type="{{ $typeLabel }}" data-tag="{{ $isHot ? 'hot' : '' }}">
                            <div class="coupon-left {{ $coupon->type === 'fixed' ? 'fixed-type' : ($isFreeship ? 'freeship-type' : '') }}">
                                @if($isHot)
                                    <span class="coupon-badge hot">HOT</span>
                                @endif
                                <span class="material-symbols-outlined coupon-icon">
                                    {{ $coupon->type === 'fixed' ? 'payments' : ($isFreeship ? 'local_shipping' : 'percent') }}
                                </span>
                                <span class="coupon-value {{ $isFreeship ? 'text-lg' : '' }}">
                                    @if($isFreeship)
                                        FREE
                                    @elseif($coupon->type === 'fixed')
                                        {{ number_format($coupon->value / 1000, 0) }}K
                                    @else
                                        {{ rtrim(rtrim((string)$coupon->value, '0'), '.') }}%
                                    @endif
                                </span>
                                <span class="coupon-label">{{ $isFreeship ? 'SHIP' : 'GIẢM' }}</span>
                            </div>
                            <div class="coupon-right">
                                <div class="coupon-header">
                                    <h3 class="coupon-title">
                                        @if($isFreeship)
                                            Miễn Phí Giao Dịch
                                        @else
                                            Giảm {{ $coupon->type === 'fixed' ? number_format($coupon->value, 0, ',', '.') . 'đ' : rtrim(rtrim((string)$coupon->value, '0'), '.') . '%' }}
                                        @endif
                                    </h3>
                                    <span class="coupon-game">Toàn Shop</span>
                                </div>
                                <div class="coupon-details">
                                    <div class="coupon-detail-item">
                                        <span class="material-symbols-outlined text-[14px]">shopping_bag</span>
                                        Đơn tối thiểu: {{ number_format($coupon->min_order_amount, 0, ',', '.') }}đ
                                    </div>
                                    <div class="coupon-detail-item">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        HSD: <span class="{{ $coupon->end_date ? 'countdown' : '' }}" data-expire="{{ $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i:s') : '' }}">
                                            {{ $coupon->end_date ? '--' : 'Không giới hạn' }}
                                        </span>
                                    </div>
                                    <div class="coupon-detail-item">
                                        <span class="material-symbols-outlined text-[14px]">inventory_2</span>
                                        Còn lại: <strong class="text-primary">{{ max($coupon->max_uses - $coupon->used_count, 0) }}/{{ $coupon->max_uses }}</strong>
                                    </div>
                                </div>
                                <div class="coupon-actions">
                                    <div class="coupon-code-box"><span class="coupon-code">{{ $coupon->code }}</span></div>
                                    <button class="copy-btn" data-code="{{ $coupon->code }}">
                                        <span class="material-symbols-outlined text-[16px]">content_copy</span> Sao chép
                                    </button>
                                </div>
                                <div class="coupon-progress">
                                    <div class="coupon-progress-bar {{ $isHot ? 'warning' : '' }}" style="width: <?php echo $percentageUsed; ?>%;"></div>
                                </div>
                                <span class="coupon-progress-text {{ $isHot ? 'text-yellow-400' : '' }}">
                                    {{ $isHot ? 'Sắp hết - ' : 'Đã dùng ' }}{{ $percentageUsed }}%
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 text-center py-8 text-slate-400">
                            Hiện tại chưa có mã giảm giá nào.
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Guide -->
            <section class="pb-16">
                <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2 mb-6"><span
                        class="w-2 h-8 bg-primary rounded-full"></span>Hướng Dẫn Sử Dụng</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="guide-step">
                        <div class="guide-step-number">1</div><span
                            class="material-symbols-outlined text-3xl text-primary mb-2">content_copy</span>
                        <h3 class="font-bold text-sm mb-1">Sao chép mã</h3>
                        <p class="text-xs text-slate-400">Nhấn "Sao chép" để copy mã</p>
                    </div>
                    <div class="guide-step">
                        <div class="guide-step-number">2</div><span
                            class="material-symbols-outlined text-3xl text-primary mb-2">shopping_cart</span>
                        <h3 class="font-bold text-sm mb-1">Chọn sản phẩm</h3>
                        <p class="text-xs text-slate-400">Chọn nick game muốn mua</p>
                    </div>
                    <div class="guide-step">
                        <div class="guide-step-number">3</div><span
                            class="material-symbols-outlined text-3xl text-primary mb-2">edit_note</span>
                        <h3 class="font-bold text-sm mb-1">Nhập mã</h3>
                        <p class="text-xs text-slate-400">Dán mã vào ô khi thanh toán</p>
                    </div>
                    <div class="guide-step">
                        <div class="guide-step-number">4</div><span
                            class="material-symbols-outlined text-3xl text-primary mb-2">celebration</span>
                        <h3 class="font-bold text-sm mb-1">Nhận ưu đãi</h3>
                        <p class="text-xs text-slate-400">Giá giảm tự động, nhận nick ngay!</p>
                    </div>
                </div>
            </section>
        </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/magiamgia.js') }}"></script>
@endpush
