<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach(\App\Models\DepositCategory::all() as $c) {
    echo $c->id . ': ' . $c->name . ' (' . $c->type . ')' . PHP_EOL;
}
