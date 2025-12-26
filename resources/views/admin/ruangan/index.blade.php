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
        color: #224914;
    }
    .status-tidak_tersedia {
        background-color: #fff3cd;
        color: #d29201;
    }
    .status-tidak_dapat_dipakai {
        background-color: #f8d7da;
        color: #0a0a0a;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('lantai.index', $gedung->id) }}" class="text-decoration-none text-muted">← Kembali ke Data Lantai</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #2c7113;">{{ $gedung->nama_gedung }} - Lantai {{ $lantai->nomor_lantai }}</h1>
        <a href="{{ route('ruangan.create', [$gedung->id, $lantai->id]) }}" class="btn btn-primary" style="border: none;">
        <i class="fas fa-plus me-2"></i>Tambah Ruangan</a>
    </div>

    {{-- Filter form --}}
    <form method="GET" action="{{ route('ruangan.index', [$gedung->id, $lantai->id]) }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode atau nama ruangan...">
        </div>
        <div class="col-md-6">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="tidak_tersedia" {{ request('status') == 'tidak_tersedia' ? 'selected' : '' }}>Terpakai</option>
                <option value="tidak_dapat_dipakai" {{ request('status') == 'tidak_dapat_dipakai' ? 'selected' : '' }}>Tidak Dapat Dipakai</option>
            </select>
        </div>
        <div class="col-6 mb-2">
            <button type="submit" class="btn btn-warning w-100">Filter</button>
        </div>
        <div class="col-6">
            <a href="{{ route('ruangan.index', [$gedung->id, $lantai->id]) }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    @if ($ruangan->isEmpty())
        <div class="card p-4 text-center text-muted">
            <p>Belum ada data ruangan. <a href="{{ route('ruangan.create', [$gedung->id, $lantai->id]) }}">Tambah ruangan sekarang</a></p>
        </div>
    @else
        <div class="table-responsive" style="border-radius: 12px;">
            <table class="table mb-0">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
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
                                <a href="{{ route('fasilitas.edit', [$gedung->id, $lantai->id, $item->id]) }}" class="btn btn-sm btn-primary">Fasilitas</a>
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
