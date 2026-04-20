<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Categories: " . \App\Models\Category::count() . "\n";
echo "Food Items: " . \App\Models\FoodItem::count() . "\n";
