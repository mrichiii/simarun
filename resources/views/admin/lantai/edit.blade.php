@extends('layouts.app')

@section('title', 'Edit Lantai - ' . $gedung->nama_gedung)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h2 class="mb-4">Edit Lantai</h2>

                <form action="{{ route('lantai.update', [$gedung->id, $lantai->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Gedung</label>
                        <input type="text" class="form-control" value="{{ $gedung->nama_gedung }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="nomor_lantai" class="form-label">Nomor Lantai</label>
                        <input type="number" class="form-control @error('nomor_lantai') is-invalid @enderror"
                               id="nomor_lantai" name="nomor_lantai" value="{{ old('nomor_lantai', $lantai->nomor_lantai) }}" min="0" required>
                        @error('nomor_lantai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_lantai" class="form-label">Nama Lantai (Optional)</label>
                        <input type="text" class="form-control @error('nama_lantai') is-invalid @enderror"
                               id="nama_lantai" name="nama_lantai" value="{{ old('nama_lantai', $lantai->nama_lantai) }}" placeholder="Contoh: Lantai Dasar">
                        @error('nama_lantai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('lantai.index', $gedung->id) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
