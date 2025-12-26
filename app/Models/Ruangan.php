<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $fillable = [
        'lantai_id', 'kode_ruangan', 'nama_ruangan', 'status',
        'alasan_tidak_dapat_dipakai', 'jam_masuk', 'jam_keluar', 'dosen_pengampu'
    ];

    /**
     * ACCESSOR untuk status real-time
     * 
     * Status ruangan dihitung secara dinamis berdasarkan:
     * 1. Status column di database (untuk 'tidak_dapat_dipakai')
     * 2. Peminjaman aktif yang sedang berlangsung (untuk 'tidak_tersedia')
     * 3. Default: 'tersedia'
     * 
     * Sistem ini tidak memerlukan refresh manual atau update scheduled job
     * karena status selalu dihitung real-time saat diakses
     */
    public function getStatusRealTimeAttribute()
    {
        // Jika ruangan ditetapkan tidak dapat dipakai, selalu tampilkan status itu
        if ($this->attributes['status'] === 'tidak_dapat_dipakai') {
            return 'tidak_dapat_dipakai';
        }

        // Cek apakah ada peminjaman aktif yang sedang berlangsung sekarang
        $now = Carbon::now(config('app.timezone'));
        
        $activeBooking = Peminjaman::where('ruangan_id', $this->id)
            ->where('status', 'aktif')
            ->where('tanggal_jam_masuk', '<=', $now)
            ->where('tanggal_jam_keluar', '>=', $now)
            ->first();

        if ($activeBooking) {
            return 'tidak_tersedia';
        }

        // Default: tersedia
        return 'tersedia';
    }

    /**
     * Accessor untuk mendapatkan informasi peminjaman yang sedang berlangsung
     * Berguna untuk menampilkan siapa yang sedang meminjam dan jam berapa
     */
    public function getCurrentPeminjamanAttribute()
    {
        $now = Carbon::now(config('app.timezone'));
        
        return Peminjaman::where('ruangan_id', $this->id)
            ->where('status', 'aktif')
            ->where('tanggal_jam_masuk', '<=', $now)
            ->where('tanggal_jam_keluar', '>=', $now)
            ->with('user')
            ->first();
    }

    /**
     * Scope untuk filter ruangan tersedia
     * Menggunakan logika real-time
     */
    public function scopeAvailable($query)
    {
        $now = Carbon::now(config('app.timezone'));
        
        return $query->where(function ($q) use ($now) {
            // Ruangan yang tidak dalam status 'tidak_dapat_dipakai'
            $q->where('status', '!=', 'tidak_dapat_dipakai')
              // Dan tidak ada peminjaman aktif yang sedang berlangsung
              ->whereDoesntHave('peminjaman', function ($pq) use ($now) {
                  $pq->where('status', 'aktif')
                    ->where('tanggal_jam_masuk', '<=', $now)
                    ->where('tanggal_jam_keluar', '>=', $now);
              });
        });
    }

    /**
     * Scope untuk filter ruangan tidak tersedia
     */
    public function scopeUnavailable($query)
    {
        $now = Carbon::now(config('app.timezone'));
        
        return $query->where(function ($q) use ($now) {
            // Ada peminjaman aktif yang sedang berlangsung
            $q->whereHas('peminjaman', function ($pq) use ($now) {
                $pq->where('status', 'aktif')
                  ->where('tanggal_jam_masuk', '<=', $now)
                  ->where('tanggal_jam_keluar', '>=', $now);
            });
        });
    }

    public function lantai()
    {
        return $this->belongsTo(Lantai::class);
    }

    public function fasilitas()
    {
        return $this->hasOne(Fasilitas::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class);
    }
}

