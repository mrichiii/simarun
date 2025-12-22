<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    protected $table = 'gedung';
    protected $fillable = ['kode_gedung', 'nama_gedung', 'lokasi'];

    public function lantai()
    {
        return $this->hasMany(Lantai::class);
    }
}

