@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('css')
<style>
    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        border-left: 4px solid #111;
    }
    .stat-card h6 {
        color: #999;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .stat-card h2 {
        margin: 0;
        font-size: 2.5rem;
        font-weight: 700;
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
    }
    .grid-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .grid-item.tersedia {
        background-color: #28a745;
    }
    .grid-item.tidak_tersedia {
        background-color: #ffc107;
        color: #333;
    }
    .grid-item.tidak_dapat_dipakai {
        background-color: #dc3545;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Statistik Ringkas -->
    <div class="row mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <h6>Ruangan Tersedia</h6>
                <h2>{{ $ruanganTersedia }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left-color: #ffc107;">
                <h6>Ruangan Terpakai</h6>
                <h2>{{ $ruanganTerpakai }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left-color: #dc3545;">
                <h6>Tidak Dapat Dipakai</h6>
                <h2>{{ $ruanganTidakDapatDipakai }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card" style="border-left-color: #666;">
                <h6>Total Ruangan</h6>
                <h2>{{ $totalRuangan }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <!-- Manajemen Cepat -->
            <div class="card p-4 mb-4">
                <h5 class="card-title mb-3">Manajemen Data</h5>
                <div class="list-group">
                    <a href="/gedung" class="list-group-item list-group-item-action">
                        <strong>📍 Kelola Gedung</strong>
                        <p class="text-muted small mb-0">Tambah, edit, hapus data gedung</p>
                    </a>
                    <a href="{{ route('laporan.admin-index') }}" class="list-group-item list-group-item-action">
                        <strong>📝 Kelola Laporan & Pengaduan</strong>
                        <p class="text-muted small mb-0">Proses laporan dari user</p>
                    </a>
                </div>
            </div>

            <!-- Grid Visual Ruangan -->
            <div class="card p-4">
                <h5 class="card-title mb-3">Visualisasi Status Ruangan (Semua Gedung)</h5>
                <p class="text-muted small">Klik untuk melihat detail ruangan</p>

                @if ($allRuangan->isEmpty())
                    <div class="alert alert-info">Belum ada ruangan yang terdaftar</div>
                @else
                    <div class="grid-container">
                        @foreach ($allRuangan as $ruangan)
                            <div class="grid-item {{ $ruangan->status }}" title="{{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}">
                                {{ $ruangan->kode_ruangan }}
                            </div>
                        @endforeach
                    </div>

                    <div class="row mt-4 pt-3" style="border-top: 1px solid #eee;">
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 20px; height: 20px; background-color: #28a745; border-radius: 4px;"></div>
                                <span>Tersedia</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 20px; height: 20px; background-color: #ffc107; border-radius: 4px;"></div>
                                <span>Terpakai</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <div style="width: 20px; height: 20px; background-color: #dc3545; border-radius: 4px;"></div>
                                <span>Tidak Dapat Dipakai</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-4">
                <h5 class="card-title">Informasi</h5>
                <p class="text-muted small">Selamat datang di panel administrasi Sistem Informasi Manajemen Ruangan Gedung FST.</p>
                <p class="text-muted small">Gunakan menu di atas untuk mengelola data gedung, lantai, ruangan, fasilitas, dan laporan.</p>
            </div>
        </div>
    </div>
</div>
@endsection


