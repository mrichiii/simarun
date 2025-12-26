@extends('layouts.app')

@section('title', 'Kelola Lantai (Semua Gedung)')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #2c7113;">Kelola Lantai (Semua Gedung)</h1>
        <a href="{{ route('gedung.index') }}" class="btn btn-primary" style="border: none;">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Gedung</a>
    </div>

    @if ($lantai->isEmpty())
        <div class="card p-4 text-center text-muted">
            <p>Belum ada lantai yang terdaftar. <a href="{{ route('gedung.index') }}">Mulai dari kelola gedung</a></p>
        </div>
    @else
        <div class="table-responsive" style="border-radius: 12px;">
            <table class="table mb-0">
                <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <tr>
                        <th>Gedung</th>
                        <th>Nomor Lantai</th>
                        <th>Nama Lantai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lantai as $item)
                        <tr>
                            <td><strong>{{ $item->gedung->nama_gedung ?? 'N/A' }}</strong></td>
                            <td>{{ $item->nomor_lantai }}</td>
                            <td>{{ $item->nama_lantai ?? '-' }}</td>
                            <td>
                                <a href="{{ route('ruangan.index', [$item->gedung_id, $item->id]) }}" class="btn btn-sm btn-primary">Ruangan</a>
                                <a href="{{ route('lantai.edit', [$item->gedung_id, $item->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('lantai.destroy', [$item->gedung_id, $item->id]) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus lantai ini beserta semua ruangannya?')">Hapus</button>
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
