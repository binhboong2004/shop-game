@extends('admin.layouts.master')

@section('title', 'Tài khoản Thành viên')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/taikhoanthanhvien.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Quản lý Thành viên</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Tài khoản Thành viên</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#20222a] hover:bg-[#2a2d35] border border-[#2a2d35] text-white px-4 py-2 rounded-md transition-colors flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Xuất Excel
        </button>
        <a href="{{ route('admin.themthanhvien') }}" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Thành viên
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-md mb-6 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-400">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>
@endif

<!-- Stats / Analytics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Số User</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($totalUsers) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">group</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-emerald-400">
            {{-- <span class="material-symbols-outlined text-[16px]">trending_up</span> --}}
            {{-- <span class="font-medium">+420 tuần này</span> --}}
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">User Mới (24h)</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($newUsers24h) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">person_add</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-emerald-400">
            {{-- <span class="material-symbols-outlined text-[16px]">trending_up</span> --}}
            {{-- <span class="font-medium">+12% vs hôm qua</span> --}}
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Hoạt Động</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($activeUsers) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                <span class="material-symbols-outlined text-[28px]">how_to_reg</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
            {{-- <span class="font-medium">Chơi game gần đây</span> --}}
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tài Khoản Bị Khóa</p>
                <h3 class="text-2xl font-bold text-white">{{ number_format($bannedUsers) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">person_off</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-[#E70814]">
            {{-- <span class="material-symbols-outlined text-[16px]">warning</span> --}}
            {{-- <span class="font-medium">Vi phạm nội quy</span> --}}
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-4 mb-6">
        <form action="{{ route('admin.taikhoanthanhvien') }}" method="GET" class="contents">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tìm Kiếm</label>
                <div class="relative">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Tên, Email, SĐT..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
                <select name="status" id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Tất cả trạng thái</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Bị khóa</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Sắp Xếp</label>
                <select name="sort" id="sortFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                    <option value="new" {{ request('sort') == 'new' ? 'selected' : '' }}>Mới đăng ký nhất</option>
                    <option value="balance" {{ request('sort') == 'balance' ? 'selected' : '' }}>Số dư cao nhất</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" id="filterBtn" class="w-full bg-[#E70814] hover:bg-[#ff0f1e] text-white font-medium py-2.5 rounded-md transition-colors">
                    Lọc Kết Quả
                </button>
            </div>
        </div>
        </form>
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
                    <th class="p-4">Thành Viên</th>
                    <th class="p-4">Liên Hệ</th>
                    <th class="p-4 text-right">Số Dư</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4">Ngày Đăng Ký</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @forelse($users as $user)
                <tr class="hover:bg-[#1a1c23] transition-colors group user-row" data-search="{{ $user->name }} {{ $user->email }} {{ $user->phone }}" data-status="{{ $user->status }}" data-balance="{{ $user->balance }}" data-date="{{ $user->created_at->format('Y-m-d') }}">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar ? asset($user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" class="w-10 h-10 rounded-full object-cover">
                            <div>
                                <p class="font-bold text-white group-hover:text-[#E70814] transition-colors">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">ID: #USER-{{ $user->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-300">{{ $user->email }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $user->phone ?? 'Chưa cập nhật' }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="font-bold text-emerald-400">{{ number_format($user->balance) }} đ</div>
                    </td>
                    <td class="p-4 text-center">
                        @if($user->status == 'active')
                        <!-- Status Badge (Active -> Lock) -->
                        <button class="inline-block w-24 px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20 rounded btn-status-toggle hover:bg-emerald-500/20 transition-colors text-center" data-action="lock" data-id="{{ $user->id }}">
                            Hoạt động
                        </button>
                        @else
                        <!-- Status Badge (Disabled -> Unlock) -->
                        <button class="inline-block w-24 px-2 py-1 bg-[#E70814]/10 text-[#E70814] text-xs font-bold border border-[#E70814]/20 rounded btn-status-toggle hover:bg-[#E70814]/20 transition-colors text-center" data-action="unlock" data-id="{{ $user->id }}">
                            Bị khóa
                        </button>
                        @endif
                    </td>
                    <td class="p-4 text-gray-400">
                        <div>{{ $user->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs mt-0.5">{{ $user->created_at->format('H:i A') }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-purple-400 hover:bg-purple-500 hover:text-white transition-colors flex items-center justify-center btn-promote-user" title="Phân quyền" data-id="{{ $user->id }}">
                                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                            </button>
                            <a href="{{ route('admin.thanhvien.edit', $user->id) }}" class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center" title="Chỉnh sửa">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            @if($user->status == 'active')
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete-user" title="Khóa" data-id="{{ $user->id }}">
                                <span class="material-symbols-outlined text-[18px]">lock</span>
                            </button>
                            @else
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-green-500 hover:bg-green-500 hover:text-white transition-colors flex items-center justify-center btn-unlock-user" title="Mở khóa" data-id="{{ $user->id }}">
                                <span class="material-symbols-outlined text-[18px]">lock_open</span>
                            </button>
                            @endif
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:bg-gray-500 hover:text-white transition-colors flex items-center justify-center btn-remove-user" title="Xóa" data-id="{{ $user->id }}">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-400">Không tìm thấy thành viên nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 border-t border-[#2a2d35] flex items-center justify-between text-sm text-gray-400">
        <div>Hiển thị {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} trong tổng {{ number_format($users->total()) }} user</div>
        <div class="flex items-center gap-1">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Confirm Delete/Ban Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="lockForm" method="POST" class="p-6 text-center">
            @csrf
            @method('PUT')
            <div class="w-16 h-16 rounded-full bg-[#E70814]/10 text-[#E70814] flex items-center justify-center mx-auto mb-4 border border-[#E70814]/20">
                <span class="material-symbols-outlined text-[32px]">warning</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Khóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn khóa tài khoản này? Người dùng sẽ không thể đăng nhập vào hệ thống.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors">Khóa Ngay</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Unlock Modal -->
<div id="unlockModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="unlockForm" method="POST" class="p-6 text-center">
            @csrf
            @method('PUT')
            <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                <span class="material-symbols-outlined text-[32px]">lock_open</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Mở Khóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn mở khóa tài khoản này? Người dùng sẽ có thể đăng nhập lại vào hệ thống.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-emerald-500 text-white font-medium hover:bg-emerald-600 shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-colors">Mở Khóa Ngay</button>
            </div>
        </form>
    </div>
</div>
<!-- Confirm Remove Modal -->
<div id="removeModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="removeForm" method="POST" class="p-6 text-center">
            @csrf
            @method('DELETE')
            <div class="w-16 h-16 rounded-full bg-gray-500/10 text-gray-400 flex items-center justify-center mx-auto mb-4 border border-gray-500/20">
                <span class="material-symbols-outlined text-[32px]">delete</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa thành viên này? Hành động này không thể hoàn tác.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-gray-600 text-white font-medium hover:bg-gray-700 shadow-[0_2px_10px_rgba(75,85,99,0.3)] transition-colors">Xóa Ngay</button>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Promote Modal -->
<div id="promoteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="promoteForm" method="POST" class="p-6 text-center">
            @csrf
            @method('PUT')
            <div class="w-16 h-16 rounded-full bg-purple-500/10 text-purple-500 flex items-center justify-center mx-auto mb-4 border border-purple-500/20">
                <span class="material-symbols-outlined text-[32px]">manage_accounts</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Phân quyền Tài khoản</h3>
            <p class="text-gray-400 text-sm mb-4">Chọn cấp bậc mới cho thành viên này:</p>
            <div class="mb-6 space-y-3 text-left">
                <label class="flex items-center gap-3 p-3 rounded-lg border border-[#2a2d35] bg-[#13131A] cursor-pointer hover:border-[#E70814] transition-colors">
                    <input type="radio" name="role" value="agent" class="w-4 h-4 text-[#E70814] bg-[#20222a] border-gray-600 focus:ring-[#E70814]" checked>
                    <div>
                        <div class="text-white font-medium">Đại lý</div>
                        <div class="text-xs text-gray-400">Có quyền bán tài khoản và nhận hoa hồng</div>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-lg border border-[#2a2d35] bg-[#13131A] cursor-pointer hover:border-[#E70814] transition-colors">
                    <input type="radio" name="role" value="admin" class="w-4 h-4 text-[#E70814] bg-[#20222a] border-gray-600 focus:ring-[#E70814]">
                    <div>
                        <div class="text-white font-medium">Quản trị viên (Admin)</div>
                        <div class="text-xs text-gray-400">Bảo lưu toàn quyền trên hệ thống</div>
                    </div>
                </label>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 shadow-[0_2px_10px_rgba(147,51,234,0.3)] transition-colors">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/taikhoanthanhvien.js') }}"></script>
@endpush
