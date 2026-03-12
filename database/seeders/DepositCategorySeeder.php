<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DepositCategory;

class DepositCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Thẻ cào Viettel',
                'type' => 'card',
                'image' => null,
                'details' => json_encode(['fee' => 0.8]), // Ví dụ nhận 80%
                'status' => true,
            ],
            [
                'name' => 'Thẻ cào VinaPhone',
                'type' => 'card',
                'image' => null,
                'details' => json_encode(['fee' => 0.8]),
                'status' => true,
            ],
            [
                'name' => 'Thẻ cào Mobifone',
                'type' => 'card',
                'image' => null,
                'details' => json_encode(['fee' => 0.8]),
                'status' => true,
            ],
            [
                'name' => 'Chuyển khoản MBBank',
                'type' => 'bank',
                'image' => null,
                'details' => json_encode([
                    'bank_name' => 'MBBank',
                    'account_number' => '0987654321',
                    'account_name' => 'NGUYEN VAN A',
                ]),
                'status' => true,
            ],
            [
                'name' => 'Ví điện tử Momo',
                'type' => 'ewallet',
                'image' => null,
                'details' => json_encode([
                    'momo_number' => '0987654321',
                    'momo_name' => 'NGUYEN VAN A',
                ]),
                'status' => true,
            ],
        ];

        foreach ($categories as $category) {
            DepositCategory::create($category);
        }
    }
}
