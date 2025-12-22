@extends('layouts.app')

@section('title', 'Form Peminjaman Ruangan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-3">
                <a href="{{ route('user.ruangan-detail', $ruangan->id) }}" class="text-decoration-none text-muted">← Kembali</a>
            </div>

            <div class="card p-4">
                <h2 class="mb-1">Peminjaman Ruangan</h2>
                <p class="text-muted mb-4">{{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}</p>

                <form action="{{ route('booking.store', $ruangan->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Gedung</label>
                        <input type="text" class="form-control" value="{{ $ruangan->lantai->gedung->nama_gedung }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ruangan</label>
                        <input type="text" class="form-control" value="{{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}" disabled>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="dosen_pengampu" class="form-label">Nama Dosen Pengampu <span style="color: red;">*</span></label>
                        <input type="text" class="form-control @error('dosen_pengampu') is-invalid @enderror"
                               id="dosen_pengampu" name="dosen_pengampu" value="{{ old('dosen_pengampu') }}" required>
                        @error('dosen_pengampu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk (HH:MM) <span style="color: red;">*</span></label>
                                <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror"
                                       id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk') }}" required>
                                <small class="text-muted">Format 24 jam, contoh: 08:00</small>
                                @error('jam_masuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar (HH:MM) <span style="color: red;">*</span></label>
                                <input type="time" class="form-control @error('jam_keluar') is-invalid @enderror"
                                       id="jam_keluar" name="jam_keluar" value="{{ old('jam_keluar') }}" required>
                                <small class="text-muted">Harus lebih besar dari jam masuk</small>
                                @error('jam_keluar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>⚠️ Perhatian:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Pastikan jadwal tidak bertabrakan dengan peminjaman lain</li>
                            <li>Anda tidak bisa meminjam ruangan pada waktu yang sama untuk 2 ruangan berbeda</li>
                            <li>Satu ruangan tidak bisa digunakan oleh lebih dari satu kelas pada waktu yang sama</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Buat Peminjaman</button>
                        <a href="{{ route('user.ruangan-detail', $ruangan->id) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
