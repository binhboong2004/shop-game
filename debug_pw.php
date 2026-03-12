<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = \App\Models\Order::with('account')->get();
foreach($orders as $o) {
    if (!$o->account) continue;
    echo "ID " . $o->account_id . " - TK: " . $o->account->account_username . " - MK: " . $o->account->account_password . "\n";
}
