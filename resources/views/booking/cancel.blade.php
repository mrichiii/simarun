@extends('layouts.app')

@section('title', 'Batalkan Peminjaman')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="mb-3">
                <a href="{{ route('booking.my-bookings') }}" class="text-decoration-none text-muted">← Kembali</a>
            </div>

            <div class="card p-4">
                <h2 class="mb-3">Batalkan Peminjaman</h2>

                <div class="alert alert-warning">
                    <strong>⚠️ Konfirmasi Pembatalan</strong><br>
                    Anda akan membatalkan peminjaman ruangan berikut:
                </div>

                <div class="mb-4 p-3 bg-light rounded">
                    <div class="mb-2">
                        <strong>Ruangan:</strong> {{ $peminjaman->ruangan->kode_ruangan }} - {{ $peminjaman->ruangan->nama_ruangan }}
                    </div>
                    <div class="mb-2">
                        <strong>Jam Masuk:</strong> {{ $peminjaman->jam_masuk }}
                    </div>
                    <div class="mb-2">
                        <strong>Jam Keluar:</strong> {{ $peminjaman->jam_keluar }}
                    </div>
                    <div>
                        <strong>Dosen Pengampu:</strong> {{ $peminjaman->dosen_pengampu }}
                    </div>
                </div>

                <form action="{{ route('booking.confirm-cancel', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="alasan_pembatalan" class="form-label">Alasan Pembatalan <span style="color: red;">*</span></label>
                        <textarea class="form-control @error('alasan_pembatalan') is-invalid @enderror"
                                  id="alasan_pembatalan" name="alasan_pembatalan" rows="4" required
                                  placeholder="Jelaskan alasan pembatalan Anda..."></textarea>
                        <small class="text-muted">Minimal 10 karakter</small>
                        @error('alasan_pembatalan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-danger">Batalkan Peminjaman</button>
                        <a href="{{ route('booking.my-bookings') }}" class="btn btn-secondary">Tidak, Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
