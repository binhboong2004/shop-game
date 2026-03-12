@extends('admin.layouts.master')

@section('title', 'Cấu hình chung')

@section('content_header')
<div class="flex items-center justify-between xl:mb-6 mb-4 xl:mt-0 mt-4">
    <div>
        <h1 class="text-2xl font-bold text-white mb-1"><span class="text-[#E70814]">|</span> Cấu hình chung</h1>
        <p class="text-sm text-gray-400">Quản lý các thiết lập hệ thống cơ bản</p>
    </div>
    
    <!-- Breadcrumb -->
    <nav class="hidden md:flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[18px] mr-1.5">home</span>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 text-[18px] mr-1.5">chevron_right</span>
                    <a href="#" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Cài Đặt</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-gray-500 text-[18px] mr-1.5">chevron_right</span>
                    <span class="text-sm font-medium text-[#E70814]">Cấu hình chung</span>
                </div>
            </li>
        </ol>
    </nav>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <!-- Form Settings -->
    <div class="xl:col-span-2 space-y-6">
        <form action="#" method="POST" enctype="multipart/form-data" id="form-settings">
            @csrf
            
            <!-- General Info -->
            <div class="bg-[#1a1c23] rounded-xl border border-[#2a2d35] overflow-hidden shadow-sm hover:shadow-[0_4px_24px_rgba(0,0,0,0.2)] transition-all mb-6">
                <div class="border-b border-[#2a2d35] p-5 flex items-center justify-between bg-[#13131A]">
                    <h3 class="font-bold text-white text-[15px] flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#E70814] text-[20px]">info</span>
                        Thông tin cơ bản
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <!-- Website Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Tên Website <span class="text-[#E70814]">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500 text-[18px]">language</span>
                                <input type="text" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg pl-10 pr-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm" placeholder="VD: ShopNickVN" value="ShopNickVN" required>
                            </div>
                        </div>

                        <!-- Hotline -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Hotline / Zalo <span class="text-[#E70814]">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500 text-[18px]">call</span>
                                <input type="text" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg pl-10 pr-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm" placeholder="Nhập số điện thoại" value="0987.654.321" required>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email hỗ trợ</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500 text-[18px]">mail</span>
                                <input type="email" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg pl-10 pr-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm" placeholder="VD: hotro@shopnick.vn" value="hotro@shopnick.vn">
                            </div>
                        </div>
                        
                        <!-- Facebook Link -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Link Fanpage Facebook</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-500 text-[18px]">public</span>
                                <input type="text" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg pl-10 pr-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm" placeholder="https://facebook.com/..." value="https://facebook.com/shopnickvn">
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Logo Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Logo Website</label>
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-lg border border-dashed border-[#2a2d35] bg-[#13131A] flex items-center justify-center p-2 relative overflow-hidden group">
                                    <img src="https://ui-avatars.com/api/?name=SN&background=1a1c23&color=E70814" alt="Logo preview" class="max-w-full max-h-full object-contain z-0" id="logo-preview">
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <span class="material-symbols-outlined text-white text-[20px]">upload</span>
                                    </div>
                                    <input type="file" id="logo-upload" class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*">
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 mb-2">Định dạng: PNG, JPG, SVG.<br>Kích thước khuyên dùng: 200x50px.<br>Dung lượng tối đa: 2MB.</p>
                                    <button type="button" class="btn-upload text-xs px-3 py-1.5 bg-[#20222a] hover:bg-[#2a2d35] text-white border border-[#2a2d35] rounded-md transition-colors" onclick="document.getElementById('logo-upload').click()">Chọn ảnh khác</button>
                                </div>
                            </div>
                        </div>

                        <!-- Favicon Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Favicon (Icon tab)</label>
                            <div class="flex items-center gap-4">
                                <div class="w-24 h-24 rounded-lg border border-dashed border-[#2a2d35] bg-[#13131A] flex items-center justify-center p-2 relative overflow-hidden group">
                                    <img src="https://ui-avatars.com/api/?name=SN&background=1a1c23&color=E70814" alt="Favicon preview" class="w-12 h-12 object-contain z-0" id="favicon-preview">
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <span class="material-symbols-outlined text-white text-[20px]">upload</span>
                                    </div>
                                    <input type="file" id="favicon-upload" class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*">
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-gray-400 mb-2">Định dạng: ICO, PNG.<br>Kích thước khuyên dùng: 32x32px hoặc 64x64px.</p>
                                    <button type="button" class="btn-upload text-xs px-3 py-1.5 bg-[#20222a] hover:bg-[#2a2d35] text-white border border-[#2a2d35] rounded-md transition-colors" onclick="document.getElementById('favicon-upload').click()">Chọn ảnh khác</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="bg-[#1a1c23] rounded-xl border border-[#2a2d35] overflow-hidden shadow-sm hover:shadow-[0_4px_24px_rgba(0,0,0,0.2)] transition-all mb-6">
                <div class="border-b border-[#2a2d35] p-5 flex items-center justify-between bg-[#13131A]">
                    <h3 class="font-bold text-white text-[15px] flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500 text-[20px]">travel_explore</span>
                        Tối ưu hóa tìm kiếm (SEO)
                    </h3>
                </div>
                <div class="p-6">
                    <!-- SEO Title -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tiêu đề (Title) mặc định</label>
                        <input type="text" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm" placeholder="Nhập tiêu đề SEO" value="ShopNickVN - Shop Bán Nick Game Uy Tín Số 1">
                        <p class="text-[11px] text-gray-500 mt-1.5 text-right"><span class="text-green-500 font-medium" id="title-counter">44</span>/60 ký tự (Đề xuất)</p>
                    </div>

                    <!-- SEO Description -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Mô tả (Description) mặc định</label>
                        <textarea rows="3" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm resize-none" placeholder="Nhập mô tả SEO">ShopNickVN chuyên mua bán nick game Liên Quân, Free Fire, PUBG Mobile giá rẻ, uy tín, giao dịch tự động 24/7.</textarea>
                        <p class="text-[11px] text-gray-500 mt-1.5 text-right"><span class="text-green-500 font-medium" id="desc-counter">108</span>/160 ký tự (Đề xuất)</p>
                    </div>

                    <!-- SEO Keywords -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Từ khóa (Keywords)</label>
                        <input type="text" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none text-sm" placeholder="Từ khóa 1, Từ khóa 2, ..." value="Shop game, nick game, mua acc, acc game rẻ">
                        <p class="text-[11px] text-gray-500 mt-1.5">Cách nhau bởi dấu phẩy (,)</p>
                    </div>
                </div>
            </div>

            <!-- Scripts -->
            <div class="bg-[#1a1c23] rounded-xl border border-[#2a2d35] overflow-hidden shadow-sm hover:shadow-[0_4px_24px_rgba(0,0,0,0.2)] transition-all">
                <div class="border-b border-[#2a2d35] p-5 flex items-center justify-between bg-[#13131A]">
                    <h3 class="font-bold text-white text-[15px] flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500 text-[20px]">code</span>
                        Tích hợp Script (Google, Fanpage, Livechat)
                    </h3>
                </div>
                <div class="p-6">
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Script Header (Mã nhúng dán vào thẻ &lt;head&gt;)</label>
                        <textarea rows="4" class="w-full bg-[#13131A] text-green-400 font-mono text-xs border border-[#2a2d35] rounded-lg px-4 py-3 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none resize-none" spellcheck="false" placeholder="<script>...</script>"></textarea>
                        <p class="text-[11px] text-gray-500 mt-1.5">Thường dùng để chèn mã Google Analytics, Facebook Pixel.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Script Footer (Mã nhúng dán cuối thẻ &lt;body&gt;)</label>
                        <textarea rows="4" class="w-full bg-[#13131A] text-green-400 font-mono text-xs border border-[#2a2d35] rounded-lg px-4 py-3 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] transition-colors outline-none resize-none" spellcheck="false" placeholder="<script>...</script>"></textarea>
                        <p class="text-[11px] text-gray-500 mt-1.5">Tránh chèn JS nặng làm giảm tốc độ tải trang. Phù hợp chèn Livechat.</p>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- Status & Save Panel -->
    <div class="xl:col-span-1">
        <div class="bg-[#1a1c23] rounded-xl border border-[#2a2d35] overflow-hidden shadow-sm sticky top-[100px]">
            <div class="border-b border-[#2a2d35] p-5 bg-[#13131A]">
                <h3 class="font-bold text-white text-[15px] flex items-center gap-2">
                    <span class="material-symbols-outlined text-yellow-500 text-[20px]">tune</span>
                    Trạng thái hệ thống
                </h3>
            </div>
            <div class="p-6">
                <!-- Maintenance Mode -->
                <div class="flex items-start justify-between mb-6 pb-6 border-b border-[#2a2d35]">
                    <div class="pr-4">
                        <h4 class="text-sm font-bold text-white mb-1">Chế độ bảo trì</h4>
                        <p class="text-xs text-gray-400">Khóa truy cập vào website phía User, chỉ Admin mới thấy trang web. Dùng khi nâng cấp hệ thống.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div class="w-11 h-6 bg-[#2a2d35] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E70814]"></div>
                    </label>
                </div>

                <!-- Debug Mode -->
                <div class="flex items-start justify-between mb-6 pb-6 border-b border-[#2a2d35]">
                    <div class="pr-4">
                        <h4 class="text-sm font-bold text-white mb-1">Chế độ Debug</h4>
                        <p class="text-xs text-gray-400">Hiển thị lỗi chi tiết khi web bị lỗi thay vì trang 500 mặc định. <span class="text-red-400">Không nên bật ở môi trường Production.</span></p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0 mt-1">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-[#2a2d35] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#E70814]"></div>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" form="form-settings" class="w-full bg-[#E70814] hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition-all flex items-center justify-center gap-2 shadow-[0_4px_12px_rgba(231,8,20,0.3)]">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    LƯU CẤU HÌNH
                </button>
                <button type="button" class="mt-3 w-full bg-transparent hover:bg-[#20222a] text-gray-400 hover:text-white font-medium py-2.5 px-4 rounded-lg border border-[#2a2d35] transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">refresh</span>
                    Khôi phục gốc
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/cauhinhchung.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/admin/js/cauhinhchung.js') }}"></script>
@endpush
