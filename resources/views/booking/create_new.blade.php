{{-- 
    Form untuk create booking dengan tanggal dan waktu
    Update ini menggunakan datetime columns untuk real-time status
--}}

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-plus"></i>
                        Pesan Ruangan: {{ $ruangan->kode_ruangan }}
                    </h4>
                </div>

                <div class="card-body">
                    {{-- Alert jika status tidak tersedia --}}
                    @if($ruangan->getStatusRealTimeAttribute() !== 'tersedia')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Ruangan Tidak Tersedia</strong>
                            <br>
                            Maaf, ruangan ini sedang tidak tersedia. 
                            Status dapat berubah setiap saat. Silakan coba lagi nanti.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    {{-- Informasi Ruangan --}}
                    <div class="mb-4 p-3 bg-light rounded">
                        <h6>Informasi Ruangan</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="d-block">
                                    <strong>Kode Ruangan:</strong> {{ $ruangan->kode_ruangan }}
                                </small>
                                <small class="d-block">
                                    <strong>Nama Ruangan:</strong> {{ $ruangan->nama_ruangan }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="d-block">
                                    <strong>Lantai:</strong> 
                                    Lantai {{ $ruangan->lantai->nomor_lantai ?? 'N/A' }}
                                </small>
                                <small class="d-block">
                                    <strong>Gedung:</strong> 
                                    {{ $ruangan->lantai->gedung->nama_gedung ?? 'N/A' }}
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Booking Form --}}
                    <form action="{{ route('booking.store', $ruangan->id) }}" method="POST">
                        @csrf

                        {{-- Tanggal Peminjaman --}}
                        <div class="mb-3">
                            <label for="tanggal_peminjaman" class="form-label">
                                <i class="bi bi-calendar"></i> Tanggal Peminjaman
                            </label>
                            <input 
                                type="date" 
                                id="tanggal_peminjaman"
                                name="tanggal_peminjaman" 
                                class="form-control @error('tanggal_peminjaman') is-invalid @enderror"
                                value="{{ old('tanggal_peminjaman', now()->format('Y-m-d')) }}"
                                min="{{ now()->format('Y-m-d') }}"
                                required
                            >
                            @error('tanggal_peminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Pilih tanggal peminjaman (minimal hari ini)
                            </small>
                        </div>

                        {{-- Jam Masuk --}}
                        <div class="mb-3">
                            <label for="jam_masuk" class="form-label">
                                <i class="bi bi-clock-history"></i> Jam Masuk
                            </label>
                            <input 
                                type="time" 
                                id="jam_masuk"
                                name="jam_masuk" 
                                class="form-control @error('jam_masuk') is-invalid @enderror"
                                value="{{ old('jam_masuk', '08:00') }}"
                                required
                            >
                            @error('jam_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Masukkan jam mulai peminjaman ruangan
                            </small>
                        </div>

                        {{-- Jam Keluar --}}
                        <div class="mb-3">
                            <label for="jam_keluar" class="form-label">
                                <i class="bi bi-clock"></i> Jam Keluar
                            </label>
                            <input 
                                type="time" 
                                id="jam_keluar"
                                name="jam_keluar" 
                                class="form-control @error('jam_keluar') is-invalid @enderror"
                                value="{{ old('jam_keluar', '10:00') }}"
                                required
                            >
                            @error('jam_keluar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Masukkan jam akhir peminjaman ruangan (harus lebih besar dari jam masuk)
                            </small>
                        </div>

                        {{-- Dosen Pengampu --}}
                        <div class="mb-3">
                            <label for="dosen_pengampu" class="form-label">
                                <i class="bi bi-person-badge"></i> Nama Dosen Pengampu
                            </label>
                            <input 
                                type="text" 
                                id="dosen_pengampu"
                                name="dosen_pengampu" 
                                class="form-control @error('dosen_pengampu') is-invalid @enderror"
                                value="{{ old('dosen_pengampu') }}"
                                placeholder="Contoh: Prof. Dr. Nama Dosen"
                                required
                            >
                            @error('dosen_pengampu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Nama dosen pengampu untuk aktivitas di ruangan ini
                            </small>
                        </div>

                        {{-- Alert Info Sistem Real-Time --}}
                        <div class="alert alert-info alert-sm mb-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>Informasi:</strong>
                            <br>
                            Status ruangan akan <strong>otomatis berubah menjadi "Tidak Tersedia"</strong> 
                            sejak jam masuk yang Anda atur.
                            <br>
                            Sistem berjalan real-time berdasarkan waktu server dan tidak memerlukan refresh manual.
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-check-circle"></i> Pesan Sekarang
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>

                    {{-- Info Ketersediaan --}}
                    <div class="mt-4 p-3 bg-info bg-opacity-10 rounded">
                        <h6>Cek Ketersediaan Ruangan</h6>
                        <small class="d-block text-muted mb-3">
                            Klik tombol di bawah untuk melihat ruangan mana saja yang tersedia 
                            di tanggal dan jam yang Anda pilih
                        </small>
                        <button 
                            type="button" 
                            id="checkAvailabilityBtn"
                            class="btn btn-sm btn-info"
                            onclick="checkAvailability()"
                        >
                            <i class="bi bi-search"></i> Cek Ketersediaan
                        </button>
                        <div id="availabilityResult" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border-radius: 0.375rem;
    }

    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .alert-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
</style>

<script>
    /**
     * Check ketersediaan ruangan untuk tanggal + jam yang dipilih
     */
    async function checkAvailability() {
        const tanggal = document.getElementById('tanggal_peminjaman').value;
        const jam_mulai = document.getElementById('jam_masuk').value;
        const jam_selesai = document.getElementById('jam_keluar').value;

        if (!tanggal || !jam_mulai || !jam_selesai) {
            alert('Harap isi tanggal dan jam terlebih dahulu');
            return;
        }

        const resultDiv = document.getElementById('availabilityResult');
        resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Mengecek...';

        try {
            const params = new URLSearchParams({
                tanggal,
                jam_mulai,
                jam_selesai
            });

            const response = await fetch(`/api/ruangan/available?${params}`);
            const data = await response.json();

            if (data.available_rooms_count === 0) {
                resultDiv.innerHTML = `
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        Tidak ada ruangan yang tersedia untuk slot waktu ini.
                    </div>
                `;
                return;
            }

            let html = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    <strong>${data.available_rooms_count} ruangan tersedia</strong> 
                    untuk tanggal ${tanggal} jam ${jam_mulai}-${jam_selesai}
                </div>
                <div class="list-group">
            `;

            data.available_rooms.forEach(room => {
                html += `
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">${room.kode_ruangan}</h6>
                                <small class="text-muted">${room.nama_ruangan}</small>
                                <br>
                                <small class="text-muted">${room.gedung} - Lantai ${room.lantai}</small>
                            </div>
                            <span class="badge bg-success">Tersedia</span>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            resultDiv.innerHTML = html;

        } catch (error) {
            console.error('Error:', error);
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle"></i>
                    Terjadi kesalahan saat mengecek ketersediaan. Silakan coba lagi.
                </div>
            `;
        }
    }

    /**
     * Validasi jam_keluar > jam_masuk
     */
    document.getElementById('jam_keluar').addEventListener('change', function() {
        const jam_masuk = document.getElementById('jam_masuk').value;
        const jam_keluar = this.value;

        if (jam_masuk && jam_keluar && jam_keluar <= jam_masuk) {
            this.setCustomValidity('Jam keluar harus lebih besar dari jam masuk');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endsection
