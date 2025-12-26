<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AutoUpdatePeminjamanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'peminjaman:auto-update-status';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Automatically update peminjaman status to "selesai" when booking time has ended';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now(config('app.timezone'));

        // Cari semua peminjaman aktif yang sudah melewati jam keluar
        $completedBookings = Peminjaman::where('status', 'aktif')
            ->where('tanggal_jam_keluar', '<', $now)
            ->get();

        if ($completedBookings->isEmpty()) {
            $this->info('Tidak ada peminjaman yang perlu diupdate.');
            return;
        }

        $count = 0;
        foreach ($completedBookings as $peminjaman) {
            $peminjaman->update(['status' => 'selesai']);
            $count++;
            
            $this->line("Peminjaman #{$peminjaman->id} (Ruangan: {$peminjaman->ruangan->kode_ruangan}) diupdate ke status 'selesai'");
        }

        $this->info("Total {$count} peminjaman berhasil diupdate menjadi 'selesai'.");
        
        // Log untuk tracking
        \Log::info("Peminjaman auto-update status job executed", [
            'time' => $now,
            'count' => $count,
        ]);
    }
}
