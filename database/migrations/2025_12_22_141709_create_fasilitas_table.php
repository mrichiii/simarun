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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruangan_id')->constrained('ruangan')->onDelete('cascade');
            $table->boolean('ac')->default(false);
            $table->boolean('proyektor')->default(false);
            $table->integer('jumlah_kursi')->default(0);
            $table->boolean('papan_tulis')->default(false);
            $table->enum('wifi', ['lancar', 'lemot', 'tidak_terjangkau'])->default('tidak_terjangkau');
            $table->enum('arus_listrik', ['lancar', 'tidak'])->default('tidak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
