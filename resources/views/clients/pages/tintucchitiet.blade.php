@extends('clients.layouts.master')

@section('title', $article->title . ' - ShopNickVN')

@section('content')
<main class="flex flex-col flex-1 max-w-[1280px] mx-auto w-full px-4 sm:px-6 py-6 md:py-10">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-primary transition-colors flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">home</span>
            Trang chủ
        </a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a href="{{ route('tintuc') }}" class="hover:text-primary transition-colors">Tin tức</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-slate-300 font-medium cursor-default truncate max-w-[200px]">{{ $article->title }}</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Left: Content -->
        <div class="flex-1 w-full bg-primary/5 rounded-2xl p-6 md:p-10 border border-primary/10">
            <div class="flex items-center gap-3 mb-6">
                <span class="bg-primary text-white text-xs font-bold px-3 py-1 rounded-full uppercase">{{ $article->type == 'event' ? 'Sự Kiện' : 'Tin Tức' }}</span>
                <span class="text-slate-400 text-sm flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">schedule</span> {{ $article->created_at->format('d/m/Y H:i') }}</span>
                <span class="text-slate-400 text-sm flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">visibility</span> {{ number_format($article->views) }} lượt xem</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-black text-white mb-8 tracking-tight leading-tight capitalize">
                {{ $article->title }}
            </h1>

            @if($article->thumbnail)
            <div class="rounded-xl overflow-hidden mb-10 aspect-video">
                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="prose prose-invert max-w-none prose-p:text-slate-300 prose-headings:text-white prose-strong:text-primary prose-a:text-primary prose-img:rounded-xl">
                {!! $article->content !!}
            </div>

            <div class="mt-12 pt-8 border-t border-primary/10 flex flex-wrap items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-slate-700 flex items-center justify-center border-2 border-primary">
                        <span class="material-symbols-outlined text-white">person</span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Được viết bài bởi</p>
                        <p class="text-white font-bold">{{ $article->author->name ?? 'Admin' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="bg-[#1877f2] text-white px-4 py-2 rounded text-xs font-bold flex items-center gap-2 hover:brightness-110 transition-all">
                        <span class="material-symbols-outlined text-[16px]">share</span> Chia sẻ Facebook
                    </button>
                </div>
            </div>
        </div>

        <!-- Right: Sidebar -->
        <aside class="w-full lg:w-[320px] flex-shrink-0 flex flex-col gap-6 sticky top-24">
            <!-- Related News -->
            <div class="bg-primary/5 rounded-2xl p-6 border border-primary/10">
                <h3 class="font-bold text-lg mb-4 text-white flex items-center gap-2 border-b border-primary/10 pb-3">
                    <span class="material-symbols-outlined text-primary">dynamic_feed</span> Tin liên quan
                </h3>
                <div class="flex flex-col gap-6">
                    @foreach($relatedArticles as $rArticle)
                    <a href="{{ route('tintucchitiet', $rArticle->slug) }}" class="group flex flex-col gap-3">
                        <div class="aspect-video rounded-xl overflow-hidden">
                            <img src="{{ $rArticle->thumbnail ? asset('storage/' . $rArticle->thumbnail) : 'https://placehold.co/300x200?text=ShopNickVN' }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        </div>
                        <h4 class="font-bold text-white text-sm line-clamp-2 group-hover:text-primary transition-colors capitalize">{{ $rArticle->title }}</h4>
                        <span class="text-[11px] text-slate-500">{{ $rArticle->created_at->format('d/m/Y') }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Trending News -->
            <div class="bg-primary/5 rounded-2xl p-6 border border-primary/10">
                <h3 class="font-bold text-lg mb-4 text-white flex items-center gap-2 border-b border-primary/10 pb-3">
                    <span class="material-symbols-outlined text-primary">local_fire_department</span> Tin nổi bật
                </h3>
                <div class="flex flex-col gap-5">
                    @foreach($trendingArticles as $tArticle)
                    <a href="{{ route('tintucchitiet', $tArticle->slug) }}" class="flex gap-4 group">
                        <div class="w-[70px] h-[50px] rounded-lg overflow-hidden flex-shrink-0">
                            <img src="{{ $tArticle->thumbnail ? asset('storage/' . $tArticle->thumbnail) : 'https://placehold.co/100x70?text=Shop' }}" alt="{{ $tArticle->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="text-xs font-bold text-white line-clamp-2 group-hover:text-primary transition-colors capitalize">{{ $tArticle->title }}</h4>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</main>
@endsection
