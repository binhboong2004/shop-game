@extends('clients.layouts.master')

@section('title', 'Lịch sử quay - ShopNickVN')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/clients/css/thongtincanhan.css') }}">
@endpush

@section('content')
<div class="mt-8 mb-16 max-w-6xl mx-auto w-full">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-slate-400 mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="{{ url('/') }}" class="hover:text-primary flex items-center transition-colors">
                    <span class="material-symbols-outlined text-lg mr-1">home</span>
                    Trang chủ
                </a>
            </li>
            <li class="inline-flex items-center">
                <span class="material-symbols-outlined text-sm mx-1">chevron_right</span>
                <a href="{{ route('thongtincanhan') }}" class="hover:text-primary transition-colors">Thông tin cá nhân</a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-sm mx-1">chevron_right</span>
                    <span class="text-slate-200">Lịch sử quay</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar (Reuse from layout or other pages) -->
        <div class="lg:col-span-1">
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 sticky top-24">
                <div class="flex flex-col items-center mb-6 pb-6 border-b border-primary/10 relative">
                    <div class="size-24 rounded-full border-[3px] border-primary p-1 shadow-[0_0_15px_rgba(231,8,20,0.5)] mb-4 relative group cursor-pointer">
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}" alt="Avatar"
                            class="w-full h-full object-cover rounded-full bg-background-dark">
                    </div>
                    <h3 class="font-bold text-xl text-white text-center mb-1">{{ Auth::user()->name }}</h3>
                    <span class="text-primary text-xs font-bold bg-primary/10 px-3 py-1 rounded-full mb-3">{{ Auth::user()->level ?: 'Thành viên' }}</span>
                    <div class="w-full bg-background-dark border border-primary/20 rounded-xl p-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-400">Số dư:</span>
                        <span class="font-bold text-lg text-primary">{{ number_format(Auth::user()->balance, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex flex-col gap-2">
                    <a href="{{ route('thongtincanhan') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                            Thông tin chung
                        </div>
                    </a>

                    <a href="{{ route('lichsunaptien') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                            Lịch sử nạp tiền
                        </div>
                    </a>

                    <a href="{{ route('lichsumuahang') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">history</span>
                            Lịch sử mua hàng
                        </div>
                    </a>

                    <a href="{{ route('lichsuquay') }}" class="active flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all bg-primary text-white shadow-[0_4px_15px_rgba(231,8,20,0.4)]">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">casino</span>
                            Lịch sử quay
                        </div>
                    </a>

                    <a href="#"
                        class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                        <span class="material-symbols-outlined text-[20px] text-primary">payment_arrow_down</span>
                        Rút vật phẩm
                    </a>

                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn flex items-center justify-between w-full px-4 py-3 mt-4 border border-red-500/30 rounded-xl text-sm font-medium transition-all text-red-500 hover:bg-red-500 hover:text-white">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">logout</span>
                            Đăng xuất
                        </div>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 sm:p-8 relative overflow-hidden h-full">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-[80px] -z-10 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-primary/10">
                    <span class="material-symbols-outlined text-3xl text-primary">casino</span>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Lịch sử quay vòng quay</h2>
                        <p class="text-sm text-slate-400 mt-1">Theo dõi các lượt quay và phần quà bạn đã nhận được.</p>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="bg-background-dark/50 border border-primary/20 rounded-xl overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-300 uppercase bg-primary/10 border-b border-primary/20">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-xl">ID</th>
                                <th scope="col" class="px-6 py-4">Vòng quay</th>
                                <th scope="col" class="px-6 py-4">Phần quà</th>
                                <th scope="col" class="px-6 py-4">Chi phí</th>
                                <th scope="col" class="px-6 py-4">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary/10">
                            @forelse($histories as $history)
                                <tr class="hover:bg-primary/5 transition-colors">
                                    <td class="px-6 py-4 font-medium text-white whitespace-nowrap">#{{ $history->id }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-200">
                                            {{ $history->prize && $history->prize->luckyWheel ? $history->prize->luckyWheel->name : 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-primary">
                                        {{ $history->prize ? $history->prize->name : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ number_format($history->spin_cost, 0, ',', '.') }}đ
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 whitespace-nowrap">{{ $history->created_at->format('H:i - d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        Bạn chưa thực hiện lượt quay nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($histories->hasPages())
                    <div class="p-4 border-t border-primary/20">
                        {{ $histories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
