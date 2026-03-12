<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartWishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::pluck('id');
        $accounts = \App\Models\Account::pluck('id');

        if ($users->isEmpty() || $accounts->isEmpty()) {
            return;
        }

        // Tạo 20 sản phẩm ngẫu nhiên trong giỏ hàng
        for ($i = 0; $i < 20; $i++) {
            $userId = $users->random();
            $accountId = $accounts->random();
            
            \App\Models\Cart::firstOrCreate([
                'user_id' => $userId,
                'account_id' => $accountId
            ]);
        }

        // Tạo 30 sản phẩm ngẫu nhiên trong danh sách yêu thích
        for ($i = 0; $i < 30; $i++) {
            $userId = $users->random();
            $accountId = $accounts->random();
            
            \App\Models\Wishlist::firstOrCreate([
                'user_id' => $userId,
                'account_id' => $accountId
            ]);
        }
    }
}
