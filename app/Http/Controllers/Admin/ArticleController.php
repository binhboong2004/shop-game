<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(10);
        
        $stats = [
            'total' => Article::count(),
            'news' => Article::where('type', 'news')->count(),
            'event' => Article::where('type', 'event')->count(),
            'hidden' => Article::where('status', 'draft')->count(),
        ];

        return view('admin.pages.tintucsukien', compact('articles', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required|in:news,event',
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['title', 'type', 'content', 'status', 'excerpt']);
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['author_id'] = Auth::id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        Article::create($data);

        return response()->json(['success' => true, 'message' => 'Lưu bài viết thành công!']);
    }

    public function edit(Article $article)
    {
        return response()->json($article);
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'type' => 'required|in:news,event',
            'content' => 'required',
            'status' => 'required|in:published,draft',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['title', 'type', 'content', 'status', 'excerpt']);
        if ($article->title !== $request->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        $article->update($data);

        return response()->json(['success' => true, 'message' => 'Cập nhật bài viết thành công!']);
    }

    public function destroy(Article $article)
    {
        if ($article->thumbnail) {
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        return response()->json(['success' => true, 'message' => 'Xóa bài viết thành công!']);
    }

    public function toggleStatus(Article $article)
    {
        $article->status = $article->status === 'published' ? 'draft' : 'published';
        $article->save();
        return response()->json(['success' => true, 'message' => 'Đã thay đổi trạng thái bài viết!']);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            
            $request->file('upload')->storeAs('articles/content', $fileName, 'public');
            
            $url = asset('storage/articles/content/' . $fileName);
            
            return response()->json([
                'uploaded' => 1,
                'fileName' => $fileName,
                'url' => $url
            ]);
        }
    }
}
