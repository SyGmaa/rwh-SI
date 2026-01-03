<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\JenisDokumen;

$jd = JenisDokumen::first();
echo 'Before: is_active=' . $jd->is_active . PHP_EOL;
$jd->update(['is_active' => !$jd->is_active]);
echo 'After: is_active=' . $jd->is_active . PHP_EOL;
