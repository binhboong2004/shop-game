@extends('admin.layouts.master')

@section('content_header')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-[28px] font-bold text-white mb-2">Vòng Quay May Mắn</h1>
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E70814] transition-colors">Trang chủ</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-white">Marketing</span>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-[#E70814]">Vòng Quay May Mắn</span>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#20222a] hover:bg-[#2a2d35] text-white px-4 py-2 rounded-md font-medium transition-all flex items-center gap-2 border border-[#2a2d35]">
            <span class="material-symbols-outlined text-[20px]">settings</span>
            Cấu hình
        </button>
        <button class="bg-[#E70814] hover:bg-[#c60711] text-white px-4 py-2 rounded-md font-medium transition-all shadow-[0_4px_12px_rgba(231,8,20,0.25)] flex items-center gap-2" id="btnAddWheel">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Thêm Vòng Quay Mới
        </button>
    </div>
</div>
@endsection

@section('content')
<!-- Filter & Search -->
<div class="bg-[#1a1c23] border border-[#2a2d35] rounded-xl p-5 mb-6">
    <div class="flex flex-col md:flex-row gap-4 mb-5">
        <div class="flex-1 relative">
            <input type="text" placeholder="Tìm kiếm vòng quay..." class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md pl-10 pr-4 py-2.5 focus:outline-none focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814]/50 transition-all font-medium placeholder-gray-500">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">search</span>
        </div>
        <div class="w-full md:w-[200px]">
            <select class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-md px-4 py-2.5 focus:outline-none focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814]/50 transition-all font-medium cursor-pointer appearance-none custom-select">
                <option value="">Trạng thái: Tất cả</option>
                <option value="active">Đang hoạt động</option>
                <option value="inactive">Đã tạm dừng</option>
            </select>
        </div>
    </div>
</div>

<!-- List Vong Quay -->
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    <!-- Wheel Card 1 -->
    <div class="bg-[#1a1c23] border border-[#2a2d35] rounded-xl overflow-hidden hover:border-[#E70814]/50 transition-colors group relative">
        <div class="h-[160px] bg-[#13131A] relative flex items-center justify-center p-4 border-b border-[#2a2d35]">
            <div class="absolute top-3 right-3 flex items-center gap-2 z-10">
                <span class="bg-green-500/20 text-green-500 px-2 py-1 rounded text-xs font-bold border border-green-500/20">Hoạt động</span>
            </div>
            
            <div class="w-[120px] h-[120px] rounded-full border-4 border-[#2a2d35] bg-[#20222a] flex items-center justify-center relative overflow-hidden group-hover:border-[#E70814] transition-colors duration-300 shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                <span class="material-symbols-outlined text-[48px] text-[#E70814]">casino</span>
                <!-- Decorative elements for wheel -->
                <div class="absolute inset-x-0 w-[4px] h-full bg-[#2a2d35] mx-auto opacity-50"></div>
                <div class="absolute inset-y-0 h-[4px] w-full bg-[#2a2d35] my-auto opacity-50"></div>
            </div>
        </div>
        
        <div class="p-5">
            <h3 class="text-lg font-bold text-white mb-2 group-hover:text-[#E70814] transition-colors leading-tight">Vòng Quay Liên Quân Siêu Cấp</h3>
            <p class="text-sm text-gray-400 line-clamp-2 mb-4">Vòng quay với tỷ lệ trúng nick VIP lên đến 50%. Yêu cầu 20k/lượt quay.</p>
            
            <div class="flex items-center justify-between py-3 border-t border-[#2a2d35]/50 mb-4">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Giá/Lượt</p>
                    <p class="text-sm font-bold text-white">20,000đ</p>
                </div>
                <div class="w-px h-8 bg-[#2a2d35]"></div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Đã quay</p>
                    <p class="text-sm font-bold text-green-500">1,250</p>
                </div>
                <div class="w-px h-8 bg-[#2a2d35]"></div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Doanh thu</p>
                    <p class="text-sm font-bold text-[#E70814]">25M</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button class="flex-1 bg-[#20222a] hover:bg-[#E70814] text-white hover:text-white border border-[#2a2d35] hover:border-[#E70814] py-2 rounded-md font-medium transition-all text-sm flex items-center justify-center gap-1.5 shadow-[0_4px_12px_transparent] hover:shadow-[0_4px_12px_rgba(231,8,20,0.25)]">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Chỉnh sửa
                </button>
                <button class="w-10 h-10 flex items-center justify-center bg-[#20222a] hover:bg-gray-100/10 text-gray-400 hover:text-white border border-[#2a2d35] py-2 rounded-md font-medium transition-all text-sm transition-colors">
                    <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Wheel Card 2 -->
    <div class="bg-[#1a1c23] border border-[#2a2d35] rounded-xl overflow-hidden hover:border-[#E70814]/50 transition-colors group relative">
        <div class="h-[160px] bg-[#13131A] relative flex items-center justify-center p-4 border-b border-[#2a2d35]">
            <div class="absolute top-3 right-3 flex items-center gap-2 z-10">
                <span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded text-xs font-bold border border-gray-500/20">Tạm dừng</span>
            </div>
            
            <div class="w-[120px] h-[120px] rounded-full border-4 border-[#2a2d35] bg-[#20222a] flex items-center justify-center relative overflow-hidden group-hover:border-gray-500 transition-colors duration-300 opacity-70 shadow-[0_4px_12px_rgba(0,0,0,0.5)]">
                <span class="material-symbols-outlined text-[48px] text-gray-500">casino</span>
                <!-- Decorative elements for wheel -->
                <div class="absolute inset-x-0 w-[4px] h-full bg-[#2a2d35] mx-auto opacity-50"></div>
                <div class="absolute inset-y-0 h-[4px] w-full bg-[#2a2d35] my-auto opacity-50"></div>
            </div>
        </div>
        
        <div class="p-5">
            <h3 class="text-lg font-bold text-gray-300 mb-2 group-hover:text-white transition-colors leading-tight">Vòng Quay Free Fire 9k</h3>
            <p class="text-sm text-gray-500 line-clamp-2 mb-4">Vòng quay thử nhân phẩm Free Fire với giá cực sinh viên. Có thể trúng KC hoặc Nick FF xịn sò.</p>
            
            <div class="flex items-center justify-between py-3 border-t border-[#2a2d35]/50 mb-4 opacity-70">
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Giá/Lượt</p>
                    <p class="text-sm font-bold text-gray-300">9,000đ</p>
                </div>
                <div class="w-px h-8 bg-[#2a2d35]"></div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Đã quay</p>
                    <p class="text-sm font-bold text-gray-300">5,420</p>
                </div>
                <div class="w-px h-8 bg-[#2a2d35]"></div>
                <div class="text-center">
                    <p class="text-xs text-gray-500 mb-1">Doanh thu</p>
                    <p class="text-sm font-bold text-gray-300">48.7M</p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <button class="flex-1 bg-[#20222a] hover:bg-[#20222a]/80 text-gray-300 border border-[#2a2d35] py-2 rounded-md font-medium transition-all text-sm flex items-center justify-center gap-1.5 focus:outline-none focus:border-green-500 focus:text-green-500">
                    <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                    Kích hoạt
                </button>
                <button class="w-10 h-10 flex items-center justify-center bg-[#20222a] hover:bg-gray-100/10 text-gray-400 hover:text-white border border-[#2a2d35] py-2 rounded-md font-medium transition-all text-sm transition-colors">
                    <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/admin/js/vongquaymayman.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/vongquaymayman.css') }}">
@endsection
