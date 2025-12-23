@extends('layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="row justify-content-center">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card" style="border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4" style="color: #333;">
                    <i class="fas fa-user-edit me-2" style="color: var(--yellow);"></i>Edit Data Mahasiswa
                </h3>

                <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-600" style="color: #333;">Nama Lengkap <span style="color: var(--yellow);">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $mahasiswa->name) }}" 
                               placeholder="Masukkan nama mahasiswa" required style="border-radius: 8px;">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                           <label for="nim" class="form-label fw-600" style="color: #333;">NIM <span style="color: var(--yellow);">*</span></label>
                           <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                               id="nim" name="nim" value="{{ old('nim', $mahasiswa->nim) }}" 
                               placeholder="Contoh: 0702231043" maxlength="10" required style="border-radius: 8px;">
                           <small class="text-muted d-block mt-2">NIM harus numerik (maksimal 10 digit). Login mahasiswa hanya menggunakan NIM, tanpa password.</small>
                        @error('nim')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning fw-600 py-2" style="border-radius: 8px; background: var(--yellow); border-color: var(--yellow); color: #111;">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>

                <hr class="my-4">
                <div class="row text-center">
                    <div class="col-6">
                        <small style="color: #999;">Email</small>
                        <p style="color: #333; font-weight: 500;">{{ $mahasiswa->email }}</p>
                    </div>
                    <div class="col-6">
                        <small style="color: #999;">Terdaftar Sejak</small>
                        <p style="color: #333; font-weight: 500;">{{ $mahasiswa->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #2c7113;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }
</style>
@endsection
