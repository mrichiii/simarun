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
        $currentTime = Carbon::now()->format('H:i');
        
        // Ambil semua peminjaman yang masih aktif
        $activePeminjaman = Peminjaman::where('status', 'aktif')->get();
        
        $updated = 0;
        
        foreach ($activePeminjaman as $peminjaman) {
            // Jika jam_keluar sudah lewat, ubah status menjadi selesai
            if ($currentTime >= $peminjaman->jam_keluar) {
                $peminjaman->update(['status' => 'selesai']);
                
                // Update status ruangan kembali ke tersedia jika tidak ada peminjaman lain
                $ruangan = $peminjaman->ruangan;
                $hasOtherActive = Peminjaman::where('ruangan_id', $ruangan->id)
                    ->where('status', 'aktif')
                    ->exists();
                
                if (!$hasOtherActive && $ruangan->status === 'tidak_tersedia') {
                    $ruangan->update([
                        'status' => 'tersedia',
                        'dosen_pengampu' => null,
                        'jam_masuk' => null,
                        'jam_keluar' => null,
                    ]);
                }
                
                $updated++;
            }
        }
        
        if ($updated > 0) {
            $this->info("✓ Berhasil mengupdate {$updated} peminjaman yang selesai");
        } else {
            $this->info("✓ Tidak ada peminjaman yang perlu diupdate");
        }
    }
}
