<?php
// Test script untuk create gedung
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $gedung = \App\Models\Gedung::create([
        'kode_gedung' => 'TEST-' . time(),
        'nama_gedung' => 'Test Gedung ' . time(),
        'lokasi' => 'Test Location'
    ]);
    
    echo "✅ SUCCESS! Gedung created:\n";
    echo "ID: " . $gedung->id . "\n";
    echo "Kode: " . $gedung->kode_gedung . "\n";
    echo "Nama: " . $gedung->nama_gedung . "\n";
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
