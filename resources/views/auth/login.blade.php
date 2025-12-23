@extends('layouts.app')

@section('title', 'Login')

@section('content')
@php $type = $type ?? request('type') ?? 'nim'; @endphp
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-5" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: #333; margin-bottom: 0.5rem;">Selamat Datang</h2>
                <p class="text-muted">Sistem Manajemen Ruangan Gedung FST</p>
            </div>
            
            <!-- Nav tabs untuk switch login type -->
            <ul class="nav nav-tabs mb-4" id="loginTabs" role="tablist" style="border-bottom: 2px solid #e9ecef;">
                <li class="nav-item flex-grow-1 text-center" role="presentation">
                    <button class="{{ $type === 'nim' ? 'nav-link active w-100' : 'nav-link w-100' }}" id="mahasiswa-tab" data-bs-toggle="tab" data-bs-target="#mahasiswa-pane" type="button" role="tab">
                        <i class="fas fa-user-graduate me-2"></i>Mahasiswa (NIM)
                    </button>
                </li>
                <li class="nav-item flex-grow-1 text-center" role="presentation">
                    <button class="{{ $type === 'email' ? 'nav-link active w-100' : 'nav-link w-100' }}" id="admin-tab" data-bs-toggle="tab" data-bs-target="#admin-pane" type="button" role="tab">
                        <i class="fas fa-shield-alt me-2"></i>Admin (Email)
                    </button>
                </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="loginTabContent">
                <!-- Mahasiswa Tab -->
                <div class="tab-pane fade {{ $type === 'nim' ? 'show active' : '' }}" id="mahasiswa-pane" role="tabpanel">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="nim">
                        
                        <div class="mb-3">
                            <label for="login_nim" class="form-label fw-600">NIM Mahasiswa</label>
                            <input type="text" class="form-control @error('login') is-invalid @enderror" 
                                   id="login_nim" name="login" value="{{ old('login') }}" 
                                   placeholder="Contoh: 12345" maxlength="10" required>
                            <small class="text-muted d-block mt-2">
                                <i class="fas fa-info-circle"></i> Masukkan NIM Anda (maksimal 10 digit)
                            </small>
                            @error('login')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block mt-2">Masukkan NIM dan tekan tombol untuk masuk tanpa password.</small>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-600 py-2" style="background: linear-gradient(135deg, #2c7113, #224914); border: none;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Mahasiswa (NIM)
                        </button>
                    </form>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-0">
                        <i class="fas fa-lightbulb"></i> NIM belum terdaftar? <br>
                        Hubungi Admin untuk pendaftaran
                    </p>
                </div>

                <!-- Admin Tab -->
                <div class="tab-pane fade {{ $type === 'email' ? 'show active' : '' }}" id="admin-pane" role="tabpanel">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="email">
                        
                        <div class="mb-3">
                            <label for="login_email" class="form-label fw-600">Email</label>
                            <input type="email" class="form-control @error('login') is-invalid @enderror" 
                                   id="login_email" name="login" value="{{ old('login') }}" 
                                   placeholder="admin@example.com" required>
                            @error('login')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_email" class="form-label fw-600">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password_email" name="password" required>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-600 py-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Admin
                        </button>
                    </form>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-0">
                        <strong>Demo Admin:</strong><br>
                        Email: <code>admin@uinsu.ac.id</code><br>
                        Password: <code>Admin@123</code>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-link {
        color: #666 !important;
        border: none !important;
        border-bottom: 3px solid transparent !important;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .nav-link:hover {
        color: #2c7113 !important;
        border-bottom: 3px solid #2c7113 !important;
    }

    .nav-link.active {
        color: #2c7113 !important;
        border-bottom: 3px solid #2c7113 !important;
        background: transparent !important;
    }

    .form-label {
        font-size: 0.95rem;
        color: #333;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #2c7113;
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
    }

    code {
        background: #f5f5f5;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
    }
</style>
@endsection
