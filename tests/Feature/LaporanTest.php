<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Gedung;
use App\Models\Lantai;
use App\Models\Ruangan;
use App\Models\Laporan;

class LaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_laporan_with_photo()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $gedung = Gedung::create(['kode_gedung' => 'FST','nama_gedung' => 'FST','lokasi'=>'Kampus']);
        $lantai = Lantai::create(['gedung_id' => $gedung->id, 'nomor_lantai' => 1, 'nama_lantai' => 'L1']);
        $ruangan = Ruangan::create(['lantai_id'=>$lantai->id,'kode_ruangan'=>'FST-201','nama_ruangan'=>'R201','status'=>'tersedia']);

        $this->actingAs($user);

        // Use create() instead of image() to avoid GD dependency in some PHP environments
        $file = UploadedFile::fake()->create('bukti.jpg', 100, 'image/jpeg');

        $response = $this->post(route('laporan.store'), [
            'ruangan_id' => $ruangan->id,
            'deskripsi' => 'Meja rusak di pojok kanan',
            'foto' => $file,
        ]);

        $response->assertRedirect(route('laporan.index'));
        $this->assertDatabaseHas('laporan', ['deskripsi' => 'Meja rusak di pojok kanan', 'user_id' => $user->id]);
        Storage::disk('public')->assertExists('laporan/' . $file->hashName());
    }
}
