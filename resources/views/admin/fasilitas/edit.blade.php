@extends('layouts.app')

@section('title', 'Edit Fasilitas - ' . $ruangan->nama_ruangan)

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('ruangan.index', [$gedung->id, $lantai->id]) }}" class="text-decoration-none text-muted">← Kembali ke Data Ruangan</a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-4">
                <h2 class="mb-4">Edit Fasilitas Ruangan</h2>

                <form action="{{ route('fasilitas.update', [$gedung->id, $lantai->id, $ruangan->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Gedung</label>
                            <input type="text" class="form-control" value="{{ $gedung->nama_gedung }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ruangan</label>
                            <input type="text" class="form-control" value="{{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}" disabled>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-md-4 mb-3" style="background: #fafafa; padding: 15px;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="ac" id="ac" value="1" {{ $fasilitas->ac ? 'checked' : '' }}>
                                <label class="form-check-label" for="ac">
                                    <strong>AC (Pendingin Ruangan)</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3" style="background: #fafafa; padding: 15px;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="proyektor" id="proyektor" value="1" {{ $fasilitas->proyektor ? 'checked' : '' }}>
                                <label class="form-check-label" for="proyektor">
                                    <strong>Proyektor</strong>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3" style="background: #fafafa; padding: 15px;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="papan_tulis" id="papan_tulis" value="1" {{ $fasilitas->papan_tulis ? 'checked' : '' }}>
                                <label class="form-check-label" for="papan_tulis">
                                    <strong>Papan Tulis</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="jumlah_kursi" class="form-label">Jumlah Kursi</label>
                        <input type="number" class="form-control @error('jumlah_kursi') is-invalid @enderror"
                               id="jumlah_kursi" name="jumlah_kursi" min="0" value="{{ $fasilitas->jumlah_kursi ?? 0 }}">
                        @error('jumlah_kursi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="wifi" class="form-label">Kualitas WiFi</label>
                        <select class="form-select @error('wifi') is-invalid @enderror" id="wifi" name="wifi" required>
                            <option value="">-- Pilih Kualitas WiFi --</option>
                            <option value="lancar" {{ ($fasilitas->wifi ?? '') === 'lancar' ? 'selected' : '' }}>📶 Lancar</option>
                            <option value="lemot" {{ ($fasilitas->wifi ?? '') === 'lemot' ? 'selected' : '' }}>📊 Lemot</option>
                            <option value="tidak_terjangkau" {{ ($fasilitas->wifi ?? '') === 'tidak_terjangkau' ? 'selected' : '' }}>❌ Tidak Terjangkau</option>
                        </select>
                        @error('wifi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="arus_listrik" class="form-label">Arus Listrik</label>
                        <select class="form-select @error('arus_listrik') is-invalid @enderror" id="arus_listrik" name="arus_listrik" required>
                            <option value="">-- Pilih Status Listrik --</option>
                            <option value="lancar" {{ ($fasilitas->arus_listrik ?? '') === 'lancar' ? 'selected' : '' }}>⚡ Lancar</option>
                            <option value="tidak" {{ ($fasilitas->arus_listrik ?? '') === 'tidak' ? 'selected' : '' }}>❌ Tidak</option>
                        </select>
                        @error('arus_listrik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('ruangan.index', [$gedung->id, $lantai->id]) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
