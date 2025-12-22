<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $fillable = [
        'ruangan_id', 'ac', 'proyektor', 'jumlah_kursi',
        'papan_tulis', 'wifi', 'arus_listrik'
    ];

    protected $casts = [
        'ac' => 'boolean',
        'proyektor' => 'boolean',
        'papan_tulis' => 'boolean',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }
}

