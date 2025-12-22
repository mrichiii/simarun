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

    <div class="card p-4">
        <h5 class="card-title">Selamat Datang, Admin</h5>
        <p class="text-muted">Panel admin untuk manajemen gedung, lantai, ruangan, fasilitas, dan laporan akan dilanjutkan di tahap berikutnya.</p>
    </div>
</div>
@endsection
