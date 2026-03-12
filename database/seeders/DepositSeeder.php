<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deposit;
use App\Models\User;
use App\Models\DepositCategory;
use Carbon\Carbon;

class DepositSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('role', ['member', 'agent'])->get();
        $categories = DepositCategory::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $statuses = ['pending', 'approved', 'rejected'];

        for ($i = 0; $i < 15; $i++) {
            $category = $categories->random();
            $amount = rand(5, 50) * 10000;
            $received_amount = $category->type === 'card' ? ($amount * 0.8) : $amount;

            Deposit::create([
                'user_id' => $users->random()->id,
                'deposit_category_id' => $category->id,
                'amount' => $amount,
                'received_amount' => $received_amount,
                'card_network' => $category->type === 'card' ? $category->name : null,
                'card_pin' => $category->type === 'card' ? rand(10000000000000, 99999999999999) : null,
                'card_serial' => $category->type === 'card' ? rand(10000000000, 99999999999) : null,
                'transaction_id' => $category->type !== 'card' ? 'TXN' . rand(100000, 999999) : null,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => Carbon::now()->subDays(rand(0, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
