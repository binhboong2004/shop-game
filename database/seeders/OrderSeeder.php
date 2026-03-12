<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;
use App\Models\Account;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::where('role', 'member')->get();
        $sellers = User::where('role', 'agent')->get();
        $accounts = Account::all();

        if ($buyers->isEmpty() || $sellers->isEmpty() || $accounts->isEmpty()) {
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $account = $accounts->random();
            $status = rand(0, 10) > 2 ? 'completed' : 'refunded'; // 80% completed
            
            Order::create([
                'buyer_id' => $buyers->random()->id,
                'seller_id' => $sellers->random()->id,
                'account_id' => $account->id,
                'amount' => $account->price,
                'discount_code_id' => null,
                'status' => $status,
                'created_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
