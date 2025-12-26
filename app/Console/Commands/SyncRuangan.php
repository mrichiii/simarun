<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ruangan;
use App\Models\Peminjaman;

class SyncRuangan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ruangan {ruangan_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronkan ruangan dengan peminjaman aktif terbaru (atau semua jika tidak diberikan)';

    public function handle()
    {
        $ruanganId = $this->argument('ruangan_id');

        $query = Ruangan::query();
        if ($ruanganId) {
            $query->where('id', $ruanganId);
        }

        $ruangans = $query->get();

        foreach ($ruangans as $ruangan) {
            $latest = Peminjaman::where('ruangan_id', $ruangan->id)
                ->where('status', 'aktif')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($latest) {
                $ruangan->update([
                    'status' => 'tidak_tersedia',
                    'dosen_pengampu' => $latest->dosen_pengampu,
                    'jam_masuk' => $latest->jam_masuk,
                    'jam_keluar' => $latest->jam_keluar,
                ]);
                $this->info("Ruangan {$ruangan->id} disinkronkan ke peminjaman {$latest->id}");
            } else {
                $ruangan->update([
                    'status' => 'tersedia',
                    'dosen_pengampu' => null,
                    'jam_masuk' => null,
                    'jam_keluar' => null,
                ]);
                $this->info("Ruangan {$ruangan->id} direset (tidak ada peminjaman aktif)");
            }
        }

        return 0;
    }
}
