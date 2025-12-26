<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $gedung = Gedung::with('lantai.ruangan')->get();
        
        // Hitung ruangan tersedia secara real-time menggunakan accessor
        $now = Carbon::now(config('app.timezone'));
        $ruanganTersedia = 0;

        foreach ($gedung as $g) {
            foreach ($g->lantai as $l) {
                foreach ($l->ruangan as $r) {
                    if ($r->getStatusRealTimeAttribute() === 'tersedia') {
                        $ruanganTersedia++;
                    }
                }
            }
        }

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
        $ruangan = Ruangan::with('lantai.gedung', 'fasilitas', 'peminjaman')->findOrFail($ruangan_id);

        // Ambil peminjaman yang sedang berlangsung sekarang
        $now = Carbon::now(config('app.timezone'));
        $currentPeminjaman = Peminjaman::where('ruangan_id', $ruangan_id)
            ->where('status', 'aktif')
            ->where('tanggal_jam_masuk', '<=', $now)
            ->where('tanggal_jam_keluar', '>=', $now)
            ->with('user')
            ->first();

        // Status real-time ruangan
        $statusRealTime = $ruangan->getStatusRealTimeAttribute();

        return view('user.ruangan-detail', compact('ruangan', 'currentPeminjaman', 'statusRealTime'));
    }
}

