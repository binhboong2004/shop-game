<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\DepositCategory;
use Illuminate\Support\Facades\Schema;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$data = [
    ['id' => 1, 'name' => 'Viettel', 'type' => 'card'],
    ['id' => 2, 'name' => 'Vinaphone', 'type' => 'card'],
    ['id' => 3, 'name' => 'Mobifone', 'type' => 'card'],
    ['id' => 4, 'name' => 'MBBank', 'type' => 'bank'],
    ['id' => 5, 'name' => 'Momo', 'type' => 'ewallet'],
];

foreach ($data as $item) {
    DepositCategory::updateOrCreate(['id' => $item['id']], $item);
}

echo "Seeded deposit categories successfully!\n";
