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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lantai_id')->constrained('lantai')->onDelete('cascade');
            $table->string('kode_ruangan')->unique();
            $table->string('nama_ruangan');
            $table->enum('status', ['tersedia', 'tidak_tersedia', 'tidak_dapat_dipakai'])->default('tersedia');
            $table->string('alasan_tidak_dapat_dipakai')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->string('dosen_pengampu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
