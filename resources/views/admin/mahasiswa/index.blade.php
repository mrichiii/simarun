@extends('layouts.app')

@section('title', 'Kelola Mahasiswa')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold" style="color: #2c7113;">Kelola Mahasiswa</h1>
        <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-primary" style="border: none;">
        <i class="fas fa-plus me-2"></i>Tambah Mahasiswa</a>
    </div>

    {{-- Filter form --}}
    <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="row g-2 mb-4">
        <div class="col-md-12">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, NIM, atau email...">
        </div>
        <div class="col-6 mb-2">
            <button type="submit" class="btn btn-warning w-100">Filter</button>
        </div>
        <div class="col-6">
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
    </form>
    <div class="table-responsive" style="border-radius: 12px;">
        <table class="table mb-0">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                <tr>
                    <th style="color: #000000; font-weight: 600;">No</th>
                    <th style="color: #000000; font-weight: 600;">Nama</th>
                    <th style="color: #000000; font-weight: 600;">NIM</th>
                    <th style="color: #000000; font-weight: 600;">Email</th>
                    <th style="color: #000000; font-weight: 600; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle me-3" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--green), var(--green-600)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    {{ substr($item->name, 0, 1) }}
                                </div>
                                <span>{{ $item->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge" style="background: #f0fdf6; color: var(--green);">{{ $item->nim }}</span>
                        </td>
                        <td>
                            <small style="color: #666;">{{ $item->email }}</small>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.mahasiswa.edit', $item->id) }}" class="btn btn-sm btn-warning" style="padding: 5px 12px;">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.mahasiswa.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="padding: 5px 12px;" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5" style="color: #999;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 1rem; display: block;"></i>
                            Belum ada data mahasiswa
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
        transition: background-color 0.2s ease;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .btn-sm {
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .btn-sm:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
