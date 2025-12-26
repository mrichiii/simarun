@extends('layouts.app')

@section('title', 'Kelola Ruangan (Semua Gedung)')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #2c7113;">Kelola Ruangan (Semua Gedung)</h1>
        <a href="{{ route('gedung.index') }}" class="btn btn-primary" style="border: none;">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Gedung</a>
    </div>
    {{-- Filter form --}}
    <form method="GET" action="{{ route('admin.ruangan.index') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode atau nama ruangan...">
        </div>
        <div class="col-md-6">
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="tidak_dapat_dipakai" {{ request('status') == 'tidak_dapat_dipakai' ? 'selected' : '' }}>Tidak Dapat Dipakai</option>
            </select>
        </div>
        <div class="col-6 mb-2">
            <button type="submit" class="btn btn-warning w-100">Filter</button>
        </div>
        <div class="col-6">
            <a href="{{ route('admin.ruangan.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>

    @if ($ruangan->isEmpty())
        <div class="card p-4 text-center text-muted">
            <p>Belum ada ruangan yang terdaftar. <a href="{{ route('gedung.index') }}">Mulai dari kelola gedung</a></p>
        </div>
    @else
        <div class="table-responsive" style="border-radius: 12px;">
            <table class="table mb-0">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <tr>
                        <th>Kode Ruangan</th>
                        <th>Nama Ruangan</th>
                        <th>Gedung</th>
                        <th>Lantai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ruangan as $item)
                        <tr>
                            <td><strong>{{ $item->kode_ruangan }}</strong></td>
                            <td>{{ $item->nama_ruangan }}</td>
                            <td>{{ $item->lantai->gedung->nama_gedung ?? 'N/A' }}</td>
                            <td>{{ $item->lantai->nomor_lantai }}</td>
                            <td>
                                @php $displayStatus = $item->status_real_time ?? $item->status; @endphp
                                <span class="badge 
                                    {{ $displayStatus === 'tersedia' ? 'bg-success text-white' : (
                                        $displayStatus === 'tidak_tersedia' ? 'bg-warning text-dark' : 'bg-danger text-white'
                                    ) }}">
                                    {{ ucfirst(str_replace('_', ' ', $displayStatus)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('fasilitas.edit', [$item->lantai->gedung_id, $item->lantai_id, $item->id]) }}" class="btn btn-sm btn-primary">Fasilitas</a>
                                <a href="{{ route('ruangan.edit', [$item->lantai->gedung_id, $item->lantai_id, $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('ruangan.destroy', [$item->lantai->gedung_id, $item->lantai_id, $item->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus ruangan ini?')">Hapus</button>
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
