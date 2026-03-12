@extends('agents.layouts.master')

@section('title', 'Đăng Nick Mới')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/agents/css/dangnickmoi.css') }}">
@endpush

@section('content')
<div class="space-y-6 animate-fade-in custom-scrollbar">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white mb-1">Đăng Nick Mới</h2>
            <p class="text-agent-muted text-sm">Thêm tài khoản game mới lên hệ thống để bán.</p>
        </div>
        <div>
            <a href="{{ route('agent.khonickcuatoi') }}" class="inline-flex items-center gap-2 bg-agent-sidebar hover:bg-agent-border border border-agent-border text-white px-5 py-2.5 rounded-md font-bold transition-all shadow-sm">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                Quay lại
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-agent-card border border-agent-border rounded-lg p-6">
        <form action="" method="POST" id="addNickForm">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Thông tin chung & Game -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-5 border-b border-agent-border pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-agent-primary">info</span>
                        Thông tin Nick
                    </h3>
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-agent-muted mb-2">Tên/Tiêu đề Nick <span class="text-agent-primary">*</span></label>
                        <input type="text" name="name" class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none" placeholder="VD: Nick Trắng Thông Tin, Full Tướng" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-agent-muted mb-2">Danh mục Game <span class="text-agent-primary">*</span></label>
                        <div class="relative">
                            <select name="game" class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none appearance-none cursor-pointer" required>
                                <option value="">-- Chọn Game --</option>
                                <option value="lienquan">Liên Quân Mobile</option>
                                <option value="freefire">Free Fire</option>
                                <option value="pubg">PUBG Mobile</option>
                                <option value="tocchien">Tốc Chiến</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-agent-muted pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-agent-muted mb-2">Phân loại (Loại Acc) <span class="text-agent-primary">*</span></label>
                        <div class="relative">
                            <select name="type" class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none appearance-none cursor-pointer" required>
                                <option value="trang_tt">Acc Trắng Thông Tin</option>
                                <option value="random">Acc Random</option>
                                <option value="vip">Acc VIP</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-2.5 text-agent-muted pointer-events-none">expand_more</span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-agent-muted mb-2">Tên Đăng Nhập Game <span class="text-agent-primary">*</span></label>
                        <input type="text" name="username" class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập tài khoản (Garena/FB/Google...)" required>
                    </div>
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-agent-muted mb-2">Mật Khẩu Game <span class="text-agent-primary">*</span></label>
                        <input type="password" name="password" class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập mật khẩu game" required>
                    </div>
                </div>

                <!-- Hình ảnh & Giá -->
                <div>
                    <h3 class="text-lg font-bold text-white mb-5 border-b border-agent-border pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-agent-primary">image</span>
                        Hình ảnh & Giá trị
                    </h3>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-agent-muted mb-2">Ảnh Đại Diện Thumbnail <span class="text-agent-primary">*</span></label>
                        <div class="relative w-full h-11 bg-agent-sidebar border border-agent-border rounded-md hover:border-agent-muted transition-colors flex items-center px-3 cursor-pointer overflow-hidden group">
                            <input type="file" name="thumbnail" id="avatarInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                            <span class="material-symbols-outlined text-agent-muted group-hover:text-agent-primary transition-colors mr-2">cloud_upload</span>
                            <span id="fileNameDisplay" class="text-sm text-agent-muted truncate flex-1">Chọn ảnh tải lên...</span>
                        </div>
                        <p class="text-xs text-agent-muted mt-1 opacity-70">Ảnh nổi bật hiển thị trên shop (Khuyến nghị tỷ lệ 16:9)</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-agent-muted mb-2">Giá Gốc (VND) <span class="text-agent-primary">*</span></label>
                            <input type="number" name="original_price" class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none" placeholder="0" required min="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-agent-muted mb-2">Giá Bán (VND) <span class="text-agent-primary">*</span></label>
                            <input type="number" name="price" class="w-full bg-agent-sidebar border border-agent-border text-[#FF9800] font-bold text-sm rounded-md focus:ring-1 focus:ring-agent-primary focus:border-agent-primary hover:border-agent-muted transition-colors block px-3 py-2.5 outline-none" placeholder="0" required min="0">
                        </div>
                    </div>

                    <div class="mb-5 pt-3">
                        <label class="flex items-center cursor-pointer group mb-1 w-max">
                            <span class="text-sm font-medium text-agent-muted mr-4 group-hover:text-white transition-colors">Trạng thái Kích hoạt bán:</span>
                            <div class="relative inline-flex items-center">
                                <input type="checkbox" name="is_active" id="isActiveCheckbox" checked class="sr-only peer">
                                <div class="w-11 h-6 bg-agent-sidebar peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-agent-border"></div>
                            </div>
                        </label>
                        <p class="text-xs text-agent-muted mt-1 opacity-70" id="statusDescription">Tắt sẽ Ẩn nick này trên hệ thống Shop (Khách không thể mua)</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-agent-border flex justify-end gap-3">
                <a href="{{ route('agent.khonickcuatoi') }}" class="px-6 py-2.5 rounded-md border border-agent-border text-white hover:bg-agent-sidebar transition-colors font-medium">Hủy bỏ</a>
                <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-md bg-agent-primary hover:bg-agent-hover text-white transition-colors font-medium shadow-[0_4px_12px_rgba(231,8,20,0.25)] flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    <span>Đăng Nick Mới</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/agents/js/dangnickmoi.js') }}"></script>
@endpush
