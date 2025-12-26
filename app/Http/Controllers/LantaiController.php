<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lantai;
use App\Models\Gedung;

class LantaiController extends Controller
{
    public function index(Request $request, $gedung_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);

        $query = Lantai::where('gedung_id', $gedung_id);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nama_lantai', 'like', "%{$q}%")
                    ->orWhere('nomor_lantai', 'like', "%{$q}%");
            });
        }

        $lantai = $query->orderBy('nomor_lantai')->get();
        return view('admin.lantai.index', compact('gedung', 'lantai'));
    }

    public function create($gedung_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        return view('admin.lantai.create', compact('gedung'));
    }

    public function store(Request $request, $gedung_id)
    {
        Gedung::findOrFail($gedung_id);

        $validated = $request->validate([
            'nomor_lantai' => 'required|integer|min:0',
            'nama_lantai' => 'nullable|string|max:255',
        ], [
            'nomor_lantai.required' => 'Nomor lantai harus diisi',
            'nomor_lantai.integer' => 'Nomor lantai harus berupa angka',
        ]);

        $validated['gedung_id'] = $gedung_id;
        Lantai::create($validated);

        return redirect()->route('lantai.index', $gedung_id)->with('success', 'Lantai berhasil ditambahkan');
    }

    public function edit($gedung_id, $lantai_id)
    {
        $gedung = Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        return view('admin.lantai.edit', compact('gedung', 'lantai'));
    }

    public function update(Request $request, $gedung_id, $lantai_id)
    {
        Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();

        $validated = $request->validate([
            'nomor_lantai' => 'required|integer|min:0',
            'nama_lantai' => 'nullable|string|max:255',
        ]);

        $lantai->update($validated);

        return redirect()->route('lantai.index', $gedung_id)->with('success', 'Lantai berhasil diperbarui');
    }

    public function destroy($gedung_id, $lantai_id)
    {
        Gedung::findOrFail($gedung_id);
        $lantai = Lantai::where('id', $lantai_id)->where('gedung_id', $gedung_id)->firstOrFail();
        $lantai->delete();

        return redirect()->route('lantai.index', $gedung_id)->with('success', 'Lantai berhasil dihapus');
    }

    // Admin method untuk menampilkan semua lantai dari semua gedung
    public function adminIndex()
    {
        $lantai = Lantai::with('gedung')->orderBy('gedung_id')->orderBy('nomor_lantai')->get();
        return view('admin.lantai.admin-index', compact('lantai'));
    }
}


