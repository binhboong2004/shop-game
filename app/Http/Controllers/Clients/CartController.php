<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $carts = $user->carts()->with('account')->get();
        return view('clients.pages.giohang', compact('carts'));
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để thêm vào giỏ hàng.']);
        }

        $accountId = $request->input('account_id');
        
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Check if already in cart
        $exists = $user->carts()->where('account_id', $accountId)->exists();
        if ($exists) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm đã có trong giỏ hàng.']);
        }

        $user->carts()->create([
            'account_id' => $accountId
        ]);

        $cartCount = $user->carts()->count();

        return response()->json([
            'success' => true, 
            'message' => 'Đã thêm thành công vào giỏ hàng.',
            'cart_count' => $cartCount
        ]);
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.']);
        }

        $accountId = $request->input('account_id');
        
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->carts()->where('account_id', $accountId)->delete();

        $cartCount = $user->carts()->count();

        return response()->json([
            'success' => true, 
            'message' => 'Đã xóa khỏi giỏ hàng.',
            'cart_count' => $cartCount
        ]);
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.']);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $carts = $user->carts()->with('account')->get();
        
        if ($carts->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng của bạn đang trống.']);
        }

        // Validate coupon (if applicable)
        $couponCode = $request->input('coupon_code');
        // Simple logic for total price calculation (discount logic skipped to keep simple, just use provided from FE for verification or recalculate)
        $subtotal = 0;
        $discount = 0;
        
        foreach ($carts as $cart) {
            $subtotal += $cart->account->price;
        }

        if ($couponCode === 'SHOPNICK50K') {
            $discount = 50000;
        } elseif ($couponCode === 'FREESHIP') {
            $discount = 20000;
        }

        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $totalPrice = $subtotal - $discount;

        if ($user->balance < $totalPrice) {
            return response()->json(['success' => false, 'message' => 'Số dư không đủ để thanh toán. Vui lòng nạp thêm.']);
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // 1. Deduct balance from buyer
            $user->balance -= $totalPrice;
            $user->save();

            // 2. Process each account order
            foreach ($carts as $cart) {
                $account = $cart->account;
                
                // Optional: Check if account already sold by someone else
                if ($account->status === 'sold') {
                    throw new \Exception("Tài khoản (MS: {$account->id}) đã được người khác mua. Vui lòng thử lại.");
                }

                $seller = $account->seller;

                // Update Account
                $account->status = 'sold';
                $account->buyer_id = $user->id;
                $account->sold_at = \Illuminate\Support\Carbon::now();
                $account->save();

                // Create Order
                \App\Models\Order::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $seller->id,
                    'account_id' => $account->id,
                    'amount' => $account->price, // Storing original individual price
                    'discount_code_id' => null, // Placeholder if you integrate real DB coupons
                    'status' => 'completed',
                ]);

                // Increase seller balance
                if ($seller) {
                    $seller->balance += $account->price;
                    $seller->save();
                    
                    // You might want to log transactions here
                }
            }

            // 3. Clear cart
            $user->carts()->delete();

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thanh toán thành công. Cảm ơn bạn đã mua hàng!',
                'redirect' => route('lichsumuahang')
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
}
