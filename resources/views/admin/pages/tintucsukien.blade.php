@extends('admin.layouts.master')

@section('title', 'Tin tức & Sự kiện')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/css/tintucsukien.css') }}">
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-white">Tin tức & Sự kiện</h2>
        <nav class="text-sm font-medium text-gray-400 mt-1">
            <ol class="list-reset flex">
                <li><a href="{{ route('admin.dashboard') }}" class="text-[#E70814] hover:underline">CMS & Cài Đặt</a></li>
                <li><span class="mx-2">/</span></li>
                <li>Tin tức & Sự kiện</li>
            </ol>
        </nav>
    </div>
    <div class="flex items-center gap-3">
        <button class="bg-[#E70814] hover:bg-[#ff0f1e] text-white px-4 py-2 rounded-md shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-all flex items-center gap-2 text-sm font-medium" id="btn-add-news">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Thêm Bài Viết Mới
        </button>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tổng Bài Viết</p>
                <h3 class="text-2xl font-bold text-white">{{ $stats['total'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                <span class="material-symbols-outlined text-[28px]">article</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Tin Tức</p>
                <h3 class="text-2xl font-bold text-white">{{ $stats['news'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                <span class="material-symbols-outlined text-[28px]">newspaper</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Sự Kiện</p>
                <h3 class="text-2xl font-bold text-white">{{ $stats['event'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-500">
                <span class="material-symbols-outlined text-[28px]">event</span>
            </div>
        </div>
    </div>
    <div class="bg-[#20222a] rounded-lg border border-[#2a2d35] p-5 relative overflow-hidden group">
        <div class="flex justify-between items-center relative z-10">
            <div>
                <p class="text-gray-400 text-sm font-medium mb-1">Đang Ẩn/Chờ</p>
                <h3 class="text-2xl font-bold text-white">{{ $stats['hidden'] }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-[#E70814]/10 flex items-center justify-center text-[#E70814]">
                <span class="material-symbols-outlined text-[28px]">visibility_off</span>
            </div>
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
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814]">
                    </th>
                    <th class="p-4">Bài Viết</th>
                    <th class="p-4">Chuyên Mục</th>
                    <th class="p-4 text-center">Lượt Xem</th>
                    <th class="p-4 text-center">Trạng Thái</th>
                    <th class="p-4">Ngày Đăng</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-[#2a2d35]">
                @forelse($articles as $article)
                <tr class="hover:bg-[#1a1c23] transition-colors group" data-id="{{ $article->id }}">
                    <td class="p-4 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded border-[#2a2d35] bg-[#13131A] text-[#E70814] focus:ring-[#E70814]">
                    </td>
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-16 h-12 rounded bg-[#13131A] border border-[#2a2d35] overflow-hidden shrink-0">
                                <img src="{{ $article->thumbnail ? asset('storage/' . $article->thumbnail) : 'https://placehold.co/150?text=No+Image' }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="Thumb">
                            </div>
                            <div>
                                <p class="font-bold text-white group-hover:text-[#E70814] transition-colors line-clamp-1 capitalize">{{ $article->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5 max-w-[300px] line-clamp-1">{{ $article->excerpt ?? 'Không có mô tả ngắn' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4">
                        @if($article->type == 'news')
                            <span class="inline-block px-2 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold border border-emerald-500/20 rounded">Tin Tức</span>
                        @else
                            <span class="inline-block px-2 py-1 bg-purple-500/10 text-purple-400 text-xs font-bold border border-purple-500/20 rounded">Sự Kiện</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <span class="text-gray-300 font-medium">{{ number_format($article->views) }}</span>
                    </td>
                    <td class="p-4 text-center">
                        <button onclick="toggleStatus({{ $article->id }})" class="inline-block w-20 px-2 py-1 {{ $article->status == 'published' ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-gray-500/10 text-gray-400 border-gray-500/20' }} text-xs font-bold border rounded btn-status-toggle">
                            {{ $article->status == 'published' ? 'Hiển thị' : 'Đang ẩn' }}
                        </button>
                    </td>
                    <td class="p-4 text-gray-400">
                        <div class="text-xs">{{ $article->created_at->format('d/m/Y H:i') }}</div>
                        <div class="text-[11px] mt-0.5 text-blue-400">Bởi: {{ $article->author->name ?? 'Admin' }}</div>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="editNews({{ $article->id }})" class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-blue-400 hover:bg-blue-500 hover:text-white transition-colors flex items-center justify-center btn-edit">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                            <button onclick="confirmDelete({{ $article->id }})" class="w-8 h-8 rounded bg-[#13131A] border border-[#2a2d35] text-[#E70814] hover:bg-[#E70814] hover:text-white transition-colors flex items-center justify-center btn-delete">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">Chưa có bài viết nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="p-4 border-t border-[#2a2d35]">
        {{ $articles->links('vendor.pagination.tailwind') }}
    </div>
</div>

<!-- Modal Thêm/Sửa Bài Viết -->
<div id="newsModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-3xl max-h-[90vh] flex flex-col shadow-2xl relative">
        <div class="p-5 border-b border-[#2a2d35] flex items-center justify-between shrink-0">
            <h3 class="text-xl font-bold text-white" id="modalTitle">Thêm Bài Viết Mới</h3>
            <button type="button" class="btn-close-modal text-gray-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto admin-scrollbar flex-1">
            <form id="newsForm" class="space-y-5" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="newsId" name="id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tiêu đề bài viết <span class="text-[#E70814]">*</span></label>
                        <input type="text" id="newsTitle" name="title" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] outline-none" required placeholder="Nhập tiêu đề...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Chuyên mục <span class="text-[#E70814]">*</span></label>
                        <select id="newsCategory" name="type" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] outline-none appearance-none" required>
                            <option value="news">Tin tức</option>
                            <option value="event">Sự kiện</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Trạng thái hiển thị</label>
                        <select id="newsStatus" name="status" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2.5 focus:border-[#E70814] focus:ring-1 focus:ring-[#E70814] outline-none appearance-none">
                            <option value="published">Hiển thị ngay</option>
                            <option value="draft">Lưu nháp (Ẩn)</option>
                        </select>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Ảnh đại diện (Thumbnail)</label>
                        <div class="flex items-center gap-4">
                            <div class="w-32 h-20 rounded-lg border border-dashed border-[#2a2d35] bg-[#13131A] flex items-center justify-center p-1 relative overflow-hidden group">
                                <img src="" alt="" class="w-full h-full object-cover hidden z-0" id="thumbnail-preview">
                                <div class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10" id="upload-overlay">
                                    <span class="material-symbols-outlined text-white text-[20px]">upload</span>
                                </div>
                                <span class="material-symbols-outlined text-gray-500 text-[32px] absolute" id="thumbnail-icon">image</span>
                                <input type="file" id="thumbnail-upload" name="thumbnail" class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*">
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-400 mb-2">Định dạng: JPG, PNG, WEBP. Tỷ lệ 16:9.</p>
                                <button type="button" class="btn-upload text-xs px-3 py-1.5 bg-[#20222a] hover:bg-[#2a2d35] text-white border border-[#2a2d35] rounded-md transition-colors" onclick="document.getElementById('thumbnail-upload').click()">Tải ảnh lên</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Mô tả ngắn</label>
                        <textarea id="newsExcerpt" name="excerpt" rows="2" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg px-4 py-2 focus:border-[#E70814] outline-none resize-none text-sm" placeholder="Mô tả ngắn gọn về bài viết..."></textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Nội dung chi tiết <span class="text-[#E70814]">*</span></label>
                        <textarea id="newsContent" name="content" rows="8" class="w-full bg-[#13131A] text-white border border-[#2a2d35] rounded-lg p-4 focus:border-[#E70814] outline-none resize-none text-sm" placeholder="Nhập nội dung bài viết vào đây..."></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="p-5 border-t border-[#2a2d35] flex items-center justify-end gap-3 shrink-0 bg-[#20222a] rounded-b-xl">
            <button type="button" class="btn-close-modal px-5 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
            <button type="button" id="btn-save-news" class="px-5 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors">Lưu Bài Viết</button>
        </div>
    </div>
</div>

<!-- Modal Xóa -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-[#20222a] border border-[#2a2d35] rounded-xl w-full max-w-sm shadow-2xl relative">
        <div class="p-6 text-center">
            <div class="w-16 h-16 rounded-full bg-gray-500/10 text-gray-400 flex items-center justify-center mx-auto mb-4 border border-gray-500/20">
                <span class="material-symbols-outlined text-[32px]">delete</span>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Xác nhận Xóa</h3>
            <p class="text-gray-400 text-sm mb-6">Bạn có chắc chắn muốn xóa bài viết này không? Hành động này không thể hoàn tác.</p>
            <div class="flex items-center gap-3">
                <button type="button" class="btn-close-delete w-full px-4 py-2.5 rounded-lg border border-[#2a2d35] text-white font-medium hover:bg-[#2a2d35] transition-colors">Hủy</button>
                <button type="button" id="btn-confirm-delete" class="w-full px-4 py-2.5 rounded-lg bg-[#E70814] text-white font-medium hover:bg-[#ff0f1e] shadow-[0_2px_10px_rgba(231,8,20,0.3)] transition-colors">Xóa Ngay</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    let editor;
    ClassicEditor
        .create(document.querySelector('#newsContent'), {
            ckfinder: {
                uploadUrl: "{{ route('admin.tintucsukien.uploadImage') . '?_token=' . csrf_token() }}"
            }
        })
        .then(newEditor => {
            editor = newEditor;
        })
        .catch(error => {
            console.error(error);
        });

    const ARTICLE_ROUTES = {
        store: "{{ route('admin.tintucsukien.store') }}",
        edit: "{{ url('admin/tin-tuc-su-kien') }}/:id/edit",
        update: "{{ url('admin/tin-tuc-su-kien') }}/:id/update",
        delete: "{{ url('admin/tin-tuc-su-kien') }}/:id",
        toggle: "{{ url('admin/tin-tuc-su-kien') }}/:id/toggle-status"
    };
</script>
<style>
    .ck-editor__editable {
        min-height: 250px;
        background-color: #13131A !important;
        color: white !important;
        border-color: #2a2d35 !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: #2a2d35 !important;
    }
    .ck.ck-editor__main>.ck-editor__editable.ck-focused {
        border-color: #E70814 !important;
    }
    .ck.ck-toolbar {
        background: #1a1c23 !important;
        border-color: #2a2d35 !important;
    }
    .ck.ck-button {
        color: #8b8d93 !important;
    }
    .ck.ck-button:hover {
        background: #2a2d35 !important;
    }
    .ck.ck-button.ck-on {
        background: #E70814 !important;
        color: white !important;
    }
</style>
<script src="{{ asset('assets/admin/js/tintucsukien.js') }}"></script>
@endpush
