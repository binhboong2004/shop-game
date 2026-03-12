<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'ShopNickVN', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_logo', 'value' => '/client/images/logo.png', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_favicon', 'value' => '/client/images/favicon.ico', 'type' => 'image', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'hotline', 'value' => '0123456789', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'facebook_link', 'value' => 'https://facebook.com/admin', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'footer_text', 'value' => '<p>Shop cung cấp tài khoản game uy tín hàng đầu Việt Nam.</p>', 'type' => 'text', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
