@extends('clients.layouts.master')

@section('title', 'Giỏ hàng - ShopNickVN')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/clients/css/giohang.css') }}">
@endpush

@section('content')
<div class="py-6 sm:py-10">
    <div class="mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-orange-500">Giỏ hàng của bạn</h1>
        <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm sm:text-base">Kiểm tra thông tin sản phẩm và mã giảm giá trước khi thanh toán.</p>
    </div>

    <!-- Giỏ hàng content -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Cột trái: Danh sách sản phẩm -->
        <div class="w-full lg:w-2/3 flex flex-col gap-4" id="cart-items-container">
            @if($carts->isEmpty())
                <div class="bg-white dark:bg-[#1a1c23] rounded-xl p-8 text-center border border-slate-200 dark:border-slate-800 shadow-sm">
                    <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4">production_quantity_limits</span>
                    <h3 class="text-xl font-bold mb-2">Giỏ hàng của bạn đang trống</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Hãy thêm sản phẩm vào giỏ hàng để tiến hành thanh toán.</p>
                    <a href="{{ url('/sanpham') }}" class="inline-flex items-center gap-2 bg-[#E70814] hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-bold transition-colors shadow-md my-shadow-red">
                        <span class="material-symbols-outlined text-[20px]">shopping_bag</span>
                        Tiếp tục mua sắm
                    </a>
                </div>
            @else
                @foreach($carts as $cart)
                <div class="cart-item bg-white dark:bg-[#1a1c23] rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4 border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:border-red-500/30" data-id="{{ $cart->account_id }}" data-price="{{ $cart->account->price }}">
                    <div class="w-full sm:w-24 h-24 rounded-lg overflow-hidden shrink-0 border border-slate-100 dark:border-slate-700 relative">
                        <img src="{{ isset($cart->account->images) && is_array($cart->account->images) && count($cart->account->images) > 0 ? (Str::startsWith($cart->account->images[0], 'http') ? $cart->account->images[0] : asset($cart->account->images[0])) : 'https://images.unsplash.com/photo-1542751371-adc38448a05e' }}" alt="Nick Game" class="w-full h-full object-cover">
                        <div class="absolute top-1 left-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">MS: {{ $cart->account->id }}</div>
                    </div>
                    <div class="flex-1 flex flex-col gap-1 w-full">
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-bold text-lg leading-tight hover:text-red-500 transition-colors cursor-pointer line-clamp-2">{{ $cart->account->title }}</h3>
                            <button class="remove-item text-slate-400 hover:text-red-500 transition-colors p-1" title="Xóa" data-id="{{ $cart->account_id }}">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </button>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $cart->account->gameCategory->name ?? 'Tài khoản Game' }} | {{ Str::limit($cart->account->description, 50) }}</p>
                        <div class="flex justify-between items-center mt-2 w-full">
                            <div class="flex flex-col">
                                <span class="font-bold text-red-500 text-lg">{{ number_format($cart->account->price, 0, ',', '.') }}đ</span>
                                @if($cart->account->original_price)
                                <span class="text-sm text-slate-400 line-through">{{ number_format($cart->account->original_price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                            <div class="flex items-center bg-slate-100 dark:bg-[#15171c] border border-slate-200 dark:border-slate-700 rounded-lg p-1">
                                <input type="number" class="w-12 text-center bg-transparent border-none text-sm font-bold focus:ring-0 p-1 text-slate-700 dark:text-slate-200" value="1" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Cột phải: Tổng quan đơn hàng -->
        <div class="w-full lg:w-1/3">
            <div class="bg-white dark:bg-[#1a1c23] rounded-xl p-5 sm:p-6 border border-slate-200 dark:border-slate-800 shadow-sm sticky top-24">
                <h3 class="font-bold text-xl mb-4 border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-500">receipt_long</span>
                    Thông tin thanh toán
                </h3>
                
                <div class="flex flex-col gap-3 text-sm sm:text-base mb-4">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-500 dark:text-slate-400">Tạm tính:</span>
                        <span class="font-medium" id="subtotal">750,000đ</span>
                    </div>
                    <div class="flex justify-between items-center text-emerald-500 hidden" id="discount-row">
                        <span>Mã giảm giá:</span>
                        <span class="font-medium" id="discount-amount">-0đ</span>
                    </div>
                </div>

                <!-- Nhập mã giảm giá -->
                <div class="mb-5 pb-5 border-b border-slate-100 dark:border-slate-800">
                    <p class="text-sm font-medium mb-2 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px] text-orange-500">local_activity</span>
                        Mã ưu đãi
                    </p>
                    <div class="flex gap-2">
                        <input type="text" id="coupon-code" placeholder="Nhập mã (nếu có)" class="flex-1 bg-slate-50 dark:bg-[#15171c] border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors uppercase font-medium">
                        <button id="apply-coupon" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 px-4 py-2.5 rounded-lg text-sm font-bold transition-colors">Áp dụng</button>
                    </div>
                    <p id="coupon-message" class="text-xs mt-2 hidden font-medium transition-all"></p>
                </div>

                <div class="flex justify-between items-end mb-6">
                    <span class="font-bold text-lg">Tổng cộng:</span>
                    <span class="font-bold text-2xl text-red-500 drop-shadow-sm" id="total-price">750,000đ</span>
                </div>

                <button id="btn-checkout" class="w-full bg-[#E70814] hover:bg-red-700 text-white rounded-xl py-3.5 sm:py-4 font-bold text-base sm:text-lg flex justify-center items-center gap-2 transition-all shadow-lg shadow-red-500/20 hover:shadow-red-500/40 transform hover:-translate-y-0.5 group">
                    <span class="material-symbols-outlined text-[22px]">shopping_cart_checkout</span>
                    Tiến hành thanh toán
                </button>
                
                <div class="mt-5 flex flex-col gap-2">
                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-[#15171c] p-2.5 rounded-lg border border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-[18px] text-emerald-500">verified_user</span>
                        <span>Giao dịch an toàn và bảo mật 100%</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-[#15171c] p-2.5 rounded-lg border border-slate-100 dark:border-slate-800">
                        <span class="material-symbols-outlined text-[18px] text-blue-500">support_agent</span>
                        <span>Hỗ trợ khách hàng 24/7 trực tuyến</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="delete-modal-backdrop"></div>
    <div class="bg-white dark:bg-[#1a1c23] rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 relative z-10 scale-95 transition-transform duration-300 transform-gpu" id="delete-modal-content">
        <div class="w-16 h-16 bg-red-100 dark:bg-red-500/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white dark:border-[#1a1c23] shadow-lg">
            <span class="material-symbols-outlined text-3xl">delete_forever</span>
        </div>
        <h3 class="text-xl font-bold text-center mb-2">Xóa sản phẩm?</h3>
        <p class="text-slate-500 dark:text-slate-400 text-center mb-6 text-sm">Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?</p>
        <div class="flex gap-3">
            <button id="cancel-delete" class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 py-2.5 rounded-xl font-bold transition-all hover:shadow-md">Hủy</button>
            <button id="confirm-delete" class="flex-1 bg-[#E70814] hover:bg-red-700 text-white py-2.5 rounded-xl font-bold transition-all shadow-md shadow-red-500/20 hover:shadow-red-500/40">Xóa ngay</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/clients/js/giohang.js') }}"></script>
@endpush
