<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['buyer', 'account.gameCategory.game']);

        // Filter by Search (Transaction ID or Account ID)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('account_id', 'LIKE', "%{$search}%");
            });
        }

        // Filter by Date Range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.pages.lichsubanhang', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['buyer', 'seller', 'account.gameCategory.game'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => [
                'txn_id' => '#' . $order->id,
                'status' => $order->status,
                'buyer_name' => $order->buyer->name ?? 'N/A',
                'buyer_id' => $order->buyer->username ?? $order->buyer->id,
                'product_id' => 'ACCOUNT-' . $order->account_id,
                'product_name' => $order->account->gameCategory->name ?? 'N/A',
                'amount' => number_format($order->amount) . 'đ',
                'time' => $order->created_at->format('H:i d/m/Y'),
            ]
        ]);
    }
}
