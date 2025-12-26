@extends('layouts.app')

@section('title', 'Kelola Fasilitas Ruangan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #2c7113;">Kelola Fasilitas Ruangan</h1>
        <a href="{{ route('gedung.index') }}" class="btn btn-primary" style="border: none;">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Gedung</a>
    </div>

    <p class="text-muted">Pilih ruangan di bawah untuk mengelola fasilitasnya</p>

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
                                <a href="{{ route('fasilitas.edit', [$item->lantai->gedung_id, $item->lantai_id, $item->id]) }}" class="btn btn-sm btn-primary">Kelola Fasilitas</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
