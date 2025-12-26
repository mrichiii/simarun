@extends('layouts.app')

@section('title', 'Tambah Gedung')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-4">
                <h2 class="mb-4">Tambah Gedung Baru</h2>

                <form action="{{ route('gedung.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="kode_gedung" class="form-label">Kode Gedung</label>
                        <input type="text" class="form-control @error('kode_gedung') is-invalid @enderror"
                               id="kode_gedung" name="kode_gedung" value="{{ old('kode_gedung') }}" required>
                        @error('kode_gedung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_gedung" class="form-label">Nama Gedung</label>
                        <input type="text" class="form-control @error('nama_gedung') is-invalid @enderror"
                               id="nama_gedung" name="nama_gedung" value="{{ old('nama_gedung') }}" required>
                        @error('nama_gedung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <textarea class="form-control @error('lokasi') is-invalid @enderror"
                                  id="lokasi" name="lokasi" rows="3">{{ old('lokasi') }}</textarea>
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('gedung.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
