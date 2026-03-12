<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $wishlists = $user->wishlists()->with('account')->get();
        return view('clients.pages.yeuthich', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm vào yêu thích.']);
        }

        $accountId = $request->input('account_id');
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $wishlist = $user->wishlists()->where('account_id', $accountId)->first();
        
        if ($wishlist) {
            $wishlist->delete();
            $action = 'removed';
            $message = 'Đã xóa khỏi danh sách yêu thích.';
        } else {
            $user->wishlists()->create([
                'account_id' => $accountId
            ]);
            $action = 'added';
            $message = 'Đã thêm vào danh sách yêu thích.';
        }

        $wishlistCount = $user->wishlists()->count();

        return response()->json([
            'success' => true, 
            'action' => $action,
            'message' => $message,
            'wishlist_count' => $wishlistCount
        ]);
    }
}
