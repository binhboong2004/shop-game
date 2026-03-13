<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

use App\Models\DepositCategory;
use Illuminate\Support\Facades\Schema;

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

if (!Schema::hasTable('deposit_categories')) {
    echo "Table does not exist\n";
    exit;
}

$categories = DepositCategory::all();
foreach ($categories as $cat) {
    echo "ID: {$cat->id} | Name: {$cat->name} | Type: {$cat->type}\n";
}
