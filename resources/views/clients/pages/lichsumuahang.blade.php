@extends('clients.layouts.master')

@section('title', 'Lịch sử mua hàng - ShopNickVN')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/clients/css/thongtincanhan.css') }}">
<link rel="stylesheet" href="{{ asset('assets/clients/css/lichsumuahang.css') }}">
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
                    <span class="text-slate-200">Lịch sử mua hàng</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
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

                    <a href="{{ route('thongtincanhan') }}#tab-password" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">password</span>
                            Đổi mật khẩu
                        </div>
                    </a>

                    <a href="{{ route('lichsunaptien') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">account_balance_wallet</span>
                            Lịch sử nạp tiền
                        </div>
                    </a>

                    <a href="{{ route('lichsumuahang') }}" class="active flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all bg-primary text-white shadow-[0_4px_15px_rgba(231,8,20,0.4)]">
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

                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-primary/10">
                    <span class="material-symbols-outlined text-3xl text-primary">history_toggle_off</span>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Lịch sử mua hàng</h2>
                        <p class="text-sm text-slate-400 mt-1">Danh sách các nick game và dịch vụ bạn đã thanh toán.</p>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="bg-background-dark/50 border border-primary/20 rounded-xl overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-slate-300 uppercase bg-primary/10 border-b border-primary/20">
                            <tr>
                                <th scope="col" class="px-6 py-4 rounded-tl-xl">Mã Đơn</th>
                                <th scope="col" class="px-6 py-4">Tên sản phẩm</th>
                                <th scope="col" class="px-6 py-4">Tổng tiền</th>
                                <th scope="col" class="px-6 py-4">Thông tin (TK/MK)</th>
                                <th scope="col" class="px-6 py-4">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-primary/10">
                            @forelse($orders as $order)
                                <tr class="hover:bg-primary/5 transition-colors">
                                    <td class="px-6 py-4 font-medium text-white whitespace-nowrap">#OD{{ $order->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3 w-48 sm:w-auto">
                                            <div class="size-10 rounded-lg overflow-hidden flex-shrink-0 border border-primary/20 bg-primary/10 text-primary flex items-center justify-center">
                                                @if($order->account && $order->account->gameCategory && $order->account->gameCategory->image)
                                                    <img src="{{ asset('storage/' . $order->account->gameCategory->image) }}" class="w-full h-full object-cover" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png'">
                                                @else
                                                    <span class="material-symbols-outlined text-[20px]">sports_esports</span>
                                                @endif
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-200">
                                                    @if($order->account && $order->account->gameCategory)
                                                        Nick {{ $order->account->gameCategory->name }} #{{ $order->account->id }}
                                                    @else
                                                        Sản phẩm #{{ $order->account_id }}
                                                    @endif
                                                </span>
                                                <span class="text-xs text-slate-400 line-clamp-1">
                                                    {{ $order->account ? $order->account->description : 'Đã bị xóa' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-primary">{{ number_format($order->amount - $order->discount_amount, 0, ',', '.') }}đ</span>
                                            @if($order->discount_amount > 0)
                                                <span class="text-xs text-slate-500 line-through">{{ number_format($order->amount, 0, ',', '.') }}đ</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($order->account)
                                            <div class="flex flex-col gap-1 min-w-[200px]">
                                                <div class="flex items-center justify-between bg-black/40 px-2 py-1 rounded">
                                                    <span class="text-xs text-slate-400">TK: <span class="text-slate-200 account-text">{{ $order->account->account_username }}</span></span>
                                                    <button class="text-primary hover:text-white transition-colors copy-btn" data-copy="{{ $order->account->account_username }}" title="Sao chép"><span class="material-symbols-outlined text-[14px]">content_copy</span></button>
                                                </div>
                                                <div class="flex items-center justify-between bg-black/40 px-2 py-1 rounded">
                                                    <span class="text-xs text-slate-400">MK: <span class="text-slate-200 password-text">**********</span></span>
                                                    <button class="text-primary hover:text-white transition-colors view-pass-btn" data-password="{{ $order->account->account_password }}" title="Xem/Ẩn mật khẩu"><span class="material-symbols-outlined text-[14px]">visibility</span></button>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">Không có thông tin</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 whitespace-nowrap">{{ $order->created_at->format('H:i - d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        Bạn chưa có giao dịch mua hàng nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                    <div class="flex items-center justify-between p-4 border-t border-primary/20 bg-background-dark/30">
                        <span class="text-sm text-slate-400">Trang {{ $orders->currentPage() }} / {{ $orders->lastPage() }} (Tổng {{ $orders->total() }} Đơn)</span>
                        <div class="flex gap-1">
                            {{ $orders->links() }}
                        </div>
                    </div>
                    @else
                    <div class="flex items-center justify-between p-4 border-t border-primary/20 bg-background-dark/30">
                        <span class="text-sm text-slate-400">Trang 1 / 1 (Tổng {{ $orders->total() }} Đơn)</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/clients/js/lichsumuahang.js') }}"></script>
@endpush