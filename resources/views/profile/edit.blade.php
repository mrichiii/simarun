@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container">
    <div class="col-md-12">
    <div class="card border-0" style="box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
        <div class="card-body p-4">
            <h2 class="fw-bold mb-4" style="color: #000;">Edit Profil</h2>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- NIM (jika user) -->
                @if($user->role === 'user')
                    <div class="mb-3">
                        <label for="nim" class="form-label fw-bold">NIM</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim', $user->nim) }}">
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <!-- Password Baru -->
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Password Baru <span class="text-muted fw-normal">(Opsional)</span></label>
                    <small class="text-muted d-block mb-2">Kosongkan jika tidak ingin mengubah password</small>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru atau biarkan kosong">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password <span class="text-muted fw-normal">(Opsional)</span></label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru atau biarkan kosong">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <script>
                    // Validasi: jika password diisi, password_confirmation harus diisi
                    document.querySelector('form').addEventListener('submit', function(e) {
                        const password = document.getElementById('password').value;
                        const passwordConfirm = document.getElementById('password_confirmation').value;
                        
                        if (password && !passwordConfirm) {
                            e.preventDefault();
                            alert('Jika mengubah password, silakan isi konfirmasi password');
                            document.getElementById('password_confirmation').focus();
                            return false;
                        }
                    });
                </script>

                <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary" style="border: none;">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>

                    <button type="button" class="btn btn-secondary" onclick="window.history.back();">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>
@endsection

<style>
    .form-label {
        color: #333;
        font-size: 0.95rem;
    }

    .form-control {
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #2c7113;
        box-shadow: 0 0 0 0.2rem rgba(44, 113, 19, 0.1);
    }

    .btn {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #2c7113;
    }

    .btn-primary:hover {
        background-color: #1f5010;
    }
</style>
