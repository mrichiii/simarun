@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard User</h1>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card p-4">
                <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}!</h5>
                <p class="text-muted">Dashboard user untuk peminjaman ruangan akan dilanjutkan di tahap berikutnya.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4">
                <h6 class="card-title">Profil</h6>
                <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
