@extends('admin.layouts.master')

@section('title', 'Thêm Đại lý Mới')

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">{{ isset($user) ? 'Chỉnh sửa Đại lý' : 'Thêm Đại lý Mới' }}</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.taikhoandaily') }}" class="text-[#E70814] hover:underline">Tài khoản Đại lý</a></li>
                <li><span class="mx-2">/</span></li>
                <li>{{ isset($user) ? 'Chỉnh sửa' : 'Thêm mới' }}</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.taikhoandaily') }}" class="bg-[#20222a] hover:bg-[#2a2d35] border border-[#2a2d35] text-white px-4 py-2 rounded-md transition-colors flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Quay lại
        </a>
    </div>
</div>

<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-6 mb-6 transform transition-all hover:border-gray-500/50">
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/20 text-green-500 px-4 py-3 rounded-md mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-3 rounded-md mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ isset($user) ? route('admin.daily.update', $user->id) : route('admin.themdaily.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Thông tin cá nhân -->
            <div>
                <h3 class="text-lg font-bold text-white mb-5 border-b border-[#2a2d35] pb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E70814]">account_circle</span>
                    Thông tin Đại lý
                </h3>
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Họ và Tên <span class="text-[#E70814]">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập họ và tên đại lý" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email <span class="text-[#E70814]">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập địa chỉ email" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Số điện thoại <span class="text-[#E70814]">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập số điện thoại" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Ảnh Đại Diện (Không bắt buộc)</label>
                    @if(isset($user) && $user->avatar)
                        <div class="mb-2">
                            <img src="{{ asset($user->avatar) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover">
                        </div>
                    @endif
                    <div class="relative w-full h-11 bg-[#13131A] border border-[#2a2d35] rounded-md hover:border-gray-500 transition-colors flex items-center px-3 cursor-pointer overflow-hidden group">
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-[#E70814] transition-colors mr-2">cloud_upload</span>
                        <span id="fileNameDisplay" class="text-sm text-gray-400 truncate flex-1">Chọn ảnh tải lên...</span>
                    </div>
                </div>
            </div>

            <!-- Phân quyền và Bảo mật -->
            <div>
                <h3 class="text-lg font-bold text-white mb-5 border-b border-[#2a2d35] pb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E70814]">shield</span>
                    Phân quyền & Bảo mật
                </h3>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mật khẩu {!! isset($user) ? '' : '<span class="text-[#E70814]">*</span>' !!}</label>
                    <input type="password" name="password" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="{{ isset($user) ? 'Để trống nếu không muốn đổi mật khẩu' : 'Nhập mật khẩu' }}" {{ isset($user) ? '' : 'required' }}>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nhập lại Mật khẩu {!! isset($user) ? '' : '<span class="text-[#E70814]">*</span>' !!}</label>
                    <input type="password" name="password_confirmation" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="{{ isset($user) ? 'Để trống nếu không muốn đổi mật khẩu' : 'Nhập lại mật khẩu' }}" {{ isset($user) ? '' : 'required' }}>
                </div>

                <div class="mb-5 grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Cấp độ Đại lý</label>
                        <input type="number" name="level" value="{{ old('level', $user->level ?? '1') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="1" min="1">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Chiết khấu (%)</label>
                        <input type="number" name="discount_rate" value="{{ old('discount_rate', $user->discount_rate ?? '15') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="15" min="0" max="100" step="0.1">
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Số dư ban đầu (VND)</label>
                    <input type="number" name="balance" value="{{ old('balance', isset($user) ? round($user->balance) : '0') }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="0" min="0">
                </div>

                <div class="mb-5 pt-3">
                    <label class="flex items-center cursor-pointer group mb-1">
                        <span class="text-sm font-medium text-gray-300 mr-4 group-hover:text-white transition-colors">Kích hoạt tài khoản ngay</span>
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" name="is_active" id="isActiveCheckbox" {{ (old('is_active') || (isset($user) && $user->status === 'active') || !isset($user)) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </div>
                    </label>
                    <p class="text-xs text-gray-500 mt-1">Bật để cho phép đăng nhập ngay</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-[#2a2d35] flex justify-end gap-3">
            <a href="{{ route('admin.taikhoandaily') }}" class="px-6 py-2.5 rounded-md border border-[#2a2d35] text-white hover:bg-[#2a2d35] transition-colors font-medium">Hủy bỏ</a>
            <button type="submit" class="px-6 py-2.5 rounded-md bg-[#E70814] hover:bg-[#ff0f1e] text-white transition-colors font-medium shadow-[0_2px_10px_rgba(231,8,20,0.3)] flex items-center gap-2" id="submitBtnText">
                <span class="material-symbols-outlined text-[20px]">save</span>
                {{ isset($user) ? 'Cập nhật Đại lý' : 'Lưu Đại lý' }}
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/admin/js/taikhoandaily.js') }}"></script>
@endpush
