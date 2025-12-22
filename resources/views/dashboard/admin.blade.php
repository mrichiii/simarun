@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Ruangan Tersedia</h6>
                <h2>--</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Ruangan Terpakai</h6>
                <h2>--</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Tidak Dapat Dipakai</h6>
                <h2>--</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center">
                <h6 class="text-muted">Total Ruangan</h6>
                <h2>--</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="card-title mb-3">Manajemen Data Dasar</h5>
                <div class="list-group">
                    <a href="{{ route('gedung.index') }}" class="list-group-item list-group-item-action">
                        <strong>📍 Kelola Gedung</strong>
                        <p class="text-muted small mb-0">Tambah, edit, hapus data gedung</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4">
                <h5 class="card-title">Selamat Datang, Admin</h5>
                <p class="text-muted">Fitur tambahan untuk manajemen lantai, ruangan, fasilitas, dan laporan akan dilanjutkan di tahap berikutnya.</p>
            </div>
        </div>
    </div>
</div>
@endsection

