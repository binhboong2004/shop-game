@extends('admin.layouts.master')

@section('title', 'Tài khoản Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/taikhoanadmin.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Quản lý Admin</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Tài khoản Admin</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#20222a] hover:bg-[#2a2d35] border border-[#2a2d35] text-white px-4 py-2 rounded-md transition-colors flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Xuất Excel
        </button>
        <a href="{{ route('admin.themadmin') }}" class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Admin
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-md mb-6 flex items-center gap-2">
        <span class="material-symbols-outlined">check_circle</span>
        {{ session('success') }}
    </div>
@endif

<!-- Stats / Analytics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Số Admin</p>
                <h3 class="text-2xl font-bold text-white">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">admin_panel_settings</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-emerald-400">
            <span class="material-symbols-outlined text-[16px]">trending_up</span>
            <span class="font-medium">Admin hệ thống</span>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Hoạt Động</p>
                <h3 class="text-2xl font-bold text-white">{{ \App\Models\User::where('role', 'admin')->where('status', 'active')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-500/10 flex items-center justify-center text-green-500">
                <span class="material-symbols-outlined text-[28px]">verified_user</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-gray-500">
            <span class="font-medium">Online gần nhất</span>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tài Khoản Bị Khóa</p>
                <h3 class="text-2xl font-bold text-white">{{ \App\Models\User::where('role', 'admin')->where('status', 'banned')->count() }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">block</span>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm text-[#E70814]">
            <span class="material-symbols-outlined text-[16px]">warning</span>
            <span class="font-medium">Ngừng hoạt động</span>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Tìm Kiếm</label>
            <div class="relative">
                <input type="text" id="searchInput" placeholder="Tên, Email, SĐT..." class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block pl-10 pr-3 py-2.5 outline-none">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-500 text-[20px]">search</span>
            </div>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Trạng Thái</label>
            <select id="statusFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="all">Tất cả trạng thái</option>
                <option value="active">Hoạt động</option>
                <option value="banned">Bị khóa</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Sắp Xếp</label>
            <select id="sortFilter" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] block px-3 py-2.5 outline-none appearance-none">
                <option value="new">Mới đăng ký nhất</option>
                <option value="balance">Số dư cao nhất</option>
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
                    <th class="p-4">Admin</th>
                    <th class="p-4">Liên Hệ</th>
                    <th class="p-4 text-right">Số Dư</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4">Ngày Tham Gia</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @foreach ($admins as $admin)
                <tr class="hover:bg-[#1a1c23] transition-colors group admin-row" data-search="{{ $admin->name }} {{ $admin->email }} {{ $admin->phone }}" data-status="{{ $admin->status }}" data-balance="{{ $admin->balance }}" data-date="{{ $admin->created_at->format('Y-m-d') }}">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814] focus:ring-offset-[#20222a]">
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold border border-purple-500/30">
                                {{ strtoupper(substr($admin->name, 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-bold text-white group-hover:text-[#E70814] transition-colors">{{ $admin->name }}</p>
                                <p class="text-xs text-gray-500">ID: #ADM-{{ str_pad($admin->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        <div class="text-gray-300">{{ $admin->email }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $admin->phone ?? 'Chưa cập nhật' }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="font-bold text-emerald-400">{{ number_format($admin->balance, 0, ',', '.') }} đ</div>
                    </td>
                    <td class="p-4 text-center">
                        @if ($admin->status === 'active')
                            <button class="inline-block w-24 px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20 rounded btn-status-toggle hover:bg-emerald-500/20 transition-colors text-center" data-action="lock" data-id="{{ $admin->id }}">
                                Hoạt động
                            </button>
                        @elseif ($admin->status === 'banned')
                            <button class="inline-block w-24 px-2 py-1 bg-[#E70814]/10 text-[#E70814] text-xs font-bold border border-[#E70814]/20 rounded btn-status-toggle hover:bg-[#E70814]/20 transition-colors text-center" data-action="unlock" data-id="{{ $admin->id }}">
                                Bị khóa
                            </button>
                        @else
                            <button class="inline-block w-24 px-2 py-1 bg-gray-500/10 text-gray-400 text-xs font-bold border border-gray-500/20 rounded text-center">
                                Khác
                            </button>
                        @endif
                    </td>
                    <td class="p-4 text-gray-400">
                        <div>{{ $admin->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs mt-0.5">{{ $admin->created_at->format('H:i A') }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-purple-400 hover:bg-purple-500 hover:text-white transition-colors flex items-center justify-center btn-promote-user" title="Phân quyền" data-id="{{ $admin->id }}">
                                <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                            </button>
                            <a href="{{ route('admin.admin.edit', $admin->id) }}" class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center" title="Chỉnh sửa">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                            @if ($admin->status === 'active')
                                <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete-user" title="Khóa" data-id="{{ $admin->id }}">
                                    <span class="material-symbols-outlined text-[18px]">lock</span>
                                </button>
                            @elseif ($admin->status === 'banned')
                                <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-green-500 hover:bg-green-500 hover:text-white transition-colors flex items-center justify-center btn-unlock-user" title="Mở khóa" data-id="{{ $admin->id }}">
                                    <span class="material-symbols-outlined text-[18px]">lock_open</span>
                                </button>
                            @endif
                            <button class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-gray-400 hover:bg-gray-500 hover:text-white transition-colors flex items-center justify-center btn-remove-user" title="Xóa" data-id="{{ $admin->id }}">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 border-t border-[#2a2d35] flex items-center justify-between text-sm text-gray-400">
        <div>Hiển thị {{ $admins->firstItem() ?? 0 }} - {{ $admins->lastItem() ?? 0 }} trong tổng {{ $admins->total() }} admin</div>
        <div class="flex items-center gap-1">
            {{ $admins->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<!-- Confirm Delete/Ban Modal -->
<div id="confirmModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="lockForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-[#E70814]/10 text-[#E70814] flex items-center justify-center mx-auto mb-4 border border-[#E70814]/20">
                    <span class="material-symbols-outlined text-[32px]">warning</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Xác nhận Khóa</h3>
                <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn khóa tài khoản quản trị này?</p>
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors">Khóa Ngay</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Unlock Modal -->
<div id="unlockModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="unlockForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-emerald-500/10 text-emerald-500 flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                    <span class="material-symbols-outlined text-[32px]">lock_open</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Xác nhận Mở Khóa</h3>
                <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn mở khóa tài khoản quản trị này?</p>
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-emerald-500 text-white font-medium hover:bg-emerald-600 shadow-[0_2px_10px_rgba(16,185,129,0.3)] transition-colors">Mở Khóa Ngay</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Remove Modal -->
<div id="removeModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="removeForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-500/10 text-gray-400 flex items-center justify-center mx-auto mb-4 border border-gray-500/20">
                    <span class="material-symbols-outlined text-[32px]">delete</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
                <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa tài khoản này vĩnh viễn? Hành động này không thể hoàn tác.</p>
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-gray-600 text-white font-medium hover:bg-gray-700 shadow-[0_2px_10px_rgba(75,85,99,0.3)] transition-colors">Xóa Ngay</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Confirm Promote Modal -->
<div id="promoteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
        <form id="promoteForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-purple-500/10 text-purple-500 flex items-center justify-center mx-auto mb-4 border border-purple-500/20">
                    <span class="material-symbols-outlined text-[32px]">manage_accounts</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Phân quyền Tài khoản</h3>
                <p class="text-gray-400 text-sm mb-4">Hạ cấp bậc quản trị, chọn cấp bậc mới:</p>
                <div class="mb-6 space-y-3 text-left">
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-[#2a2d35] bg-[#13131A] cursor-pointer hover:border-[#E70814] transition-colors">
                        <input type="radio" name="role" value="agent" class="w-4 h-4 text-[#E70814] bg-[#20222a] border-gray-600 focus:ring-[#E70814]" checked>
                        <div>
                            <div class="text-white font-medium">Đại lý</div>
                            <div class="text-xs text-gray-400">Có quyền bán tài khoản và nhận hoa hồng</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3 rounded-lg border border-[#2a2d35] bg-[#13131A] cursor-pointer hover:border-[#E70814] transition-colors">
                        <input type="radio" name="role" value="member" class="w-4 h-4 text-[#E70814] bg-[#20222a] border-gray-600 focus:ring-[#E70814]">
                        <div>
                            <div class="text-white font-medium">Thành viên</div>
                            <div class="text-xs text-gray-400">Chỉ có quyền mua - bán với tư cách user</div>
                        </div>
                    </label>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" class="btn-cancel w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                    <button type="submit" class="w-full px-4 py-2.5 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 shadow-[0_2px_10px_rgba(147,51,234,0.3)] transition-colors">Cập Nhật</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/taikhoanadmin.js') }}"></script>
@endpush
