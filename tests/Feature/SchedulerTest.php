<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;

class SchedulerTest extends TestCase
{
    use RefreshDatabase;

    public function test_scheduler_marks_peminjaman_selesai_and_updates_ruangan()
    {
        $gedung = Gedung::create(['kode_gedung' => '','nama_gedung' => '','lokasi'=>'Kampus']);
        $lantai = Lantai::create(['gedung_id' => $gedung->id, 'nomor_lantai' => 1, 'nama_lantai' => 'L1']);
        $ruangan = Ruangan::create(['lantai_id'=>$lantai->id,'kode_ruangan'=>'-301','nama_ruangan'=>'R301','status'=>'tidak_tersedia']);

        $user = User::factory()->create();

        // buat peminjaman yang jam_keluar sudah lewat
        Peminjaman::create([
            'user_id' => $user->id,
            'ruangan_id' => $ruangan->id,
            'dosen_pengampu' => 'Test',
            'jam_masuk' => '06:00',
            'jam_keluar' => Carbon::now()->subHour()->format('H:i'),
            'status' => 'aktif'
        ]);

        // jalankan artisan command
        Artisan::call('app:auto-update-ruangan-status');

        $this->assertDatabaseHas('peminjaman', ['ruangan_id' => $ruangan->id, 'status' => 'selesai']);
        $this->assertDatabaseHas('ruangan', ['id' => $ruangan->id, 'status' => 'tersedia']);
    }
}
