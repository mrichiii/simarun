<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\Lantai;
use App\Models\Gedung;

class RuanganController extends Controller
{
    private function generateKodeRuangan($gedung, $lantai)
    {
        $lastRuangan = Ruangan::where('lantai_id', $lantai->id)
            ->orderBy('id', 'desc')
            ->first();

        $nomorUrt = ($lastRuangan) ? ((int) substr($lastRuangan->kode_ruangan, -2)) + 1 : 1;
        return $gedung->kode_gedung . '-' . $lantai->nomor_lantai . str_pad($nomorUrt, 2, '0', STR_PAD_LEFT);
    }

    public function index(Request $request, $gedung_id, $lantai_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();

        $query = Ruangan::where('lantai_id', $lantai_id);

        // filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // search by kode or nama
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nama_ruangan', 'like', "%{$q}%")
                    ->orWhere('kode_ruangan', 'like', "%{$q}%");
            });
        }

        $ruangan = $query->orderBy('id', 'desc')->get();

        return view('admin.ruangan.index', compact('gedung', 'lantai', 'ruangan'));
    }

    public function create($gedung_id, $lantai_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $kodeRuangan = $this->generateKodeRuangan($gedung, $lantai);
        return view('admin.ruangan.create', compact('gedung', 'lantai', 'kodeRuangan'));
    }

    public function store(Request $request, $gedung_id, $lantai_id)
    {
        Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();

        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'status' => 'required|in:tersedia,tidak_tersedia,tidak_dapat_dipakai',
            'alasan_tidak_dapat_dipakai' => 'nullable|string',
        ]);

        $kodeRuangan = $this->generateKodeRuangan((Gedung::find($gedung_id)), $lantai);
        $validated['kode_ruangan'] = $kodeRuangan;
        $validated['lantai_id'] = $lantai_id;

        Ruangan::create($validated);

        return redirect()->route('ruangan.index', [$gedung_id, $lantai_id])->with('success', 'Ruangan berhasil ditambahkan');
    }

    public function edit($gedung_id, $lantai_id, $ruangan_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $ruangan = Ruangan::where('id', $ruangan_id)->where('lantai_id', $lantai_id)->firstOrFail();
        return view('admin.ruangan.edit', compact('gedung', 'lantai', 'ruangan'));
    }

    public function update(Request $request, $gedung_id, $lantai_id, $ruangan_id)
    {
        Gedung::findOrFail($gedung_id);
        Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $ruangan = Ruangan::where('id', $ruangan_id)->where('lantai_id', $lantai_id)->firstOrFail();

        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
            'status' => 'required|in:tersedia,tidak_tersedia,tidak_dapat_dipakai',
            'alasan_tidak_dapat_dipakai' => 'nullable|string',
        ]);

        $ruangan->update($validated);

        return redirect()->route('ruangan.index', [$gedung_id, $lantai_id])->with('success', 'Ruangan berhasil diperbarui');
    }

    public function destroy($gedung_id, $lantai_id, $ruangan_id)
    {
        Gedung::findOrFail($gedung_id);
        Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $ruangan = Ruangan::where('id', $ruangan_id)->where('lantai_id', $lantai_id)->firstOrFail();
        $ruangan->delete();

        return redirect()->route('ruangan.index', [$gedung_id, $lantai_id])->with('success', 'Ruangan berhasil dihapus');
    }

    // Admin method untuk menampilkan semua ruangan dari semua gedung
    public function adminIndex()
    {
        $ruangan = Ruangan::with('lantai.gedung')->orderBy('id', 'desc')->get();
        return view('admin.ruangan.admin-index', compact('ruangan'));
    }

    // Admin method untuk menampilkan semua ruangan untuk manage fasilitas
    public function adminFasilitasIndex()
    {
        $ruangan = Ruangan::with('lantai.gedung')->orderBy('id', 'desc')->get();
        return view('admin.fasilitas.admin-index', compact('ruangan'));
    }}