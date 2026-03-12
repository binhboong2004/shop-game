@extends('clients.layouts.master')

@section('title', 'ShopNick - Danh sách tài khoản game')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/sanpham.css') }}">
@endpush

@section('content')
<div class="py-5">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-6">
                    <div>
                        <h2 class="text-lg font-bold flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary">filter_list</span>
                            Bộ lọc tìm kiếm
                        </h2>
                        <!-- Filter Groups -->
                        <div class="space-y-4">
                            <!-- Price Range -->
                            @php
                                $selectedPrices = request()->price ? explode(',', request()->price) : [];
                                $isPriceOpen = count($selectedPrices) > 0;
                            @endphp
                            <details class="group border-b border-border-muted pb-4" {{ $isPriceOpen ? 'open' : '' }}>
                                <summary class="flex items-center justify-between cursor-pointer list-none font-medium text-sm">
                                    Khoảng giá
                                    <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                                </summary>
                                <div class="mt-4 space-y-2">
                                    <label class="flex items-center gap-2 text-sm text-slate-400 hover:text-slate-100 cursor-pointer">
                                        <input type="checkbox" name="price" value="0-100000" class="rounded border-border-muted bg-surface text-primary focus:ring-primary filter-input" 
                                            @if(in_array('0-100000', $selectedPrices)) checked @endif />
                                        Dưới 100k
                                    </label>
                                    <label class="flex items-center gap-2 text-sm text-slate-400 hover:text-slate-100 cursor-pointer">
                                        <input type="checkbox" name="price" value="100000-500000" class="rounded border-border-muted bg-surface text-primary focus:ring-primary filter-input"
                                            @if(in_array('100000-500000', $selectedPrices)) checked @endif />
                                        100k - 500k
                                    </label>
                                    <label class="flex items-center gap-2 text-sm text-slate-400 hover:text-slate-100 cursor-pointer">
                                        <input type="checkbox" name="price" value="500000-2000000" class="rounded border-border-muted bg-surface text-primary focus:ring-primary filter-input"
                                            @if(in_array('500000-2000000', $selectedPrices)) checked @endif />
                                        500k - 2 triệu
                                    </label>
                                    <label class="flex items-center gap-2 text-sm text-slate-400 hover:text-slate-100 cursor-pointer">
                                        <input type="checkbox" name="price" value="2000000-above" class="rounded border-border-muted bg-surface text-primary focus:ring-primary filter-input"
                                            @if(in_array('2000000-above', $selectedPrices)) checked @endif />
                                        Trên 2 triệu
                                    </label>
                                </div>
                            </details>

                            <!-- Dynamic Attributes Filters -->
                            @foreach($attributes as $attribute)
                            @php
                                $reqVal = request()->get($attribute->variable_name);
                                $isNumeric = (str_contains(strtolower($attribute->name), 'số lượng') || str_contains(strtolower($attribute->name), 'level'));
                                
                                if ($isNumeric) {
                                    $currentMin = request()->get($attribute->variable_name . '_min', $attribute->min_val);
                                    $currentMax = request()->get($attribute->variable_name . '_max', $attribute->max_val);
                                    $isAttrOpen = request()->has($attribute->variable_name . '_min');
                                } else {
                                    $selectedOptions = $reqVal ? explode(',', $reqVal) : [];
                                    $isAttrOpen = count($selectedOptions) > 0;
                                }
                            @endphp
                            <details class="group border-b border-border-muted pb-4" {{ $isAttrOpen ? 'open' : '' }}>
                                <summary class="flex items-center justify-between cursor-pointer list-none font-medium text-sm text-slate-200">
                                    {{ $attribute->name }}
                                    <span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
                                </summary>
                                <div class="mt-4">
                                    @if($isNumeric)
                                        <div class="space-y-4 px-1">
                                            <div class="flex items-center justify-between text-[11px] text-primary font-bold">
                                                <span id="label-{{ $attribute->variable_name }}-min">{{ $currentMin }}</span>
                                                <span id="label-{{ $attribute->variable_name }}-max">{{ $currentMax }}</span>
                                            </div>
                                            <div class="relative h-2 bg-surface rounded-full border border-border-muted flex items-center">
                                                <input type="range" name="{{ $attribute->variable_name }}_min" 
                                                    min="{{ $attribute->min_val }}" max="{{ $attribute->max_val }}" value="{{ $currentMin }}"
                                                    class="absolute w-full h-1 bg-transparent appearance-none cursor-pointer z-10 range-input range-min"
                                                    data-target="label-{{ $attribute->variable_name }}-min">
                                                <input type="range" name="{{ $attribute->variable_name }}_max" 
                                                    min="{{ $attribute->min_val }}" max="{{ $attribute->max_val }}" value="{{ $currentMax }}"
                                                    class="absolute w-full h-1 bg-transparent appearance-none cursor-pointer z-20 range-input range-max"
                                                    data-target="label-{{ $attribute->variable_name }}-max">
                                            </div>
                                            <div class="text-[10px] text-slate-500 text-center italic">Kéo để chọn khoảng</div>
                                        </div>
                                    @elseif($attribute->options)
                                        <div class="@if($attribute->type == 'select' || $attribute->type == 'text') grid grid-cols-2 gap-2 @else space-y-2 @endif">
                                            @foreach($attribute->options as $option)
                                                @php
                                                    $isActive = in_array($option, $selectedOptions);
                                                @endphp
                                                @if($attribute->type == 'select' || $attribute->type == 'text')
                                                    <button type="button" data-name="{{ $attribute->variable_name }}" data-value="{{ $option }}"
                                                        class="filter-btn px-3 py-1.5 text-xs rounded border transition-colors {{ $isActive ? 'border-primary text-primary bg-primary/10' : 'border-border-muted hover:border-primary hover:text-primary' }}">
                                                        {{ $option }}
                                                    </button>
                                                @else
                                                    <label class="flex items-center gap-2 text-sm text-slate-400 hover:text-slate-100 cursor-pointer">
                                                        <input type="checkbox" name="{{ $attribute->variable_name }}" value="{{ $option }}"
                                                            class="rounded border-border-muted bg-surface text-primary focus:ring-primary filter-input" {{ $isActive ? 'checked' : '' }} />
                                                        {{ $option }}
                                                    </label>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </details>
                            @endforeach
                        </div>
                        <button class="w-full mt-6 bg-primary text-white py-2 rounded-lg font-bold text-sm hover:brightness-110 transition-all" onclick="applyFilters()">
                            ÁP DỤNG BỘ LỌC
                        </button>
                        <button class="w-full mt-2 text-slate-400 py-2 rounded-lg font-medium text-sm hover:text-slate-100 transition-all" onclick="resetFilters()">
                            Xóa tất cả
                        </button>
                    </div>
                </div>
            </aside>
            <!-- Main Content -->
            <div class="flex-1">
                <!-- Header & Sorting -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                            <a class="hover:text-primary" href="{{ url('/') }}">Trang chủ</a>
                            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                            <span class="text-slate-300">Sản phẩm</span>
                            @if($currentGame)
                            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                            <a class="hover:text-primary" href="{{ url('sanpham') }}?game={{ $currentGame->slug }}">{{ $currentGame->name }}</a>
                            @endif
                            @if($currentCategory)
                            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                            <span class="text-slate-300">{{ $currentCategory->name }}</span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-black text-slate-100 uppercase leading-none">
                            {{ $currentCategory ? $currentCategory->name : ($currentGame ? $currentGame->name : 'TẤT CẢ SẢN PHẨM') }}
                        </h1>
                        <p class="text-slate-400 text-sm mt-1">Tìm thấy {{ number_format($accounts->total()) }} tài khoản phù hợp</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-slate-400 whitespace-nowrap">Sắp xếp:</span>
                        <select id="sort-select" onchange="applyFilters()"
                            class="bg-[#2d1215] border-primary/20 rounded-lg text-sm px-4 py-2 focus:ring-primary focus:border-primary text-slate-100 outline-none">
                            <option value="latest" class="bg-[#2d1215]" @selected(request()->sort == 'latest')>Mới nhất</option>
                            <option value="price_asc" class="bg-[#2d1215]" @selected(request()->sort == 'price_asc')>Giá thấp đến cao</option>
                            <option value="price_desc" class="bg-[#2d1215]" @selected(request()->sort == 'price_desc')>Giá cao đến thấp</option>
                        </select>
                    </div>
                </div>
                <!-- Product Grid -->
                <div class="product-grid grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5 gap-3">
                    @forelse($accounts as $account)
                    @php
                        $thumbnail = asset('assets/clients/images/no-image.jpg');
                        if (is_array($account->images) && count($account->images) > 0) {
                            $firstImg = $account->images[0];
                            if (Str::startsWith($firstImg, 'http')) {
                                $thumbnail = $firstImg;
                            } elseif (Str::startsWith($firstImg, 'aida-public/')) {
                                $thumbnail = 'https://lh3.googleusercontent.com/' . $firstImg;
                            } elseif (Str::startsWith($firstImg, 'storage/')) {
                                $thumbnail = asset($firstImg);
                            } else {
                                $thumbnail = asset('storage/' . $firstImg);
                            }
                        }
                    @endphp
                    <div class="group bg-surface rounded-xl overflow-hidden border border-border-muted hover:border-primary/50 transition-all hover:shadow-2xl hover:shadow-primary/10 flex flex-col h-full">
                        <div class="relative aspect-video overflow-hidden flex-shrink-0">
                            @if($account->badge)
                            <div class="absolute top-2 left-2 z-10 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded">
                                {{ $account->badge }}
                            </div>
                            @endif
                            <button onclick="toggleWishlist({{ $account->id }})"
                                class="absolute top-2 right-2 z-10 size-8 bg-black/40 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg wishlist-icon-{{ $account->id }} @if(in_array($account->id, $wishlistedIds)) fill-1 text-primary @endif">favorite</span>
                            </button>
                            <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                                style="background-image: url('{{ $thumbnail }}');">
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-surface to-transparent p-3">
                                <span class="text-xs font-bold text-primary">MS: {{ $account->id }}</span>
                            </div>
                        </div>
                        <div class="p-3 flex flex-col flex-1 gap-3">
                            <div class="space-y-1">
                                <h3 class="font-bold text-slate-100 group-hover:text-primary transition-colors line-clamp-2 text-sm leading-snug h-10">{{ $account->title }}</h3>
                                <p class="text-[11px] text-slate-500 line-clamp-1 italic">{{ $account->gameCategory->name ?? 'N/A' }}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-1.5 overflow-hidden">
                                @foreach($account->accountAttributes->take(2) as $accAttr)
                                <div class="flex items-center justify-between text-[10px] text-slate-400">
                                    <span class="opacity-70">{{ $accAttr->attribute->name }}:</span>
                                    <span class="font-medium text-slate-300">{{ $accAttr->value }}</span>
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-auto pt-3 border-t border-border-muted">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="text-base font-black text-primary truncate">{{ number_format($account->price) }}đ</div>
                                    <a href="{{ route('sanphamchitiet', $account->id) }}"
                                        class="bg-primary text-white p-2 rounded-lg text-[10px] font-bold hover:brightness-110 transition-all flex items-center gap-1 flex-shrink-0">
                                        <span class="material-symbols-outlined text-xs">shopping_cart</span>
                                        CHI TIẾT
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full py-12 text-center text-slate-500">
                        Không tìm thấy tài khoản nào phù hợp.
                    </div>
                    @endforelse
                </div>
                <!-- Pagination -->
                <div class="mt-12 flex justify-center items-center gap-2">
                    {{ $accounts->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/sanpham.js') }}"></script>
@endpush
