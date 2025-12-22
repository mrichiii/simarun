@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h2 class="mb-4 text-center fw-bold">Login</h2>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <hr class="my-4">
            <p class="text-center text-muted small">
                Demo akun Admin:<br>
                <strong>admin@uinsu.ac.id</strong> / Admin@123
            </p>
        </div>
    </div>
</div>
@endsection
