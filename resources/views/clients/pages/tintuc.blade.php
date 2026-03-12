@extends('clients.layouts.master')

@section('title', 'Tin Tức & Sự Kiện - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/tintuc.css') }}">
@endpush

@section('content')
    <main class="flex flex-col flex-1 max-w-[1280px] mx-auto w-full px-4 sm:px-6 py-6 md:py-10">

            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">home</span>
                    Trang chủ
                </a>
                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                <span class="text-slate-300 font-medium cursor-default">Tin tức</span>
            </div>

            <!-- Page Header -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl md:text-5xl font-black text-white mb-4 tracking-tight uppercase">Tin Tức & Sự Kiện
                </h1>
                <p class="text-slate-400 max-w-2xl mx-auto">Cập nhật những thông tin mới nhất về các giải đấu, sự kiện
                    khuyến mại và các mẹo chơi game cực đỉnh từ <span class="text-primary font-bold">SHOPNICKVN</span>.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 items-start">

                <!-- Left Column: News List -->
                <div class="flex-1 w-full flex flex-col gap-8">

                    <!-- Featured post (Bản tin nổi bật) -->
                    @if($featuredArticle)
                    <div
                        class="relative rounded-2xl overflow-hidden group hover:shadow-2xl hover:shadow-primary/20 transition-all border border-primary/10 cursor-pointer">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                            style="background-image: url('{{ $featuredArticle->thumbnail ? asset($featuredArticle->thumbnail) : 'https://game8.vn/media/202008/images/pubg-mobile-1-0-800.jpg' }}');">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#110608] via-[#110608]/80 to-transparent">
                        </div>
                        <div class="relative z-10 p-6 md:p-10 flex flex-col justify-end h-full min-h-[400px]">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-primary text-white text-xs font-bold px-3 py-1 rounded-full">{{ $featuredArticle->type == 'event' ? 'Sự Kiện' : 'Tin Tức' }}</span>
                                <span class="text-slate-300 text-sm flex items-center gap-1"><span
                                        class="material-symbols-outlined text-[16px]">schedule</span> {{ $featuredArticle->created_at->format('d/m/Y') }}</span>
                            </div>
                            <h2
                                class="text-2xl md:text-4xl font-black text-white leading-tight mb-3 group-hover:text-primary transition-colors">
                                {{ $featuredArticle->title }}</h2>
                            <p class="text-slate-300 line-clamp-2 md:line-clamp-3 mb-6">{{ Str::limit(strip_tags($featuredArticle->content), 200) }}</p>
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-slate-700 overflow-hidden border-2 border-primary border-transparent">
                                    <span class="material-symbols-outlined text-white pt-2 text-center w-full block">person</span>
                                </div>
                                <span class="text-white font-medium text-sm">Đăng bởi <span
                                        class="text-primary">{{ $featuredArticle->author->name ?? 'Admin' }}</span></span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Filter Tabs -->
                    <div
                        class="news-tabs flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none border-b border-primary/10">
                        <a href="{{ route('tintuc') }}"
                            class="news-tab {{ !request('type') ? 'active bg-primary/10 text-primary border-primary' : 'text-slate-400 hover:text-white border-transparent hover:border-slate-600' }} font-bold whitespace-nowrap px-5 py-2.5 rounded-t-lg border-b-2 transition-all">Tất
                            cả</a>
                        <a href="{{ route('tintuc', ['type' => 'news']) }}"
                            class="news-tab {{ request('type') == 'news' ? 'active bg-primary/10 text-primary border-primary font-bold' : 'text-slate-400 hover:text-white font-medium border-transparent hover:border-slate-600' }} whitespace-nowrap px-5 py-2.5 rounded-t-lg border-b-2 transition-all">Tin
                            Tức</a>
                        <a href="{{ route('tintuc', ['type' => 'event']) }}"
                            class="news-tab {{ request('type') == 'event' ? 'active bg-primary/10 text-primary border-primary font-bold' : 'text-slate-400 hover:text-white font-medium border-transparent hover:border-slate-600' }} whitespace-nowrap px-5 py-2.5 rounded-t-lg border-b-2 transition-all">Sự Kiện</a>
                    </div>

                    <!-- News Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="news-grid">
                        @forelse($articles as $article)
                        <!-- Article Item -->
                        <article
                            class="bg-primary/5 rounded-xl overflow-hidden border border-primary/10 group cursor-pointer hover:-translate-y-1 transition-all hover:shadow-xl hover:shadow-primary/10 hover:border-primary/30 flex flex-col h-full">
                            <div class="relative aspect-video overflow-hidden">
                                <img src="{{ $article->thumbnail ? asset($article->thumbnail) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSlQ0BFX38dEYj9fqM9syQL7OoKgXeJn9NiJw&s' }}"
                                    alt="{{ $article->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div
                                    class="absolute top-3 left-3 bg-[#e70814] text-white text-[10px] font-bold px-2.5 py-1 rounded shadow-lg uppercase tracking-wider">
                                    {{ $article->type == 'event' ? 'Sự Kiện' : 'Tin Tức' }}</div>
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <span class="text-slate-500 text-xs flex items-center gap-1.5 mb-2"><span
                                        class="material-symbols-outlined text-[14px]">calendar_today</span>
                                    {{ $article->created_at->format('d/m/Y') }}</span>
                                <h3
                                    class="font-bold text-lg md:text-xl text-white leading-snug mb-3 group-hover:text-primary transition-colors flex-1">
                                    {{ $article->title }}</h3>
                                <p class="text-slate-400 text-sm line-clamp-2 mb-4">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                                <div
                                    class="flex items-center justify-between text-xs border-t border-primary/10 pt-4 mt-auto">
                                    <span class="text-slate-500 flex items-center gap-1"><span
                                            class="material-symbols-outlined text-[14px]">visibility</span> Lượt
                                        xem</span>
                                    <span
                                        class="text-primary font-medium flex items-center gap-1 group-hover:gap-2 transition-all">Đọc
                                        tiếp <span
                                            class="material-symbols-outlined text-[16px]">arrow_forward</span></span>
                                </div>
                            </div>
                        </article>
                        @empty
                            <div class="col-span-1 md:col-span-2 text-center text-slate-400 py-10">Hiện chưa có tin tức nào.</div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($articles->hasPages())
                    <div class="mt-8">
                        {{ $articles->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                    @endif

                </div>

                <!-- Right Column: Sidebar -->
                <aside class="w-full lg:w-[320px] flex-shrink-0 flex flex-col gap-6 sticky top-24">

                    <!-- Search Widget -->
                    <div class="bg-primary/5 rounded-2xl p-6 border border-primary/10">
                        <h3 class="font-bold text-lg mb-4 text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">search</span> Tìm Kiếm Tin
                        </h3>
                        <div class="relative">
                            <input type="text" placeholder="Nhập từ khóa..."
                                class="w-full bg-background-dark border border-primary/20 rounded-lg pl-10 pr-4 py-3 text-sm text-slate-200 placeholder:text-slate-500 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all">
                            <span
                                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="bg-primary/5 rounded-2xl p-6 border border-primary/10">
                        <h3
                            class="font-bold text-lg mb-4 text-white flex items-center gap-2 border-b border-primary/10 pb-3">
                            <span class="material-symbols-outlined text-primary">category</span> Danh Mục Tin
                        </h3>
                        <ul class="flex flex-col gap-3 text-sm font-medium">
                            <li><a href="{{ route('tintuc', ['type' => 'news']) }}"
                                    class="flex items-center justify-between text-slate-400 hover:text-primary group transition-colors"><span
                                        class="flex items-center gap-2"><span
                                            class="material-symbols-outlined text-[16px] text-primary/50 group-hover:text-primary transition-colors">sports_esports</span>
                                        Tin Tức</span></a>
                            </li>
                            <li class="border-t border-white/5 pt-3"><a href="{{ route('tintuc', ['type' => 'event']) }}"
                                    class="flex items-center justify-between text-slate-400 hover:text-primary group transition-colors"><span
                                        class="flex items-center gap-2"><span
                                            class="material-symbols-outlined text-[16px] text-primary/50 group-hover:text-primary transition-colors">event</span>
                                        Sự Kiện</span></a>
                            </li>
                        </ul>
                    </div>

                    <!-- Trending News Widget -->
                    <div class="bg-primary/5 rounded-2xl p-6 border border-primary/10">
                        <h3
                            class="font-bold text-lg mb-4 text-white flex items-center gap-2 border-b border-primary/10 pb-3">
                            <span class="material-symbols-outlined text-primary">local_fire_department</span> Đọc Nhiều
                            Nhất
                        </h3>
                        <div class="flex flex-col gap-5">
                            @foreach($trendingArticles as $tArticle)
                            <a href="#" class="flex gap-4 group">
                                <div class="w-[80px] h-[60px] rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ $tArticle->thumbnail ? asset($tArticle->thumbnail) : 'https://img.utdstc.com/icon/cc2/e0f/cc2e0f7a7432a583e43ff44b472a197019dc91669e5a6c54f776c89a00b261dd:200' }}"
                                        alt="{{ $tArticle->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                </div>
                                <div class="flex flex-col justify-between">
                                    <h4
                                        class="text-sm font-bold text-white leading-tight line-clamp-2 group-hover:text-primary transition-colors">
                                        {{ $tArticle->title }}</h4>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="bg-primary/5 rounded-2xl p-6 border border-primary/10">
                        <h3
                            class="font-bold text-lg mb-4 text-white flex items-center gap-2 border-b border-primary/10 pb-3">
                            <span class="material-symbols-outlined text-primary">tag</span> Thẻ nổi bật
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="#"
                                class="px-3 py-1.5 bg-background-dark border border-primary/20 hover:border-primary text-slate-300 hover:text-primary text-xs font-medium rounded-lg transition-all">LienQuan</a>
                            <a href="#"
                                class="px-3 py-1.5 bg-background-dark border border-primary/20 hover:border-primary text-slate-300 hover:text-primary text-xs font-medium rounded-lg transition-all">FreeFire</a>
                            <a href="#"
                                class="px-3 py-1.5 bg-background-dark border border-primary/20 hover:border-primary text-slate-300 hover:text-primary text-xs font-medium rounded-lg transition-all">GiaRe</a>
                            <a href="#"
                                class="px-3 py-1.5 bg-background-dark border border-primary/20 hover:border-primary text-slate-300 hover:text-primary text-xs font-medium rounded-lg transition-all">KinhNghiem</a>
                            <a href="#"
                                class="px-3 py-1.5 bg-background-dark border border-primary/20 hover:border-primary text-slate-300 hover:text-primary text-xs font-medium rounded-lg transition-all">KhuyenMai</a>
                            <a href="#"
                                class="px-3 py-1.5 bg-background-dark border border-primary/20 hover:border-primary text-slate-300 hover:text-primary text-xs font-medium rounded-lg transition-all">NapTheKM</a>
                        </div>
                    </div>

                </aside>
            </div>

        
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/tintuc.js') }}"></script>
@endpush
