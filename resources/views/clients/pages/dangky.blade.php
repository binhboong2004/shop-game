@extends('clients.layouts.master')

@section('title', 'Đăng ký tài khoản - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/dangky.css') }}">
@endpush

@section('content')
<div class="mt-8 mb-16 flex items-center justify-center min-h-[60vh] px-4">
    <div class="w-full max-w-md bg-background-dark/80 backdrop-blur-sm border border-primary/20 rounded-2xl p-8 shadow-[0_0_30px_rgba(231,8,20,0.15)] relative overflow-hidden">
        
        <!-- Decoration effect -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/20 rounded-full blur-[80px] -z-10 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/10 rounded-full blur-[80px] -z-10 -translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-primary mb-4">
                <span class="material-symbols-outlined text-4xl">sports_esports</span>
            </a>
            <h1 class="text-2xl font-bold text-white mb-2">Tạo tài khoản mới</h1>
            <p class="text-sm text-slate-400">Gia nhập cộng đồng game thủ ngay hôm nay.</p>
        </div>

        <!-- Register Form -->
        <form class="space-y-4" id="registerForm" method="POST" action="{{ route('register.post') }}">
            @csrf

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/50 text-red-500 text-sm rounded-xl p-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Display Name -->
            <div class="space-y-1.5">
                <label class="text-sm font-bold text-slate-300">Tên hiển thị <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">badge</span>
                    </span>
                    <input type="text" id="fullname" name="name" value="{{ old('name') }}" required placeholder="Nhập tên của bạn"
                        class="w-full bg-background-light/50 border border-primary/20 rounded-xl pl-12 pr-4 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-500">
                </div>
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="text-sm font-bold text-slate-300">Email <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">mail</span>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Nhập địa chỉ email"
                        class="w-full bg-background-light/50 border border-primary/20 rounded-xl pl-12 pr-4 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-500">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label class="text-sm font-bold text-slate-300">Mật khẩu <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">lock</span>
                    </span>
                    <input type="password" id="password" name="password" required minlength="6" placeholder="Tạo mật khẩu (ít nhất 6 ký tự)"
                        class="w-full bg-background-light/50 border border-primary/20 rounded-xl pl-12 pr-12 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-500">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <label class="text-sm font-bold text-slate-300">Nhập lại mật khẩu <span class="text-red-500">*</span></label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">offline_pin</span>
                    </span>
                    <input type="password" id="password_confirmation" name="password_confirmation" required minlength="6" placeholder="Xác nhận lại mật khẩu"
                        class="w-full bg-background-light/50 border border-primary/20 rounded-xl pl-12 pr-12 py-3 text-white text-sm focus:border-primary focus:ring-1 focus:ring-primary focus:outline-none transition-all placeholder:text-slate-500">
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">visibility_off</span>
                    </button>
                </div>
                <p id="password-match-error" class="hidden text-xs text-red-500 mt-1 font-medium ml-1">Mật khẩu không khớp!</p>
            </div>

            <!-- Terms -->
            <div class="flex items-start pt-2">
                <div class="flex items-center h-5">
                    <input type="checkbox" id="terms" required checked class="w-4 h-4 text-primary bg-background-light border-primary/30 rounded focus:ring-primary focus:ring-2">
                </div>
                <label for="terms" class="ml-2 text-xs font-medium text-slate-300 pointer-events-none">
                    Tôi đồng ý với các <a href="#" class="text-primary hover:underline pointer-events-auto">Điều khoản dịch vụ</a> và <a href="#" class="text-primary hover:underline pointer-events-auto">Chính sách bảo mật</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="btnSubmit" class="w-full group flex items-center justify-center gap-2 px-8 py-3.5 mt-2 rounded-xl font-bold bg-primary text-white hover:brightness-110 shadow-[0_4px_15px_rgba(231,8,20,0.4)] transition-all">
                <span>Đăng ký tài khoản</span>
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">person_add</span>
            </button>
        </form>

        <!-- Social Login Divider -->
        <div class="mt-6 mb-6 relative flex items-center">
            <div class="flex-grow border-t border-primary/20"></div>
            <span class="flex-shrink-0 mx-4 text-xs font-medium text-slate-400">HOẶC ĐĂNG KÝ VỚI</span>
            <div class="flex-grow border-t border-primary/20"></div>
        </div>

        <!-- Social Buttons -->
        <div class="grid grid-cols-2 gap-4">
            <button class="flex items-center justify-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl transition-colors">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-4 h-4" alt="Google">
                <span class="text-sm font-bold text-white">Google</span>
            </button>
            <button class="flex items-center justify-center gap-2 px-4 py-2 bg-[#1877F2]/10 hover:bg-[#1877F2]/20 border border-[#1877F2]/30 rounded-xl transition-colors">
                <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" class="w-4 h-4" alt="Facebook">
                <span class="text-sm font-bold text-[#1877F2]">Facebook</span>
            </button>
        </div>

        <!-- Footer link -->
        <p class="mt-6 text-center text-sm text-slate-400">
            Đã có tài khoản? 
            <a href="{{ route('dangnhap') }}" class="font-bold text-primary hover:underline">Đăng nhập</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/dangky.js') }}"></script>
@endpush
