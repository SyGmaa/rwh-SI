<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Jemaah;
use App\Models\JenisDokumen;

$jemaah = Jemaah::first();
echo 'Jemaah ID: ' . $jemaah->id . ', Status Berkas: ' . $jemaah->status_berkas . PHP_EOL;
$active = JenisDokumen::where('is_active', 1)->pluck('id')->toArray();
echo 'Active Jenis: ' . implode(', ', $active) . PHP_EOL;
$uploaded = $jemaah->dokumenJemaah->pluck('jenis_id')->toArray();
echo 'Uploaded: ' . implode(', ', $uploaded) . PHP_EOL;
$diff = array_diff($active, $uploaded);
echo 'Missing: ' . implode(', ', $diff) . PHP_EOL;
