<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DepositController extends Controller
{
    public function index(Request $request)
    {
        $query = Deposit::with(['user', 'category']);

        // Filter by Search (Transaction ID or Username)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($userQ) use ($search) {
                      $userQ->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $deposits = $query->latest()->paginate(10);

        // Stats
        $todayDeposit = Deposit::whereDate('created_at', Carbon::today())
            ->where('status', 'approved')
            ->sum('amount');

        $monthDeposit = Deposit::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'approved')
            ->sum('amount');

        $pendingCount = Deposit::where('status', 'pending')->count();
        $failedCount = Deposit::whereIn('status', ['rejected', 'failed'])->count();

        return view('admin.pages.quanlynaptien', compact(
            'deposits', 
            'todayDeposit', 
            'monthDeposit', 
            'pendingCount', 
            'failedCount'
        ));
    }

    public function approve($id)
    {
        $deposit = Deposit::findOrFail($id);
        if ($deposit->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Giao dịch đã được xử lý trước đó.']);
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $deposit->update(['status' => 'approved']);
            
            // Increment user balance
            User::where('id', $deposit->user_id)->increment('balance', $deposit->received_amount);

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['success' => true, 'message' => 'Đã duyệt giao dịch và cộng tiền cho người dùng.']);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['reason' => 'required|string|max:255']);
        
        $deposit = Deposit::findOrFail($id);
        if ($deposit->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Giao dịch đã được xử lý trước đó.']);
        }

        $deposit->update([
            'status' => 'rejected',
            'details' => array_merge($deposit->details ?? [], ['reject_reason' => $request->reason])
        ]);

        return response()->json(['success' => true, 'message' => 'Đã từ chối giao dịch.']);
    }

    public function manualAdd(Request $request)
    {
        $request->validate([
            'user_identifier' => 'required', // ID or Name
            'amount' => 'required|numeric|min:1000',
            'reason' => 'required|string'
        ]);

        $user = User::where('id', $request->user_identifier)
                    ->orWhere('name', 'LIKE', $request->user_identifier)
                    ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy người dùng này.']);
        }

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            // Find or create a specific category for manual additions
            $manualCategory = \App\Models\DepositCategory::firstOrCreate(
                ['type' => 'manual'],
                ['name' => 'Cộng thủ công', 'status' => 1]
            );

            // Create a pseudo deposit record for tracking
            Deposit::create([
                'user_id' => $user->id,
                'deposit_category_id' => $manualCategory->id,
                'amount' => $request->amount,
                'received_amount' => $request->amount,
                'status' => 'approved',
                'details' => ['type' => 'manual', 'note' => $request->reason]
            ]);

            User::where('id', $user->id)->increment('balance', $request->amount);

            \Illuminate\Support\Facades\DB::commit();
            return response()->json(['success' => true, 'message' => "Đã cộng " . number_format($request->amount) . "đ cho {$user->name}."]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
        }
    }
}
