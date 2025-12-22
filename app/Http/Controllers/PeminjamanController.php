<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function create($ruangan_id)
    {
        $ruangan = Ruangan::findOrFail($ruangan_id);
        
        if ($ruangan->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Ruangan tidak tersedia untuk peminjaman');
        }

        return view('booking.create', compact('ruangan'));
    }

    public function store(Request $request, $ruangan_id)
    {
        $ruangan = Ruangan::findOrFail($ruangan_id);

        $validated = $request->validate([
            'dosen_pengampu' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ], [
            'jam_masuk.required' => 'Jam masuk harus diisi',
            'jam_masuk.date_format' => 'Format jam harus HH:MM',
            'jam_keluar.required' => 'Jam keluar harus diisi',
            'jam_keluar.date_format' => 'Format jam harus HH:MM',
            'jam_keluar.after' => 'Jam keluar harus lebih besar dari jam masuk',
            'dosen_pengampu.required' => 'Nama dosen pengampu harus diisi',
        ]);

        // Cek overlap dengan peminjaman aktif ruangan yang sama
        $overlap = Peminjaman::where('ruangan_id', $ruangan_id)
            ->where('status', 'aktif')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_masuk', [$validated['jam_masuk'], $validated['jam_keluar']])
                    ->orWhereBetween('jam_keluar', [$validated['jam_masuk'], $validated['jam_keluar']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('jam_masuk', '<=', $validated['jam_masuk'])
                          ->where('jam_keluar', '>=', $validated['jam_keluar']);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors(['jam_masuk' => 'Waktu yang dipilih bentrok dengan peminjaman lain'])->withInput();
        }

        // Cek overlap peminjaman user itu sendiri
        $userOverlap = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->where(function ($query) use ($validated) {
                $query->whereBetween('jam_masuk', [$validated['jam_masuk'], $validated['jam_keluar']])
                    ->orWhereBetween('jam_keluar', [$validated['jam_masuk'], $validated['jam_keluar']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('jam_masuk', '<=', $validated['jam_masuk'])
                          ->where('jam_keluar', '>=', $validated['jam_keluar']);
                    });
            })
            ->exists();

        if ($userOverlap) {
            return back()->withErrors(['jam_masuk' => 'Anda sudah memiliki peminjaman pada waktu yang sama'])->withInput();
        }

        $validated['user_id'] = Auth::id();
        $validated['ruangan_id'] = $ruangan_id;
        $validated['status'] = 'aktif';

        Peminjaman::create($validated);

        return redirect()->route('booking.my-bookings')->with('success', 'Peminjaman ruangan berhasil dibuat');
    }

    public function myBookings()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::id())
            ->with('ruangan.lantai.gedung')
            ->orderBy('created_at', 'desc')
            ->get();

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

        return redirect()->route('booking.my-bookings')->with('success', 'Peminjaman berhasil dibatalkan');
    }
}

