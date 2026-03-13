<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with('agent');

        // Filter by Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('agent', function($agentQ) use ($search) {
                      $agentQ->where('name', 'LIKE', "%{$search}%")
                             ->orWhere('id', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Date
        if ($request->filled('date') && $request->date !== 'all') {
            if ($request->date === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($request->date === 'week') {
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->date === 'month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            }
        }

        $withdrawals = $query->latest()->paginate(10);

        // Stats
        $totalYc = Withdrawal::count();
        $pendingCount = Withdrawal::where('status', 'pending')->count();
        $approvedCount = Withdrawal::where('status', 'approved')->count();
        $rejectedCount = Withdrawal::where('status', 'rejected')->count();

        return view('admin.pages.kiemduyetruttien', compact(
            'withdrawals', 'totalYc', 'pendingCount', 'approvedCount', 'rejectedCount'
        ));
    }

    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        if ($withdrawal->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Yêu cầu này đã được xử lý.']);
        }

        $withdrawal->update(['status' => 'approved']);

        return response()->json(['success' => true, 'message' => 'Đã duyệt yêu cầu rút tiền thành công.']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string']);
        
        $withdrawal = Withdrawal::findOrFail($id);
        if ($withdrawal->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Yêu cầu này đã được xử lý.']);
        }

        DB::beginTransaction();
        try {
            $withdrawal->update([
                'status' => 'rejected',
                'note' => $request->reason
            ]);

            // Refund balance to agent
            User::where('id', $withdrawal->agent_id)->increment('balance', $withdrawal->amount);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Đã từ chối và hoàn tiền cho đại lý.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->delete();

        return response()->json(['success' => true, 'message' => 'Đã xóa bản ghi rút tiền.']);
    }
}
