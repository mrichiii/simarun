@extends('layouts.app')

@section('title', 'Dashboard User')

@section('css')
<style>
    .card-gedung {
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid #e0e0e0;
    }
    .card-gedung:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .stat-badge {
        display: inline-block;
        background-color: #d4edda;
        color: #155724;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1.25rem;
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 0.5rem;
        margin-top: 1rem;
    }
    .grid-item {
        aspect-ratio: 1;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
        font-size: 0.85rem;
        text-align: center;
        padding: 0.5rem;
        color: white;
        background-color: #28a745;
        text-decoration: none;
    }
    .grid-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
</style>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-2">Dashboard Peminjaman Ruangan</h1>
    <p class="text-muted mb-4">Selamat datang, {{ Auth::user()->name }}! Pilih gedung untuk melihat ruangan yang tersedia.</p>

    <!-- Quick Action -->
    <div class="mb-4">
        <a href="{{ route('booking.my-bookings') }}" class="btn btn-outline-primary btn-sm">📋 Lihat Peminjaman Saya</a>
        <a href="{{ route('laporan.index') }}" class="btn btn-outline-danger btn-sm">📝 Laporan & Pengaduan</a>
    </div>

    <!-- Info Ruangan Tersedia -->
    <div class="mb-4">
        <p>
            <span class="stat-badge">{{ $ruanganTersedia }} ruangan tersedia</span>
        </p>
    </div>

    <!-- Daftar Gedung -->
    @if ($gedung->isEmpty())
        <div class="alert alert-info">Belum ada gedung yang terdaftar di sistem</div>
    @else
        <div class="row">
            @foreach ($gedung as $g)
                <div class="col-md-6 col-lg-4 mb-4">
                    <a href="{{ route('user.gedung-detail', $g->id) }}" class="text-decoration-none text-dark">
                        <div class="card card-gedung h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $g->nama_gedung }}</h5>
                                <p class="card-text text-muted small">{{ $g->kode_gedung }}</p>
                                <p class="text-muted small">{{ $g->lokasi ?? '-' }}</p>
                                <hr>
                                <p class="card-text small">
                                    <strong>{{ $g->lantai->count() }}</strong> lantai
                                    <br>
                                    <strong>{{ $g->lantai->flatMap->ruangan->count() }}</strong> ruangan
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

