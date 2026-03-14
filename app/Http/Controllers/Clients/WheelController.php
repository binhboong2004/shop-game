<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheel;
use App\Models\WheelHistory;
use App\Models\WheelPrize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WheelController extends Controller
{
    public function spin(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để bắt đầu quay!']);
        }

        $user = Auth::user();
        $wheel = LuckyWheel::with(['prizes' => function($q) {
            $q->where('status', 1);
        }])->findOrFail($id);

        if ($wheel->prizes->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Vòng quay này chưa được thiết lập phần thưởng!']);
        }

        if ($user->balance < $wheel->price) {
            return response()->json(['success' => false, 'message' => 'Số dư không đủ, vui lòng nạp thêm tiền!']);
        }

        // Logic chọn phần thưởng dựa trên tỷ lệ
        $totalProbability = $wheel->prizes->sum('probability');
        $random = mt_rand(1, 10000) / 100; // 0.01 to 100.00
        
        // Điều chỉnh nếu tổng tỷ lệ khác 100
        $currentProb = 0;
        $selectedPrize = null;

        foreach ($wheel->prizes as $prize) {
            $currentProb += $prize->probability;
            if ($random <= $currentProb) {
                $selectedPrize = $prize;
                break;
            }
        }

        // Nếu hên xui không trúng (do tổng tỷ lệ < 100), lấy phần thưởng cuối cùng hoặc mặc định
        if (!$selectedPrize) {
            $selectedPrize = $wheel->prizes->last();
        }

        try {
            DB::beginTransaction();

            // Trừ tiền
            $user->balance -= $wheel->price;
            $user->save();

            // Lưu lịch sử
            WheelHistory::create([
                'user_id' => $user->id,
                'prize_id' => $selectedPrize->id,
                'spin_cost' => $wheel->price
            ]);

            DB::commit();

            // Tìm index của prize trong danh sách (để frontend biết quay đến đâu)
            // Lưu ý: frontend vẽ prizes theo thứ tự của window.wheelPrizes
            $prizeIndex = -1;
            foreach ($wheel->prizes as $index => $p) {
                if ($p->id == $selectedPrize->id) {
                    $prizeIndex = $index;
                    break;
                }
            }

            return response()->json([
                'success' => true,
                'prize_index' => $prizeIndex,
                'prize' => $selectedPrize,
                'new_balance' => number_format($user->balance) . 'đ',
                'message' => 'Quay thành công!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra, vui lòng thử lại sau!']);
        }
    }
}
