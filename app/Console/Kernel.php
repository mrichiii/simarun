<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Auto-update peminjaman status dari 'aktif' menjadi 'selesai' setiap menit
        // ketika waktu booking sudah berakhir
        $schedule->command('peminjaman:auto-update-status')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // Register custom commands
        $this->commands([
            App\Console\Commands\AutoUpdatePeminjamanStatus::class,
        ]);

        require base_path('routes/console.php');
    }
}
