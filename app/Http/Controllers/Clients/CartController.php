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
        // Recalculate subtotal and validate coupon
        $subtotal = 0;
        $discount = 0;
        foreach ($carts as $cart) {
            $subtotal += $cart->account->price;
        }

        $coupon = null;
        if ($request->filled('coupon_code')) {
            $coupon = \App\Models\DiscountCode::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->status == 1) {
                $now = now();
                $isValid = true;
                if ($coupon->start_date && $coupon->start_date > $now) $isValid = false;
                if ($coupon->end_date && $coupon->end_date < $now) $isValid = false;
                if ($coupon->max_uses > 0 && $coupon->used_count >= $coupon->max_uses) $isValid = false;
                if ($coupon->min_order_amount > 0 && $subtotal < $coupon->min_order_amount) $isValid = false;

                if ($isValid) {
                    if ($coupon->type === 'percent') {
                        $discount = ($subtotal * $coupon->value) / 100;
                        if ($coupon->max_discount_amount > 0 && $discount > $coupon->max_discount_amount) {
                            $discount = $coupon->max_discount_amount;
                        }
                    } else {
                        $discount = $coupon->value;
                    }
                }
            }
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
            \App\Models\User::where('id', $user->id)->decrement('balance', $totalPrice);

            // 2. Process each account order
            $totalDiscountUsed = 0;
            $remainingDiscount = $discount;
            $orderCount = count($carts);
            $processedCount = 0;

            foreach ($carts as $cart) {
                $processedCount++;
                $account = $cart->account;
                
                if ($account->status === 'sold') {
                    throw new \Exception("Tài khoản (MS: {$account->id}) đã được người khác mua. Vui lòng thử lại.");
                }

                $seller = $account->seller;

                // Calculate proportional discount for this item
                $itemDiscount = 0;
                if ($discount > 0 && $subtotal > 0) {
                    if ($processedCount === $orderCount) {
                        // Last item gets the remainder to avoid rounding issues
                        $itemDiscount = $remainingDiscount;
                    } else {
                        $itemDiscount = round(($account->price / $subtotal) * $discount);
                        $remainingDiscount -= $itemDiscount;
                    }
                }

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
                    'amount' => $account->price,
                    'discount_amount' => $itemDiscount,
                    'discount_code_id' => $coupon ? $coupon->id : null,
                    'status' => 'completed',
                ]);

                // Increase seller balance (Only if buyer is not the seller)
                if ($seller && $seller->id !== $user->id) {
                    \App\Models\User::where('id', $seller->id)->increment('balance', $account->price);
                }
            }

            // 3. Update coupon usage
            if ($coupon) {
                $coupon->increment('used_count');
            }

            // 4. Clear cart
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
