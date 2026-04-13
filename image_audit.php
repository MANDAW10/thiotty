<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

echo "--- AUDIT DES IMAGES CATEGORIES ---\n";
foreach (Category::all() as $cat) {
    echo "Catégorie: {$cat->name} | Image: {$cat->image_url}\n";
}

echo "\n--- AUDIT DES IMAGES SLIDER ---\n";
foreach (\App\Models\Slide::all() as $slide) {
    echo "Slide: {$slide->title} | Image: {$slide->image_url}\n";
}
