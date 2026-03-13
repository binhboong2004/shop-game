<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $code = $request->code;
        $subtotal = $request->subtotal;

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập mã giảm giá.'
            ]);
        }

        $coupon = DiscountCode::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại.'
            ]);
        }

        // Kiểm tra trạng thái
        if ($coupon->status != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đang bị tạm khóa.'
            ]);
        }

        // Kiểm tra thời gian
        $now = now();
        if ($coupon->start_date && $coupon->start_date > $now) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá chưa đến thời gian áp dụng.'
            ]);
        }

        if ($coupon->end_date && $coupon->end_date < $now) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết hạn.'
            ]);
        }

        // Kiểm tra lượt dùng
        if ($coupon->max_uses > 0 && $coupon->used_count >= $coupon->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá đã hết lượt sử dụng.'
            ]);
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($coupon->min_order_amount > 0 && $subtotal < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng tối thiểu ' . number_format($coupon->min_order_amount) . 'đ để áp dụng mã này.'
            ]);
        }

        // Tính toán số tiền giảm
        $discountAmount = 0;
        if ($coupon->type === 'percent') {
            $discountAmount = ($subtotal * $coupon->value) / 100;
            if ($coupon->max_discount_amount > 0 && $discountAmount > $coupon->max_discount_amount) {
                $discountAmount = $coupon->max_discount_amount;
            }
        } else {
            $discountAmount = $coupon->value;
        }

        // Không cho phép giảm quá tổng tiền
        if ($discountAmount > $subtotal) {
            $discountAmount = $subtotal;
        }

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'data' => [
                'discount_amount' => $discountAmount,
                'code' => $coupon->code
            ]
        ]);
    }
}
