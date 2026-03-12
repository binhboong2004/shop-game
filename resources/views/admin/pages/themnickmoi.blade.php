@extends('admin.layouts.master')

@section('title', 'Thêm Nick Tới')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/themnickmoi.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">{{ isset($account) ? 'Chỉnh sửa Nick' : 'Thêm Nick Mới' }}</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">Hệ thống</a></li>
                <li><span class="mx-2">/</span></li>
                <li><a href="{{ route('admin.danhsachnick') }}" class="text-[#E70814] hover:underline">Danh sách Nick có sẵn</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Thêm mới</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.danhsachnick') }}" class="bg-[#20222a] hover:bg-[#2a2d35] border border-[#2a2d35] text-white px-4 py-2 rounded-md transition-colors flex items-center gap-2 text-sm font-medium">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Quay lại
        </a>
    </div>
</div>

<div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-6 mb-6 transform transition-all hover:border-gray-500/50">
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($account))
            @method('PUT')
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Thông tin chung & Game -->
            <div>
                <h3 class="text-lg font-bold text-white mb-5 border-b border-[#2a2d35] pb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E70814]">info</span>
                    Thông tin Nick
                </h3>
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tên/Tiêu đề Nick <span class="text-[#E70814]">*</span></label>
                    <input type="text" name="name" value="{{ $account->title ?? '' }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="VD: Nick Trắng Thông Tin, Full Tướng" required>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nhãn / Badge Nick</label>
                    <input type="text" name="badge" value="{{ $account->badge ?? '' }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="VD: HOT, -15%, SALE, VIP...">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Danh mục Game <span class="text-[#E70814]">*</span></label>
                    <div class="relative">
                        <select name="game" id="gameSelect" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none appearance-none cursor-pointer" required>
                            <option value="">-- Chọn Game --</option>
                            @foreach($games as $game)
                                <option value="{{ $game->id }}" {{ (isset($account) && optional($account->gameCategory)->game_id == $game->id) ? 'selected' : '' }}>{{ $game->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-500 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Danh mục con <span class="text-[#E70814]">*</span></label>
                    <div class="relative">
                        <select name="category" id="categorySelect" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none appearance-none cursor-pointer" required disabled>
                            <option value="">-- Chọn Game cha trước --</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-500 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div id="gameAttributesContainer" class="mb-5 bg-[#1a1c23] p-4 rounded-md border border-[#2a2d35] hidden">
                    <h4 class="text-sm font-bold text-gray-300 mb-3 border-b border-[#2a2d35] pb-2">Cấu hình thuộc tính</h4>
                    <div id="attributesList" class="grid grid-cols-1 gap-4">
                        <!-- Thuộc tính động sẽ xuất hiện ở đây -->
                    </div>
                </div>



                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tên Đăng Nhập Game <span class="text-[#E70814]">*</span></label>
                    <input type="text" name="username" value="{{ $account->account_username ?? '' }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập tài khoản (Garena/FB/Google...)" required>
                </div>
                
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mật Khẩu Game <span class="text-[#E70814]">*</span></label>
                    <input type="text" name="password" value="{{ $account->account_password ?? '' }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="Nhập mật khẩu game" required>
                </div>

                <div class="mb-5 border-t border-[#2a2d35] pt-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2 border-b border-[#2a2d35] pb-2 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#E70814]">description</span>
                        Mô tả chi tiết sản phẩm
                    </label>
                    <textarea name="description" rows="5" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none mt-3" placeholder="Ví dụ: Tài khoản siêu VIP, có nhiều skin hiếm, phù hợp leo rank,...">{{ $account->description ?? '' }}</textarea>
                </div>
            </div>

            <!-- Hình ảnh & Giá -->
            <div>
                <h3 class="text-lg font-bold text-white mb-5 border-b border-[#2a2d35] pb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E70814]">image</span>
                    Hình ảnh & Giá trị
                </h3>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Ảnh Đại Diện Thumbnail <span class="text-[#E70814]">*</span></label>
                    <div class="relative w-full h-11 bg-[#13131A] border border-[#2a2d35] rounded-md hover:border-gray-500 transition-colors flex items-center px-3 cursor-pointer overflow-hidden group">
                        <input type="file" name="thumbnail" id="avatarInput" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" {{ isset($account) ? '' : 'required' }}>
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-[#E70814] transition-colors mr-2">cloud_upload</span>
                        <span id="fileNameDisplay" class="text-sm text-gray-400 truncate flex-1">{{ isset($account) && filled($account->images) ? 'Đã có ảnh (Tải lên để đổi)' : 'Chọn ảnh tải lên...' }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Ảnh nổi bật hiển thị trên shop (Khuyến nghị tỷ lệ 16:9)</p>
                </div>

                <div class="mb-5 flex flex-col gap-2">
                    <label class="block text-sm font-medium text-gray-300">Ảnh chi tiết sản phẩm (Nhiều ảnh) <span class="text-xs text-gray-500 font-normal">(Không bắt buộc)</span></label>
                    <div class="relative w-full bg-[#13131A] border-2 border-dashed border-[#2a2d35] rounded-md hover:border-gray-500 transition-colors flex flex-col items-center justify-center p-6 cursor-pointer group">
                        <input type="file" name="images[]" id="multipleImagesInput" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <span class="material-symbols-outlined text-gray-400 group-hover:text-[#E70814] transition-colors mb-2 text-3xl">photo_library</span>
                        <span class="text-sm text-gray-400 font-medium z-0 pointer-events-none">Kéo thả hoặc click để chọn nhiều ảnh</span>
                        <span class="text-xs text-gray-500 mt-1 z-0 pointer-events-none">Hỗ trợ JPG, PNG, WEBP</span>
                    </div>
                    <!-- Image Preview Container -->
                    <div id="imagePreviewContainer" class="flex flex-wrap gap-3 mt-2 hidden">
                        <!-- Previews will show here -->
                    </div>
                    @if(isset($account) && is_array($account->images) && count($account->images) > 1)
                    <div class="mt-3 bg-[#1a1c23] p-3 rounded border border-[#2a2d35]">
                        <p class="text-xs text-gray-400 mb-2">Các ảnh phụ hiện tại của nick (Trừ thumbnail):</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(array_slice($account->images, 1) as $imgUrl)
                            <div class="w-14 h-14 rounded overflow-hidden border border-[#2a2d35]">
                                <img src="{{ asset($imgUrl) }}" class="w-full h-full object-cover" />
                            </div>
                            @endforeach
                        </div>
                        <p class="text-[11px] mt-2 text-yellow-500 italic">* Lưu ý: Nếu tải lên ảnh mới, tất cả ảnh phụ cũ sẽ bị xóa và thay thế.</p>
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Giá Gốc (VND) <span class="text-[#E70814]">*</span></label>
                        <input type="number" name="original_price" value="{{ $account->original_price ?? '' }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-white text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="0" required min="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Giá Bán (VND) <span class="text-[#E70814]">*</span></label>
                        <input type="number" name="price" value="{{ $account->price ?? '' }}" class="w-full bg-[#13131A] border border-[#2a2d35] text-[#FF9800] font-bold text-sm rounded-md focus:ring-1 focus:ring-[#E70814] focus:border-[#E70814] hover:border-gray-500 transition-colors block px-3 py-2.5 outline-none" placeholder="0" required min="0">
                    </div>
                </div>

                <div class="mb-5 pt-3">
                    <label class="flex items-center cursor-pointer group mb-1">
                        <span class="text-sm font-medium text-gray-300 mr-4 group-hover:text-white transition-colors">Trạng thái Kích hoạt bán:</span>
                        <div class="relative inline-flex items-center">
                            <input type="checkbox" name="is_active" id="isActiveCheckbox" {{ (!isset($account) || $account->status === 'active') ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-[#13131A] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-400 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 border border-[#2a2d35]"></div>
                        </div>
                    </label>
                    <p class="text-xs text-gray-500 mt-1" id="statusDescription">Tắt sẽ Ẩn nick này trên hệ thống Shop (Khách không thể mua)</p>
                </div>
                
                <!-- Extra field for ID (Hidden or Readonly) when editing -->
                <div class="mb-5" id="idFieldContainer" style="display: {{ isset($account) ? 'block' : 'none' }};">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mã Nick (Mã SC)</label>
                    <input type="text" name="nick_id" value="{{ $account->id ?? '' }}" class="w-full bg-[#1a1c23] border border-[#2a2d35] text-gray-400 text-sm rounded-md px-3 py-2.5 outline-none cursor-not-allowed" readonly>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-[#2a2d35] flex justify-end gap-3">
            <a href="{{ route('admin.danhsachnick') }}" class="px-6 py-2.5 rounded-md border border-[#2a2d35] text-white hover:bg-[#2a2d35] transition-colors font-medium">Hủy bỏ</a>
            <button type="submit" id="submitBtn" class="px-6 py-2.5 rounded-md bg-[#E70814] hover:bg-[#ff0f1e] text-white transition-colors font-medium shadow-[0_2px_10px_rgba(231,8,20,0.3)] flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">save</span>
                <span id="submitBtnText">{{ isset($account) ? 'Lưu Thay Đổi' : 'Thêm Nick Mới' }}</span>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    window.existingAttributes = @json(isset($account) && $account->accountAttributes ? $account->accountAttributes->pluck('value', 'attribute_id') : new stdClass());
    window.existingCategory = "{{ isset($account) ? $account->game_category_id : '' }}";
</script>
<script src="{{ asset('assets/admin/js/themnickmoi.js') }}"></script>
@endpush
