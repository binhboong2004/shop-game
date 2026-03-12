<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\GameCategory;
use App\Models\User;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $categories = GameCategory::all();
        $sellers = User::where('role', 'agent')->get();

        if ($categories->isEmpty() || $sellers->isEmpty()) return;

        for ($i = 1; $i <= 20; $i++) {
            Account::create([
                'game_category_id' => $categories->random()->id,
                'seller_id' => $sellers->random()->id,
                'title' => 'Tài khoản siêu VIP tự động số ' . $i,
                'price' => rand(50000, 500000),
                'original_price' => rand(600000, 1000000),
                'account_username' => 'acc_demo_' . $i,
                'account_password' => 'password123',
                'description' => 'Mô tả chi tiết tài khoản ' . $i . '. Nick random có nhiều vật phẩm giá trị.',
                'status' => 'active',
            ]);
        }
    }
}
