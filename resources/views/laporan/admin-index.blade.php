@extends('layouts.app')

@section('title', 'Kelola Laporan')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">← Kembali ke Dashboard Admin</a>
            </div>

            <div class="card p-4 mb-4 d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-4">Kelola Laporan dan Pengaduan</h2>
                </div>
                <div>
                    <a href="{{ route('laporan.export-pdf') }}" class="btn btn-sm btn-outline-secondary">⬇️ Export PDF</a>
                </div>
            </div>

                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Laporan Baru</h5>
                                <h3 class="mb-0">{{ $stats['baru'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title">Sedang Diproses</h5>
                                <h3 class="mb-0">{{ $stats['diproses'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Selesai</h5>
                                <h3 class="mb-0">{{ $stats['selesai'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total</h5>
                                <h3 class="mb-0">{{ $stats['baru'] + $stats['diproses'] + $stats['selesai'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($laporan->isEmpty())
                <div class="alert alert-info">
                    Tidak ada laporan dari user
                </div>
            @else
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>User</th>
                                    <th>Ruangan</th>
                                    <th>Deskripsi</th>
                                    <th>Status</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->user->name }}</strong><br>
                                            <small class="text-muted">{{ $item->user->email }}</small>
                                        </td>
                                        <td>
                                            @if($item->ruangan)
                                                <strong>{{ $item->ruangan->kode_ruangan }}</strong><br>
                                                <small class="text-muted">{{ $item->ruangan->nama_ruangan }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ Str::limit($item->deskripsi, 50) }}</small>
                                        </td>
                                        <td>
                                            @if($item->status === 'baru')
                                                <span class="badge bg-info">Baru</span>
                                            @elseif($item->status === 'diproses')
                                                <span class="badge bg-warning">Diproses</span>
                                            @else
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $item->created_at->format('d M Y H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('laporan.admin-edit', $item->id) }}" class="btn btn-sm btn-outline-primary">Proses</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
