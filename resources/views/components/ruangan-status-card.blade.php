{{-- 
    Contoh Blade Component untuk menampilkan status ruangan real-time
    
    Cara pakai:
    <x-ruangan-status-card :ruangan="$ruangan" />
    
    Atau di views:
    @include('components.ruangan-status-card', ['ruangan' => $ruangan])
--}}

<div class="ruangan-card" data-ruangan-id="{{ $ruangan->id }}">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0">
                        {{ $ruangan->kode_ruangan }} - {{ $ruangan->nama_ruangan }}
                    </h5>
                </div>
                <div class="col-auto">
                    @php
                        $statusRealTime = $ruangan->getStatusRealTimeAttribute();
                        $statusClass = match($statusRealTime) {
                            'tersedia' => 'bg-success',
                            'tidak_tersedia' => 'bg-danger',
                            'tidak_dapat_dipakai' => 'bg-warning',
                            default => 'bg-secondary'
                        };
                        
                        $statusLabel = match($statusRealTime) {
                            'tersedia' => '✓ Tersedia',
                            'tidak_tersedia' => '✗ Tidak Tersedia',
                            'tidak_dapat_dipakai' => '⚠ Tidak Dapat Dipakai',
                            default => ucfirst($statusRealTime)
                        };
                    @endphp
                    
                    <span class="badge {{ $statusClass }}" data-status-badge>
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            {{-- Lantai dan Gedung --}}
            <small class="d-block text-muted mb-2">
                <strong>Lokasi:</strong> 
                @if($ruangan->lantai)
                    {{ $ruangan->lantai->gedung->nama_gedung ?? 'N/A' }} - 
                    Lantai {{ $ruangan->lantai->nomor_lantai ?? 'N/A' }}
                @else
                    Lokasi tidak tersedia
                @endif
            </small>
            
            {{-- Fasilitas --}}
            @if($ruangan->fasilitas)
                <small class="d-block text-muted mb-2">
                    <strong>Fasilitas:</strong> 
                    {{ $ruangan->fasilitas->deskripsi ?? 'N/A' }}
                </small>
            @endif
            
            {{-- Booking Info (akan di-update via AJAX) --}}
            @if($currentPeminjaman = $ruangan->getCurrentPeminjamanAttribute())
                <div class="alert alert-warning alert-sm mt-3 mb-0" data-booking-info>
                    <small>
                        <strong>Sedang dipinjam oleh:</strong><br>
                        {{ $currentPeminjaman->user->name ?? 'Unknown' }}<br>
                        <strong>Dosen:</strong> {{ $currentPeminjaman->dosen_pengampu }}<br>
                        <strong>Jam:</strong> 
                        {{ $currentPeminjaman->tanggal_jam_masuk->format('H:i') }} 
                        - 
                        {{ $currentPeminjaman->tanggal_jam_keluar->format('H:i') }}
                    </small>
                </div>
            @else
                <div style="display: none;" data-booking-info></div>
            @endif
        </div>
        
        <div class="card-footer">
            @if($statusRealTime === 'tersedia')
                <a href="{{ route('booking.create', $ruangan->id) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-calendar-plus"></i> Pesan Ruangan
                </a>
            @else
                <button class="btn btn-sm btn-secondary" disabled>
                    <i class="bi bi-lock"></i> Tidak Bisa Pesan
                </button>
            @endif
        </div>
    </div>
</div>

<style>
    .ruangan-card {
        margin-bottom: 1.5rem;
    }
    
    .ruangan-card .card {
        transition: all 0.3s ease;
    }
    
    .ruangan-card .card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .status-tersedia {
        background-color: #28a745 !important;
    }
    
    .status-tidak_tersedia {
        background-color: #dc3545 !important;
    }
    
    .status-tidak_dapat_dipakai {
        background-color: #ffc107 !important;
    }
</style>
