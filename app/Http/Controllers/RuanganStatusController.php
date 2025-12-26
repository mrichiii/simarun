<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RuanganStatusController extends Controller
{
    /**
     * Endpoint untuk mendapatkan status real-time ruangan
     * Digunakan untuk polling atau AJAX request
     * 
     * GET /api/ruangan/{ruangan_id}/status
     */
    public function getStatus($ruangan_id)
    {
        $ruangan = Ruangan::findOrFail($ruangan_id);

        // Status real-time dihitung dari accessor
        $statusRealTime = $ruangan->getStatusRealTimeAttribute();

        // Ambil informasi peminjaman yang sedang berlangsung
        $currentBooking = $ruangan->getCurrentPeminjamanAttribute();

        return response()->json([
            'ruangan_id' => $ruangan->id,
            'kode_ruangan' => $ruangan->kode_ruangan,
            'nama_ruangan' => $ruangan->nama_ruangan,
            'status' => $statusRealTime,
            'status_database' => $ruangan->status, // Status literal di database untuk debugging
            'current_booking' => $currentBooking ? [
                'id' => $currentBooking->id,
                'user_id' => $currentBooking->user_id,
                'user_name' => $currentBooking->user->name ?? 'Unknown',
                'dosen_pengampu' => $currentBooking->dosen_pengampu,
                'tanggal_jam_masuk' => $currentBooking->tanggal_jam_masuk,
                'tanggal_jam_keluar' => $currentBooking->tanggal_jam_keluar,
            ] : null,
            'server_time' => Carbon::now(config('app.timezone'))->toIso8601String(),
        ]);
    }

    /**
     * Endpoint untuk mendapatkan status multiple ruangan sekaligus
     * Berguna untuk dashboard yang menampilkan banyak ruangan
     * 
     * POST /api/ruangan/status/bulk
     * Body: { "ruangan_ids": [1, 2, 3, ...] }
     */
    public function getBulkStatus(Request $request)
    {
        $ruangan_ids = $request->input('ruangan_ids', []);

        if (!is_array($ruangan_ids) || empty($ruangan_ids)) {
            return response()->json([
                'error' => 'ruangan_ids must be a non-empty array'
            ], 400);
        }

        $ruangans = Ruangan::whereIn('id', $ruangan_ids)
            ->with(['peminjaman' => function ($q) {
                $now = Carbon::now(config('app.timezone'));
                $q->where('status', 'aktif')
                  ->where('tanggal_jam_masuk', '<=', $now)
                  ->where('tanggal_jam_keluar', '>=', $now);
            }])
            ->get();

        $result = [];
        $now = Carbon::now(config('app.timezone'));

        foreach ($ruangans as $ruangan) {
            $statusRealTime = $ruangan->getStatusRealTimeAttribute();
            $currentBooking = $ruangan->peminjaman->first();

            $result[] = [
                'ruangan_id' => $ruangan->id,
                'kode_ruangan' => $ruangan->kode_ruangan,
                'nama_ruangan' => $ruangan->nama_ruangan,
                'status' => $statusRealTime,
                'has_active_booking' => $currentBooking ? true : false,
                'jam_keluar_saat_ini' => $currentBooking ? $currentBooking->tanggal_jam_keluar : null,
            ];
        }

        return response()->json([
            'data' => $result,
            'server_time' => $now->toIso8601String(),
            'count' => count($result),
        ]);
    }

    /**
     * Endpoint untuk mendapatkan ruangan yang tersedia di jam-jam tertentu
     * 
     * GET /api/ruangan/available?tanggal=2025-12-26&jam_mulai=08:00&jam_selesai=10:00
     */
    public function getAvailableRooms(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $tanggal = $request->input('tanggal');
        $jam_mulai = $request->input('jam_mulai');
        $jam_selesai = $request->input('jam_selesai');

        $start = Carbon::createFromFormat('Y-m-d H:i', "$tanggal $jam_mulai", config('app.timezone'));
        $end = Carbon::createFromFormat('Y-m-d H:i', "$tanggal $jam_selesai", config('app.timezone'));

        // Cari ruangan yang tidak ada peminjaman untuk slot waktu tersebut
        $availableRooms = Ruangan::where('status', '!=', 'tidak_dapat_dipakai')
            ->whereDoesntHave('peminjaman', function ($q) use ($start, $end) {
                $q->where('status', 'aktif')
                  ->where(function ($query) use ($start, $end) {
                      // Overlap check: ada booking yang bertabrakan dengan slot ini
                      $query->where('tanggal_jam_masuk', '<', $end)
                            ->where('tanggal_jam_keluar', '>', $start);
                  });
            })
            ->with('lantai.gedung', 'fasilitas')
            ->get();

        return response()->json([
            'tanggal' => $tanggal,
            'jam_mulai' => $jam_mulai,
            'jam_selesai' => $jam_selesai,
            'available_rooms_count' => count($availableRooms),
            'available_rooms' => $availableRooms->map(function ($r) {
                return [
                    'id' => $r->id,
                    'kode_ruangan' => $r->kode_ruangan,
                    'nama_ruangan' => $r->nama_ruangan,
                    'status' => $r->getStatusRealTimeAttribute(),
                    'lantai' => $r->lantai->nomor_lantai ?? null,
                    'gedung' => $r->lantai->gedung->nama_gedung ?? null,
                ];
            }),
        ]);
    }

    /**
     * Endpoint untuk testing dan debugging
     * Menampilkan semua peminjaman aktif dan status real-time untuk ruangan tertentu
     * 
     * GET /api/ruangan/{ruangan_id}/debug
     */
    public function debug($ruangan_id)
    {
        $ruangan = Ruangan::with('peminjaman')->findOrFail($ruangan_id);
        $now = Carbon::now(config('app.timezone'));

        $allBookings = $ruangan->peminjaman()->get();
        
        $bookingDetails = $allBookings->map(function ($p) use ($now) {
            $isActive = $p->status === 'aktif' 
                && $p->tanggal_jam_masuk <= $now 
                && $p->tanggal_jam_keluar >= $now;
            
            return [
                'id' => $p->id,
                'status_db' => $p->status,
                'tanggal_jam_masuk' => $p->tanggal_jam_masuk,
                'tanggal_jam_keluar' => $p->tanggal_jam_keluar,
                'is_currently_active' => $isActive,
                'time_to_start' => $p->tanggal_jam_masuk > $now 
                    ? $p->tanggal_jam_masuk->diffInSeconds($now) . ' seconds' 
                    : 'already started',
                'time_to_end' => $p->tanggal_jam_keluar > $now 
                    ? $p->tanggal_jam_keluar->diffInSeconds($now) . ' seconds' 
                    : 'already ended',
            ];
        });

        return response()->json([
            'ruangan' => [
                'id' => $ruangan->id,
                'kode_ruangan' => $ruangan->kode_ruangan,
                'status_real_time' => $ruangan->getStatusRealTimeAttribute(),
                'status_database' => $ruangan->status,
            ],
            'server_time' => $now->toIso8601String(),
            'timezone' => config('app.timezone'),
            'all_bookings' => $bookingDetails,
            'total_bookings' => count($allBookings),
        ]);
    }
}
