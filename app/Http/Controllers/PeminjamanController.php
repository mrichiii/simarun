<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function create($ruangan_id)
    {
        $ruangan = Ruangan::findOrFail($ruangan_id);
        
        // Cek status real-time, bukan status database
        if ($ruangan->getStatusRealTimeAttribute() !== 'tersedia') {
            return redirect()->back()->with('error', 'Ruangan tidak tersedia untuk peminjaman pada saat ini');
        }

        return view('booking.create', compact('ruangan'));
    }

    public function store(Request $request, $ruangan_id)
    {
        $ruangan = Ruangan::findOrFail($ruangan_id);

        $validated = $request->validate([
            'dosen_pengampu' => 'required|string|max:255',
            // Make tanggal_peminjaman optional for backward compatibility; default to today if missing
            'tanggal_peminjaman' => 'nullable|date_format:Y-m-d|after_or_equal:today',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ], [
            'tanggal_peminjaman.date_format' => 'Format tanggal harus YYYY-MM-DD',
            'tanggal_peminjaman.after_or_equal' => 'Tanggal peminjaman harus hari ini atau setelahnya',
            'jam_masuk.required' => 'Jam masuk harus diisi',
            'jam_masuk.date_format' => 'Format jam harus HH:MM',
            'jam_keluar.required' => 'Jam keluar harus diisi',
            'jam_keluar.date_format' => 'Format jam harus HH:MM',
            'jam_keluar.after' => 'Jam keluar harus lebih besar dari jam masuk',
            'dosen_pengampu.required' => 'Nama dosen pengampu harus diisi',
        ]);

        // Konversi ke datetime format
        // Jika user tidak mengisi tanggal, gunakan tanggal hari ini (backward compatibility)
        $tanggal = $request->input('tanggal_peminjaman', Carbon::now(config('app.timezone'))->format('Y-m-d'));
        $jam_masuk = $validated['jam_masuk'];
        $jam_keluar = $validated['jam_keluar'];

        $tanggal_jam_masuk = Carbon::createFromFormat(
            'Y-m-d H:i',
            "$tanggal $jam_masuk",
            config('app.timezone')
        );
        
        $tanggal_jam_keluar = Carbon::createFromFormat(
            'Y-m-d H:i',
            "$tanggal $jam_keluar",
            config('app.timezone')
        );

        // Cek overlap dengan peminjaman aktif ruangan yang sama
        // Menggunakan datetime columns untuk akurasi penuh
        // Hanya cek booking aktif atau yang belum lewat waktu keluar
        $overlap = Peminjaman::where('ruangan_id', $ruangan_id)
            ->where('status', 'aktif')
            ->where('tanggal_jam_keluar', '>', now()) // Hanya yang belum lewat waktu keluar
            ->where(function ($query) use ($tanggal_jam_masuk, $tanggal_jam_keluar) {
                // Ada booking yang overlap dengan slot waktu yang diminta
                $query->where('tanggal_jam_masuk', '<', $tanggal_jam_keluar)
                      ->where('tanggal_jam_keluar', '>', $tanggal_jam_masuk);
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['jam_masuk' => 'Waktu yang dipilih bentrok dengan peminjaman lain. Silakan pilih waktu lain.'])->withInput();
        }

        // Cek apakah pengguna sudah memiliki peminjaman aktif yang belum berakhir
        // Persyaratan: satu nim hanya boleh meminjam 1 ruangan sekaligus
        // Hanya cek booking aktif atau yang belum lewat waktu keluar
        $userOverlap = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->where('tanggal_jam_keluar', '>', now()) // Hanya yang belum lewat waktu keluar
            ->where(function ($query) use ($tanggal_jam_masuk, $tanggal_jam_keluar) {
                // Overlap dengan waktu booking yang baru diminta
                $query->where('tanggal_jam_masuk', '<', $tanggal_jam_keluar)
                      ->where('tanggal_jam_keluar', '>', $tanggal_jam_masuk);
            })
            ->exists();

        if ($userOverlap) {
            return back()->withErrors(['jam_masuk' => 'Anda masih memiliki peminjaman aktif yang belum selesai. Tunggu hingga peminjaman tersebut berakhir sebelum booking ruangan baru.'])->withInput();
        }

        // Jika semua validasi lolos, cek status real-time sekali lagi
        // untuk memastikan tidak ada race condition
        if ($ruangan->getStatusRealTimeAttribute() !== 'tersedia') {
            return back()->with('error', 'Maaf, ruangan baru saja di-booking oleh pengguna lain. Silakan refresh dan coba lagi.')->withInput();
        }

        // Buat peminjaman baru dengan datetime columns saja (tidak perlu legacy)
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'ruangan_id' => $ruangan_id,
            'dosen_pengampu' => $validated['dosen_pengampu'],
            'tanggal_jam_masuk' => $tanggal_jam_masuk,
            'tanggal_jam_keluar' => $tanggal_jam_keluar,
            'status' => 'aktif',
        ]);

        return redirect()->route('booking.my-bookings')->with('success', 'Peminjaman ruangan berhasil dibuat. Status ruangan akan otomatis berubah menjadi "Tidak Tersedia" sejak jam masuk.');
    }

    public function myBookings(Request $request)
    {
        $query = Peminjaman::where('user_id', Auth::id())->with('ruangan.lantai.gedung');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->whereHas('ruangan', function($r) use ($q) {
                $r->where('kode_ruangan', 'like', "%{$q}%")
                  ->orWhere('nama_ruangan', 'like', "%{$q}%");
            });
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->get();

        return view('booking.my-bookings', compact('peminjaman'));
    }

    public function cancel($peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);

        if ($peminjaman->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak membatalkan peminjaman ini');
        }

        if ($peminjaman->status !== 'aktif') {
            return redirect()->back()->with('error', 'Hanya peminjaman aktif yang bisa dibatalkan');
        }

        return view('booking.cancel', compact('peminjaman'));
    }

    public function confirmCancel(Request $request, $peminjaman_id)
    {
        $peminjaman = Peminjaman::findOrFail($peminjaman_id);

        if ($peminjaman->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak membatalkan peminjaman ini');
        }

        $validated = $request->validate([
            'alasan_pembatalan' => 'required|string|min:10',
        ], [
            'alasan_pembatalan.required' => 'Alasan pembatalan harus diisi',
            'alasan_pembatalan.min' => 'Alasan pembatalan minimal 10 karakter',
        ]);

        $peminjaman->update([
            'status' => 'dibatalkan',
            'alasan_pembatalan' => $validated['alasan_pembatalan'],
        ]);

        // Status ruangan akan secara otomatis berubah kembali menjadi tersedia
        // karena status dihitung real-time berdasarkan peminjaman aktif

        return redirect()->route('booking.my-bookings')->with('success', 'Peminjaman berhasil dibatalkan. Status ruangan akan otomatis kembali menjadi "Tersedia".');
    }
}


