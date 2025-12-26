@extends('layouts.app')

@section('title', 'Kelola Laporan')

@section('content')
<style>
    .stat-card {
        background: #ffffff;
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
        border-left: 4px solid #2c7113;
        margin-bottom: 0%;
    }
    .stat-card h5 {
        color: #0a0a0a;
    }
    .stat-card h3 {
        color: #0a0a0a;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold" style="color: #2c7113;">Kelola Laporan dan Pengaduan</h1>
                <a href="{{ route('laporan.export-pdf') }}" class="btn btn-warning" style="border: none;">
                <i class="fas fa-download me-2"></i>Export PDF</a>
            </div>

            {{-- Filter --}}
            <form method="GET" action="{{ route('laporan.admin-index') }}" class="row g-2 mb-4">
                <div class="col-md-6">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari user, ruangan, atau deskripsi...">
                </div>
                <div class="col-md-6">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="baru" {{ request('status') == 'baru' ? 'selected' : '' }}>Baru</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-6 mb-2">
                    <button type="submit" class="btn btn-warning w-100">Filter</button>
                </div>
                <div class="col-6">
                    <a href="{{ route('laporan.admin-index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>

                <!-- Statistik -->
                <div class="row mb-4">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #1ccaef;">
                                <h5 class="card-title">Laporan Baru</h5>
                                <h3 class="mb-0">{{ $stats['baru'] }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #d29201;">
                                <h5 class="card-title">Sedang Diproses</h5>
                                <h3 class="mb-0">{{ $stats['diproses'] }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #2c7113;">
                                <h5 class="card-title">Selesai</h5>
                                <h3 class="mb-0">{{ $stats['selesai'] }}</h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card" style="border-left-color: #666666;">
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
                <div class="">
                    <div class="table-responsive" style="border-radius: 12px;">
                        <table class="table mb-0">
                            <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
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
                                                <span class="badge bg-danger">Baru</span>
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
                                            <a href="{{ route('laporan.admin-edit', $item->id) }}" class="btn btn-sm btn-primary">Proses</a>
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
