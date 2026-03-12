@extends('clients.layouts.master')

@section('title', 'Lịch sử nạp tiền - ShopNickVN')

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
                    <span class="text-slate-200">Lịch sử nạp tiền</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 sticky top-24">
                <!-- Avatar & Info -->
                <div class="flex flex-col items-center mb-6 pb-6 border-b border-primary/10 relative">
                    <div class="size-24 rounded-full border-[3px] border-primary p-1 shadow-[0_0_15px_rgba(231,8,20,0.5)] mb-4 relative group cursor-pointer">
                        <img src="{{ Auth::user()->avatar ?? 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}" alt="Avatar"
                            class="w-full h-full object-cover rounded-full bg-background-dark">
                    </div>
                    <h3 class="font-bold text-xl text-white text-center mb-1">{{ Auth::user()->name ?? 'Người dùng' }}</h3>
                    <span class="text-primary text-xs font-bold bg-primary/10 px-3 py-1 rounded-full mb-3">
                        @if(Auth::user()->role == 'admin') Quản trị @elseif(Auth::user()->role == 'agent') Đại lý @else Thành viên @endif
                    </span>
                    <div class="w-full bg-background-dark border border-primary/20 rounded-xl p-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-400">Số dư:</span>
                        <span class="font-bold text-lg text-primary">{{ number_format(Auth::user()->balance ?? 0, 0, ',', '.') }}đ</span>
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

                    <a href="{{ route('thongtincanhan') }}#tab-password" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">password</span>
                            Đổi mật khẩu
                        </div>
                    </a>

                    <a href="{{ route('lichsunaptien') }}" class="active flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all bg-primary text-white shadow-[0_4px_15px_rgba(231,8,20,0.4)]">
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

                    <a href="#"
                        class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                        <span class="material-symbols-outlined text-[20px] text-primary">history</span>
                        Lịch sử quay
                    </a>

                    <a href="#"
                        class="px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-primary/10 flex items-center gap-3 transition-colors border-t border-primary/10">
                        <span class="material-symbols-outlined text-[20px] text-primary">payment_arrow_down</span>
                        Rút vật phẩm
                    </a>

                    <a href="{{ route('dangnhap') }}" class="logout-btn flex items-center justify-between w-full px-4 py-3 mt-4 border border-red-500/30 rounded-xl text-sm font-medium transition-all text-red-500 hover:bg-red-500 hover:text-white">
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

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-primary/10">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-3xl text-primary">account_balance_wallet</span>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Lịch sử nạp tiền</h2>
                            <p class="text-sm text-slate-400 mt-1">Quản lý và theo dõi các giao dịch nạp quỹ của bạn.</p>
                        </div>
                    </div>
                    <!-- Nút nạp tiền nhanh -->
                    <a href="{{ route('napthecao') }}" class="group flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl font-bold bg-primary text-white hover:brightness-110 shadow-[0_4px_15px_rgba(231,8,20,0.4)] transition-all flex-shrink-0">
                        <span class="material-symbols-outlined text-[20px]">add_circle</span>
                        <span>Nạp thêm</span>
                    </a>
                </div>

                <!-- Table Container -->
                <div class="bg-background-dark/50 border border-primary/20 rounded-xl overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-300 uppercase bg-primary/10 border-b border-primary/20">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-xl">Mã GD</th>
                                <th scope="col" class="px-6 py-4">Số tiền</th>
                                <th scope="col" class="px-6 py-4">Phương thức</th>
                                <th scope="col" class="px-6 py-4">Thời gian</th>
                                <th scope="col" class="px-6 py-4 rounded-tr-xl">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary/10">
                            @forelse($deposits as $deposit)
                            <tr class="hover:bg-primary/5 transition-colors">
                                <td class="px-6 py-4 font-medium text-white whitespace-nowrap">#NT{{ $deposit->id }}</td>
                                <td class="px-6 py-4 font-bold @if($deposit->status == 'approved') text-green-400 @elseif($deposit->status == 'pending') text-yellow-400 @else text-red-500 @endif">+{{ number_format($deposit->amount, 0, ',', '.') }}đ</td>
                                <td class="px-6 py-4 text-slate-300">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-slate-400">
                                            @if(in_array($deposit->deposit_category_id ?? 0, [4, 5])) account_balance @else credit_card @endif
                                        </span>
                                        {{ $deposit->category->name ?? 'Nạp tiền' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-400">{{ $deposit->created_at->format('H:i - d/m/Y') }}</td>
                                <td class="px-6 py-4">
                                    @if($deposit->status == 'approved')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-500/10 text-green-500 border border-green-500/20 w-max inline-block">Thành công</span>
                                    @elseif($deposit->status == 'pending')
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 flex items-center gap-1 w-max">
                                            <span class="material-symbols-outlined text-[14px]">hourglass_empty</span>
                                            Đang chờ
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-500/10 text-red-500 border border-red-500/20 flex items-center gap-1 w-max" title="{{ $deposit->admin_note ?? 'Thất bại' }}">
                                            <span class="material-symbols-outlined text-[14px]">error</span>
                                            Thất bại
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                    Bạn chưa có giao dịch nạp tiền nào.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($deposits->count() > 0)
                    <div class="flex items-center justify-between p-4 border-t border-primary/20 bg-background-dark/30">
                        <span class="text-sm text-slate-400">Trang {{ $deposits->currentPage() }} / {{ max(1, $deposits->lastPage()) }} (Tổng {{ $deposits->total() }} GD)</span>
                        <div class="flex gap-1">
                            @if ($deposits->onFirstPage())
                            <button class="flex items-center justify-center size-8 rounded-lg bg-primary/10 text-slate-400 transition-colors cursor-not-allowed opacity-50" disabled>
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                            </button>
                            @else
                            <a href="{{ $deposits->previousPageUrl() }}" class="flex items-center justify-center size-8 rounded-lg bg-primary/10 text-slate-400 hover:text-white hover:bg-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                            </a>
                            @endif

                            <button class="flex items-center justify-center size-8 rounded-lg border border-primary bg-primary text-white font-bold transition-colors">{{ $deposits->currentPage() }}</button>

                            @if ($deposits->hasMorePages())
                            <a href="{{ $deposits->nextPageUrl() }}" class="flex items-center justify-center size-8 rounded-lg bg-primary/10 text-slate-400 hover:text-white hover:bg-primary transition-colors">
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </a>
                            @else
                            <button class="flex items-center justify-center size-8 rounded-lg bg-primary/10 text-slate-400 transition-colors cursor-not-allowed opacity-50" disabled>
                                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection