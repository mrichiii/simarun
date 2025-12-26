@extends('layouts.app')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-4">
                <h2 class="mb-4">Tambah Ruangan Baru</h2>

                <form action="{{ route('ruangan.store', [$gedung->id, $lantai->id]) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Gedung</label>
                        <input type="text" class="form-control" value="{{ $gedung->nama_gedung }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lantai</label>
                        <input type="text" class="form-control" value="Lantai {{ $lantai->nomor_lantai }} - {{ $lantai->nama_lantai ?? 'Lantai Dasar' }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kode Ruangan</label>
                        <input type="text" class="form-control" value="{{ $kodeRuangan }}" disabled>
                        <small class="text-muted">Kode akan di-generate otomatis</small>
                    </div>

                    <div class="mb-3">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control @error('nama_ruangan') is-invalid @enderror"
                               id="nama_ruangan" name="nama_ruangan" value="{{ old('nama_ruangan') }}" placeholder="Contoh: Ruang Kelas A" required>
                        @error('nama_ruangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak_tersedia" {{ old('status') === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia (Terpakai)</option>
                            <option value="tidak_dapat_dipakai" {{ old('status') === 'tidak_dapat_dipakai' ? 'selected' : '' }}>Tidak Dapat Dipakai</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="alasan-container" style="display: none;">
                        <label for="alasan_tidak_dapat_dipakai" class="form-label">Alasan Tidak Dapat Dipakai</label>
                        <textarea class="form-control @error('alasan_tidak_dapat_dipakai') is-invalid @enderror"
                                  id="alasan_tidak_dapat_dipakai" name="alasan_tidak_dapat_dipakai" rows="3"
                                  placeholder="Contoh: Renovasi, Kerusakan">{{ old('alasan_tidak_dapat_dipakai') }}</textarea>
                        @error('alasan_tidak_dapat_dipakai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('ruangan.index', [$gedung->id, $lantai->id]) }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const statusSelect = document.getElementById('status');
    const alasanContainer = document.getElementById('alasan-container');
    const updateAlasanVisibility = () => {
        alasanContainer.style.display = statusSelect.value === 'tidak_dapat_dipakai' ? 'block' : 'none';
    };
    statusSelect.addEventListener('change', updateAlasanVisibility);
    updateAlasanVisibility();
</script>
@endsection
