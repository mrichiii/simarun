<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('peminjaman')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                if (Schema::hasColumn('peminjaman', 'jam_masuk_legacy')) {
                    $table->time('jam_masuk_legacy')->nullable()->change();
                }
                if (Schema::hasColumn('peminjaman', 'jam_keluar_legacy')) {
                    $table->time('jam_keluar_legacy')->nullable()->change();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('peminjaman')) {
            Schema::table('peminjaman', function (Blueprint $table) {
                if (Schema::hasColumn('peminjaman', 'jam_masuk_legacy')) {
                    $table->time('jam_masuk_legacy')->nullable(false)->change();
                }
                if (Schema::hasColumn('peminjaman', 'jam_keluar_legacy')) {
                    $table->time('jam_keluar_legacy')->nullable(false)->change();
                }
            });
        }
    }
};
