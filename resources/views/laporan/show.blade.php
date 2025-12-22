@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('laporan.index') }}" class="text-decoration-none text-muted">← Kembali</a>
            </div>

            <div class="card p-4">
                <h2 class="mb-1">Detail Laporan</h2>
                <p class="text-muted mb-4">Dibuat pada {{ $laporan->created_at->format('d M Y H:i') }}</p>

                <div class="mb-4">
                    @if($laporan->status === 'baru')
                        <span class="badge bg-info">Baru</span>
                    @elseif($laporan->status === 'diproses')
                        <span class="badge bg-warning">Diproses</span>
                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="mb-2">Informasi Ruangan</h5>
                        @if($laporan->ruangan)
                            <div class="p-3 bg-light rounded">
                                <p class="mb-1"><strong>{{ $laporan->ruangan->kode_ruangan }}</strong></p>
                                <p class="mb-1 text-muted">{{ $laporan->ruangan->nama_ruangan }}</p>
                                <p class="mb-0 small">
                                    Lantai {{ $laporan->ruangan->lantai->nomor_lantai }} - 
                                    {{ $laporan->ruangan->lantai->gedung->nama_gedung }}
                                </p>
                            </div>
                        @else
                            <p class="text-muted">Tidak ada ruangan terkait</p>
                        @endif
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">Deskripsi Laporan</h5>
                <div class="p-3 bg-light rounded mb-4">
                    <p>{{ $laporan->deskripsi }}</p>
                </div>

                @if($laporan->foto_path)
                    <h5 class="mb-3">Bukti Foto</h5>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $laporan->foto_path) }}" alt="Bukti foto" class="img-fluid rounded" style="max-width: 400px;">
                    </div>
                @endif

                @if($laporan->catatan_admin)
                    <hr>
                    <h5 class="mb-3">Catatan Admin</h5>
                    <div class="alert alert-secondary">
                        <p class="mb-0">{{ $laporan->catatan_admin }}</p>
                    </div>
                @endif

                <div class="mt-4">
                    @if($laporan->status === 'baru')
                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus Laporan</button>
                        </form>
                    @endif
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
