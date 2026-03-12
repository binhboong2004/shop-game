<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    /**
     * Display a listing of the games.
     */
    public function index()
    {
        // Load games with the count of related accounts through categories
        $games = Game::withCount('accounts')->orderBy('created_at', 'desc')->get();
        
        $totalGames = collect($games)->count();
        $activeGames = collect($games)->where('status', 1)->count();
        $hiddenGames = $totalGames - $activeGames;

        return view('admin.pages.quanlydanhmuc', compact('games', 'totalGames', 'activeGames', 'hiddenGames'));
    }

    /**
     * Store a newly created game in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,hidden',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url|max:2048'
        ]);

        $game = collect($request->only(['name', 'description']));
        $game['slug'] = Str::slug($request->name);
        $game['status'] = $request->status === 'active' ? 1 : 0;

        // Handle Image
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('games', 'public');
            $game['image'] = '/storage/' . $path;
        } elseif (!empty($request->image_url)) {
            $game['image'] = $request->image_url;
        }

        Game::create($game->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm danh mục thành công!'
        ]);
    }

    /**
     * Update the specified game in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,hidden',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_url' => 'nullable|url|max:2048'
        ]);

        $game = Game::findOrFail($id);
        
        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status === 'active' ? 1 : 0
        ];

        // Handle new Image if provided, either File or URL
        if ($request->hasFile('image_file')) {
            // Optional: delete old image from storage if it was a local file
            if ($game->image && str_starts_with($game->image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $game->image);
                Storage::disk('public')->delete($oldPath);
            }
            
            $path = $request->file('image_file')->store('games', 'public');
            $updateData['image'] = '/storage/' . $path;
            
        } elseif (!empty($request->image_url)) {
            $updateData['image'] = $request->image_url;
        }

        $game->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật danh mục thành công!'
        ]);
    }

    /**
     * Handle toggle status via Ajax
     */
    public function toggleStatus(string $id)
    {
        $game = Game::findOrFail($id);
        $game->update(['status' => !$game->status]);

        return response()->json([
            'success' => true,
            'message' => 'Đã đổi trạng thái danh mục thành công!'
        ]);
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(string $id)
    {
        $game = Game::findOrFail($id);
        
        // Remove image if it was stored locally
        if ($game->image && str_starts_with($game->image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $game->image);
            Storage::disk('public')->delete($oldPath);
        }
        
        $game->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa danh mục khỏi hệ thống!'
        ]);
    }
}
