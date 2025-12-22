@extends('layouts.app')

@section('title', 'Proses Laporan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('laporan.admin-index') }}" class="text-decoration-none text-muted">← Kembali</a>
            </div>

            <div class="card p-4">
                <h2 class="mb-1">Proses Laporan</h2>
                <p class="text-muted mb-4">dari {{ $laporan->user->name }} ({{ $laporan->user->email }})</p>

                <div class="mb-4">
                    <h5>Informasi Laporan</h5>
                    <div class="p-3 bg-light rounded">
                        <p class="mb-2">
                            <strong>User:</strong> {{ $laporan->user->name }}<br>
                            @if($laporan->ruangan)
                                <strong>Ruangan:</strong> {{ $laporan->ruangan->kode_ruangan }} - {{ $laporan->ruangan->nama_ruangan }}<br>
                            @endif
                            <strong>Dibuat:</strong> {{ $laporan->created_at->format('d M Y H:i') }}<br>
                            <strong>Status Saat Ini:</strong>
                            @if($laporan->status === 'baru')
                                <span class="badge bg-info">Baru</span>
                            @elseif($laporan->status === 'diproses')
                                <span class="badge bg-warning">Diproses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </p>
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

                <hr>

                <form action="{{ route('laporan.admin-update', $laporan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Laporan <span style="color: red;">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="baru" {{ $laporan->status === 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ $laporan->status === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="selesai" {{ $laporan->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="catatan_admin" class="form-label">Catatan Admin (Opsional)</label>
                        <textarea class="form-control @error('catatan_admin') is-invalid @enderror"
                                  id="catatan_admin" name="catatan_admin" rows="4"
                                  placeholder="Catatan ini akan terlihat oleh user...">{{ old('catatan_admin', $laporan->catatan_admin) }}</textarea>
                        <small class="text-muted">Maksimal 1000 karakter</small>
                        @error('catatan_admin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('laporan.admin-index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
