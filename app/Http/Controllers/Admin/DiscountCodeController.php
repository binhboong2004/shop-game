<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscountCodeController extends Controller
{
    public function index(Request $request)
    {
        $query = DiscountCode::query();

        // Stats
        $totalCoupons = DiscountCode::count();
        $activeCoupons = DiscountCode::where('status', 1)
            ->where(function($q) {
                $q->whereNull('end_date')->orWhere('end_date', '>', now());
            })
            ->where(function($q) {
                $q->where('max_uses', 0)->orWhereColumn('used_count', '<', 'max_uses');
            })
            ->count();
        $inactiveCoupons = $totalCoupons - $activeCoupons;

        // Filters
        if ($request->filled('search')) {
            $query->where('code', 'LIKE', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 1)
                    ->where(function($q) {
                        $q->whereNull('end_date')->orWhere('end_date', '>', now());
                    })
                    ->where(function($q) {
                        $q->where('max_uses', 0)->orWhereColumn('used_count', '<', 'max_uses');
                    });
            } elseif ($request->status === 'expired') {
                $query->where(function($q) {
                    $q->where('status', 0)
                        ->orWhere('end_date', '<=', now())
                        ->orWhere(function($sq) {
                            $sq->where('max_uses', '>', 0)->whereColumn('used_count', '>=', 'max_uses');
                        });
                });
            }
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        $coupons = $query->latest()->paginate(15);

        return view('admin.pages.magiamgia', compact('coupons', 'totalCoupons', 'activeCoupons', 'inactiveCoupons'));
    }

    public function store(Request $request)
    {
        $messages = [
            'code.required' => 'Vui lòng nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá này đã tồn tại.',
            'type.required' => 'Vui lòng chọn loại giảm giá.',
            'value.required' => 'Vui lòng nhập mức giảm.',
            'value.numeric' => 'Mức giảm phải là một số.',
            'max_uses.integer' => 'Số lượng tối đa phải là số nguyên.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];

        $data = $request->validate([
            'code' => 'required|unique:discount_codes,code',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
        ], $messages);

        $data['status'] = $request->status === 'active' ? 1 : 0;
        $data['max_uses'] = (int)$request->max_uses;

        DiscountCode::create($data);

        return response()->json(['success' => true, 'message' => 'Thêm mã giảm giá thành công!']);
    }

    public function show($id)
    {
        return response()->json(['success' => true, 'data' => DiscountCode::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $coupon = DiscountCode::findOrFail($id);
        
        $messages = [
            'code.required' => 'Vui lòng nhập mã giảm giá.',
            'code.unique' => 'Mã giảm giá này đã tồn tại.',
            'type.required' => 'Vui lòng chọn loại giảm giá.',
            'value.required' => 'Vui lòng nhập mức giảm.',
            'value.numeric' => 'Mức giảm phải là một số.',
            'max_uses.integer' => 'Số lượng tối đa phải là số nguyên.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ];

        $data = $request->validate([
            'code' => 'required|unique:discount_codes,code,' . $id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
        ], $messages);

        $data['status'] = $request->status === 'active' ? 1 : 0;
        $data['max_uses'] = (int)$request->max_uses;

        $coupon->update($data);

        return response()->json(['success' => true, 'message' => 'Cập nhật mã giảm giá thành công!']);
    }

    public function destroy($id)
    {
        DiscountCode::findOrFail($id)->delete();
        return response()->json(['success' => true, 'message' => 'Đã xóa mã giảm giá!']);
    }
}
