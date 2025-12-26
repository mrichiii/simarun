@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <div class="mb-3">
                	<a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">← Kembali ke Dashboard</a>
                </div>
            <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold" style="color: #2c7113;">Laporan dan Pengaduan Saya</h1>
                <a href="{{ route('laporan.create') }}" class="btn btn-primary" style="border: none;">
                <i class="fas fa-plus"></i> Laporan Baru</a>
            </div>

                @if($laporan->isEmpty())
                    <div class="alert alert-info">
                        <strong>Belum ada laporan</strong><br>
                        Anda belum membuat laporan apapun. <a href="{{ route('laporan.create') }}" class="alert-link">Buat laporan baru sekarang</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
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
                                            @if($item->ruangan)
                                                <strong>{{ $item->ruangan->kode_ruangan }}</strong><br>
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
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('laporan.show', $item->id) }}" class="btn btn-warning" style="padding: 5px 12px;">Lihat</a>
                                                @if($item->status === 'baru')
                                                    <form action="{{ route('laporan.destroy', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-muted small mt-3">
                        <p>Total laporan: <strong>{{ $laporan->count() }}</strong></p>
                        <p>Baru: <strong>{{ $laporan->where('status', 'baru')->count() }}</strong> | 
                           Diproses: <strong>{{ $laporan->where('status', 'diproses')->count() }}</strong> | 
                           Selesai: <strong>{{ $laporan->where('status', 'selesai')->count() }}</strong></p>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
