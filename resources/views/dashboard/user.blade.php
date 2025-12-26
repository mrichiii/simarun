@extends('layouts.app')

@section('title', 'Dashboard User')

@section('css')
<style>
    .card-gedung {
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid #e0e0e0;
    }
    .card-gedung:hover {
        transform: translateY(-2px);
    }
    .stat-badge {
        display: inline-block;
        background-color: #d4edda;
        color: #155724;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1.25rem;
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 0.5rem;
        margin-top: 1rem;
    }
    .grid-item {
        aspect-ratio: 1;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-weight: 600;
        font-size: 0.85rem;
        text-align: center;
        padding: 0.5rem;
        color: white;
        background-color: #28a745;
        text-decoration: none;
    }
    .grid-item:hover {
        transform: scale(1.05);
    }
    /* Dashboard modern styles */
    .dashboard-header {
        display: flex;
        gap: 1rem;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.25rem;
    }
    .stat-card {
        background: linear-gradient(180deg,#ffffff,#f7fffa);
        border-radius: 12px;
        padding: 18px;
        border: 1px solid #eef7ee;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
        background: linear-gradient(135deg,#2c7113,#224914);
        flex-shrink: 0;
    }
    .stat-body {
        display: flex;
        flex-direction: column;
    }
    .stat-number { font-size: 1.5rem; font-weight: 800; color: #0b1220; }
    .stat-label { font-size: 0.95rem; color: #6b6b6b; }

    .quick-actions { display:flex; gap:10px; flex-wrap:wrap; }
    .quick-btn { border-radius:10px; padding:10px 14px; }

    .recent-card { border-radius:12px; padding:16px; border:1px solid #f0f6f0; }
    .recent-item { display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px dashed #eef6ef; }
    .recent-item:last-child { border-bottom: none; }
    .recent-thumb { width:48px; height:48px; border-radius:8px; background:#eefaf0; display:flex; align-items:center; justify-content:center; color:#2c7113; font-weight:700; }

    @media (max-width: 991px) {
        .stats-row { grid-template-columns: repeat(2,1fr); }
    }
    .container {
        color: #0a0a0a;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="dashboard-header">
        <div>
            <h1 class="fw-bold" style="color: #2c7113;">Kelola Laporan dan Pengaduan</h1>
            <p class="text-muted mb-0">Halo, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <div class="quick-actions">
            <a href="{{ route('booking.my-bookings') }}" class="btn quick-btn btn-primary"><i class="fas fa-calendar"></i> Peminjaman Saya</a>
            <a href="{{ route('laporan.create') }}" class="btn quick-btn btn-warning"><i class="fas fa-file-alt"></i> Buat Laporan</a>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"  style="background:linear-gradient(135deg,#2c7113,#224914);"><i class="fas fa-door-open"></i></div>
            <div class="stat-body">
                <div class="stat-number">{{ $ruanganTersedia ?? 0 }}</div>
                <div class="stat-label">Ruangan Tersedia</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#ffa200,#d29201);"><i class="fas fa-building"></i></div>
            <div class="stat-body">
                <div class="stat-number">{{ isset($gedung) ? $gedung->count() : 0 }}</div>
                <div class="stat-label">Total Gedung</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:linear-gradient(135deg,#e01c30,#a00d1b);"><i class="fas fa-clock"></i></div>
            <div class="stat-body">
                <div class="stat-number">{{ $pendingBookings ?? 0 }}</div>
                <div class="stat-label">Peminjaman Pending</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="recent-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Peminjaman Terbaru</h5>
                    <a href="{{ route('booking.my-bookings') }}" class="small">Lihat semua</a>
                </div>
                @if(isset($bookings) && $bookings->count())
                    @foreach($bookings as $b)
                        <div class="recent-item">
                            <div class="recent-thumb">{{ strtoupper(substr($b->ruangan->kode_ruangan ?? 'R',0,2)) }}</div>
                            <div>
                                <div style="font-weight:700;">{{ $b->ruangan->nama ?? ($b->ruangan->kode_ruangan ?? 'Ruangan') }}</div>
                                <div class="small text-muted">{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') ?? '-' }} — {{ $b->waktu_mulai ?? '-' }}</div>
                            </div>
                            <div class="ms-auto text-end small text-muted">{{ $b->status ?? '—' }}</div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <svg width="72" height="72" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="opacity:0.35;"><path d="M3 7H21" stroke="#6b7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 3V7" stroke="#6b7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 3V7" stroke="#6b7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 10V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V10" stroke="#6b7280" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <p class="mt-3 mb-0 text-muted">Belum ada peminjaman terbaru. Buat peminjaman pertama Anda sekarang.</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="recent-card">
                <h5>Daftar Gedung</h5>
                <div class="mt-3">
                    @if(isset($gedung) && $gedung->count())
                        @foreach($gedung->take(5) as $g)
                            <a href="{{ route('user.gedung-detail', $g->id) }}" class="d-flex align-items-center text-decoration-none mb-2">
                                <div class="recent-thumb">{{ strtoupper(substr($g->nama_gedung,0,1)) }}</div>
                                <div class="ms-3">
                                    <div style="font-weight:700; color:#0b1220;">{{ $g->nama_gedung }}</div>
                                    <div class="small text-muted">{{ $g->kode_gedung }} • {{ $g->lantai->count() }} lantai</div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-muted">Belum ada gedung terdaftar.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

