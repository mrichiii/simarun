@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
                <div class="mb-3">
                	<a href="{{ route('dashboard') }}" class="text-decoration-none text-muted">← Kembali ke Dashboard</a>
                </div>
            <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold" style="color: #2c7113;">Riwayat Peminjaman Saya</h1>
            </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('booking.my-bookings') }}" class="row g-2 mb-4">
                    <div class="col-md-6">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari kode atau nama ruangan...">
                    </div>
                    <div class="col-md-6">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-6 mb-2">
                        <button type="submit" class="btn btn-warning w-100">Filter</button>
                    </div>
                    <div class="col-6">
                        <a href="{{{ route('booking.my-bookings') }}}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>

                @if($peminjaman->isEmpty())
                    <div class="alert alert-info">
                        <strong>Belum ada riwayat peminjaman</strong><br>
                        <a href="{{ route('dashboard') }}" class="alert-link">Lihat ruangan yang tersedia</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Ruangan</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Dosen Pengampu</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->ruangan->kode_ruangan }}</strong><br>
                                            <small class="text-muted">{{ $item->ruangan->nama_ruangan }}</small>
                                        </td>
                                        <td>{{ $item->jam_masuk }}</td>
                                        <td>{{ $item->jam_keluar }}</td>
                                        <td>{{ $item->dosen_pengampu }}</td>
                                        <td>
                                            @if($item->status === 'aktif')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($item->status === 'selesai')
                                                <span class="badge bg-secondary">Selesai</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('user.ruangan-detail', $item->ruangan->id) }}" class="btn btn-warning">Lihat</a>
                                                @if($item->status === 'aktif')
                                                    <form action="{{ route('booking.cancel', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan peminjaman ini?')">Batalkan</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-muted small mt-3">
                        <p>Total peminjaman: <strong>{{ $peminjaman->count() }}</strong></p>
                        <p>Aktif: <strong>{{ $peminjaman->where('status', 'aktif')->count() }}</strong> | 
                           Selesai: <strong>{{ $peminjaman->where('status', 'selesai')->count() }}</strong> | 
                           Dibatalkan: <strong>{{ $peminjaman->where('status', 'dibatalkan')->count() }}</strong></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
