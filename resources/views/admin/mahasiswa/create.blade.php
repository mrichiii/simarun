@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="row justify-content-center">
    <div class="">
        <div class="mb-4">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="card" style="border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.1);">
            <div class="card-body p-4">
                <h3 class="fw-bold mb-4" style="color: #333;">
                    <i class="fas fa-user-plus me-2" style="color: var(--green);"></i>Tambah Mahasiswa Baru
                </h3>

                <form action="{{ route('admin.mahasiswa.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-600" style="color: #333;">Nama Lengkap <span style="color: var(--yellow);">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Masukkan nama mahasiswa" required style="border-radius: 8px;">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                           <label for="nim" class="form-label fw-600" style="color: #333;">NIM <span style="color: var(--yellow);">*</span></label>
                           <input type="text" class="form-control @error('nim') is-invalid @enderror" 
                               id="nim" name="nim" value="{{ old('nim') }}" 
                               placeholder="Contoh: 0702231043" maxlength="10" required style="border-radius: 8px;">
                           <small class="text-muted d-block mt-2">NIM harus numerik (maksimal 10 digit). Mahasiswa login hanya menggunakan NIM tanpa password.</small>
                        @error('nim')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-600 py-2" style="border-radius: 8px;">
                            <i class="fas fa-plus me-2"></i>Tambah Mahasiswa
                        </button>
                    </div>
                </form>

                <hr class="my-4">
                <div class="alert" role="alert" style="background: var(--surface); border: 1px solid rgba(16,185,129,0.12); border-radius: 8px;">
                    <i class="fas fa-info-circle me-2" style="color: var(--green);"></i>
                    <strong>Informasi:</strong>
                    <ul class="mb-0 mt-2" style="font-size: 0.9rem; color: #555;">
                        <li>Email otomatis akan dibuat dengan format: <code>mahasiswa_[NIM]@student.uinsu.ac.id</code></li>
                        <li><strong>Login mahasiswa hanya menggunakan NIM, tanpa password</strong></li>
                        <li>Pastikan NIM yang diinput valid dan unik</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: var(--green);
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.12);
    }

    code {
        background: #f5f5f5;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: var(--text);
    }
</style>
@endsection
