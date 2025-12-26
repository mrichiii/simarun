@extends('layouts.app')

@section('title', $ruangan->nama_ruangan)

@section('css')
<style>
    .info-box {
        background-color: #f9f9f9;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .status-tersedia {
        background-color: #d4edda;
        color: #155724;
    }
    .status-tidak_tersedia {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-tidak_dapat_dipakai {
        background-color: #f8d7da;
        color: #721c24;
    }
    .fasilitas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }
    .fasilitas-item {
        background-color: white;
        padding: 1rem;
        border-radius: 6px;
        border-left: 4px solid #2c7113;
    }
    .fasilitas-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .fasilitas-label {
        font-size: 0.9rem;
        color: #666;
    }
</style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1 class="fw-bold mb-1" style="color: #2c7113;">{{ $ruangan->nama_ruangan }}</h1>
            <p class="text-muted mb-3">
                {{ $ruangan->kode_ruangan }} • 
                Lantai {{ $ruangan->lantai->nomor_lantai }} •
                {{ $ruangan->lantai->gedung->nama_gedung }}
            </p>

            <span class="status-badge status-{{ $statusRealTime }}">
                @if ($statusRealTime === 'tersedia')
                    ✓ Tersedia untuk Peminjaman
                @elseif ($statusRealTime === 'tidak_tersedia')
                    ⚠ Sedang Digunakan
                @else
                    ✗ Tidak Dapat Dipakai
                @endif
            </span>

            @if ($statusRealTime === 'tidak_dapat_dipakai' && $ruangan->alasan_tidak_dapat_dipakai)
                <div class="alert alert-danger mt-3">
                    <strong>Alasan:</strong> {{ $ruangan->alasan_tidak_dapat_dipakai }}
                </div>
            @endif

            @if ($statusRealTime === 'tidak_tersedia')
                <div class="alert alert-warning mt-4" role="alert">
                    <h5 class="alert-heading">⚠️ Ruangan Sedang Digunakan</h5>
                    @if($currentPeminjaman)
                        <p class="mb-0">
                            <strong>Dosen Pengampu:</strong> {{ $currentPeminjaman->dosen_pengampu }}<br>
                            <strong>Waktu Penggunaan:</strong> 
                            {{ $currentPeminjaman->tanggal_jam_masuk->format('H:i') }} - 
                            {{ $currentPeminjaman->tanggal_jam_keluar->format('H:i') }}
                        </p>
                    @else
                        <p class="mb-0">Ruangan sedang tidak tersedia untuk peminjaman saat ini.</p>
                    @endif
                </div>
            @endif

            <!-- Fasilitas -->
            @if ($ruangan->fasilitas)
                <h4 class="mt-4 mb-3">Fasilitas Ruangan</h4>
                <div class="fasilitas-grid">
                    <div class="fasilitas-item">
                        <div class="fasilitas-icon">❄️</div>
                        <div class="fasilitas-label">AC</div>
                        <strong>{{ $ruangan->fasilitas->ac ? 'Ada' : 'Tidak Ada' }}</strong>
                    </div>
                    <div class="fasilitas-item">
                        <div class="fasilitas-icon">🎬</div>
                        <div class="fasilitas-label">Proyektor</div>
                        <strong>{{ $ruangan->fasilitas->proyektor ? 'Ada' : 'Tidak Ada' }}</strong>
                    </div>
                    <div class="fasilitas-item">
                        <div class="fasilitas-icon">🪑</div>
                        <div class="fasilitas-label">Jumlah Kursi</div>
                        <strong>{{ $ruangan->fasilitas->jumlah_kursi ?? 0 }} kursi</strong>
                    </div>
                    <div class="fasilitas-item">
                        <div class="fasilitas-icon">📋</div>
                        <div class="fasilitas-label">Papan Tulis</div>
                        <strong>{{ $ruangan->fasilitas->papan_tulis ? 'Ada' : 'Tidak Ada' }}</strong>
                    </div>
                    <div class="fasilitas-item">
                        <div class="fasilitas-icon">📶</div>
                        <div class="fasilitas-label">WiFi</div>
                        <strong>{{ ucfirst(str_replace('_', ' ', $ruangan->fasilitas->wifi)) }}</strong>
                    </div>
                    <div class="fasilitas-item">
                        <div class="fasilitas-icon">⚡</div>
                        <div class="fasilitas-label">Arus Listrik</div>
                        <strong>{{ ucfirst(str_replace('_', ' ', $ruangan->fasilitas->arus_listrik)) }}</strong>
                    </div>
                </div>
            @else
                <div class="alert alert-info mt-4">Belum ada data fasilitas untuk ruangan ini</div>
            @endif
        </div>

        <div class="col-md-4">
            <div class="card p-4" style="position: sticky; top: 20px;">
                <h5 class="card-title mb-3">Ringkasan Ruangan</h5>
                <dl class="row">
                    <dt class="col-sm-7">Kode Ruangan</dt>
                    <dd class="col-sm-5"><strong>{{ $ruangan->kode_ruangan }}</strong></dd>

                    <dt class="col-sm-7">Nama</dt>
                    <dd class="col-sm-5">{{ $ruangan->nama_ruangan }}</dd>

                    <dt class="col-sm-7">Status</dt>
                    <dd class="col-sm-5">
                        @if ($statusRealTime === 'tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @elseif ($statusRealTime === 'tidak_tersedia')
                            <span class="badge bg-warning">Terpakai</span>
                        @else
                            <span class="badge bg-danger">Tidak Dapat Dipakai</span>
                        @endif
                    </dd>

                    <dt class="col-sm-7">Lantai</dt>
                    <dd class="col-sm-5">{{ $ruangan->lantai->nomor_lantai }}</dd>

                    <dt class="col-sm-7">Gedung</dt>
                    <dd class="col-sm-5">{{ $ruangan->lantai->gedung->nama_gedung }}</dd>
                </dl>
            </div>
            <!-- CTA Booking -->
            @if ($statusRealTime === 'tersedia')
                <div class="mt-4 d-grid">
                    <a href="{{ route('booking.create', $ruangan->id) }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-calendar-plus"></i> Buat Peminjaman Ruangan
                    </a>
                </div>
                <div class="mt-4 d-grid">
                    <a href="{{ route('user.gedung-detail', $ruangan->lantai->gedung_id) }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            @else
                <div class="mt-4">
                    @if ($statusRealTime === 'tidak_dapat_dipakai')
                        <div class="alert alert-danger" role="alert">
                            <h5 class="alert-heading">❌ Ruangan Tidak Dapat Dipakai</h5>
                            <p class="mb-0">Ruangan ini sedang tidak tersedia untuk peminjaman.</p>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <p class="mb-0">Ruangan ini saat ini tidak tersedia untuk peminjaman</p>
                        </div>
                    @endif
                </div>
                <div class="mt-4 d-grid">
                    <a href="{{ route('user.gedung-detail', $ruangan->lantai->gedung_id) }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            @endif  
        </div>
    </div>
</div>
@endsection
