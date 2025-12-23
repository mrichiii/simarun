<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class LaporanController extends Controller
{
    // User: Buat laporan baru
    public function create()
    {
        $ruangan = Ruangan::all();
        return view('laporan.create', compact('ruangan'));
    }

    // User: Store laporan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id' => 'nullable|exists:ruangan,id',
            'deskripsi' => 'required|string|min:10|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'deskripsi.required' => 'Deskripsi laporan harus diisi',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $laporan = new Laporan([
            'user_id' => Auth::id(),
            'ruangan_id' => $validated['ruangan_id'] ?? null,
            'deskripsi' => $validated['deskripsi'],
            'status' => 'baru',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('laporan', 'public');
            $laporan->foto_path = $path;
        }

        $laporan->save();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat');
    }

    // User: Lihat laporan sendiri
    public function index()
    {
        $laporan = Laporan::where('user_id', Auth::id())
            ->with('ruangan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan.index', compact('laporan'));
    }

    // User: Lihat detail laporan
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengakses laporan ini');
        }

        return view('laporan.show', compact('laporan'));
    }

    // Admin: Lihat semua laporan
    public function adminIndex()
    {
        $laporan = Laporan::with('user', 'ruangan')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'baru' => $laporan->where('status', 'baru')->count(),
            'diproses' => $laporan->where('status', 'diproses')->count(),
            'selesai' => $laporan->where('status', 'selesai')->count(),
        ];

        return view('laporan.admin-index', compact('laporan', 'stats'));
    }

    // Admin: Export laporan ke PDF
    public function exportPdf()
    {
        $laporan = Laporan::with('user', 'ruangan')->orderBy('created_at', 'desc')->get();
        $pdf = PDF::loadView('laporan.pdf', compact('laporan'));
        return $pdf->download('laporan_pengaduan.pdf');
    }

    // Admin: Edit laporan (untuk menambah catatan)
    public function adminEdit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.admin-edit', compact('laporan'));
    }

    // Admin: Update laporan
    public function adminUpdate(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:baru,diproses,selesai',
            'catatan_admin' => 'nullable|string|max:1000',
        ], [
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status tidak valid',
        ]);

        $laporan->update($validated);

        return redirect()->route('laporan.admin-index')->with('success', 'Laporan berhasil diupdate');
    }

    // User: Hapus laporan (hanya jika status baru)
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        if ($laporan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus laporan ini');
        }

        if ($laporan->status !== 'baru') {
            return redirect()->back()->with('error', 'Hanya laporan dengan status "Baru" yang bisa dihapus');
        }

        if ($laporan->foto_path) {
            Storage::disk('public')->delete($laporan->foto_path);
        }

        $laporan->delete();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus');
    }
}
