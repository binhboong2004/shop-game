@extends('admin.layouts.master')

@section('title', 'Danh sách Nick có sẵn')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/danhsachnick.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Danh sách Nick Hệ thống</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Danh sách Nick có sẵn</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#20222a] hover:bg-[#2a2d35] border border-[#2a2d35] text-white px-4 py-2 rounded-md transition-colors flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Xuất Excel
        </button>
        <a href="{{ route('admin.themnickmoi') }}" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Nick Mới
        </a>
    </div>
</div>

<!-- Stats / Analytics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Số Nick</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($totalAccounts) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">inventory_2</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-emerald-400">
            <span class="material-symbols-outlined text-[16px]">trending_up</span>
            <!-- <span class="font-medium">+15 hôm nay</span> -->
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Bán</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($activeAccounts) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">sell</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-emerald-400">
            <span class="material-symbols-outlined text-[16px]">check_circle</span>
            <span class="font-medium">Sẵn sàng giao dịch</span>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đã Bán</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($soldAccounts) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500">
                <span class="material-symbols-outlined text-[28px]">shopping_cart_checkout</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
            <!-- <span class="font-medium">Tháng này: 42</span> -->
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Ẩn/Chờ</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($hiddenAccounts) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">visibility_off</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-[#E70814]">
            <span class="material-symbols-outlined text-[16px]">warning</span>
            <span class="font-medium">Cần kiểm tra lại</span>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tìm Kiếm</label>
            <div class="relative">
                <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Mã SC, Tên nick..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Danh Chọn Game</label>
            <select id="gameFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả Game</option>
                @foreach($games as $game)
                <option value="{{ $game->id }}" {{ request('game') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả trạng thái</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Đang bán</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>Đang ẩn</option>
            </select>
        </div>
        <div class="flex items-end">
            <button id="filterBtn" class="w-full bg-[#E70814] hover:bg-[#ff0f1e] text-white font-medium py-2.5 rounded-md transition-colors">
                Lọc Kết Quả
            </button>
        </div>
    </div>
</div>

<!-- Table -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
                <tr class="bg-[#1a1c23] border-b border-[#2a2d35] text-xs uppercase tracking-wider text-gray-400 font-semibold">
                    <th class="p-4 w-12 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                    </th>
                    <th class="p-4">Thông tin Nick</th>
                    <th class="p-4">Danh Mục Game</th>
                    <th class="p-4 text-right">Giá Trị</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4">Người Đăng</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @forelse($accounts as $account)
                <tr class="hover:bg-[#1a1c23] transition-colors group nick-row" 
                    data-id="{{ $account->id }}"
                    data-search="{{ $account->title }} SC-{{ $account->id }}" 
                    data-game="{{ optional($account->gameCategory)->game_id }}" 
                    data-status="{{ $account->status }}" 
                    data-price="{{ $account->price }}">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]" {{ $account->status == 'sold' ? 'disabled' : '' }}>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded bg-[#13131A] border border-[#2a2d35] flex items-center justify-center overflow-hidden shrink-0">
                                @php
                                    $thumb = isset($account->images[0]) ? asset($account->images[0]) : (isset($account->gameCategory->game->image) ? asset($account->gameCategory->game->image) : asset('assets/clients/images/default-thumbnail.jpg'));
                                @endphp
                                <img src="{{ $thumb }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="Thumb">
                            </div>
                            <div>
                                <p class="font-bold text-white group-hover:text-[#E70814] transition-colors line-clamp-1">{{ $account->title }}</p>
                                <p class="text-xs text-blue-400 font-medium mt-0.5">Mã SC: #SC-{{ $account->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-300 font-medium">{{ optional(optional($account->gameCategory)->game)->name ?? 'Không rõ' }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ optional($account->gameCategory)->name }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="font-bold text-emerald-400">{{ number_format($account->price) }} đ</div>
                        @if($account->original_price > $account->price)
                        <div class="text-xs text-gray-500 line-through mt-0.5">{{ number_format($account->original_price) }} đ</div>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($account->status === 'active')
                        <button class="inline-block w-24 px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20 rounded btn-status-toggle hover:bg-emerald-500/20 transition-colors text-center" data-id="{{ $account->id }}" data-action="hide">
                            Đang bán
                        </button>
                        @elseif($account->status === 'pending_approval')
                        <button class="inline-block w-24 px-2 py-1 bg-yellow-500/10 text-yellow-400 text-xs font-bold border border-yellow-500/20 rounded btn-status-toggle hover:bg-yellow-500/20 transition-colors text-center" data-id="{{ $account->id }}" data-action="show">
                            Đang ẩn
                        </button>
                        @elseif($account->status === 'sold')
                        <span class="inline-block w-24 px-2 py-1 bg-purple-500/10 text-purple-400 text-xs font-bold border border-purple-500/20 rounded text-center">
                            Đã bán
                        </span>
                        @endif
                    </td>
                    <td class="p-4 text-gray-400">
                        <div class="flex items-center gap-2">
                            @if($account->seller && $account->seller->role === 'admin')
                            <span class="material-symbols-outlined text-[16px] text-[#E70814]">shield_person</span>
                            <span class="text-white text-xs font-medium">Admin</span>
                            @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(optional($account->seller)->username ?? 'Vô danh') }}&background=random" class="w-4 h-4 rounded-full">
                            <span class="text-gray-300 text-xs font-medium">{{ optional($account->seller)->username ?? 'Vô danh' }}</span>
                            @endif
                        </div>
                        <div class="text-xs mt-1">{{ $account->created_at->format('d/m/Y H:i') }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit-nick" data-id="{{ $account->id }}" title="{{ $account->status == 'sold' ? 'Xem chi tiết' : 'Chỉnh sửa' }}">
                                <span class="material-symbols-outlined text-[18px]">{{ $account->status == 'sold' ? 'visibility' : 'edit' }}</span>
                            </button>
                            @if($account->status !== 'sold')
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] hover:text-white transition-colors flex items-center justify-center btn-hide-nick {{ $account->status === 'pending_approval' ? 'text-emerald-400 hover:bg-emerald-500' : 'text-yellow-400 hover:bg-yellow-500' }}" data-id="{{ $account->id }}" data-current="{{ $account->status }}" title="{{ $account->status === 'pending_approval' ? 'Hiện Nick' : 'Ẩn Nick' }}">
                                <span class="material-symbols-outlined text-[18px]">{{ $account->status === 'pending_approval' ? 'visibility' : 'visibility_off' }}</span>
                            </button>
                            @endif
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:bg-gray-500 hover:text-white transition-colors flex items-center justify-center btn-remove-nick" data-id="{{ $account->id }}" title="Xóa">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        Không tìm thấy tài khoản nào phù hợp.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 border-t border-[#2a2d35]">
        {{ $accounts->links() }}
    </div>
</div>

<!-- Confirm Remove Modal -->
<div id="removeModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-500/10 text-gray-400 flex items-center justify-center mx-auto mb-4 border border-gray-500/20">
                <span class="material-symbols-outlined text-[32px]">delete</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa nick này khỏi hệ thống? Hành động này không thể hoàn tác.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-gray-600 text-white font-medium hover:bg-gray-700 shadow-[0_2px_10px_rgba(75,85,99,0.3)] transition-colors">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirm Hide/Show Modal -->
<div id="toggleStatusModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-yellow-500/10 text-yellow-500 flex items-center justify-center mx-auto mb-4 border border-yellow-500/20">
                <span class="material-symbols-outlined text-[32px]" id="toggleIcon">visibility_off</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2" id="toggleTitle">Xác nhận Ẩn</h3>
            <p class="text-gray-400 text-sm mb-6" id="toggleMessage">Bạn có chắc chắn muốn ẩn nick này? Khách hàng sẽ không thể thấy và mua nick.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-yellow-600 text-white font-medium hover:bg-yellow-700 shadow-[0_2px_10px_rgba(202,138,4,0.3)] transition-colors" id="toggleConfirmBtn">Ẩn Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/danhsachnick.js') }}"></script>
@endpush
