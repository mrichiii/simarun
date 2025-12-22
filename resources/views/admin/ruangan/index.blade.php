@extends('layouts.app')

@section('title', 'Data Ruangan - ' . $lantai->nama_lantai ?: 'Lantai ' . $lantai->nomor_lantai)

@section('css')
<style>
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.875rem;
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
</style>
@endsection

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('lantai.index', $gedung->id) }}" class="text-decoration-none text-muted">← Kembali ke Data Lantai</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>{{ $gedung->nama_gedung }} - Lantai {{ $lantai->nomor_lantai }}</h1>
            <p class="text-muted">{{ $lantai->nama_lantai ?: 'Lantai Dasar' }}</p>
        </div>
        <a href="{{ route('ruangan.create', [$gedung->id, $lantai->id]) }}" class="btn btn-primary">+ Tambah Ruangan</a>
    </div>

    @if ($ruangan->isEmpty())
        <div class="card p-4 text-center text-muted">
            <p>Belum ada data ruangan. <a href="{{ route('ruangan.create', [$gedung->id, $lantai->id]) }}">Tambah ruangan sekarang</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Ruangan</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruangan as $item)
                        <tr>
                            <td><strong>{{ $item->kode_ruangan }}</strong></td>
                            <td>{{ $item->nama_ruangan }}</td>
                            <td>
                                <span class="status-badge status-{{ $item->status }}">
                                    @if ($item->status === 'tersedia')
                                        ✓ Tersedia
                                    @elseif ($item->status === 'tidak_tersedia')
                                        ⚠ Terpakai
                                    @else
                                        ✗ Tidak Dapat Dipakai
                                    @endif
                                </span>
                            </td>
                            <td>{{ $item->alasan_tidak_dapat_dipakai ?? '-' }}</td>
                            <td>
                                <a href="{{ route('ruangan.edit', [$gedung->id, $lantai->id, $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('ruangan.destroy', [$gedung->id, $lantai->id, $item->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
