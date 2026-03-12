@extends('clients.layouts.master')

@section('title', 'Tài khoản yêu thích - ShopNickVN')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/clients/css/yeuthich.css') }}">
@endpush

@section('content')
<div class="py-6 sm:py-10">
    <div class="mb-6 max-w-3xl mx-auto flex items-end justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-500 to-orange-500 mb-2">Tài khoản yêu thích</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base">Bạn đang lưu <span id="wishlist-count" class="font-bold text-white">4</span> tài khoản trong danh sách quan tâm.</p>
        </div>
    </div>

    <!-- Yêu thích content -->
    <div class="max-w-3xl mx-auto flex flex-col gap-4">
        
        <div id="wishlist-items-container" class="flex flex-col gap-4">
            @if($wishlists->isEmpty())
                <div class="bg-white dark:bg-[#15171c] rounded-xl p-8 text-center border border-slate-200 dark:border-slate-800 shadow-sm">
                    <span class="material-symbols-outlined text-6xl text-slate-300 dark:text-slate-600 mb-4">heart_broken</span>
                    <h3 class="text-xl font-bold mb-2">Chưa có tài khoản yêu thích</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-6">Bạn chưa lưu tài khoản nào vào danh sách yêu thích.</p>
                    <a href="{{ url('/sanpham') }}" class="inline-flex items-center gap-2 bg-[#E70814] hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-bold transition-colors shadow-md shadow-red-500/20">
                        Khám phá sản phẩm
                    </a>
                </div>
            @else
                @foreach($wishlists as $wishlist)
                <div class="wishlist-item relative bg-white dark:bg-[#15171c] rounded-xl p-4 flex flex-col sm:flex-row items-center gap-4 sm:gap-5 border border-slate-200 dark:border-slate-800 hover:border-red-500/40 shadow-sm transition-all group overflow-hidden" data-id="{{ $wishlist->account_id }}">
                    <!-- Hình ảnh -->
                    <div class="w-full sm:w-36 h-36 rounded-lg overflow-hidden shrink-0 border border-slate-100 dark:border-slate-800 shadow-inner relative cursor-pointer" onclick="window.location.href=`{{ url('/sanphamchitiet/' . $wishlist->account_id) }}`">
                        <img src="{{ isset($wishlist->account->images) && is_array($wishlist->account->images) && count($wishlist->account->images) > 0 ? (Str::startsWith($wishlist->account->images[0], 'http') ? $wishlist->account->images[0] : asset($wishlist->account->images[0])) : 'https://images.unsplash.com/photo-1542751371-adc38448a05e' }}" alt="Nick Game" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-1 left-1 bg-black/60 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-sm">{{ $wishlist->account->gameCategory->name ?? 'GAME' }}</div>
                    </div>
                    
                    <!-- Nút X (Góc phải trên) -->
                    <button class="remove-item absolute top-3 right-3 text-slate-400 hover:text-white transition-colors bg-slate-100 dark:bg-black/20 hover:bg-red-500 dark:hover:bg-red-500 rounded-full w-8 h-8 flex items-center justify-center backdrop-blur-sm z-10" title="Xóa khỏi yêu thích" data-id="{{ $wishlist->account_id }}">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>

                    <!-- Nội dung hiển thị -->
                    <div class="flex-1 flex flex-col justify-between h-full w-full relative z-0">
                        <div class="pr-8">
                            <a href="{{ url('sanphamchitiet/' . $wishlist->account_id) }}" class="font-bold text-lg sm:text-xl text-slate-900 dark:text-white leading-tight hover:text-red-500 transition-colors mb-2 line-clamp-1">{{ $wishlist->account->title }}</a>
                            
                            <div class="flex flex-col gap-1.5 text-slate-500 dark:text-slate-400 text-xs sm:text-sm mt-2">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-amber-500">info</span>
                                    <span>Mã số: {{ $wishlist->account->id }} | {{ Str::limit($wishlist->account->description, 60) }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mt-4 sm:mt-auto gap-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-red-500 text-xl tracking-tight">{{ number_format($wishlist->account->price, 0, ',', '.') }}đ</span>
                                @if($wishlist->account->original_price)
                                <span class="text-sm text-slate-400 line-through">{{ number_format($wishlist->account->original_price, 0, ',', '.') }}đ</span>
                                @endif
                            </div>
                            
                            <!-- Nhóm nút hành động -->
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <a href="{{ url('sanphamchitiet/' . $wishlist->account_id) }}" class="flex-1 sm:flex-none justify-center text-slate-600 dark:text-slate-300 hover:text-red-500 dark:hover:text-red-400 font-medium text-sm flex items-center gap-1 transition-colors border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 bg-slate-50 dark:bg-[#1a1c23]">
                                    <span class="material-symbols-outlined text-[16px]">info</span>
                                    Chi tiết
                                </a>
                                <button class="add-to-cart flex-[2] sm:flex-none justify-center bg-[#E70814] hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold text-sm flex items-center gap-1.5 transition-all shadow-md shadow-red-500/20" data-id="{{ $wishlist->account_id }}">
                                    <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
                                    Thêm <span class="hidden sm:inline">vào giỏ</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        <!-- Banner tiếp tục mua sắm -->
        <div id="continue-shopping-banner" class="border border-dashed border-red-900/30 dark:border-red-900/50 rounded-xl p-6 flex flex-col items-center justify-center text-center mt-2 transition-all hover:bg-red-900/5 cursor-pointer" onclick="window.location.href=`{{ url('sanpham') }}`">
            <span class="material-symbols-outlined text-[32px] text-slate-500 mb-2">add_shopping_cart</span>
            <p class="text-slate-400 text-sm font-medium">Tiếp tục mua sắm để nhận thêm ưu đãi combo</p>
            <span class="font-bold text-[#E70814] hover:text-red-400 transition-colors inline-block mt-1 relative after:content-[''] after:absolute after:-bottom-1 after:left-0 after:w-0 after:h-0.5 after:bg-red-500 hover:after:w-full after:transition-all after:duration-300">Xem thêm tài khoản khác</span>
        </div>
            
    </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="delete-modal-backdrop"></div>
    <div class="bg-white dark:bg-[#1a1c23] rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 relative z-10 scale-95 transition-transform duration-300 transform-gpu border border-slate-200 dark:border-slate-800" id="delete-modal-content">
        <div class="w-16 h-16 bg-red-50 dark:bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white dark:border-[#1a1c23] shadow-lg">
            <span class="material-symbols-outlined text-3xl">heart_broken</span>
        </div>
        <h3 class="text-xl font-bold text-center mb-2 text-slate-800 dark:text-white">Xóa khỏi yêu thích?</h3>
        <p class="text-slate-500 dark:text-slate-400 text-center mb-6 text-sm">Bạn có chắc chắn muốn bỏ lưu tài khoản game này không?</p>
        <div class="flex gap-3">
            <button id="cancel-delete" class="flex-1 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 py-2.5 rounded-xl font-bold transition-all hover:shadow-md">Hủy</button>
            <button id="confirm-delete" class="flex-1 bg-[#E70814] hover:bg-red-700 text-white py-2.5 rounded-xl font-bold transition-all shadow-md shadow-red-500/20 hover:shadow-red-500/40">Xóa ngay</button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-5 sm:bottom-10 right-5 sm:right-10 z-[100] transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none flex items-center gap-3 bg-white dark:bg-[#1a1c23] border border-slate-200 dark:border-slate-800 shadow-xl px-5 py-3.5 rounded-xl">
    <span class="material-symbols-outlined text-emerald-500 text-2xl">check_circle</span>
    <span class="text-sm font-bold text-slate-800 dark:text-white" id="toast-msg">Đã thêm vào giỏ hàng!</span>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/clients/js/yeuthich.js') }}"></script>
@endpush
