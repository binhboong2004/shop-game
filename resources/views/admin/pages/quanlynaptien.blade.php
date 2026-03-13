@extends('admin.layouts.master')

@section('title', 'Quản lý Nạp Tiền')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/quanlynaptien.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Quản lý Nạp Tiền</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Tài Chính</li>
                <li><span class="mx-2">/</span></li>
                <li>Nạp Tiền</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button id="addFundsBtn" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Cộng tiền thủ công
        </button>
        <button id="exportExcelBtn" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Xuất Excel
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Nạp Hôm Nay</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($todayDeposit) }}đ</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">today</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Thành Công (Tháng)</p>
                <h3 class="text-2xl font-bold text-emerald-400">{{ number_format($monthDeposit) }}đ</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">check_circle</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Chờ Duyệt</p>
                <h3 class="text-2xl font-bold text-yellow-500">{{ number_format($pendingCount) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center text-yellow-500">
                <span class="material-symbols-outlined text-[28px]">pending_actions</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Từ Chối / Lỗi</p>
                <h3 class="text-2xl font-bold text-[#E70814]">{{ number_format($failedCount) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">cancel</span>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Mã GD / User</label>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Nhập mã hoặc tên..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả</option>
                <option value="pending">Chờ duyệt</option>
                <option value="success">Thành công</option>
                <option value="failed">Thất bại / Từ chối</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Thời Gian</label>
            <input type="date" id="dateFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none [color-scheme:dark]">
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
                    <th class="p-4 w-28 text-center">Mã GD</th>
                    <th class="p-4">Người Dùng</th>
                    <th class="p-4 text-right">Số Tiền (VNĐ)</th>
                    <th class="p-4 text-center">Phương Thức</th>
                    <th class="p-4 text-center">Thời Gian</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @forelse($deposits as $deposit)
                <tr class="hover:bg-[#1a1c23] transition-colors group transaction-row" data-id="{{ $deposit->id }}" data-search="{{ $deposit->id }} {{ $deposit->user->name ?? '' }}" data-status="{{ $deposit->status }}">
                    <td class="p-4 text-center font-medium text-gray-400">#{{ $deposit->id }}</td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-{{ ['admin' => 'red', 'agent' => 'blue', 'member' => 'gray'][$deposit->user->role ?? 'member'] ?? 'gray' }}-500/20 text-{{ ['admin' => 'red', 'agent' => 'blue', 'member' => 'gray'][$deposit->user->role ?? 'member'] ?? 'gray' }}-500 flex items-center justify-center font-bold text-xs uppercase">
                                {{ substr($deposit->user->name ?? 'U', 0, 2) }}
                            </div>
                            <div>
                                <p class="font-bold text-white group-hover:text-[#E70814] transition-colors">{{ $deposit->user->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $deposit->user->role ?? 'user' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-right font-bold text-white">
                        <div class="flex flex-col">
                            <span>{{ number_format($deposit->received_amount) }}đ</span>
                            @if($deposit->amount != $deposit->received_amount)
                            <span class="text-[10px] text-gray-500">Gốc: {{ number_format($deposit->amount) }}đ</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        @php
                            $typeMap = [
                                'card' => ['icon' => 'sim_card', 'class' => 'bg-orange-500/10 text-orange-400 border-orange-500/20', 'label' => 'Thẻ Cào'],
                                'bank' => ['icon' => 'account_balance', 'class' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', 'label' => 'Ngân Hàng'],
                                'ewallet' => ['icon' => 'account_balance_wallet', 'class' => 'bg-purple-500/10 text-purple-400 border-purple-500/20', 'label' => 'Ví Điện Tử'],
                                'manual' => ['icon' => 'add_circle', 'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20', 'label' => 'Cộng Thủ Công'],
                            ];
                            $type = $typeMap[$deposit->category->type ?? 'bank'] ?? $typeMap['bank'];
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded {{ $type['class'] }} text-xs font-semibold border">
                            <span class="material-symbols-outlined text-[14px]">{{ $type['icon'] }}</span>
                            {{ $deposit->category->name ?? $type['label'] }}
                        </span>
                    </td>
                    <td class="p-4 text-center text-gray-400 text-xs">
                        {{ $deposit->created_at->format('d/m/Y') }}<br>{{ $deposit->created_at->format('H:i:s') }}
                    </td>
                    <td class="p-4 text-center">
                        @if($deposit->status === 'pending')
                            <span class="inline-block px-3 py-1 rounded-full bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 text-xs font-bold">Chờ duyệt</span>
                        @elseif($deposit->status === 'approved' || $deposit->status === 'success')
                            <span class="inline-block px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 text-xs font-bold">Thành công</span>
                        @else
                            <span class="inline-block px-3 py-1 rounded-full bg-[#E70814]/10 text-[#E70814] border border-[#E70814]/20 text-xs font-bold">Thất bại</span>
                        @endif
                    </td>
                    <td class="p-4 text-right relative">
                        @if($deposit->status === 'pending')
                        <div class="flex items-center justify-end gap-2">
                            <button class="px-3 py-1.5 rounded bg-emerald-500/10 border border-emerald-500/30 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-colors text-xs font-medium btn-approve" 
                                data-id="{{ $deposit->id }}" 
                                data-user="{{ $deposit->user->name ?? 'N/A' }}" 
                                data-amount="{{ number_format($deposit->received_amount) }} VNĐ"
                                title="Duyệt">
                                Duyệt
                            </button>
                            <button class="px-3 py-1.5 rounded bg-[#E70814]/10 border border-[#E70814]/30 text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors text-xs font-medium btn-reject" 
                                data-id="{{ $deposit->id }}"
                                title="Từ chối">
                                Từ chối
                            </button>
                        </div>
                        @else
                            <span class="text-xs text-gray-500 italic">
                                {{ $deposit->status === 'approved' ? 'Đã duyệt' : 'Đã từ chối' }}
                                @if(isset($deposit->details['reject_reason']))
                                    <button class="ml-1 text-[#E70814] hover:underline btn-view-reason-direct" data-reason="{{ $deposit->details['reject_reason'] }}"> Lý do</button>
                                @endif
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500 italic">Không tìm thấy giao dịch nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $deposits->links('vendor.pagination.tailwind-admin') }}
</div>

<!-- Modal Duyệt Nạp Tiền -->
<div id="approveModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Xác Nhận Duyệt Nạp Tiền</h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-5">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-400">Mã Giao Dịch:</span>
                    <span class="text-sm font-bold text-white">#GD10239</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-400">Người Nạp:</span>
                    <span class="text-sm font-bold text-blue-400">user123</span>
                </div>
                <div class="flex justify-between pt-2 border-t border-blue-500/20">
                    <span class="text-sm text-gray-400">Thực Nhận:</span>
                    <span class="text-lg font-bold text-emerald-400">500,000 VNĐ</span>
                </div>
            </div>
            
            <p class="text-gray-300 text-sm mb-6">Bạn có chắc chắn đã nhận được tiền từ giao dịch này? Hệ thống sẽ <span class="text-emerald-400 font-bold">cộng tiền</span> vào tài khoản người dùng ngay lập tức.</p>
            
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-emerald-600 text-white font-medium hover:bg-emerald-700 shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-colors" id="btnConfirmApprove">Xác Nhận Duyệt</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Từ Chối Nạp Tiền -->
<div id="rejectModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">Từ Chối Giao Dịch</h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-400 mb-2">Lý do từ chối (Bắt buộc) <span class="text-[#E70814]">*</span></label>
                <textarea id="rejectReason" rows="3" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none resize-none" placeholder="Nhập lý do (VD: Sai nội dung chuyển khoản, Không nhận được tiền...)"></textarea>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="btnConfirmReject">Xác Nhận Từ chối</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xem Lý Do Từ Chối -->
<div id="reasonModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-[#E70814]">info</span>
                Lý Do Từ Chối
            </h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-300 leading-relaxed bg-[#13131A] p-4 rounded-lg border border-[#2a2d35]">
                "Người dùng chuyển khoản không đúng nội dung yêu cầu, số tiền thực nhận không khớp với thông tin nạp. Vui lòng liên hệ CSKH để được hỗ trợ."
            </p>
            <div class="mt-6 flex justify-end">
                <button type="button" class="btn-cancel px-4 py-2 rounded-lg bg-[#2a2d35] text-white font-medium hover:bg-gray-600 transition-colors">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cộng Tiền Thủ Công -->
<div id="addFundsModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-md shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <div class="p-6 border-b border-[#2a2d35] flex justify-between items-center">
            <h3 class="text-xl font-bold text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-[#E70814]">add_circle</span>
                Cộng Tiền Thủ Công
            </h3>
            <button class="text-gray-400 hover:text-white transition-colors btn-cancel">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <form id="addFundsForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">ID hoặc Tên Người Dùng <span class="text-[#E70814]">*</span></label>
                    <input type="text" id="addFundsUser" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none" placeholder="Nhập ID/Username cần cộng tiền..." required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Số Tiền (VNĐ) <span class="text-[#E70814]">*</span></label>
                    <div class="relative">
                        <input type="number" id="addFundsAmount" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pr-12 pl-3 py-2.5 outline-none" placeholder="0" required min="1000">
                        <span class="absolute right-3 top-2.5 text-gray-500 font-medium">VNĐ</span>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Ghi chú (Lý do cộng) <span class="text-[#E70814]">*</span></label>
                    <textarea id="addFundsReason" rows="2" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none resize-none" placeholder="VD: Nạp qua Momo chưa tự động cộng..." required></textarea>
                </div>
                
                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-3 mb-6 flex items-start gap-3">
                    <span class="material-symbols-outlined text-yellow-500 text-[20px] shrink-0 mt-0.5">warning</span>
                    <p class="text-xs text-yellow-500/90 leading-relaxed font-medium">Hành động này sẽ cộng trực tiếp tiền vào tài khoản người dùng hiển thị trên hệ thống. Hãy kiểm tra kỹ thông tin.</p>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors" id="btnConfirmAddFunds">Xác Nhận Cộng Tiền</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/quanlynaptien.js') }}"></script>
@endpush
