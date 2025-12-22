@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <a href="{{ route('user.dashboard') }}" class="text-decoration-none text-muted">← Kembali ke Dashboard</a>
            </div>

            <div class="card p-4">
                <h2 class="mb-4">Riwayat Peminjaman Saya</h2>

                @if($peminjaman->isEmpty())
                    <div class="alert alert-info">
                        <strong>Belum ada riwayat peminjaman</strong><br>
                        <a href="{{ route('user.dashboard') }}" class="alert-link">Lihat ruangan yang tersedia</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
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
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('user.ruangan-detail', $item->ruangan->id) }}" class="btn btn-outline-info">Lihat</a>
                                                @if($item->status === 'aktif')
                                                    <form action="{{ route('booking.cancel', $item->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Yakin ingin membatalkan peminjaman ini?')">Batalkan</button>
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
