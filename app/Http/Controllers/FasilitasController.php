<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\Ruangan;
use App\Models\Lantai;
use App\Models\Gedung;

class FasilitasController extends Controller
{
    public function edit($gedung_id, $lantai_id, $ruangan_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $ruangan = Ruangan::where('id', $ruangan_id)->where('lantai_id', $lantai_id)->firstOrFail();
        
        $fasilitas = $ruangan->fasilitas ?? new Fasilitas();
        
        return view('admin.fasilitas.edit', compact('gedung', 'lantai', 'ruangan', 'fasilitas'));
    }

    public function update(Request $request, $gedung_id, $lantai_id, $ruangan_id)
    {
        Gedung::findOrFail($gedung_id);
        Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $ruangan = Ruangan::where('id', $ruangan_id)->where('lantai_id', $lantai_id)->firstOrFail();

        $validated = $request->validate([
            'ac' => 'boolean',
            'proyektor' => 'boolean',
            'jumlah_kursi' => 'nullable|integer|min:0',
            'papan_tulis' => 'boolean',
            'wifi' => 'required|in:lancar,lemot,tidak_terjangkau',
            'arus_listrik' => 'required|in:lancar,tidak',
        ]);

        if ($ruangan->fasilitas) {
            $ruangan->fasilitas->update($validated);
        } else {
            $validated['ruangan_id'] = $ruangan->id;
            Fasilitas::create($validated);
        }

        return redirect()->route('ruangan.index', [$gedung_id, $lantai_id])->with('success', 'Fasilitas berhasil diperbarui');
    }
}

