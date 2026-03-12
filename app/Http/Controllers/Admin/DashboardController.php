<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;
use App\Models\Account;
use App\Models\Withdrawal;
use App\Models\Deposit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('amount');
        $newMembers = User::where('created_at', '>=', now()->subDays(30))->count();
        $totalAgents = User::where('role', 'agent')->count();
        $pendingAccounts = Account::where('status', 'pending_approval')->count();

        $recentOrders = Order::with(['buyer', 'account.gameCategory'])
                             ->latest()
                             ->take(5)
                             ->get();

        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
        $failedDeposits = Deposit::where('status', 'rejected')->count();

        return view('admin.pages.dashboard', compact(
            'totalRevenue', 
            'newMembers', 
            'totalAgents', 
            'pendingAccounts', 
            'recentOrders',
            'pendingWithdrawals',
            'failedDeposits'
        ));
    }
}
