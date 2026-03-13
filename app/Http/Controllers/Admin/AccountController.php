<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    /**
     * Display a listing of the accounts.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Thống kê
        $totalAccounts = Account::count();
        $activeAccounts = Account::where('status', 'active')->count();
        $soldAccounts = Account::where('status', 'sold')->count();
        $hiddenAccounts = Account::where('status', 'pending_approval')->count();

        // Lấy danh sách Game cho filter
        $games = Game::orderBy('name', 'asc')->get();

        // Query cơ bản
        $query = Account::with(['gameCategory.game', 'seller', 'buyer'])->orderBy('created_at', 'desc');

        // Lọc theo tìm kiếm (Mã SC hoặc nội dung)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                // Giả sử mã SC là ID hoặc có field riêng. Ở DB có field 'title' và mã có thể là ID.
                // Ở blade hiển thị Mã SC: #SC-{id} 
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%" . str_replace(['SC', 'sc', '-', '#'], '', $search) . "%");
            });
        }

        // Lọc theo Game
        if ($request->filled('game') && $request->input('game') !== 'all') {
            $gameId = $request->input('game');
            $query->whereHas('gameCategory', function($q) use ($gameId) {
                $q->where('game_id', $gameId);
            });
        }

        // Lọc theo Trạng thái
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $query->where('status', $request->input('status'));
        }

        $accounts = $query->paginate(20)->withQueryString();

        return view('admin.pages.danhsachnick', compact(
            'accounts', 'totalAccounts', 'activeAccounts', 'soldAccounts', 'hiddenAccounts', 'games'
        ));
    }

    /**
     * Show the form for creating a new account.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Load options needed for the create form, like games
        $games = Game::orderBy('name', 'asc')->get();
        return view('admin.pages.themnickmoi', compact('games'));
    }

    /**
     * Show the form for editing the specified account.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $account = Account::with(['gameCategory.game', 'accountAttributes'])->findOrFail($id);
        $games = Game::orderBy('name', 'asc')->get();
        return view('admin.pages.themnickmoi', compact('account', 'games'));
    }

    /**
     * Store a newly created account in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'game' => 'required|exists:games,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'thumbnail' => 'required|image',
        ]);

        $account = new Account();
        $account->title = $request->input('name');
        
        // Use the selected game category from the form, or fall back to generic if not provided
        if ($request->filled('category')) {
            $account->game_category_id = $request->input('category');
        } else {
            $category = \App\Models\GameCategory::where('game_id', $request->input('game'))->first();
            if (!$category) {
                $game = Game::find($request->input('game'));
                // Create a default category if it doesn't exist
                $category = \App\Models\GameCategory::create([
                    'game_id' => $request->input('game'),
                    'name' => 'Tài khoản ' . $game->name,
                    'slug' => Str::slug('tai-khoan-' . $game->name . '-' . time()),
                    'status' => 1
                ]);
            }
            $account->game_category_id = $category->id;
        }
        
        $account->price = $request->input('price');
        $account->original_price = $request->input('original_price');
        $account->account_username = $request->input('username');
        $account->account_password = $request->input('password'); // Not hashing as per previous requirements
        $account->badge = $request->input('badge');
        $account->description = $request->input('description');
        $account->seller_id = Auth::id() ?? 1; // Default to admin if not authenticated (testing)
        $account->status = $request->has('is_active') ? 'active' : 'pending_approval';

        $imagesArray = [];
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('accounts', 'public');
            $imagesArray[] = 'storage/' . $path;
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('accounts', 'public');
                $imagesArray[] = 'storage/' . $path;
            }
        }
        
        if (!empty($imagesArray)) {
            $account->images = $imagesArray;
        }

        $account->save();

        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attrId => $value) {
                if (!empty($value)) {
                    \App\Models\AccountAttribute::create([
                        'account_id' => $account->id,
                        'attribute_id' => $attrId,
                        'value' => $value,
                    ]);
                }
            }
        }

        return redirect()->route('admin.danhsachnick')->with('success', 'Thêm nick mới thành công!');
    }

    /**
     * Update the specified account in storage.
     */
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'game' => 'required|exists:games,id',
            'price' => 'required|numeric|min:0',
            'original_price' => 'required|numeric|min:0',
        ]);

        $account->title = $request->input('name');
        
        if ($request->filled('category')) {
            $account->game_category_id = $request->input('category');
        } else {
            $category = \App\Models\GameCategory::where('game_id', $request->input('game'))->first();
            if (!$category) {
                $game = Game::find($request->input('game'));
                $category = \App\Models\GameCategory::create([
                    'game_id' => $request->input('game'),
                    'name' => 'Tài khoản ' . $game->name,
                    'slug' => Str::slug('tai-khoan-' . $game->name . '-' . time()),
                    'status' => 1
                ]);
            }
            $account->game_category_id = $category->id;
        }
        
        $account->price = $request->input('price');
        $account->original_price = $request->input('original_price');
        
        if ($request->filled('username')) {
            $account->account_username = $request->input('username');
        }
        if ($request->filled('password')) {
            $account->account_password = $request->input('password');
        }
        if ($request->filled('description')) {
            $account->description = $request->input('description');
        }
        $account->badge = $request->input('badge');
        
        if ($account->status !== 'sold') {
            $account->status = $request->has('is_active') ? 'active' : 'pending_approval';
        }

        $imagesArray = is_array($account->images) ? $account->images : [];
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('accounts', 'public');
            if (count($imagesArray) > 0) {
                $imagesArray[0] = 'storage/' . $path;
            } else {
                array_unshift($imagesArray, 'storage/' . $path);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('accounts', 'public');
                $imagesArray[] = 'storage/' . $path;
            }
        }
        
        $account->images = $imagesArray;

        $account->save();

        if ($request->has('attributes')) {
            $account->accountAttributes()->delete(); // Clear old attributes
            foreach ($request->input('attributes') as $attrId => $value) {
                if (!empty($value)) {
                    \App\Models\AccountAttribute::create([
                        'account_id' => $account->id,
                        'attribute_id' => $attrId,
                        'value' => $value,
                    ]);
                }
            }
        }

        return redirect()->route('admin.danhsachnick')->with('success', 'Cập nhật nick thành công!');
    }

    /**
     * Toggle status between active and hidden.
     */
    public function toggleStatus(Request $request, $id)
    {
        try {
            $account = Account::findOrFail($id);
            
            // Nếu đã bán thì không cho đổi trạng thái ẩn/hiện
            if ($account->status === 'sold') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tài khoản đã bán, không thể thay đổi trạng thái.'
                ], 400);
            }

            $account->status = ($account->status === 'pending_approval') ? 'active' : 'pending_approval';
            $account->save();

            $statusText = $account->status === 'active' ? 'Hiện' : 'Ẩn';

            return response()->json([
                'success' => true,
                'message' => 'Đã ' . $statusText . ' nick thành công!',
                'new_status' => $account->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified account from storage.
     */
    public function destroy($id)
    {
        try {
            $account = Account::findOrFail($id);
            
            $account->delete();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa nick thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a listing of accounts for approval (kiem duyet).
     */
    public function kiemDuyetNick(Request $request)
    {
        // Thống kê
        $pendingCount = Account::where('status', 'pending_approval')->count();
        $approvedTodayCount = Account::where('status', 'active')->whereDate('updated_at', \Carbon\Carbon::today())->count();
        $rejectedCount = Account::where('status', 'rejected')->count();

        // Lấy danh sách Game cho filter
        $games = Game::orderBy('name', 'asc')->get();

        // Query cơ bản (chỉ lấy pending, rejected, hoặc mới approved)
        $query = Account::with(['gameCategory.game', 'seller', 'buyer'])->orderBy('created_at', 'desc');

        // Lọc theo tìm kiếm (Mã SC hoặc tên đại lý)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%" . str_replace(['SC', 'sc', '-', '#'], '', $search) . "%")
                  ->orWhereHas('seller', function($sq) use ($search) {
                      $sq->where('full_name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo Game
        if ($request->filled('game') && $request->input('game') !== 'all') {
            $gameId = $request->input('game');
            $query->whereHas('gameCategory', function($q) use ($gameId) {
                $q->where('game_id', $gameId);
            });
        }

        // Lọc theo Trạng thái (Mặc định là pending_approval)
        $status = $request->input('status', 'pending_approval');
        if ($status !== 'all') {
            if ($status === 'approved') {
                $query->where('status', 'active');
            } else {
                $query->where('status', $status);
            }
        }

        $accounts = $query->paginate(20)->withQueryString();

        return view('admin.pages.kiemduyetnick', compact(
            'accounts', 'pendingCount', 'approvedTodayCount', 'rejectedCount', 'games'
        ));
    }

    /**
     * Approve an account.
     */
    public function approve(Request $request, $id)
    {
        try {
            $account = Account::findOrFail($id);
            
            if ($account->status !== 'pending_approval') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể duyệt tài khoản đang chờ duyệt.'
                ], 400);
            }

            $account->status = 'active';
            $account->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã duyệt nick thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject an account.
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'reason' => 'required|string|max:500'
            ]);

            $account = Account::findOrFail($id);
            
            if ($account->status !== 'pending_approval') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ có thể từ chối tài khoản đang chờ duyệt.'
                ], 400);
            }

            $account->status = 'rejected';
            $account->reject_reason = $request->reason; // Assuming this column exists or can just skip if it doesn't
            $account->save();

            // Here you could send a notification to the seller with the reason

            return response()->json([
                'success' => true,
                'message' => 'Đã từ chối nick thành công!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get attributes for a specific game.
     */
    public function getGameAttributes($id)
    {
        $attributes = \App\Models\Attribute::whereHas('games', function($query) use ($id) {
            $query->where('games.id', $id);
        })
        ->where('status', 'active')
        ->get();
            
        return response()->json($attributes);
    }

    /**
     * Get categories for a specific game.
     */
    public function getGameCategories($id)
    {
        $categories = \App\Models\GameCategory::where('game_id', $id)
            ->where('status', 1)
            ->get();
            
        return response()->json($categories);
    }
}
