<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gedung;

class GedungController extends Controller
{
    public function index()
    {
        $gedung = Gedung::all();
        return view('admin.gedung.index', compact('gedung'));
    }

    public function create()
    {
        return view('admin.gedung.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_gedung' => 'required|string|max:50|unique:gedung',
            'nama_gedung' => 'required|string|max:255',
            'lokasi' => 'nullable|string',
        ], [
            'kode_gedung.unique' => 'Kode gedung sudah digunakan',
            'kode_gedung.required' => 'Kode gedung harus diisi',
            'nama_gedung.required' => 'Nama gedung harus diisi',
        ]);

        Gedung::create($validated);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil ditambahkan');
    }

    public function edit(Gedung $gedung)
    {
        return view('admin.gedung.edit', compact('gedung'));
    }

    public function update(Request $request, Gedung $gedung)
    {
        $validated = $request->validate([
            'kode_gedung' => 'required|string|max:50|unique:gedung,kode_gedung,' . $gedung->id,
            'nama_gedung' => 'required|string|max:255',
            'lokasi' => 'nullable|string',
        ], [
            'kode_gedung.unique' => 'Kode gedung sudah digunakan',
            'kode_gedung.required' => 'Kode gedung harus diisi',
            'nama_gedung.required' => 'Nama gedung harus diisi',
        ]);

        $gedung->update($validated);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil diperbarui');
    }

    public function destroy(Gedung $gedung)
    {
        $gedung->delete();
        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil dihapus');
    }
}

