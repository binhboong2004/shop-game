@extends('clients.layouts.master')

@section('title', 'Thông tin cá nhân - ShopNickVN')

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
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-sm mx-1">chevron_right</span>
                    <span class="text-slate-200">Thông tin cá nhân</span>
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
                        <!-- Preview Image -->
                        <img id="avatar-preview" src="{{ $user->avatar ?? 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png' }}" alt="Avatar"
                            class="w-full h-full object-cover rounded-full bg-background-dark">
                        <!-- Upload Overlay -->
                        <label for="avatar-upload" class="absolute inset-0 bg-black/60 rounded-full flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                            <span class="material-symbols-outlined text-white mb-1">photo_camera</span>
                            <span class="text-white text-[10px] font-bold">Thay đổi</span>
                        </label>
                        <input type="file" id="avatar-upload" class="hidden" accept="image/*">
                    </div>
                    <h3 class="font-bold text-xl text-white text-center mb-1">{{ $user->username ?? $user->name }}</h3>
                    <span class="text-primary text-xs font-bold bg-primary/10 px-3 py-1 rounded-full mb-3">
                        @if(isset($user->role))
                            {{ $user->role == 'admin' ? 'Quản trị viên' : ($user->role == 'agent' ? 'Đại lý' : 'Thành viên') }}
                        @else
                            Thành viên
                        @endif
                    </span>
                    <div class="w-full bg-background-dark border border-primary/20 rounded-xl p-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-slate-400">Số dư:</span>
                        <span class="font-bold text-lg text-primary">{{ number_format($user->balance ?? 0, 0, ',', '.') }}đ</span>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex flex-col gap-2">
                    <button class="menu-btn active flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all bg-primary text-white shadow-[0_4px_15px_rgba(231,8,20,0.4)]" data-target="tab-profile">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                            Thông tin chung
                        </div>
                    </button>
                    
                    <button class="menu-btn flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10" data-target="tab-password">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">password</span>
                            Đổi mật khẩu
                        </div>
                    </button>

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

                    <a href="{{ route('lichsuquay') }}" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">casino</span>
                            Lịch sử quay
                        </div>
                    </a>

                    <a href="#" class="flex items-center justify-between w-full px-4 py-3 rounded-xl text-sm font-medium transition-all text-slate-400 hover:text-white hover:bg-primary/10">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-[20px]">payment_arrow_down</span>
                            Rút vật phẩm
                        </div>
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

        <!-- Main Content (Tabs) -->
        <div class="lg:col-span-3">
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6 sm:p-8 relative overflow-hidden h-full">
                <!-- Background Decoration -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-[80px] -z-10 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

                <!-- Tab 1: Profile -->
                <div id="tab-profile" class="tab-pane active animate-fade-in">
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-primary/10">
                        <span class="material-symbols-outlined text-3xl text-primary">badge</span>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Thông tin chung</h2>
                            <p class="text-sm text-slate-400 mt-1">Quản lý thông tin cá nhân cơ bản của bạn.</p>
                        </div>
                    </div>

                    <form id="profile-form" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- ID (Readonly) -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-300">ID Tài khoản</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <span class="material-symbols-outlined text-[20px]">tag</span>
                                    </span>
                                    <input type="text" value="{{ $user->id }}" readonly
                                        class="w-full bg-background-dark/50 border border-primary/20 rounded-xl pl-10 pr-4 py-3 text-slate-400 text-sm focus:outline-none cursor-not-allowed">
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-300">Tên hiển thị <span class="text-red-500">*</span></label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">person</span>
                                    </span>
                                    <input type="text" name="name" id="name" value="{{ $user->name }}" required
                                        class="w-full bg-background-dark border border-primary/20 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-600">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-300 flex items-center justify-between">Email liên hệ 
                                    @if($user->is_verified || $user->email_verified_at)
                                        <span class="text-[10px] bg-green-500/10 text-green-500 px-2 py-0.5 rounded flex items-center gap-1 border border-green-500/20"><span class="material-symbols-outlined text-[12px]">verified</span>Đã xác thực</span>
                                    @else
                                        <span class="text-[10px] bg-yellow-500/10 text-yellow-500 px-2 py-0.5 rounded flex items-center gap-1 border border-yellow-500/20"><span class="material-symbols-outlined text-[12px]">warning</span>Chưa xác thực</span>
                                    @endif
                                </label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">mail</span>
                                    </span>
                                    <input type="email" value="{{ $user->email }}" readonly
                                        class="w-full bg-background-dark/50 border border-primary/20 rounded-xl pl-10 pr-4 py-3 text-slate-400 text-sm focus:outline-none cursor-not-allowed">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-300">Số điện thoại</label>
                                <div class="relative group">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">call</span>
                                    </span>
                                    <input type="tel" name="phone" id="phone" value="{{ $user->phone }}"
                                        class="w-full bg-background-dark border border-primary/20 rounded-xl pl-10 pr-4 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-600">
                                </div>
                            </div>
                            
                            <!-- Join Date (Readonly) -->
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-300">Ngày tham gia</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <span class="material-symbols-outlined text-[20px]">event</span>
                                    </span>
                                    <input type="text" value="{{ $user->created_at ? $user->created_at->format('d/m/Y') : '' }}" readonly
                                        class="w-full bg-background-dark/50 border border-primary/20 rounded-xl pl-10 pr-4 py-3 text-slate-400 text-sm focus:outline-none cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end pt-6 border-t border-primary/10 gap-3">
                            <button type="button" class="px-6 py-3 rounded-xl font-bold bg-primary/10 text-primary hover:bg-primary/20 transition-all border border-primary/20">
                                Hủy bỏ
                            </button>
                            <button type="submit" class="group flex items-center justify-center gap-2 px-8 py-3 rounded-xl font-bold bg-primary text-white hover:brightness-110 shadow-[0_4px_15px_rgba(231,8,20,0.4)] transition-all">
                                <span>Lưu thay đổi</span>
                                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tab 2: Password -->
                <div id="tab-password" class="tab-pane hidden animate-fade-in">
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-primary/10">
                        <span class="material-symbols-outlined text-3xl text-primary">security</span>
                        <div>
                            <h2 class="text-2xl font-bold text-white">Đổi mật khẩu</h2>
                            <p class="text-sm text-slate-400 mt-1">Cập nhật mật khẩu để bảo vệ tài khoản của bạn.</p>
                        </div>
                    </div>

                    <form id="password-form" class="space-y-6 max-w-xl mx-auto">
                        @csrf
                        <!-- Current Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-300">Mật khẩu hiện tại <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">lock</span>
                                </span>
                                <input type="password" name="current_password" required placeholder="Nhập mật khẩu hiện tại"
                                    class="w-full bg-background-dark border border-primary/20 rounded-xl pl-10 pr-12 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-600">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-300">Mật khẩu mới <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">key</span>
                                </span>
                                <input type="password" name="new_password" required placeholder="Nhập mật khẩu mới"
                                    class="w-full bg-background-dark border border-primary/20 rounded-xl pl-10 pr-12 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-600">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-300">Nhập lại mật khẩu mới <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 group-focus-within:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">key</span>
                                </span>
                                <input type="password" name="new_password_confirmation" required placeholder="Nhập lại mật khẩu mới"
                                    class="w-full bg-background-dark border border-primary/20 rounded-xl pl-10 pr-12 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-600">
                                <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end pt-6 gap-3">
                            <button type="submit" class="w-full group flex items-center justify-center gap-2 px-8 py-3 rounded-xl font-bold bg-primary text-white hover:brightness-110 shadow-[0_4px_15px_rgba(231,8,20,0.4)] transition-all">
                                <span class="material-symbols-outlined text-xl">save</span>
                                <span>Cập nhật mật khẩu</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/thongtincanhan.js') }}"></script>
@endpush
