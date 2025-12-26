<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'user_id', 'ruangan_id', 'dosen_pengampu',
        'tanggal_jam_masuk', 'tanggal_jam_keluar',
        'status', 'alasan_pembatalan'
    ];

    protected $casts = [
        'tanggal_jam_masuk' => 'datetime',
        'tanggal_jam_keluar' => 'datetime',
    ];

    /**
     * Automatic status change event listener
     * Mengubah status ruangan secara otomatis saat booking dibuat atau dibatalkan
     * 
     * SISTEM REAL-TIME:
     * Status ruangan tidak lagi disimpan secara statis, melainkan dihitung dinamis
     * berdasarkan perbandingan waktu server dengan jam booking yang tersimpan di database.
     */
    protected static function booted()
    {
        // Saat booking baru dibuat, jangan ubah status ruangan
        // Status akan dihitung real-time oleh Ruangan model
        static::created(function ($peminjaman) {
            // No longer updating ruangan status here
            // Real-time status akan dihitung di Ruangan model accessor
        });

        // Saat booking diubah (dibatalkan/selesai), 
        // sistem akan menghitung ulang status ruangan secara real-time
        static::updated(function ($peminjaman) {
            // Status ruangan akan auto-recalculate via accessor
            // Tidak perlu update manual di sini
        });
    }

    /**
     * Scope untuk mendapatkan peminjaman yang sedang berlangsung sekarang
     * Berdasarkan tanggal_jam_masuk dan tanggal_jam_keluar
     */
    public function scopeCurrently($query)
    {
        $now = Carbon::now(config('app.timezone'));
        
        return $query->where('status', 'aktif')
            ->where('tanggal_jam_masuk', '<=', $now)
            ->where('tanggal_jam_keluar', '>=', $now);
    }

    /**
     * Scope untuk mendapatkan peminjaman di masa depan
     */
    public function scopeUpcoming($query)
    {
        $now = Carbon::now(config('app.timezone'));
        
        return $query->where('status', 'aktif')
            ->where('tanggal_jam_masuk', '>', $now);
    }

    /**
     * Scope untuk mendapatkan peminjaman yang sudah lewat
     */
    public function scopePassed($query)
    {
        $now = Carbon::now(config('app.timezone'));
        
        return $query->where('status', 'aktif')
            ->where('tanggal_jam_keluar', '<', $now);
    }

    /**
     * Scope untuk mendapatkan peminjaman aktif berdasarkan ruangan
     * Filter yang sedang berlangsung sekarang untuk ruangan tertentu
     */
    public function scopeActiveForRoom($query, $ruangan_id)
    {
        $now = Carbon::now(config('app.timezone'));
        
        return $query->where('ruangan_id', $ruangan_id)
            ->where('status', 'aktif')
            ->where('tanggal_jam_masuk', '<=', $now)
            ->where('tanggal_jam_keluar', '>=', $now);
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

