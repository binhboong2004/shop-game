<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscountCode;
use Carbon\Carbon;

class DiscountCodeSeeder extends Seeder
{
    public function run(): void
    {
        $codes = [
            [
                'code' => 'TET2026',
                'type' => 'percent',
                'value' => 10,
                'min_order_amount' => 100000,
                'max_discount_amount' => 50000,
                'max_uses' => 100,
                'used_count' => 12,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(20),
                'status' => true,
            ],
            [
                'code' => 'KHAITRUONG',
                'type' => 'fixed',
                'value' => 20000,
                'min_order_amount' => 50000,
                'max_discount_amount' => null,
                'max_uses' => 50,
                'used_count' => 50,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(1),
                'status' => false,
            ]
        ];

        foreach ($codes as $code) {
            DiscountCode::create($code);
        }
    }
}
