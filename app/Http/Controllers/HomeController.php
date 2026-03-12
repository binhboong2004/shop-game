<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Game;
use App\Models\Account;
use App\Models\Order;
use App\Models\Deposit;
use App\Models\DiscountCode;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. 4 Danh Mục Game có nhiều nick đang bán nhất
        $topGames = Game::where('status', 1)
            ->withCount(['accounts' => function ($query) {
                $query->where('accounts.status', 'active');
            }])
            ->orderByDesc('accounts_count')
            ->take(4)
            ->get();

        // 2. Các danh mục game và tối đa 10 nick mới nhất của mỗi game
        $gamesWithAccounts = Game::where('status', 1)->get()->map(function ($game) {
            $game->setRelation('latest_accounts', $game->accounts()
                ->with('gameCategory')
                ->where('accounts.status', 'active')
                ->latest('accounts.created_at')
                ->take(10)
                ->get());
            return $game;
        })->filter(function ($game) {
            return $game->latest_accounts->count() > 0;
        });

        // 4. Đơn Hàng Gần Đây
        $recentOrders = Order::with(['buyer', 'account'])->orderBy('created_at', 'desc')->take(6)->get();

        // 5. Nạp Tiền Gần Đây
        $recentDeposits = Deposit::with(['user', 'category'])->where('status', 'approved')->orderBy('created_at', 'desc')->take(6)->get();

        $wishlistedIds = Auth::check() ? Auth::user()->wishlists()->pluck('account_id')->toArray() : [];

        return view('clients.pages.index', compact(
            'topGames', 
            'gamesWithAccounts', 
            'recentOrders', 
            'recentDeposits',
            'wishlistedIds'
        ));
    }

    public function sanphamchitiet($id)
    {
        $account = Account::with(['gameCategory', 'accountAttributes.attribute', 'seller'])
            ->where('status', 'active')
            ->findOrFail($id);

        $relatedAccounts = Account::with(['gameCategory'])
            ->where('game_category_id', $account->game_category_id)
            ->where('id', '!=', $account->id)
            ->where('status', 'active')
            ->latest('created_at')
            ->take(10)
            ->get();

        $wishlistedIds = Auth::check() ? Auth::user()->wishlists()->pluck('account_id')->toArray() : [];

        return view('clients.pages.sanphamchitiet', compact('account', 'relatedAccounts', 'wishlistedIds'));
    }

    public function magiamgia()
    {
        $discountCodes = DiscountCode::where('status', true)
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('clients.pages.magiamgia', compact('discountCodes'));
    }

    public function vongquaychitiet($id)
    {
        $wheel = \App\Models\LuckyWheel::with('game')->findOrFail($id);
        return view('clients.pages.vongquaychitiet', compact('wheel'));
    }

    public function tintuc(Request $request)
    {
        $query = \App\Models\Article::where('status', 'published');
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $featuredArticle = (clone $query)->latest()->first();

        if ($featuredArticle) {
            $articles = (clone $query)->where('id', '!=', $featuredArticle->id)
                                      ->latest()
                                      ->paginate(6);
        } else {
            $articles = (clone $query)->latest()->paginate(6);
        }

        $trendingArticles = \App\Models\Article::where('status', 'published')
            ->inRandomOrder()->take(5)->get();

        return view('clients.pages.tintuc', compact('featuredArticle', 'articles', 'trendingArticles'));
    }

    public function hotro()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('clients.pages.hotro', compact('settings'));
    }
    public function napthecao()
    {
        $deposits = [];
        if (\Illuminate\Support\Facades\Auth::check()) {
            $deposits = \App\Models\Deposit::with('category')
                ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->whereIn('deposit_category_id', [1, 2, 3])
                ->latest()
                ->take(10)
                ->get();
        }
        return view('clients.pages.napthecao', compact('deposits'));
    }

    public function napnganhang()
    {
        $recentBankDeposits = [];
        if (\Illuminate\Support\Facades\Auth::check()) {
            $recentBankDeposits = \App\Models\Deposit::with(['user', 'category'])
                ->where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->whereIn('deposit_category_id', [4, 5])
                ->latest()
                ->take(10)
                ->get();
        }
            
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('clients.pages.napnganhang', compact('recentBankDeposits', 'settings'));
    }

    public function submitBankDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_type' => 'required|in:mbbank,momo'
        ]);

        $category_id = $request->bank_type == 'momo' ? 5 : 4;
        $received_amount = $request->amount * 1.15;

        \App\Models\Deposit::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'deposit_category_id' => $category_id,
            'amount' => $request->amount,
            'received_amount' => $received_amount,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Đã gửi yêu cầu nạp tiền, vui lòng chờ hệ thống duyệt!']);
    }

    public function thongtincanhan()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        return view('clients.pages.thongtincanhan', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        if($user) {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật thông tin thành công!']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng!']);
        }

        if($user) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->new_password);
            $user->save();
        }

        return response()->json(['success' => true, 'message' => 'Cập nhật mật khẩu thành công!']);
    }

    public function lichsumuahang()
    {
        $orders = \App\Models\Order::with(['account.gameCategory'])
            ->where('buyer_id', \Illuminate\Support\Facades\Auth::id())
            ->latest()
            ->paginate(10);

        return view('clients.pages.lichsumuahang', compact('orders'));
    }

    public function lichsunaptien()
    {
        if (!\Illuminate\Support\Facades\Auth::check()) {
            return redirect()->route('dangnhap');
        }

        $deposits = \App\Models\Deposit::with('category')
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->latest()
            ->paginate(10);

        return view('clients.pages.lichsunaptien', compact('deposits'));
    }
    public function sanpham(Request $request)
    {
        $gameSlug = $request->query('game');
        $categorySlug = $request->query('category');

        $currentGame = null;
        $currentCategory = null;
        $attributes = collect();
        
        $query = Account::with(['gameCategory', 'accountAttributes.attribute'])
            ->where('status', 'active');
        if ($categorySlug) {
            $currentCategory = \App\Models\GameCategory::where('slug', $categorySlug)->firstOrFail();
            $currentGame = $currentCategory->game;
        } elseif ($gameSlug) {
            $currentGame = Game::where('slug', $gameSlug)->firstOrFail();
        }

        if ($currentGame) {
            $attributes = $currentGame->attributes()->where('status', 'active')->get();
            
            // Calculate Min/Max for numeric attributes
            foreach ($attributes as $attribute) {
                if (str_contains(strtolower($attribute->name), 'số lượng') || str_contains(strtolower($attribute->name), 'level')) {
                    $minMax = \App\Models\AccountAttribute::where('attribute_id', $attribute->id)
                        ->whereHas('account', function($q) use ($currentGame) {
                            $q->where('status', 'active');
                        })
                        ->selectRaw('MIN(CAST(value AS UNSIGNED)) as min_val, MAX(CAST(value AS UNSIGNED)) as max_val')
                        ->first();
                    
                    $attribute->min_val = $minMax->min_val ?? 0;
                    $attribute->max_val = $minMax->max_val ?? 100;
                }
            }
        }

        // Initialize Accounts Query
        $accountsQuery = \App\Models\Account::query()
            ->with(['gameCategory', 'accountAttributes.attribute'])
            ->where('status', 'active');

        if ($currentCategory) {
            $accountsQuery->where('game_category_id', $currentCategory->id);
        } elseif ($currentGame) {
            $accountsQuery->whereHas('gameCategory', function ($q) use ($currentGame) {
                $q->where('game_id', $currentGame->id);
            });
        }

        // Filter by Price
        if ($request->has('price')) {
            $priceRanges = explode(',', $request->query('price'));
            $accountsQuery->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    if ($range === '0-100000') {
                        $q->orWhere('price', '<', 100000);
                    } elseif ($range === '100000-500000') {
                        $q->orWhereBetween('price', [100000, 500000]);
                    } elseif ($range === '500000-2000000') {
                        $q->orWhereBetween('price', [500001, 2000000]);
                    } elseif ($range === '2000000-above') {
                        $q->orWhere('price', '>', 2000000);
                    }
                }
            });
        }

        // Filter by Dynamic Attributes
        foreach ($request->all() as $key => $value) {
            if (empty($value)) continue;

            if (!in_array($key, ['game', 'category', 'price', 'sort', 'page'])) {
                // Range filters (e.g. skin_min, skin_max)
                if (str_ends_with($key, '_min') || str_ends_with($key, '_max')) {
                    $baseKey = str_replace(['_min', '_max'], '', $key);
                    $minVal = $request->get($baseKey . '_min', 0);
                    $maxVal = $request->get($baseKey . '_max', 999999);
                    
                    $accountsQuery->whereHas('accountAttributes', function ($q) use ($baseKey, $minVal, $maxVal) {
                        $q->whereHas('attribute', function ($attrQ) use ($baseKey) {
                            $attrQ->where('variable_name', $baseKey);
                        })->whereRaw('CAST(value AS UNSIGNED) BETWEEN ? AND ?', [$minVal, $maxVal]);
                    });
                    // Skip the _max part so we don't query twice for the same attribute
                    if (str_ends_with($key, '_max')) continue;
                } else {
                    $optionValues = explode(',', $value);
                    $accountsQuery->whereHas('accountAttributes', function ($q) use ($key, $optionValues) {
                        $q->whereHas('attribute', function ($attrQ) use ($key) {
                            $attrQ->where('variable_name', $key);
                        })->whereIn('value', $optionValues);
                    });
                }
            }
        }

        // Sorting
        $sort = $request->query('sort', 'latest');
        if ($sort === 'price_asc') {
            $accountsQuery->orderBy('price', 'asc');
        } elseif ($sort === 'price_desc') {
            $accountsQuery->orderBy('price', 'desc');
        } else {
            $accountsQuery->orderBy('created_at', 'desc');
        }

        $accounts = $accountsQuery->paginate(20)->withQueryString();

        $wishlistedIds = [];
        if (auth()->check()) {
            // Check if wishlist relation exists on User model
            if (method_exists(auth()->user(), 'wishlists')) {
                $wishlistedIds = auth()->user()->wishlists()->pluck('account_id')->toArray();
            }
        }

        return view('clients.pages.sanpham', compact(
            'currentGame',
            'currentCategory',
            'attributes',
            'accounts',
            'wishlistedIds'
        ));
    }
}
