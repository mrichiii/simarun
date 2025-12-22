<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $fillable = [
        'lantai_id', 'kode_ruangan', 'nama_ruangan', 'status',
        'alasan_tidak_dapat_dipakai', 'jam_masuk', 'jam_keluar', 'dosen_pengampu'
    ];

    public function lantai()
    {
        return $this->belongsTo(Lantai::class);
    }

    public function fasilitas()
    {
        return $this->hasOne(Fasilitas::class);
    }
}

