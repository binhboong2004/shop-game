@extends('clients.layouts.master')
@section('title', 'Đăng ký làm đại lý - ShopNickVN')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/clients/css/dangkydaily.css') }}">
@endpush

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 w-full">
    <div class="bg-white dark:bg-white/5 border border-primary/10 rounded-2xl p-6 sm:p-10 shadow-xl relative overflow-hidden">
        <!-- Decoration -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        
        <div class="text-center mb-10 relative z-10">
            <h1 class="text-3xl font-black mb-3">Đăng Ký Làm <span class="text-primary">Đại Lý</span></h1>
            <p class="text-slate-500 dark:text-slate-400">Trở thành đối tác của ShopNickVN để nhận nhiều ưu đãi và chiết khấu hấp dẫn.</p>
        </div>

        <form id="agentRegistrationForm" class="flex flex-col gap-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Họ và tên -->
                <div class="form-group">
                    <label class="block text-sm font-bold mb-2">Họ và tên <span class="text-primary">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 transition-colors">person</span>
                        <input type="text" name="name" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-slate-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Nhập họ và tên" required>
                    </div>
                </div>

                <!-- Số điện thoại -->
                <div class="form-group">
                    <label class="block text-sm font-bold mb-2">Số điện thoại <span class="text-primary">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 transition-colors">call</span>
                        <input type="tel" name="phone" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-slate-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Nhập số điện thoại" required>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Email -->
                <div class="form-group">
                    <label class="block text-sm font-bold mb-2">Email xác thực <span class="text-primary">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 transition-colors">mail</span>
                        <input type="email" name="email" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-slate-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Nhập email" required>
                    </div>
                </div>

                <!-- Zalo/Facebook -->
                <div class="form-group">
                    <label class="block text-sm font-bold mb-2">Link Facebook / Zalo</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400 transition-colors">link</span>
                        <input type="text" name="social_link" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-slate-700 rounded-lg pl-12 pr-4 py-3 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Link trang cá nhân">
                    </div>
                </div>
            </div>

            <!-- Lý do / Kinh nghiệm -->
            <div class="form-group">
                <label class="block text-sm font-bold mb-2">Kinh nghiệm bán hàng (Nếu có)</label>
                <textarea name="experience" rows="4" class="w-full bg-slate-50 dark:bg-black/20 border border-slate-200 dark:border-slate-700 rounded-lg p-4 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" placeholder="Bạn đã từng kinh doanh nick game chưa? Hãy chia sẻ với chúng tôi..."></textarea>
            </div>

            <!-- Terms -->
            <label class="flex items-start gap-3 cursor-pointer group mt-2">
                <input type="checkbox" name="terms" class="mt-1 w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary" required>
                <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-200 transition-colors">
                    Tôi đồng ý với các <a href="#" class="text-primary font-bold hover:underline">Điều khoản & Chính sách</a> của ShopNickVN dành cho đại lý.
                </span>
            </label>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/30 transition-all flex items-center justify-center gap-2 group mt-2">
                <span class="btn-text">Gửi Yêu Cầu Đăng Ký</span>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform btn-icon">arrow_forward</span>
            </button>
        </form>

        <!-- Benefits -->
        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800 grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
            <div class="text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <h3 class="font-bold mb-1">Chiết khấu cao</h3>
                <p class="text-xs text-slate-500">Lên đến 30% cho mỗi giao dịch thành công</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined">support_agent</span>
                </div>
                <h3 class="font-bold mb-1">Hỗ trợ 24/7</h3>
                <p class="text-xs text-slate-500">Đội ngũ kỹ thuật hỗ trợ riêng biệt</p>
            </div>
            <div class="text-center">
                <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined">trending_up</span>
                </div>
                <h3 class="font-bold mb-1">Thưởng doanh số</h3>
                <p class="text-xs text-slate-500">Thưởng nóng hàng tháng khi đạt KPI</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/clients/js/dangkydaily.js') }}"></script>
@endpush
