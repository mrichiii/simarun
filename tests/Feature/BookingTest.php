<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // buat struktur gedung->lantai->ruangan
        $this->gedung = Gedung::create(['kode_gedung' => '', 'nama_gedung' => '', 'lokasi' => 'Kampus']);
        $this->lantai = Lantai::create(['gedung_id' => $this->gedung->id, 'nomor_lantai' => 1, 'nama_lantai' => 'Lantai 1']);
        $this->ruangan = Ruangan::create([
            'lantai_id' => $this->lantai->id,
            'kode_ruangan' => '-101',
            'nama_ruangan' => 'Ruang A',
            'status' => 'tersedia'
        ]);
    }

    public function test_user_can_create_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('booking.store', $this->ruangan->id), [
            'dosen_pengampu' => 'Dr. A',
            'jam_masuk' => '08:00',
            'jam_keluar' => '10:00',
        ]);

        $response->assertRedirect(route('booking.my-bookings'));
        $this->assertDatabaseHas('peminjaman', [
            'user_id' => $user->id,
            'ruangan_id' => $this->ruangan->id,
            'dosen_pengampu' => 'Dr. A',
            'status' => 'aktif'
        ]);
    }

    public function test_overlap_prevented_for_same_room()
    {
        $otherUser = User::factory()->create();
        Peminjaman::create([
            'user_id' => $otherUser->id,
            'ruangan_id' => $this->ruangan->id,
            'dosen_pengampu' => 'X',
            'jam_masuk' => '09:00',
            'jam_keluar' => '10:00',
            'status' => 'aktif'
        ]);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('booking.store', $this->ruangan->id), [
            'dosen_pengampu' => 'Dr. B',
            'jam_masuk' => '09:30',
            'jam_keluar' => '10:30',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_user_overlap_prevented()
    {
        // buat booking aktif untuk user di ruangan lain
        $user = User::factory()->create();
        $ruangan2 = Ruangan::create([
            'lantai_id' => $this->lantai->id,
            'kode_ruangan' => '-102',
            'nama_ruangan' => 'Ruang B',
            'status' => 'tersedia'
        ]);

        Peminjaman::create([
            'user_id' => $user->id,
            'ruangan_id' => $ruangan2->id,
            'dosen_pengampu' => 'Y',
            'jam_masuk' => '11:00',
            'jam_keluar' => '12:00',
            'status' => 'aktif'
        ]);

        $this->actingAs($user);

        $response = $this->post(route('booking.store', $this->ruangan->id), [
            'dosen_pengampu' => 'Dr. C',
            'jam_masuk' => '11:30',
            'jam_keluar' => '12:30',
        ]);

        $response->assertSessionHasErrors();
    }

    public function test_cancel_booking()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $p = Peminjaman::create([
            'user_id' => $user->id,
            'ruangan_id' => $this->ruangan->id,
            'dosen_pengampu' => 'Z',
            'jam_masuk' => '13:00',
            'jam_keluar' => '14:00',
            'status' => 'aktif'
        ]);

        $response = $this->put(route('booking.confirm-cancel', $p->id), [
            'alasan_pembatalan' => 'Perubahan jadwal'
        ]);

        $response->assertRedirect(route('booking.my-bookings'));
        $this->assertDatabaseHas('peminjaman', [
            'id' => $p->id,
            'status' => 'dibatalkan'
        ]);
    }
}
