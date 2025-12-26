@extends('layouts.app')

@section('title', 'Login')

@section('content')
@php $type = $type ?? request('type') ?? 'nim'; @endphp
<body style="background: linear-gradient(135deg, #2c7113, #fafafa); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-5" style="border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="margin-bottom: 0.5rem;">SIMARUN</h2>
                <p class="text-muted">Sistem Informasi Manajemen Ruangan</p>
            </div>
            
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

                        <button type="submit" class="btn btn-success w-100 fw-600 py-2" style="background: linear-gradient(135deg, #2c7113, #224914); border: none;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Mahasiswa
                        </button>
                    </form>
                    <div class="separator">ATAU</div>
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

                        <button type="submit" class="btn btn-warning w-100 fw-600 py-2" style="background: linear-gradient(135deg, #ffa200, #d29201); border-color: #d29201; color: #000000;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Admin
                        </button>
                    </form>
                    <div class="separator">ATAU</div>
                </div>
            </div>
            <!-- Nav tabs untuk switch login type -->
            <ul class="nav nav-tabs mb-4 login-tabs" id="loginTabs" role="tablist">
                <li class="nav-item flex-grow-1" role="presentation">
                    <button
                        class="nav-link w-100 {{ $type === 'nim' ? 'active tab-warning' : 'tab-warning' }}"
                        id="mahasiswa-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#mahasiswa-pane"
                        type="button"
                        role="tab"
                    >
                        <i class="fas fa-user-graduate me-2"></i>Mahasiswa
                    </button>
                </li>

                <li class="nav-item flex-grow-1" role="presentation">
                    <button
                        class="nav-link w-100 {{ $type === 'email' ? 'active tab-secondary' : 'tab-secondary' }}"
                        id="admin-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#admin-pane"
                        type="button"
                        role="tab"
                    >
                        <i class="fas fa-shield-alt me-2"></i>Admin
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>

<style>
    .card {
        background: #fafafa; 
        color: #0a0a0a; 
        padding: 2rem; 
        border-radius: 12px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.45);
        right: 0;
        left: 0;
        margin-top: auto;
        margin-bottom: auto;
    }
    .nav-link {
        color: #0a0a0a !important;
    }
    .nav-link:hover {
        color: #fafafa !important;
    }
    .nav-link.active {
        color: #fafafa !important;
    }
    .login-tabs {
        border-bottom: none;
        gap: 10px;
    }
    .login-tabs .nav-link {
        border: none !important;
        border-radius: 8px;
        font-weight: 500;
        padding: 12px;
        transition: all 0.3s ease;
        color: #000;
    }
    .tab-warning {
        background: linear-gradient(135deg, #ffa200, #d29201);
        border-color: #d29201;
        color: #000;
    }
    .tab-secondary {
        background: linear-gradient(135deg, #ffa200, #d29201);
        border-color: #6c757d;
        color: #fafafa;
    }
    .login-tabs .nav-link:hover {
        filter: brightness(0.95);
    }
    .login-tabs .nav-link.active {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        background: linear-gradient(135deg, #2c7113, #224914);
        border-color: #d29201;
        color: #000;
    }
    .form-label {
        font-size: 0.95rem;
        color: #0a0a0a;
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
    .separator { 
        display:flex; 
        align-items:center; 
        gap:12px; 
        margin:1rem 0; 
        color:#9aa0a6; 
        font-size:0.75rem }
    .separator::before, .separator::after { 
        content:''; 
        flex:1; 
        height:1px; 
        background:#2b2b2b }
</style>
@endsection
