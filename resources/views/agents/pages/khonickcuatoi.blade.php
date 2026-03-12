@extends('agents.layouts.master')

@section('title', 'Kho Nick Của Tôi')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/agents/css/khonickcuatoi.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/agents/js/khonickcuatoi.js') }}"></script>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <p class="text-agent-muted text-sm">Quản lý danh sách tài khoản game bạn đang đăng bán trên hệ thống.</p>
        </div>
        <div>
            <a href="#" class="inline-flex items-center gap-2 bg-agent-primary hover:bg-agent-hover text-white px-5 py-2.5 rounded-md font-bold transition-all shadow-[0_4px_12px_rgba(231,8,20,0.25)] hover:shadow-[0_6px_16px_rgba(231,8,20,0.4)]">
                <span class="material-symbols-outlined text-[20px]">add_circle</span>
                Đăng Nick Mới
            </a>
        </div>
    </div>

    <!-- Filters & Table Container -->
    <div class="bg-agent-card border border-agent-border rounded-lg overflow-hidden flex flex-col">
        <!-- Filters -->
        <div class="p-5 border-b border-agent-border flex flex-col md:flex-row md:items-center gap-4">
            <div class="relative flex-1 max-w-sm">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-agent-muted">search</span>
                <input type="text" id="searchInput" placeholder="Tìm kiếm theo tên hoặc mã nick..." class="w-full bg-agent-sidebar border border-agent-border text-white text-sm rounded-md pl-10 pr-4 py-2.5 focus:outline-none focus:border-agent-primary focus:ring-1 focus:ring-agent-primary transition-all">
            </div>
            
            <div class="flex items-center gap-3 flex-wrap">
                <select id="categorySelect" class="bg-agent-sidebar border border-agent-border text-agent-muted text-sm rounded-md px-4 py-2.5 focus:outline-none focus:border-agent-primary hover:text-white transition-all cursor-pointer">
                    <option value="all">Tất cả</option>
                    <option value="lien-quan">Liên Quân</option>
                    <option value="free-fire">Free Fire</option>
                    <option value="pubg">PUBG Mobile</option>
                    <option value="genshin">Genshin Impact</option>
                </select>
                
                <div class="hidden md:flex bg-agent-sidebar border border-agent-border rounded-md p-1 h-[42px]" id="categoryButtons">
                    <button class="filter-btn px-4 py-1.5 text-sm font-medium rounded text-white bg-agent-border/50" data-filter="all">Tất cả</button>
                    <button class="filter-btn px-4 py-1.5 text-sm font-medium rounded text-agent-muted hover:text-white transition-colors" data-filter="lien-quan">Liên Quân Mobile</button>
                    <button class="filter-btn px-4 py-1.5 text-sm font-medium rounded text-agent-muted hover:text-white transition-colors" data-filter="free-fire">Free Fire</button>
                    <button class="filter-btn px-4 py-1.5 text-sm font-medium rounded text-agent-muted hover:text-white transition-colors" data-filter="pubg">PUBG Mobile</button>
                    <button class="filter-btn px-4 py-1.5 text-sm font-medium rounded text-agent-muted hover:text-white transition-colors" data-filter="genshin">Genshin Impact</button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b border-agent-border bg-agent-sidebar/30">
                        <th class="py-4 px-5 text-xs font-bold text-agent-muted uppercase tracking-wider w-[100px]">Hình Ảnh</th>
                        <th class="py-4 px-5 text-xs font-bold text-agent-muted uppercase tracking-wider">Thông Tin Nick</th>
                        <th class="py-4 px-5 text-xs font-bold text-agent-muted uppercase tracking-wider w-[180px]">Giá Bán</th>
                        <th class="py-4 px-5 text-xs font-bold text-agent-muted uppercase tracking-wider w-[150px]">Trạng Thái</th>
                        <th class="py-4 px-5 text-xs font-bold text-agent-muted uppercase tracking-wider w-[120px] text-right">Hành Động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-agent-border/50">
                    <!-- Item 1: Đang bán -->
                    <tr class="nick-item hover:bg-agent-sidebar/20 transition-colors group" data-category="lien-quan" data-name="Acc LQ 100 skin" data-code="#LQ123456" data-price="500.000đ" data-game="Liên Quân Mobile" data-status="Đang bán" data-status-class="text-green-500">
                        <td class="py-4 px-5">
                            <img src="https://placehold.co/100x100/1a1c23/e70814?text=LQ" alt="Thumb" class="w-16 h-16 rounded object-cover border border-agent-border group-hover:border-agent-primary/50 transition-colors">
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-white text-base mb-1">Acc LQ 100 skin</div>
                            <div class="text-agent-muted text-xs">Mã: #LQ123456 &bull; Liên Quân Mobile</div>
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-agent-primary text-base">500.000đ</div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-500 border border-green-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Đang bán
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border flex items-center justify-center transition-all bg-opacity-80"><span class="material-symbols-outlined text-[18px]">edit_square</span></button>
                                <button type="button" onclick="showDeleteModal(this)" class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-red-500 hover:bg-red-500/10 hover:border-red-500/30 flex items-center justify-center transition-all bg-opacity-80"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Item 2: Đã bán -->
                    <tr class="nick-item hover:bg-agent-sidebar/20 transition-colors group" data-category="free-fire" data-name="Acc FF Quỷ Dạ Xoa" data-code="#FF987654" data-price="1.200.000đ" data-game="Free Fire" data-status="Đã bán" data-status-class="text-gray-400" data-buyer-name="Nguyễn Văn A" data-buyer-id="KH2810">
                        <td class="py-4 px-5">
                            <img src="https://placehold.co/100x100/1a1c23/e70814?text=FF" alt="Thumb" class="w-16 h-16 rounded object-cover border border-agent-border group-hover:border-agent-primary/50 transition-colors">
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-white text-base mb-1">Acc FF Quỷ Dạ Xoa</div>
                            <div class="text-agent-muted text-xs">Mã: #FF987654 &bull; Free Fire</div>
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-agent-primary text-base">1.200.000đ</div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Đã bán
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" onclick="showVisibilityModal(this)" class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border flex items-center justify-center transition-all bg-opacity-80" aria-label="Chi tiết"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 3: Chờ duyệt -->
                    <tr class="nick-item hover:bg-agent-sidebar/20 transition-colors group" data-category="pubg" data-name="Acc PUBG Rank Chí Tôn" data-code="#PB556677" data-price="850.000đ" data-game="PUBG Mobile" data-status="Chờ duyệt" data-status-class="text-yellow-500">
                        <td class="py-4 px-5">
                            <img src="https://placehold.co/100x100/1a1c23/e70814?text=PUBG" alt="Thumb" class="w-16 h-16 rounded object-cover border border-agent-border group-hover:border-agent-primary/50 transition-colors">
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-white text-base mb-1">Acc PUBG Rank Chí Tôn</div>
                            <div class="text-agent-muted text-xs">Mã: #PB556677 &bull; PUBG Mobile</div>
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-agent-primary text-base">850.000đ</div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Chờ duyệt
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border flex items-center justify-center transition-all bg-opacity-80"><span class="material-symbols-outlined text-[18px]">edit_square</span></button>
                                <button type="button" onclick="showDeleteModal(this)" class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-red-500 hover:bg-red-500/10 hover:border-red-500/30 flex items-center justify-center transition-all bg-opacity-80"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                            </div>
                        </td>
                    </tr>

                    <!-- Item 4: Từ chối duyệt -->
                    <tr class="nick-item hover:bg-agent-sidebar/20 transition-colors group" data-category="genshin" data-name="Acc Genshin AR 60 Vip" data-code="#GS112233" data-price="2.500.000đ" data-game="Genshin Impact" data-status="Từ chối" data-status-class="text-red-500">
                        <td class="py-4 px-5">
                            <img src="https://placehold.co/100x100/1a1c23/e70814?text=GEN" alt="Thumb" class="w-16 h-16 rounded object-cover border border-agent-border group-hover:border-agent-primary/50 transition-colors opacity-70">
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-white text-base mb-1">Acc Genshin AR 60 Vip</div>
                            <div class="text-agent-muted text-xs">Mã: #GS112233 &bull; Genshin Impact</div>
                        </td>
                        <td class="py-4 px-5">
                            <div class="font-bold text-agent-primary text-base opacity-70">2.500.000đ</div>
                        </td>
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-500 border border-red-500/20" title="Thông tin không chính xác">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Từ chối
                            </span>
                        </td>
                        <td class="py-4 px-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border flex items-center justify-center transition-all bg-opacity-80"><span class="material-symbols-outlined text-[18px]">edit_square</span></button>
                                <button type="button" onclick="showDeleteModal(this)" class="w-8 h-8 rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-red-500 hover:bg-red-500/10 hover:border-red-500/30 flex items-center justify-center transition-all bg-opacity-80"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-5 flex items-center justify-between border-t border-agent-border bg-agent-sidebar/10">
            <div class="text-sm text-agent-muted">
                Hiển thị <span class="font-bold text-white">1-4</span> trong số <span class="font-bold text-white">48</span> nick
            </div>
            <div class="flex items-center gap-1">
                <button class="w-8 h-8 flex items-center justify-center rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border transition-colors"><span class="material-symbols-outlined text-[16px]">chevron_left</span></button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-agent-primary text-white font-bold font-sm border border-agent-primary">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border transition-colors font-sm">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border transition-colors font-sm">3</button>
                <button class="w-8 h-8 flex items-center justify-center rounded bg-agent-sidebar border border-agent-border text-agent-muted hover:text-white hover:bg-agent-border transition-colors"><span class="material-symbols-outlined text-[16px]">chevron_right</span></button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-2">
        <!-- Card 1: Tổng nick đã bán -->
        <div class="bg-agent-card border border-agent-border rounded-lg p-5 flex flex-col hover:border-agent-primary/30 transition-colors shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-agent-primary/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded bg-agent-sidebar border border-agent-border flex items-center justify-center text-agent-muted text-xl group-hover:text-agent-primary group-hover:bg-agent-primary/10 transition-colors">
                    <span class="material-symbols-outlined">shopping_cart_checkout</span>
                </div>
                <!-- Mini sparkline mock -->
                <div class="text-green-500 text-xs font-bold flex items-center gap-1 bg-green-500/10 px-2 py-1 rounded">
                    +12% <span class="material-symbols-outlined text-[14px]">trending_up</span>
                </div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-black text-white mb-1">124</div>
                <div class="text-agent-muted text-sm font-medium">Tổng nick đã bán</div>
            </div>
        </div>

        <!-- Card 2: Doanh thu tháng này -->
        <div class="bg-agent-card border border-agent-border rounded-lg p-5 flex flex-col hover:border-agent-primary/30 transition-colors shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-agent-primary/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded bg-agent-sidebar border border-agent-border flex items-center justify-center text-agent-muted text-xl group-hover:text-agent-primary group-hover:bg-agent-primary/10 transition-colors">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
                <div class="text-green-500 text-xs font-bold flex items-center gap-1 bg-green-500/10 px-2 py-1 rounded">
                    +5.2tr <span class="material-symbols-outlined text-[14px]">trending_up</span>
                </div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-black text-white mb-1">45.800.000đ</div>
                <div class="text-agent-muted text-sm font-medium">Doanh thu tháng này</div>
            </div>
        </div>

        <!-- Card 3: Nick đang chờ duyệt -->
        <div class="bg-agent-card border border-agent-border rounded-lg p-5 flex flex-col hover:border-yellow-500/30 transition-colors shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-500/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded bg-agent-sidebar border border-agent-border flex items-center justify-center text-agent-muted text-xl group-hover:text-yellow-500 group-hover:bg-yellow-500/10 transition-colors">
                    <span class="material-symbols-outlined">hourglass_empty</span>
                </div>
                <div class="text-agent-muted text-xs font-medium">Bình thường</div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-black text-white mb-1">08</div>
                <div class="text-agent-muted text-sm font-medium">Nick đang chờ duyệt</div>
            </div>
        </div>

        <!-- Yêu cầu thêm từ User -->
        
        <!-- Card 4: Tổng nick đang bán -->
        <div class="bg-agent-card border border-agent-border rounded-lg p-5 flex flex-col hover:border-green-500/30 transition-colors shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-green-500/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded bg-agent-sidebar border border-agent-border flex items-center justify-center text-agent-muted text-xl group-hover:text-green-500 group-hover:bg-green-500/10 transition-colors">
                    <span class="material-symbols-outlined">storefront</span>
                </div>
                <div class="text-agent-muted text-xs font-medium bg-agent-sidebar px-2 py-1 rounded border border-agent-border">Hiển thị tốt</div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-black text-white mb-1">32</div>
                <div class="text-agent-muted text-sm font-medium">Tổng nick đang bán</div>
            </div>
        </div>

        <!-- Card 5: Tổng nick bị từ chối duyệt -->
        <div class="bg-agent-card border border-agent-border rounded-lg p-5 flex flex-col hover:border-red-500/30 transition-colors shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-red-500/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded bg-agent-sidebar border border-agent-border flex items-center justify-center text-agent-muted text-xl group-hover:text-red-500 group-hover:bg-red-500/10 transition-colors">
                    <span class="material-symbols-outlined">block</span>
                </div>
                <div class="text-red-500 text-xs font-bold flex items-center gap-1 bg-red-500/10 px-2 py-1 rounded border border-red-500/20">Cần chỉnh sửa</div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-black text-white mb-1">02</div>
                <div class="text-agent-muted text-sm font-medium">Tổng nick bị từ chối duyệt</div>
            </div>
        </div>

        <!-- Card 6: Doanh thu tổng -->
        <div class="bg-agent-card border border-agent-border rounded-lg p-5 flex flex-col hover:border-agent-primary/30 transition-colors shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-agent-primary/5 rounded-bl-full -z-0 transition-transform group-hover:scale-110"></div>
            <div class="flex items-start justify-between mb-4 relative z-10">
                <div class="w-12 h-12 rounded bg-agent-sidebar border border-agent-border flex items-center justify-center text-agent-muted text-xl group-hover:text-agent-primary group-hover:bg-agent-primary/10 transition-colors">
                    <span class="material-symbols-outlined">payments</span>
                </div>
                <div class="text-agent-primary text-xs font-bold flex items-center gap-1 bg-agent-primary/10 px-2 py-1 rounded border border-agent-primary/20">All time</div>
            </div>
            <div class="relative z-10">
                <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-agent-primary to-orange-500 mb-1">245.500.000đ</div>
                <div class="text-agent-muted text-sm font-medium">Doanh thu tổng</div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="bg-[#1a1c23] p-6 rounded-xl w-full max-w-[400px] relative z-10 flex flex-col items-center text-center border border-[#2a2d35] shadow-2xl scale-95 transition-transform duration-300 transform">
            <div class="w-14 h-14 bg-red-500/10 rounded-full flex items-center justify-center mb-4 border border-red-500/20 mt-2">
                <span class="material-symbols-outlined text-red-500 text-2xl">delete</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xóa sản phẩm?</h3>
            <p class="text-agent-muted text-sm mb-6 px-4">Bạn có chắc chắn muốn xóa sản phẩm này khỏi hệ thống?</p>
            <div class="flex items-center gap-3 w-full">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 bg-[#2a2d35] hover:bg-[#343741] text-white py-2.5 rounded-lg font-semibold transition-colors border border-transparent hover:border-gray-600">Hủy</button>
                <button type="button" onclick="confirmDelete()" class="flex-1 bg-agent-primary hover:bg-agent-hover text-white py-2.5 rounded-lg font-semibold transition-colors shadow-[0_4px_12px_rgba(231,8,20,0.25)]">Xóa ngay</button>
            </div>
        </div>
    </div>

    <!-- Visibility Modal -->
    <div id="visibilityModal" class="fixed inset-0 z-[100] hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeVisibilityModal()"></div>
        <div class="bg-agent-card p-6 rounded-xl w-full max-w-[400px] relative z-10 border border-agent-border shadow-2xl flex flex-col scale-95 transition-transform duration-300 transform">
            <div class="flex items-center justify-between border-b border-agent-border pb-4 mb-4">
                <h3 class="text-xl font-bold text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-agent-primary">info</span>
                    Chi tiết tài khoản
                </h3>
                <button type="button" onclick="closeVisibilityModal()" class="text-agent-muted hover:text-white transition-colors w-8 h-8 flex items-center justify-center rounded-md hover:bg-agent-sidebar">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center bg-agent-sidebar/50 p-2.5 rounded-md border border-agent-border/50">
                     <span class="text-agent-muted">Tên nick:</span>
                     <span class="text-white font-bold text-right" id="detail-name">...</span>
                </div>
                <!-- Buyer Info -->
                <div class="flex justify-between items-center bg-agent-sidebar/50 p-2.5 rounded-md border border-agent-border/50" id="buyer-info-container" style="display: none;">
                    <span class="text-agent-muted">Người mua:</span>
                    <div class="text-right">
                        <span class="text-white font-bold block" id="detail-buyer-name">...</span>
                        <span class="text-agent-primary text-xs font-medium" id="detail-buyer-id">...</span>
                    </div>
                </div>
                <div class="flex justify-between items-center bg-agent-sidebar/50 p-2.5 rounded-md border border-agent-border/50">
                     <span class="text-agent-muted">Mã nick:</span>
                     <span class="text-agent-muted font-bold text-right" id="detail-code">...</span>
                </div>
                <div class="flex justify-between items-center bg-agent-sidebar/50 p-2.5 rounded-md border border-agent-border/50">
                     <span class="text-agent-muted">Game:</span>
                     <span class="text-white font-medium text-right" id="detail-game">...</span>
                </div>
                <div class="flex justify-between items-center bg-agent-sidebar/50 p-2.5 rounded-md border border-agent-border/50">
                     <span class="text-agent-muted">Giá bán:</span>
                     <span class="text-agent-primary font-bold text-base text-right" id="detail-price">...</span>
                </div>
                <div class="flex justify-between items-center bg-agent-sidebar/50 p-2.5 rounded-md border border-agent-border/50">
                     <span class="text-agent-muted">Trạng thái:</span>
                     <span class="text-right font-bold" id="detail-status">...</span>
                </div>
            </div>
            <div class="mt-5 flex justify-end">
                <button type="button" onclick="closeVisibilityModal()" class="w-full bg-agent-sidebar hover:bg-agent-border text-white px-5 py-2.5 rounded-lg font-bold transition-colors border border-agent-border">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection
