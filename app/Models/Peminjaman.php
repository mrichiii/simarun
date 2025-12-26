<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'user_id', 'ruangan_id', 'dosen_pengampu', 'jam_masuk', 'jam_keluar',
        'status', 'alasan_pembatalan'
    ];

    /**
     * Automatic status change event listener
     * Mengubah status ruangan secara otomatis saat booking dibuat atau dibatalkan
     */
    protected static function booted()
    {
        // Saat booking baru dibuat, ubah status ruangan menjadi tidak_tersedia
        static::created(function ($peminjaman) {
            $peminjaman->ruangan->update([
                'status' => 'tidak_tersedia'
            ]);
        });

        // Saat booking dibatalkan atau dihapus, ubah status ruangan kembali ke tersedia
        static::updated(function ($peminjaman) {
            if ($peminjaman->status === 'dibatalkan' && $peminjaman->getOriginal('status') !== 'dibatalkan') {
                // Cek apakah ada peminjaman aktif lain untuk ruangan yang sama
                $hasActiveBooking = Peminjaman::where('ruangan_id', $peminjaman->ruangan_id)
                    ->where('status', '!=', 'dibatalkan')
                    ->where('id', '!=', $peminjaman->id)
                    ->exists();

                // Jika tidak ada peminjaman aktif lain, ubah status ruangan ke tersedia
                if (!$hasActiveBooking) {
                    $peminjaman->ruangan->update([
                        'status' => 'tersedia'
                    ]);
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}

