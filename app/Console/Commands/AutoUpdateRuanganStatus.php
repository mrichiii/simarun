<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Carbon\Carbon;

class AutoUpdateRuanganStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-update-ruangan-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-update status ruangan berdasarkan jadwal peminjaman';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now(config('app.timezone'));
        $nowTime = $now->toTimeString(); // HH:MM:SS

        // Ambil peminjaman aktif yang jam_keluar <= sekarang (sudah lewat atau sama)
        $toFinish = Peminjaman::where('status', 'aktif')
            ->whereTime('jam_keluar', '<=', $nowTime)
            ->get();

        $updated = 0;

        foreach ($toFinish as $peminjaman) {
            // Tandai peminjaman selesai
            $peminjaman->update(['status' => 'selesai']);

            // Periksa apakah masih ada peminjaman aktif lain untuk ruangan ini
            $ruangan = $peminjaman->ruangan;
            $hasOtherActive = Peminjaman::where('ruangan_id', $ruangan->id)
                ->where('status', 'aktif')
                ->exists();

            if (!$hasOtherActive && $ruangan->status === 'tidak_tersedia') {
                // Reset informasi penggunaan ruangan
                $ruangan->update([
                    'status' => 'tersedia',
                    'dosen_pengampu' => null,
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                ]);
            }

            $updated++;
        }
        
        if ($updated > 0) {
            $this->info("✓ Berhasil mengupdate {$updated} peminjaman yang selesai");
        } else {
            $this->info("✓ Tidak ada peminjaman yang perlu diupdate");
        }
    }
}
