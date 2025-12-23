<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'user')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|digits_between:1,10|unique:users,nim',
        ], [
            'name.required' => 'Nama mahasiswa harus diisi',
            'nim.required' => 'NIM harus diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'nim.digits_between' => 'NIM harus berupa angka dan maksimal 10 digit',
        ]);

        User::create([
            'name' => $validated['name'],
            'nim' => $validated['nim'],
            'email' => 'mahasiswa_' . $validated['nim'] . '@student.uinsu.ac.id',
            'password' => bcrypt($validated['nim']), // Default password = NIM (for backup)
            'role' => 'user',
        ]);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mahasiswa = User::findOrFail($id);
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|digits_between:1,10|unique:users,nim,' . $id,
        ], [
            'name.required' => 'Nama mahasiswa harus diisi',
            'nim.required' => 'NIM harus diisi',
            'nim.unique' => 'NIM sudah terdaftar',
            'nim.digits_between' => 'NIM harus berupa angka dan maksimal 10 digit',
        ]);

        $mahasiswa->name = $validated['name'];
        $mahasiswa->nim = $validated['nim'];
        $mahasiswa->save();

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->delete();
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa berhasil dihapus');
    }
}

