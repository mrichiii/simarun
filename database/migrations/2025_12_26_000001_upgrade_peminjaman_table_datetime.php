<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Upgrade tabel peminjaman untuk mendukung datetime (tidak hanya time)
     * sehingga system dapat tracking booking per hari dan real-time status
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Rename kolom lama (untuk backward compatibility)
            if (Schema::hasColumn('peminjaman', 'jam_masuk')) {
                $table->renameColumn('jam_masuk', 'jam_masuk_legacy');
            }
            if (Schema::hasColumn('peminjaman', 'jam_keluar')) {
                $table->renameColumn('jam_keluar', 'jam_keluar_legacy');
            }
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            // Tambahkan datetime columns baru
            $table->dateTime('tanggal_jam_masuk')->after('ruangan_id')->nullable();
            $table->dateTime('tanggal_jam_keluar')->after('tanggal_jam_masuk')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Restore kolom lama
            if (Schema::hasColumn('peminjaman', 'jam_masuk_legacy')) {
                $table->renameColumn('jam_masuk_legacy', 'jam_masuk');
            }
            if (Schema::hasColumn('peminjaman', 'jam_keluar_legacy')) {
                $table->renameColumn('jam_keluar_legacy', 'jam_keluar');
            }
            
            // Drop datetime columns
            $table->dropColumn(['tanggal_jam_masuk', 'tanggal_jam_keluar']);
        });
    }
};
