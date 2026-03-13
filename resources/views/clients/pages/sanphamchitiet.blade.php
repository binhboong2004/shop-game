@extends('clients.layouts.master')

@section('title', 'ShopNick - Chi tiết tài khoản')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/clients/css/sanphamchitiet.css') }}">
@endpush

@section('content')
<div class="py-10 product-detail-container">
    <!-- Breadcrumb -->
    <div class="breadcrumb text-slate-300">
        <a href="{{ url('/') }}" class="hover:text-primary transition-colors">Trang chủ</a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <a href="{{ url('sanpham') }}" class="hover:text-primary transition-colors">Sản phẩm</a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <span class="text-slate-500">{{ $account->gameCategory->name ?? 'Danh mục' }}</span>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <span class="text-primary font-bold">Nick #{{ $account->id }}</span>
    </div>

    <!-- Chi tiết sản phẩm top -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
        <!-- Cột trái: Hình ảnh -->
        <div class="lg:col-span-7 flex flex-col gap-4">
            <!-- Hình ảnh lớn -->
            <div class="relative w-full aspect-video rounded-xl overflow-hidden border border-border-muted bg-surface/50 group/main-image">
                    <img src="{{ (is_array($account->images) && count($account->images) > 0) ? (Str::startsWith($account->images[0], 'http') ? $account->images[0] : asset($account->images[0])) : 'https://placehold.co/800x450?text=No+Image' }}"
                    id="main-product-image"
                    alt="Ảnh tài khoản #{{ $account->id }}"
                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105 cursor-zoom-in">

                <!-- Nút hướng -->
                <button id="prev-img-btn" class="absolute top-1/2 -translate-y-1/2 left-4 size-10 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-primary transition-colors opacity-0 group-hover/main-image:opacity-100 z-10 cursor-pointer">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button id="next-img-btn" class="absolute top-1/2 -translate-y-1/2 right-4 size-10 rounded-full bg-black/50 text-white flex items-center justify-center hover:bg-primary transition-colors opacity-0 group-hover/main-image:opacity-100 z-10 cursor-pointer">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>
            </div>

            <!-- Danh sách hình ảnh nhỏ -->
            @if(is_array($account->images) && count($account->images) > 0)
            <div class="flex gap-4 overflow-x-auto thumb-scroll pb-2 mt-2">
                @foreach($account->images as $index => $image)
                <button class="flex-shrink-0 w-32 aspect-video rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-primary' : 'border-transparent' }} hover:border-primary/50 transition-all cursor-pointer thumb-btn {{ $index === 0 ? '' : 'opacity-70 hover:opacity-100' }}">
                    <img src="{{ Str::startsWith($image, 'http') ? $image : asset($image) }}" alt="Thumb {{ $index }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif

            <!-- Mô tả chi tiết -->
            <div class="mt-8">
                <h3 class="flex items-center gap-2 text-xl font-black text-slate-100 mb-4 border-b border-border-muted pb-3">
                    <span class="material-symbols-outlined text-primary">description</span>
                    Mô tả chi tiết
                </h3>
                <div class="text-base text-slate-300 space-y-3 leading-relaxed">
                    {!! nl2br(e($account->description ?? 'Đang cập nhật mô tả...')) !!}
                </div>
            </div>
        </div>

        <!-- Cột phải: Thông tin -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <!-- Hộp thông tin chính -->
            <div class="product-info-box flex flex-col">
                <div class="flex items-start justify-between mb-6 pb-4 border-b border-primary/20">
                    <h1 class="text-2xl font-black text-white uppercase leading-snug">
                        {{ $account->title }}
                    </h1>
                    <button onclick="toggleWishlist('{{ $account->id }}', this)" class="text-slate-400 hover:text-primary transition-colors flex items-center justify-center mt-1">
                        <span class="material-symbols-outlined text-2xl {{ in_array($account->id, $wishlistedIds ?? []) ? 'text-primary' : '' }}" title="Yêu thích">favorite</span>
                    </button>
                </div>

                <!-- Bảng thông số -->
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-sm border-b border-border-muted pb-3 border-dashed">
                        <div class="flex items-center gap-2 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">tag</span>
                            <span>Mã số</span>
                        </div>
                        <div class="font-bold flex items-center gap-2 cursor-pointer copy-icon group" title="Nhấp để copy">
                            <span class="text-primary group-hover:text-white transition-colors">#{{ $account->id }}</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center text-sm border-b border-border-muted pb-3 border-dashed">
                        <div class="flex items-center gap-2 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">category</span>
                            <span>Danh mục</span>
                        </div>
                        <div class="font-bold text-slate-100">
                            {{ $account->gameCategory->name ?? 'N/A' }}
                        </div>
                    </div>

                    @foreach($account->accountAttributes as $attr)
                    <div class="flex justify-between items-center text-sm border-b border-border-muted pb-3 border-dashed">
                        <div class="flex items-center gap-2 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            <span>{{ optional($attr->attribute)->name ?? 'Không rõ' }}</span>
                        </div>
                        <div class="font-bold text-slate-100">
                            {{ $attr->value }}
                        </div>
                    </div>
                    @endforeach

                    <div class="flex justify-between items-center text-sm border-b border-border-muted pb-3 border-dashed">
                        <div class="flex items-center gap-2 text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">security</span>
                            <span>Tình trạng</span>
                        </div>
                        <div class="font-bold text-green-500">
                            {{ $account->status == 'active' ? 'Đang bán' : 'Đã bán' }}
                        </div>
                    </div>
                </div>

                <!-- Giá & Nút mua -->
                <div class="flex flex-col gap-1 mb-6">
                    @if($account->original_price && $account->original_price > $account->price)
                    <span class="text-slate-500 text-sm line-through font-medium">{{ number_format($account->original_price, 0, ',', '.') }}đ</span>
                    @endif
                    <div class="text-4xl font-black text-primary">{{ number_format($account->price, 0, ',', '.') }}đ</div>
                </div>

                <div class="flex flex-col gap-3 mt-auto">
                    <button onclick="buyNowGlobal('{{ $account->id }}')" class="w-full bg-primary hover:bg-primary/90 text-white font-black py-4 rounded-lg flex items-center justify-center gap-2 text-lg shadow-lg shadow-primary/30 transition-all hover:scale-[1.02]">
                        MUA NGAY
                    </button>
                    <button onclick="addToCartGlobal('{{ $account->id }}', this)" class="w-full bg-surface border border-primary/30 hover:bg-primary/10 text-primary hover:text-white font-bold py-3.5 rounded-lg flex items-center justify-center gap-2 transition-all">
                        <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                        THÊM VÀO GIỎ HÀNG
                    </button>
                </div>

                <div class="flex items-center justify-center gap-6 mt-6">
                    <div class="flex items-center gap-2 text-xs text-green-500/80">
                        <span class="material-symbols-outlined text-[16px]">verified</span>
                        Giao dịch tự động
                    </div>
                    <div class="flex items-center gap-2 text-xs text-green-500/80">
                        <span class="material-symbols-outlined text-[16px]">support_agent</span>
                        Hỗ trợ 24/7
                    </div>
                </div>
            </div>

            <!-- Box Liên hệ hỗ trợ nhanh -->
            <div class="bg-surface/50 border border-border-muted rounded-xl p-5 flex items-center justify-between mt-2">
                <div class="flex items-center gap-3">
                    <div class="size-10 bg-primary/20 text-primary rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined">headset_mic</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-slate-100">Cần tư vấn thêm?</h4>
                        <p class="text-xs text-slate-400">Chat ngay với admin để được hỗ trợ</p>
                    </div>
                </div>
                <!-- Cập nhật theo style mobile menu faq... -->
                <button onclick="document.getElementById('chat-toggle-btn').click()" class="px-4 py-2 border border-primary/30 text-primary hover:bg-primary hover:text-white text-xs font-bold rounded-lg transition-colors uppercase">
                    Chat ngay
                </button>
            </div>
        </div>
    </div>

    <!-- Tài khoản tương tự -->
    @if(isset($relatedAccounts) && $relatedAccounts->count() > 0)
    <div class="mt-16">
        <div class="flex items-center justify-between mb-6 pb-2 border-b-2 border-primary w-fit pr-10">
            <h2 class="text-2xl font-black text-white uppercase flex items-center gap-3">
                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                Tài khoản tương tự
            </h2>
        </div>

        <div class="product-grid grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4 mt-6">
            @foreach($relatedAccounts as $related)
            <!-- Product Card -->
            <div class="group bg-surface rounded-xl border border-border-muted hover:border-primary/50 transition-all hover:shadow-2xl hover:shadow-primary/10 flex flex-col overflow-hidden">
                <div class="relative aspect-square overflow-hidden bg-black/20">
                    @if(!empty($related->badge) || !isset($related->badge))
                        <div class="absolute top-2 left-2 z-10 bg-primary text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded leading-none">{{ $related->badge ?: 'HOT' }}</div>
                    @endif
                    <button onclick="toggleWishlist('{{ $related->id }}', this)" class="absolute top-2 right-2 z-10 size-7 sm:size-8 bg-black/40 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[16px] sm:text-[20px] {{ in_array($related->id, $wishlistedIds ?? []) ? 'text-primary' : '' }}">favorite</span>
                    </button>
                    <!-- Ảnh nền -->
                    @php
                        $bgImage = '';
                        if (is_array($related->images) && count($related->images) > 0) {
                            $bgImage = \Illuminate\Support\Str::startsWith($related->images[0], 'http') ? $related->images[0] : asset($related->images[0]);
                        }
                    @endphp
                    <a href="{{ route('sanphamchitiet', $related->id) }}" class="block w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                        style="background-image: url('{{ $bgImage }}');">
                    </a>
                    <!-- Gradient và MS -->
                    <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-surface to-transparent flex items-end p-3 sm:p-4 pb-2 sm:pb-3 pointer-events-none">
                        <span class="text-xs sm:text-sm font-bold text-primary">MS: #{{ $related->id }}</span>
                    </div>
                </div>

                <div class="p-3 sm:p-4 pt-1 sm:pt-2 flex flex-col flex-grow">
                    <div class="mb-4">
                        <h3 class="font-bold text-[14px] sm:text-base text-slate-100 group-hover:text-primary transition-colors truncate" title="{{ $related->title }}">
                            <a href="{{ route('sanphamchitiet', $related->id) }}">{{ $related->title }}</a>
                        </h3>
                        <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 truncate">{{ $related->gameCategory->name ?? '' }}</p>
                    </div>

                    <div class="mt-auto flex items-center justify-between gap-1 overflow-hidden">
                        <div class="text-[15px] sm:text-lg font-black text-primary truncate">{{ number_format($related->price, 0, ',', '.') }}đ</div>
                        <button onclick="addToCartGlobal('{{ $related->id }}', this)" class="flex-shrink-0 bg-primary hover:bg-red-600 text-white px-2.5 sm:px-3 py-1.5 sm:py-2 rounded-lg text-[11px] sm:text-xs font-bold transition-all flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">shopping_cart</span>
                            MUA
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-8">
            <a href="{{ url('sanpham') }}" class="px-6 py-2 border border-primary text-primary font-bold text-sm rounded-lg hover:bg-primary hover:text-white transition-all uppercase">
                Xem tất cả
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Lightbox Modal -->
<div id="image-lightbox" class="fixed inset-0 z-[9999] bg-black/95 backdrop-blur-sm flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 exit-scale">
    <button id="close-lightbox" class="absolute top-6 right-6 text-white/70 hover:text-primary transition-colors z-[10000] p-2 hover:bg-white/10 rounded-full">
        <span class="material-symbols-outlined text-4xl">close</span>
    </button>
    <div class="relative max-w-[95vw] max-h-[90vh] flex items-center justify-center p-4">
        <img id="lightbox-img" src="" alt="Phóng to" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl transition-transform duration-500">
    </div>
</div>

<style>
    #image-lightbox.active {
        opacity: 1;
        pointer-events: auto;
    }
    .cursor-zoom-in {
        cursor: zoom-in;
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mainImage = document.getElementById('main-product-image');
        const thumbs = document.querySelectorAll('.thumb-btn');
        const prevBtn = document.getElementById('prev-img-btn');
        const nextBtn = document.getElementById('next-img-btn');
        
        if (!mainImage || thumbs.length === 0) return;

        let currentIndex = 0;

        function updateMainImage(index) {
            thumbs.forEach(t => {
                t.classList.remove('border-primary', 'opacity-100');
                t.classList.add('border-transparent', 'opacity-70');
            });
            
            thumbs[index].classList.add('border-primary', 'opacity-100');
            thumbs[index].classList.remove('border-transparent', 'opacity-70');
            
            const newSrc = thumbs[index].querySelector('img').src;
            mainImage.src = newSrc;
            currentIndex = index;
            
            thumbs[index].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }

        thumbs.forEach((thumb, index) => {
            thumb.addEventListener('click', () => updateMainImage(index));
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                let newIndex = currentIndex - 1;
                if (newIndex < 0) newIndex = thumbs.length - 1;
                updateMainImage(newIndex);
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                let newIndex = currentIndex + 1;
                if (newIndex >= thumbs.length) newIndex = 0;
                updateMainImage(newIndex);
            });
        }

        // Lightbox Logic
        const lightbox = document.getElementById('image-lightbox');
        const lightboxImg = document.getElementById('lightbox-img');
        const closeLightbox = document.getElementById('close-lightbox');

        if (mainImage && lightbox && lightboxImg) {
            mainImage.addEventListener('click', function() {
                lightboxImg.src = this.src;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden'; // Ngăn cuộn trang
            });

            const closeAction = () => {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            };

            closeLightbox.addEventListener('click', closeAction);
            lightbox.addEventListener('click', function(e) {
                if (e.target === lightbox || e.target.closest('.relative') === null && e.target !== lightboxImg) {
                    closeAction();
                }
            });

            // Đóng bằng phím ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                    closeAction();
                }
            });
        }
    });

    // Copy ID functionality
    document.querySelector('.copy-icon')?.addEventListener('click', function() {
        const id = '{{ $account->id }}';
        navigator.clipboard.writeText(id).then(() => {
            window.showToast('Đã copy mã số: #' + id, 'success');
        });
    });
</script>
<script src="{{ asset('assets/clients/js/sanphamchitiet.js') }}"></script>
@endpush