<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;

class UserDashboardController extends Controller
{
    public function index()
    {
        $gedung = Gedung::with('lantai.ruangan')->get();
        $ruanganTersedia = Ruangan::where('status', 'tersedia')->count();

        return view('dashboard.user', compact('gedung', 'ruanganTersedia'));
    }

    public function detailGedung($gedung_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('gedung_id', $gedung_id)->orderBy('nomor_lantai')->with('ruangan')->get();

        return view('user.gedung-detail', compact('gedung', 'lantai'));
    }

    public function detailRuangan($ruangan_id)
    {
        $ruangan = Ruangan::with('lantai.gedung', 'fasilitas')->findOrFail($ruangan_id);

        return view('user.ruangan-detail', compact('ruangan'));
    }
}

