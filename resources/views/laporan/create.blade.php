@extends('layouts.app')

@section('title', 'Buat Laporan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-4">
                <h2 class="mb-4">Buat Laporan Ruangan</h2>

                <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="ruangan_id" class="form-label">Ruangan (Opsional)</label>
                        <select class="form-select @error('ruangan_id') is-invalid @enderror"
                                id="ruangan_id" name="ruangan_id">
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($ruangan as $r)
                                <option value="{{ $r->id }}" {{ old('ruangan_id') == $r->id ? 'selected' : '' }}>
                                    {{ $r->kode_ruangan }} - {{ $r->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                        @error('ruangan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Laporan <span style="color: red;">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                  id="deskripsi" name="deskripsi" rows="6" required
                                  placeholder="Jelaskan masalah yang Anda alami...">{{ old('deskripsi') }}</textarea>
                        <small class="text-muted">Minimal 10 karakter, maksimal 1000 karakter</small>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Bukti (Opsional)</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                               id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format: JPEG, PNG, atau JPG. Maksimal 2MB</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-success" role="alert">
                        <strong><i class="fas fa-info-circle me-2"></i>Informasi</strong>
                        <ul class="mb-0 mt-2">
                            <li>Sertakan deskripsi yang jelas dan detail</li>
                            <li>Anda bisa melampirkan foto bukti untuk mempercepat proses</li>
                            <li>Laporan akan diproses oleh admin dalam waktu 1-3 hari kerja</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
