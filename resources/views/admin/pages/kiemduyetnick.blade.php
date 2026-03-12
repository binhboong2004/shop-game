@extends('admin.layouts.master')

@section('title', 'Kiểm duyệt Nick Đại lý')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/kiemduyetnick.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Kiểm duyệt Nick Đại lý</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="#" class="text-[#E70814] hover:underline">Sản phẩm & Game</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Kiểm duyệt Nick</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#20222a] hover:bg-[#2a2d35] border border-[#2a2d35] text-white px-4 py-2 rounded-md transition-colors flex items-center gap-2 text-sm font-medium mt-2 md:mt-0">
            <span class="material-symbols-outlined text-[18px]">refresh</span>
            Làm mới
        </button>
    </div>
</div>

<!-- Dashboard Widgets -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-yellow-500/10 to-transparent"></div>
        <div class="flex justify-between items-start relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang chờ duyệt</p>
                <h3 class="text-3xl font-bold text-white">{{ $pendingCount }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-yellow-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-yellow-500">pending_actions</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-yellow-500">
            <span class="material-symbols-outlined text-[16px]">info</span>
            <span class="font-medium">Cần xử lý ngay</span>
        </div>
    </div>

    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-emerald-500/10 to-transparent"></div>
        <div class="flex justify-between items-start relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã duyệt hôm nay</p>
                <h3 class="text-3xl font-bold text-white">{{ $approvedTodayCount }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-500">verified</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-emerald-400">
            <span class="material-symbols-outlined text-[16px]">trending_up</span>
            <span class="font-medium">Tài khoản mới lên kệ</span>
        </div>
    </div>

    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-red-500/10 to-transparent"></div>
        <div class="flex justify-between items-start relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã từ chối</p>
                <h3 class="text-3xl font-bold text-white">{{ $rejectedCount }}</h3>
            </div>
            <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-500">cancel</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-red-400">
            <span class="material-symbols-outlined text-[16px]">warning</span>
            <span class="font-medium">Cần đại lý sửa lại</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-6 mb-6">
    <!-- Filter Section -->
    <form method="GET" action="{{ route('admin.kiemduyetnick') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search Input -->
        <div class="relative md:col-span-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-gray-400 text-[20px]">search</span>
            </div>
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 p-2.5 transition-colors" placeholder="Tìm ID, Tên đại lý...">
        </div>

        <!-- Role Filter -->
        <div>
            <select name="game" id="gameFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block p-2.5 transition-colors appearance-none cursor-pointer">
                <option value="all">Tất cả Game</option>
                @foreach($games as $game)
                <option value="{{ $game->id }}" {{ request('game') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Status Filter -->
        <div>
            <select name="status" id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block p-2.5 transition-colors appearance-none cursor-pointer">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả Trạng thái</option>
                <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Đang chờ duyệt</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt (Active)</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Bị từ chối</option>
            </select>
        </div>

        <!-- Filter Action -->
        <div class="flex items-center gap-2">
            <button type="submit" id="filterBtn" class="flex-1 bg-[#2a2d35] hover:bg-[#343741] text-white px-4 py-2.5 rounded-md transition-colors flex items-center justify-center gap-2 text-sm font-medium border border-gray-600">
                <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                Lọc
            </button>
            <a href="{{ route('admin.kiemduyetnick') }}" class="px-4 py-2.5 bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white rounded-md transition-colors flex items-center justify-center" title="Bỏ lọc">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </a>
        </div>
    </form>

    <!-- Table -->
    <div class="overflow-x-auto relative rounded-md border border-[#2a2d35]">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-[#13131A] text-gray-300 border-b border-[#2a2d35]">
                <tr>
                    <th scope="col" class="p-4 w-12 text-center">
                        <input type="checkbox" id="selectAll" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                    </th>
                    <th scope="col" class="p-4">Thông tin Nick</th>
                    <th scope="col" class="p-4">Đại lý đăng</th>
                    <th scope="col" class="p-4 text-center">Giá bán (VND)</th>
                    <th scope="col" class="p-4 text-center">Thời gian</th>
                    <th scope="col" class="p-4 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody id="nickTableBody">
                @forelse($accounts as $account)
                @php
                    $isPending = $account->status === 'pending';
                    $isApproved = $account->status === 'active';
                    $isRejected = $account->status === 'rejected';
                    $thumbnail = !empty($account->images) ? asset($account->images[0]) : 'https://via.placeholder.com/150/20222a/ffffff?text='.$account->gameCategory->game->name;
                @endphp
                <tr class="nick-row border-b border-[#2a2d35] hover:bg-[#2a2d35]/30 transition-colors" data-id="{{ $account->id }}">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                    </td>
                    <th scope="row" class="p-4 font-medium text-white whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded bg-[#13131A] border border-[#2a2d35] flex items-center justify-center overflow-hidden shrink-0">
                                <img src="{{ $thumbnail }}" alt="Thumbnail" class="w-full h-full object-cover {{ !$isPending ? 'grayscale opacity-70' : '' }}">
                            </div>
                            <div>
                                <p class="font-bold text-white text-base {{ $isRejected ? 'line-through text-gray-400' : '' }}">#SC-{{ $account->id }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $account->gameCategory->name }}</p>
                                @if($isApproved)
                                    <p class="text-xs text-emerald-500 mt-0.5"><span class="material-symbols-outlined text-[14px] align-middle">verified</span> Đã Duyệt</p>
                                @elseif($isRejected)
                                    <p class="text-xs text-red-500 mt-0.5"><span class="material-symbols-outlined text-[14px] align-middle">cancel</span> Bị Từ chối</p>
                                @endif
                            </div>
                        </div>
                    </th>
                    <td class="p-4">
                        <div class="flex items-center gap-2 {{ !$isPending ? 'opacity-70' : '' }}">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-500 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                {{ substr($account->seller->username ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-300">{{ $account->seller->full_name ?? $account->seller->username }}</p>
                                <p class="text-xs text-gray-500">{{ $account->seller->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-center {{ !$isPending ? 'opacity-70' : '' }}">
                        <span class="font-bold {{ $isPending ? 'text-[#FF9800]' : 'text-gray-400' }}">{{ number_format($account->price, 0, ',', '.') }}đ</span>
                    </td>
                    <td class="p-4 text-center {{ !$isPending ? 'opacity-70' : '' }}">
                        <div class="flex flex-col items-center">
                            <span class="text-gray-300 text-xs">{{ $account->created_at->diffForHumans() }}</span>
                            <span class="text-gray-500 text-xs">{{ $account->created_at->format('H:i, d/m') }}</span>
                        </div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button title="Xem chi tiết" class="w-8 h-8 rounded-md bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:text-white hover:border-gray-500 flex items-center justify-center transition-all group">
                                <span class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">visibility</span>
                            </button>
                            
                            @if($isPending)
                                <button title="Duyệt Nick" class="btn-approve w-8 h-8 rounded-md bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 hover:bg-emerald-500 hover:text-white flex items-center justify-center transition-all group" data-id="{{ $account->id }}">
                                    <span class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">check</span>
                                </button>
                                <button title="Từ chối" class="btn-reject w-8 h-8 rounded-md bg-red-500/10 border border-red-500/20 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-all group" data-id="{{ $account->id }}">
                                    <span class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">close</span>
                                </button>
                            @elseif($isRejected)
                                <button title="Lý do từ chối" class="px-3 py-1.5 rounded-md bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500 hover:text-white transition-all text-xs font-medium" onclick="alert('Lý do: {{ addslashes($account->reject_reason) }}')">
                                    Xem lý do
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">
                        Không có tài khoản nào phù hợp.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $accounts->links() }}
    </div>
</div>

<!-- Modal Duyệt Nick -->
<div id="approveModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#13131A] border border-[#2a2d35] rounded-lg max-w-sm w-full p-6 transform scale-95 opacity-0 transition-all duration-300">
        <div class="text-center mb-5">
            <div class="w-14 h-14 rounded-full bg-emerald-500/10 mx-auto flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[32px] text-emerald-500">check_circle</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Duyệt Nick Bán</h3>
            <p class="text-sm text-gray-400" id="approveModalText">Xác nhận duyệt tài khoản <strong class="text-white" id="approveNickId">#104239</strong> lên hệ thống cửa hàng?</p>
        </div>
        <div class="flex gap-3">
            <button type="button" class="btn-cancel w-1/2 px-4 py-2 border border-[#2a2d35] text-gray-300 rounded-md hover:bg-[#2a2d35] hover:text-white transition-colors font-medium">Hủy bỏ</button>
            <button type="button" id="confirmApproveBtn" class="w-1/2 px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-500 transition-colors font-medium shadow-[0_2px_10px_rgba(16,185,129,0.3)]">Duyệt ngay</button>
        </div>
    </div>
</div>

<!-- Modal Từ Chối Nick -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#13131A] border border-[#2a2d35] rounded-lg max-w-md w-full p-6 transform scale-95 opacity-0 transition-all duration-300">
        <div class="flex items-center gap-3 mb-4 border-b border-[#2a2d35] pb-3">
            <div class="w-10 h-10 rounded-full bg-red-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-[24px] text-red-500">cancel</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Từ chối Duyệt Nick</h3>
                <p class="text-xs text-gray-400" id="rejectNickIdDisplay">ID: #104000</p>
            </div>
        </div>
        
        <form>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300 mb-2">Lý do từ chối <span class="text-red-500">*</span></label>
                <textarea rows="3" class="w-full bg-[#20222a] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block p-3 transition-colors outline-none resize-none" placeholder="Nhập lý do chi tiết để đại lý có thể sửa (ví dụ: Sai mật khẩu, Thiếu ảnh, Form sai...)" required></textarea>
                <p class="text-xs text-gray-500 mt-2">Lý do này sẽ được gửi dưới dạng thông báo đến đại lý.</p>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-[#2a2d35]">
                <button type="button" class="btn-cancel px-5 py-2 border border-[#2a2d35] text-gray-300 rounded-md hover:bg-[#2a2d35] hover:text-white transition-colors font-medium text-sm">Hủy</button>
                <button type="button" id="confirmRejectBtn" class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-500 transition-colors font-medium text-sm shadow-[0_2px_10px_rgba(220,38,38,0.3)] flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span> Xác nhận Từ chối
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/kiemduyetnick.js') }}"></script>
@endpush
