<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameCategory;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GameCategoryController extends Controller
{
    /**
     * Display a listing of the game categories.
     */
    public function index(Request $request)
    {
        $query = GameCategory::with('game')->withCount('accounts')->orderBy('created_at', 'desc');

        // Filter by Game
        if ($request->filled('game') && $request->input('game') !== 'all') {
            $query->where('game_id', $request->input('game'));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->paginate(20)->withQueryString();
        $games = Game::orderBy('name', 'asc')->get();

        $totalCategories = GameCategory::count();
        $activeCategories = GameCategory::where('status', 1)->count();
        $hiddenCategories = $totalCategories - $activeCategories;

        return view('admin.pages.quanlydanhmuccon', compact(
            'categories', 'games', 'totalCategories', 'activeCategories', 'hiddenCategories'
        ));
    }

    /**
     * Store a newly created game category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,hidden',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url|max:2048'
        ]);

        $category = new GameCategory();
        $category->game_id = $request->game_id;
        $category->name = $request->name;
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;
        
        while (GameCategory::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $category->slug = $slug;
        $category->status = $request->status === 'active' ? 1 : 0;
        $category->description = $request->description;

        // Handle Image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('game_categories', 'public');
            $category->image = '/storage/' . $path;
        } elseif (!empty($request->image_url)) {
            $category->image = $request->image_url;
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm danh mục con thành công!'
        ]);
    }

    /**
     * Update the specified game category in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,hidden',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url|max:2048'
        ]);

        $category = GameCategory::findOrFail($id);
        
        $category->game_id = $request->game_id;
        $category->name = $request->name;
        $baseSlug = Str::slug($request->name);
        $slug = $baseSlug;
        $counter = 1;

        // Kiểm tra slug hiện tại có trùng với slug mới không (để tránh tự trùng chính nó khi không đổi tên)
        while (GameCategory::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        
        $category->slug = $slug;
        $category->status = $request->status === 'active' ? 1 : 0;
        $category->description = $request->description;

        // Handle new Image if provided, either File or URL
        if ($request->hasFile('image_file')) {
            if ($category->image && str_starts_with($category->image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $category->image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('image_file')->store('game_categories', 'public');
            $category->image = '/storage/' . $path;
            
        } elseif (!empty($request->image_url)) {
            $category->image = $request->image_url;
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật danh mục con thành công!'
        ]);
    }

    /**
     * Handle toggle status via Ajax
     */
    public function toggleStatus(string $id)
    {
        $category = GameCategory::findOrFail($id);
        $category->update(['status' => !$category->status]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đổi trạng thái danh mục con thành công!'
        ]);
    }

    /**
     * Remove the specified game category from storage.
     */
    public function destroy(string $id)
    {
        $category = GameCategory::findOrFail($id);
        
        if ($category->accounts()->count() > 0) {
             return response()->json([
                'success' => false,
                'message' => 'Không thể xóa danh mục con đang có Nick thuộc về.'
            ], 400);
        }

        // Remove image if it was stored locally
        if ($category->image && str_starts_with($category->image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $category->image);
            Storage::disk('public')->delete($oldPath);
        }
        
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa danh mục con khỏi hệ thống!'
        ]);
    }
}
