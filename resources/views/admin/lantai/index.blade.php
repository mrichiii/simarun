@extends('layouts.app')

@section('title', 'Data Lantai - ' . $gedung->nama_gedung)

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('gedung.index') }}" class="text-decoration-none text-muted">← Kembali ke Data Gedung</a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $gedung->nama_gedung }} - Data Lantai</h1>
        <a href="{{ route('lantai.create', $gedung->id) }}" class="btn btn-primary">+ Tambah Lantai</a>
    </div>

    @if ($lantai->isEmpty())
        <div class="card p-4 text-center text-muted">
            <p>Belum ada data lantai. <a href="{{ route('lantai.create', $gedung->id) }}">Tambah lantai sekarang</a></p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Lantai</th>
                        <th>Nama Lantai</th>
                        <th>Jumlah Ruangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lantai as $item)
                        <tr>
                            <td><strong>Lantai {{ $item->nomor_lantai }}</strong></td>
                            <td>{{ $item->nama_lantai ?? '-' }}</td>
                            <td>{{ $item->ruangan->count() }} ruangan</td>
                            <td>
                                <a href="{{ route('ruangan.index', [$gedung->id, $item->id]) }}" class="btn btn-sm btn-info">Ruangan</a>
                                <a href="{{ route('lantai.edit', [$gedung->id, $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('lantai.destroy', [$gedung->id, $item->id]) }}" method="POST" style="display: inline;">
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
