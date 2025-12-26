<?php

// Script untuk membuat test booking
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Peminjaman;
use Carbon\Carbon;

$now = now();
$start = $now->copy()->addMinutes(5);
$end = $start->copy()->addMinutes(10);

$p = Peminjaman::create([
    'user_id' => 2,
    'ruangan_id' => 2, // FST-102
    'dosen_pengampu' => 'Dr. Test',
    'tanggal_jam_masuk' => $start,
    'tanggal_jam_keluar' => $end,
    'status' => 'aktif'
]);

echo "✓ Booking dibuat!\n";
echo "  ID: {$p->id}\n";
echo "  Ruangan: FST-102 (ID: {$p->ruangan_id})\n";
echo "  Waktu: {$p->tanggal_jam_masuk->format('H:i')} - {$p->tanggal_jam_keluar->format('H:i')}\n";
echo "  Dosen: {$p->dosen_pengampu}\n";
